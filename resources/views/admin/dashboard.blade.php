<x-layouts.app>
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-8">
            <div>
                <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-2">Admin Dashboard</h1>
                <p class="text-lg text-gray-600">Pantau operasional harian, alur pesanan, dan trend penjualan.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-5 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Total Pesanan</p>
                    <p class="mt-2 font-poppins font-bold text-3xl text-gray-900">{{ $totalOrders }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-blue-100 p-6">
                    <p class="text-sm text-blue-700">Menunggu Verifikasi</p>
                    <p class="mt-2 font-poppins font-bold text-3xl text-blue-900">{{ $stageWaitingVerification }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-purple-100 p-6">
                    <p class="text-sm text-purple-700">Sedang Diproses</p>
                    <p class="mt-2 font-poppins font-bold text-3xl text-purple-900">{{ $stageProcessing }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-indigo-100 p-6">
                    <p class="text-sm text-indigo-700">Siap Dikirim</p>
                    <p class="mt-2 font-poppins font-bold text-3xl text-indigo-900">{{ $stageReadyToShip }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-green-100 p-6">
                    <p class="text-sm text-green-700">Selesai Hari Ini</p>
                    <p class="mt-2 font-poppins font-bold text-3xl text-green-900">{{ $completedToday }}</p>
                    <p class="mt-1 text-xs text-gray-500">Total selesai: {{ $completedOrders }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                    <div>
                        <h2 class="font-poppins font-bold text-2xl text-gray-900">Trend Penjualan</h2>
                        <p class="text-sm text-gray-600 mt-1">Data order selesai berdasarkan rentang waktu yang dipilih.</p>
                    </div>
                    <div class="flex gap-2">
                        @foreach($rangeOptions as $range)
                            <a
                                href="{{ route('admin.dashboard', ['range' => $range]) }}"
                                class="px-3 py-2 rounded-lg text-sm font-medium transition-colors {{ $selectedRange === $range ? 'bg-orange-500 text-white' : 'bg-gray-100 text-gray-700 hover:bg-gray-200' }}"
                            >
                                {{ $range }} Hari
                            </a>
                        @endforeach
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                    <div class="rounded-lg bg-orange-50 border border-orange-100 p-4">
                        <p class="text-xs text-orange-700">Total Omzet ({{ $selectedRange }} hari)</p>
                        <p class="text-xl font-bold text-orange-900 mt-1">Rp{{ number_format($rangeRevenue, 0, ',', '.') }}</p>
                    </div>
                    <div class="rounded-lg bg-blue-50 border border-blue-100 p-4">
                        <p class="text-xs text-blue-700">Total Order Selesai</p>
                        <p class="text-xl font-bold text-blue-900 mt-1">{{ $rangeOrders }} order</p>
                    </div>
                    <div class="rounded-lg bg-emerald-50 border border-emerald-100 p-4">
                        <p class="text-xs text-emerald-700">Rata-rata Omzet Harian</p>
                        <p class="text-xl font-bold text-emerald-900 mt-1">Rp{{ number_format((int) round($salesTrend->avg('revenue') ?? 0), 0, ',', '.') }}</p>
                    </div>
                </div>

                <div class="rounded-xl border border-gray-100 bg-gray-50 p-4">
                    <div class="bg-white rounded-lg border border-gray-200 p-4">
                        <div class="h-[340px]">
                            <canvas
                                id="admin-sales-chart"
                                data-trend='@json($salesTrend->values())'
                                data-range="{{ $selectedRange }}"
                            ></canvas>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-1 md:grid-cols-2 gap-3">
                        <div class="rounded-lg border border-orange-100 bg-orange-50 p-3">
                            <p class="text-xs text-orange-700">Hari omzet tertinggi</p>
                            <p class="text-sm font-semibold text-orange-900 mt-1">
                                {{ $topRevenueDay['day_label'] ?? '-' }} · Rp{{ number_format($topRevenueDay['revenue'] ?? 0, 0, ',', '.') }}
                            </p>
                        </div>
                        <div class="rounded-lg border border-blue-100 bg-blue-50 p-3">
                            <p class="text-xs text-blue-700">Hari order tertinggi</p>
                            <p class="text-sm font-semibold text-blue-900 mt-1">
                                {{ $topOrdersDay['day_label'] ?? '-' }} · {{ $topOrdersDay['orders'] ?? 0 }} order
                            </p>
                        </div>
                    </div>

                    <div class="mt-4 overflow-x-auto rounded-lg border border-gray-100">
                        <table class="w-full text-xs">
                            <thead class="bg-gray-50 border-b border-gray-100">
                                <tr>
                                    <th class="text-left py-2 px-3 font-semibold text-gray-600">Tanggal</th>
                                    <th class="text-right py-2 px-3 font-semibold text-gray-600">Omzet</th>
                                    <th class="text-right py-2 px-3 font-semibold text-gray-600">Order</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($trendSnapshot as $point)
                                    <tr class="border-b border-gray-100 last:border-b-0">
                                        <td class="py-2 px-3 text-gray-700">{{ $point['day_label'] }}</td>
                                        <td class="py-2 px-3 text-right font-medium text-gray-900">Rp{{ number_format($point['revenue'], 0, ',', '.') }}</td>
                                        <td class="py-2 px-3 text-right font-medium text-gray-900">{{ $point['orders'] }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex flex-wrap justify-between items-start gap-4 mb-6">
                    <div>
                        <h2 class="font-poppins font-bold text-2xl text-gray-900">Alur Pesanan Hari Ini</h2>
                        <p class="text-sm text-gray-600 mt-1">Alur kerja sederhana: verifikasi pembayaran, proses produksi, siapkan pengiriman, lalu tutup pesanan.</p>
                    </div>
                    <a href="{{ route('admin.orders.history') }}" class="px-4 py-2 rounded-lg bg-gray-100 hover:bg-gray-200 text-sm font-medium text-gray-700">
                        Lihat Riwayat Pesanan
                    </a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-4">
                    <div class="rounded-xl border border-blue-200 p-5 bg-blue-50">
                        <p class="text-xs font-semibold text-blue-700 mb-2">Langkah 1</p>
                        <p class="font-poppins font-bold text-blue-900 text-lg">Menunggu Verifikasi</p>
                        <p class="mt-1 text-3xl font-bold text-blue-900">{{ $stageWaitingVerification }}</p>
                        <p class="text-xs text-blue-700 mt-2">Konfirmasi pembayaran yang baru masuk.</p>
                        <a href="{{ route('admin.orders.index', ['stage' => 'waiting_verification']) }}" class="mt-4 inline-block text-sm font-semibold text-blue-700 hover:text-blue-900">Buka antrian</a>
                    </div>
                    <div class="rounded-xl border border-purple-200 p-5 bg-purple-50">
                        <p class="text-xs font-semibold text-purple-700 mb-2">Langkah 2</p>
                        <p class="font-poppins font-bold text-purple-900 text-lg">Diproses</p>
                        <p class="mt-1 text-3xl font-bold text-purple-900">{{ $stageProcessing }}</p>
                        <p class="text-xs text-purple-700 mt-2">Produksi aktif, termasuk status terkonfirmasi.</p>
                        <a href="{{ route('admin.orders.index', ['stage' => 'processing']) }}" class="mt-4 inline-block text-sm font-semibold text-purple-700 hover:text-purple-900">Lihat proses</a>
                    </div>
                    <div class="rounded-xl border border-indigo-200 p-5 bg-indigo-50">
                        <p class="text-xs font-semibold text-indigo-700 mb-2">Langkah 3</p>
                        <p class="font-poppins font-bold text-indigo-900 text-lg">Siap Dikirim</p>
                        <p class="mt-1 text-3xl font-bold text-indigo-900">{{ $stageReadyToShip }}</p>
                        <p class="text-xs text-indigo-700 mt-2">Pesanan siap kirim, tinggal jadwalkan armada.</p>
                        <a href="{{ route('admin.orders.index', ['stage' => 'ready_to_ship']) }}" class="mt-4 inline-block text-sm font-semibold text-indigo-700 hover:text-indigo-900">Lihat siap kirim</a>
                    </div>
                    <div class="rounded-xl border border-green-200 p-5 bg-green-50">
                        <p class="text-xs font-semibold text-green-700 mb-2">Langkah 4</p>
                        <p class="font-poppins font-bold text-green-900 text-lg">Selesai</p>
                        <p class="mt-1 text-3xl font-bold text-green-900">{{ $completedOrders }}</p>
                        <p class="text-xs text-green-700 mt-2">Riwayat pesanan selesai untuk evaluasi performa.</p>
                        <a href="{{ route('admin.orders.history', ['status' => 'completed']) }}" class="mt-4 inline-block text-sm font-semibold text-green-700 hover:text-green-900">Buka riwayat selesai</a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Total Pendapatan</p>
                    <p class="mt-2 font-poppins font-bold text-3xl text-gray-900">Rp{{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Total Produk</p>
                    <p class="mt-2 font-poppins font-bold text-3xl text-gray-900">{{ $totalProducts }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                    <p class="text-sm text-gray-500">Total Pelanggan</p>
                    <p class="mt-2 font-poppins font-bold text-3xl text-gray-900">{{ $totalCustomers }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-6">
                <div class="flex items-center justify-between mb-4">
                    <h2 class="font-poppins font-bold text-2xl text-gray-900">Pesanan Terbaru</h2>
                    <a href="{{ route('admin.orders.index') }}" class="text-sm text-orange-600 hover:text-orange-700 font-semibold">Kelola pesanan</a>
                </div>
                @if($recentOrders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200">
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700">Nomor</th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700">Pelanggan</th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700">Total</th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700">Tanggal</th>
                                    <th class="text-left py-3 px-3 font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($recentOrders as $order)
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="py-3 px-3 font-medium text-gray-900">#{{ $order->order_number }}</td>
                                        <td class="py-3 px-3 text-gray-700">{{ $order->user->name }}</td>
                                        <td class="py-3 px-3 font-bold text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="py-3 px-3">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold
                                                {{ $order->status === 'payment_uploaded' ? 'bg-blue-100 text-blue-800' : '' }}
                                                {{ in_array($order->status, ['confirmed','processing']) ? 'bg-purple-100 text-purple-800' : '' }}
                                                {{ $order->status === 'ready' ? 'bg-indigo-100 text-indigo-800' : '' }}
                                                {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : '' }}
                                                {{ $order->status === 'cancelled' ? 'bg-red-100 text-red-800' : '' }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-3 text-gray-700">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="py-3 px-3">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-600 hover:text-orange-700 font-semibold">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="text-gray-500">Belum ada data pesanan.</p>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
