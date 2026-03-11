<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice #{{ $order->order_number }} - Cireng Rujak</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f5f5;
            padding: 20px;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            background: white;
            border-radius: 12px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        .invoice-header {
            background: linear-gradient(135deg, #FF6B35, #FF8C5A);
            color: white;
            padding: 30px;
            text-align: center;
        }
        .invoice-header h1 {
            font-size: 28px;
            margin-bottom: 5px;
        }
        .invoice-header p {
            opacity: 0.9;
        }
        .invoice-body {
            padding: 30px;
        }
        .invoice-info {
            display: flex;
            justify-content: space-between;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #eee;
        }
        .invoice-info div {
            flex: 1;
        }
        .invoice-info h3 {
            color: #FF6B35;
            margin-bottom: 10px;
            font-size: 14px;
            text-transform: uppercase;
        }
        .invoice-info p {
            color: #666;
            font-size: 14px;
            line-height: 1.8;
        }
        .invoice-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .invoice-table th {
            background: #f8f8f8;
            padding: 12px;
            text-align: left;
            font-size: 12px;
            text-transform: uppercase;
            color: #666;
            border-bottom: 2px solid #eee;
        }
        .invoice-table td {
            padding: 12px;
            border-bottom: 1px solid #eee;
            font-size: 14px;
        }
        .invoice-table .text-right {
            text-align: right;
        }
        .invoice-table .font-bold {
            font-weight: bold;
        }
        .invoice-total {
            background: #FFF8F5;
            padding: 20px;
            border-radius: 8px;
            text-align: right;
        }
        .invoice-total .label {
            font-size: 14px;
            color: #666;
        }
        .invoice-total .amount {
            font-size: 24px;
            font-weight: bold;
            color: #FF6B35;
        }
        .invoice-footer {
            background: #f8f8f8;
            padding: 20px 30px;
            text-align: center;
            font-size: 12px;
            color: #999;
        }
        .status-badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 600;
        }
        .status-waiting_payment { background: #FEF3C7; color: #92400E; }
        .status-payment_uploaded { background: #DBEAFE; color: #1E40AF; }
        .status-confirmed { background: #D1FAE5; color: #065F46; }
        .status-processing { background: #EDE9FE; color: #5B21B6; }
        .status-ready { background: #CCFBF1; color: #134E4A; }
        .status-completed { background: #F3F4F6; color: #374151; }
        .print-btn {
            position: fixed;
            bottom: 30px;
            right: 30px;
            background: #FF6B35;
            color: white;
            border: none;
            padding: 15px 25px;
            border-radius: 50px;
            cursor: pointer;
            font-size: 14px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(255, 107, 53, 0.4);
            transition: all 0.3s;
        }
        .print-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(255, 107, 53, 0.5);
        }
        @media print {
            body { background: white; }
            .print-btn { display: none; }
            .invoice-container { box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="invoice-container">
        <div class="invoice-header">
            <h1>🌶️ Cireng Rujak</h1>
            <p>UMKM Kota Serang - Invoice Pesanan</p>
        </div>

        <div class="invoice-body">
            <div class="invoice-info">
                <div>
                    <h3>Detail Pesanan</h3>
                    <p>
                        <strong>Nomor Invoice:</strong> #{{ $order->order_number }}<br>
                        <strong>Tanggal Pesan:</strong> {{ $order->created_at->format('d M Y, H:i') }}<br>
                        <strong>Tanggal Pengiriman:</strong> {{ \Carbon\Carbon::parse($order->pickup_date)->format('d M Y') }}
                        @if($order->pickup_time)
                            <br><strong>Waktu:</strong> {{ $order->pickup_time }}
                        @endif
                    </p>
                </div>
                <div>
                    <h3>Status Pesanan</h3>
                    <p>
                        <span class="status-badge status-{{ $order->status }}">
                            {{ $order->status_label }}
                        </span>
                    </p>
                </div>
                <div>
                    <h3>Informasi Pelanggan</h3>
                    <p>
                        <strong>Nama:</strong> {{ $order->user->name }}<br>
                        <strong>Email:</strong> {{ $order->user->email }}<br>
                        @if($order->user->phone)
                        <strong>Telepon:</strong> {{ $order->user->phone }}
                        @endif
                    </p>
                </div>
            </div>

            <table class="invoice-table">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Produk</th>
                        <th class="text-right">Harga</th>
                        <th class="text-right">Qty</th>
                        <th class="text-right">Subtotal</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($order->items as $index => $item)
                    <tr>
                        <td>{{ $index + 1 }}</td>
                        <td>{{ $item->product_name }}</td>
                        <td class="text-right">Rp {{ number_format($item->price, 0, ',', '.') }}</td>
                        <td class="text-right">{{ $item->quantity }}</td>
                        <td class="text-right">Rp {{ number_format($item->subtotal, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>

            @if($order->notes)
            <div style="margin-bottom: 20px; padding: 15px; background: #f8f8f8; border-radius: 8px;">
                <strong>Catatan:</strong> {{ $order->notes }}
            </div>
            @endif

            <div class="invoice-total">
                <p class="label">Total Pembayaran</p>
                <p class="amount">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="invoice-footer">
            <p>Terima kasih telah memesan di Cireng Rujak!</p>
            <p>Untuk pertanyaan, hubungi kami di WhatsApp: +62 851-8306-2643</p>
        </div>
    </div>

    <button class="print-btn" onclick="window.print()">
        🖨️ Cetak Invoice
    </button>
</body>
</html>
