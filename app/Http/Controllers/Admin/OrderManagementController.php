<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderManagementController extends Controller
{
    public function index(Request $request)
    {
        $query = Order::with('user', 'items')->paidForAdmin()->latest();

        if ($request->stage) {
            $stageMap = [
                'waiting_verification' => ['payment_uploaded'],
                'processing' => ['confirmed', 'processing'],
                'ready_to_ship' => ['ready'],
                'completed' => ['completed'],
            ];

            if (isset($stageMap[$request->stage])) {
                $query->whereIn('status', $stageMap[$request->stage]);
            }
        }

        if ($request->status) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q2) use ($request) {
                        $q2->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->date) {
            $query->whereDate('pickup_date', $request->date);
        }

        $orders = $query->paginate(15)->withQueryString();
        $statusLabels = Order::STATUS_LABELS;

        return view('admin.orders.index', compact('orders', 'statusLabels'));
    }

    public function history(Request $request)
    {
        $query = Order::with('user', 'items')
            ->paidForAdmin()
            ->whereIn('status', ['completed', 'cancelled'])
            ->latest('completed_at')
            ->latest();

        if ($request->status && in_array($request->status, ['completed', 'cancelled'], true)) {
            $query->where('status', $request->status);
        }

        if ($request->search) {
            $query->where(function ($q) use ($request) {
                $q->where('order_number', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($q2) use ($request) {
                        $q2->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        if ($request->date_from) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }

        if ($request->date_to) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $historySummary = [
            'total' => (clone $query)->count(),
            'completed' => (clone $query)->where('status', 'completed')->count(),
            'cancelled' => (clone $query)->where('status', 'cancelled')->count(),
            'revenue' => (clone $query)->where('status', 'completed')->sum('total_price'),
        ];
        $orders = $query->paginate(20)->withQueryString();

        return view('admin.orders.history', compact('orders', 'historySummary'));
    }

    public function show(Order $order)
    {
        $order->load('user', 'items.product');
        return view('admin.orders.show', compact('order'));
    }

    public function updateStatus(Request $request, Order $order)
    {
        $request->validate([
            'status' => 'required|in:' . implode(',', array_keys(Order::STATUS_LABELS)),
            'admin_notes' => 'nullable|string|max:500',
        ]);

        $currentStatus = $order->status;
        $newStatus = $request->status;

        $allowedTransitions = [
            'waiting_payment' => ['cancelled'],
            'payment_uploaded' => ['confirmed', 'cancelled'],
            'confirmed' => ['processing', 'cancelled'],
            'processing' => ['ready', 'cancelled'],
            'ready' => ['completed', 'cancelled'],
        ];

        if ($newStatus !== $currentStatus) {
            $isAllowed = in_array($newStatus, $allowedTransitions[$currentStatus] ?? [], true);

            if (!$isAllowed) {
                return back()->withErrors([
                    'status' => 'Transisi status tidak valid untuk kondisi pesanan saat ini.',
                ]);
            }
        }

        $updateData = [
            'status' => $newStatus,
            'admin_notes' => $request->has('admin_notes') ? $request->admin_notes : $order->admin_notes,
        ];

        if ($newStatus === 'confirmed' && !$order->confirmed_at) {
            $updateData['confirmed_at'] = now();
        }

        if ($newStatus === 'completed' && !$order->completed_at) {
            $updateData['completed_at'] = now();
        }

        $order->update($updateData);

        return back()->with('success', 'Status pesanan berhasil diperbarui!');
    }
}
