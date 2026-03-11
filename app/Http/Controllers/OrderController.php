<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index()
    {
        $products = Product::active()->orderBy('category')->orderBy('sort_order')->get();
        $user = Auth::user();
        return view('order.create', compact('products', 'user'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'pickup_date' => 'required|date|after:today',
            'pickup_time' => 'nullable|string|max:20',
            'delivery_address' => 'required|string|max:500',
            'items' => 'required|array|min:1',
            'items.*.product_id' => 'required|exists:products,id',
            'items.*.quantity' => 'nullable|integer|min:0',
            'notes' => 'nullable|string|max:500',
        ], [
            'delivery_address.required' => 'Alamat pengiriman wajib diisi.',
            'items.*.quantity.min' => 'Jumlah produk tidak boleh kurang dari 0.',
        ]);

        DB::beginTransaction();
        try {
            $subtotal = 0;
            $orderItems = [];

            foreach ($request->items as $item) {
                if (empty($item['quantity']) || $item['quantity'] < 1) continue;

                $product = Product::findOrFail($item['product_id']);
                $itemSubtotal = $product->price * $item['quantity'];
                $subtotal += $itemSubtotal;

                $orderItems[] = [
                    'product_id' => $product->id,
                    'product_name' => $product->name,
                    'price' => $product->price,
                    'quantity' => $item['quantity'],
                    'subtotal' => $itemSubtotal,
                    'notes' => $item['notes'] ?? null,
                ];
            }

            if (empty($orderItems)) {
                return back()->withErrors(['items' => 'Pilih minimal 1 produk.'])->withInput();
            }

            $order = Order::create([
                'user_id' => Auth::id(),
                'order_number' => Order::generateOrderNumber(),
                'pickup_date' => $request->pickup_date,
                'pickup_time' => $this->normalizePickupTime($request->pickup_time),
                'delivery_address' => trim($request->delivery_address),
                'subtotal' => $subtotal,
                'total_price' => $subtotal,
                'status' => 'waiting_payment',
                'payment_reference' => Order::generatePaymentReference(),
                'payment_status' => Order::PAYMENT_STATUS_PENDING,
                'payment_expires_at' => now()->addMinutes((int) config('payment_methods.expiry_minutes', 30)),
                'notes' => $request->notes,
            ]);

            foreach ($orderItems as $item) {
                $item['order_id'] = $order->id;
                OrderItem::create($item);
            }

            DB::commit();

            return redirect()->route('order.payment', $order->id)
                ->with('success', 'Pesanan berhasil dibuat! Silakan lakukan pembayaran.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order store failed', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'user_id' => Auth::id(),
                'payload' => $request->except('_token'),
            ]);
            return back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi.'])->withInput();
        }
    }

    public function payment(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $this->expireOrderIfNeeded($order);

        $order->load('items');
        $paymentMethods = collect(config('payment_methods.methods', []))->groupBy('group');

        return view('order.payment', compact('order', 'paymentMethods'));
    }

    public function uploadPayment(Request $request, Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        $this->expireOrderIfNeeded($order);

        if ($order->status !== 'waiting_payment') {
            return back()->withErrors([
                'payment' => 'Pesanan ini sudah tidak menunggu pembayaran.',
            ]);
        }

        if ($order->isPaymentExpired()) {
            $this->expireOrder($order);

            return back()->withErrors([
                'payment' => 'Batas waktu pembayaran sudah habis. Silakan buat pesanan baru.',
            ]);
        }

        $paymentMethods = array_keys(config('payment_methods.methods', []));

        $request->validate([
            'payment_method' => ['required', 'string', Rule::in($paymentMethods)],
        ], [
            'payment_method.required' => 'Pilih metode pembayaran terlebih dahulu.',
            'payment_method.in' => 'Metode pembayaran yang dipilih tidak valid.',
        ]);

        $updateData = [
            'status' => 'payment_uploaded',
            'payment_status' => Order::PAYMENT_STATUS_PAID,
            'payment_paid_at' => now(),
            'payment_method' => $request->payment_method,
        ];

        $order->update($updateData);

        $admin = User::where('role', 'admin')->first();
        if ($admin) {
            $admin->notify(new NewOrderNotification($order));
        }

        return redirect()->route('dashboard')->with('success', 'Pembayaran berhasil! Pesanan Anda sudah masuk ke dashboard admin dan sedang menunggu proses.');
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load('items.product');
        return view('order.show', compact('order'));
    }

    public function invoice(Order $order)
    {
        if ($order->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403);
        }

        $order->load('items.product', 'user');
        return view('order.invoice', compact('order'));
    }

    private function expireOrderIfNeeded(Order $order): void
    {
        if ($order->status === 'waiting_payment' && $order->isPaymentExpired()) {
            $this->expireOrder($order);
        }
    }

    private function expireOrder(Order $order): void
    {
        $order->update([
            'status' => 'cancelled',
            'payment_status' => Order::PAYMENT_STATUS_EXPIRED,
            'admin_notes' => 'Pembayaran melewati batas waktu.',
        ]);
    }

    private function normalizePickupTime(?string $pickupTime): ?string
    {
        if (!$pickupTime) {
            return null;
        }

        // Handle UI slot format like "10:00-12:00" by using the slot start time.
        if (str_contains($pickupTime, '-')) {
            $pickupTime = explode('-', $pickupTime)[0];
        }

        $pickupTime = trim($pickupTime);

        // Normalize HH:MM into HH:MM:SS for TIME column compatibility.
        if (preg_match('/^\d{2}:\d{2}$/', $pickupTime) === 1) {
            return $pickupTime . ':00';
        }

        if (preg_match('/^\d{2}:\d{2}:\d{2}$/', $pickupTime) === 1) {
            return $pickupTime;
        }

        return null;
    }
}
