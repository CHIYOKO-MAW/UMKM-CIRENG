<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification
{
    use Queueable;

    protected $order;

    /**
     * Create a new notification instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        $url = route('admin.orders.show', $this->order->id);

        return (new MailMessage)
            ->subject('💳 Pembayaran Berhasil #' . $this->order->order_number)
            ->greeting('Halo Admin!')
            ->line('Pelanggan telah menyelesaikan pembayaran pesanan.')
            ->line('**Detail Pesanan:**')
            ->line('- Nomor Pesanan: #' . $this->order->order_number)
            ->line('- Pelanggan: ' . $this->order->user->name)
            ->line('- Total: Rp' . number_format($this->order->total_price, 0, ',', '.'))
            ->line('- Metode Bayar: ' . strtoupper((string) $this->order->payment_method))
            ->action('Proses Pesanan', $url)
            ->line('Silakan lanjutkan proses operasional pesanan.');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $items = $this->order->items->map(function ($item) {
            return $item->product_name . ' x' . $item->quantity;
        })->implode(', ');

        return [
            'title' => 'Pembayaran Masuk #' . $this->order->order_number,
            'message' => 'Pelanggan ' . $this->order->user->name . ' telah membayar pesanan: ' . $items,
            'order_id' => $this->order->id,
            'order_number' => $this->order->order_number,
            'total' => $this->order->total_price,
            'customer_name' => $this->order->user->name,
            'payment_method' => $this->order->payment_method,
            'url' => route('admin.orders.show', $this->order->id),
        ];
    }
}
