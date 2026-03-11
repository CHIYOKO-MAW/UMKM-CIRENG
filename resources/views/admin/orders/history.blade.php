<x-layouts.app>
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 space-y-6">
            <div class="flex flex-wrap items-start justify-between gap-4">
                <div>
                    <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-2">Riwayat Pesanan</h1>
                    <p class="text-lg text-gray-600">Data pesanan selesai dan dibatalkan untuk evaluasi operasional.</p>
                </div>
                <a href="{{ route('admin.dashboard') }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 text-gray-700 hover:bg-gray-100 text-sm font-medium">
                    Kembali ke Dashboard
                </a>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                    <p class="text-xs text-gray-500">Total Riwayat</p>
                    <p class="text-2xl font-bold text-gray-900 mt-1">{{ $historySummary['total'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-green-100 p-5">
                    <p class="text-xs text-green-700">Selesai</p>
                    <p class="text-2xl font-bold text-green-900 mt-1">{{ $historySummary['completed'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-red-100 p-5">
                    <p class="text-xs text-red-700">Dibatalkan</p>
                    <p class="text-2xl font-bold text-red-900 mt-1">{{ $historySummary['cancelled'] }}</p>
                </div>
                <div class="bg-white rounded-xl shadow-sm border border-orange-100 p-5">
                    <p class="text-xs text-orange-700">Omzet Riwayat</p>
                    <p class="text-2xl font-bold text-orange-900 mt-1">Rp{{ number_format($historySummary['revenue'], 0, ',', '.') }}</p>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-5">
                <form method="GET" action="{{ route('admin.orders.history') }}" class="grid grid-cols-1 md:grid-cols-5 gap-3">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nomor pesanan / pelanggan" class="md:col-span-2 px-4 py-2 rounded-lg border border-gray-200 focus:border-orange-500 outline-none">
                    <select name="status" class="px-4 py-2 rounded-lg border border-gray-200 focus:border-orange-500 outline-none">
                        <option value="">Semua Status Riwayat</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <input type="date" name="date_from" value="{{ request('date_from') }}" class="px-4 py-2 rounded-lg border border-gray-200 focus:border-orange-500 outline-none">
                    <input type="date" name="date_to" value="{{ request('date_to') }}" class="px-4 py-2 rounded-lg border border-gray-200 focus:border-orange-500 outline-none">
                    <button type="submit" class="px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-white text-sm font-medium">Terapkan Filter</button>
                </form>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead class="bg-gray-50 border-b border-gray-200">
                                <tr>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Nomor Pesanan</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Pelanggan</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Alamat</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Total</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Status</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Tanggal Selesai/Update</th>
                                    <th class="text-left py-3 px-4 font-semibold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    @php
                                        $historyDate = $order->completed_at ?? $order->updated_at;
                                        $address = $order->delivery_address ?: optional($order->user)->address;
                                    @endphp
                                    <tr class="border-b border-gray-100 hover:bg-gray-50">
                                        <td class="py-3 px-4 font-medium text-gray-900">#{{ $order->order_number }}</td>
                                        <td class="py-3 px-4 text-gray-700">{{ $order->user->name }}</td>
                                        <td class="py-3 px-4 text-gray-600 max-w-xs truncate" title="{{ $address }}">{{ $address ?: '-' }}</td>
                                        <td class="py-3 px-4 font-bold text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="py-3 px-4">
                                            <span class="px-2 py-1 rounded-full text-xs font-semibold {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                                {{ $order->status_label }}
                                            </span>
                                        </td>
                                        <td class="py-3 px-4 text-gray-700">{{ $historyDate ? $historyDate->format('d M Y H:i') : '-' }}</td>
                                        <td class="py-3 px-4">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-600 hover:text-orange-700 font-semibold">Detail</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="p-4 border-t border-gray-100">
                        <div class="flex flex-wrap items-center justify-between gap-3">
                            <p class="text-sm text-gray-600">
                                Halaman {{ $orders->currentPage() }} dari {{ $orders->lastPage() }} ·
                                Menampilkan {{ $orders->firstItem() }}-{{ $orders->lastItem() }} dari {{ $orders->total() }} data
                            </p>
                            <div class="flex items-center gap-2">
                                @if($orders->onFirstPage())
                                    <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed">Previous</span>
                                @else
                                    <a href="{{ $orders->previousPageUrl() }}" class="px-4 py-2 rounded-lg bg-white border border-gray-200 hover:bg-gray-50 text-sm font-medium text-gray-700">Previous</a>
                                @endif

                                @if($orders->hasMorePages())
                                    <a href="{{ $orders->nextPageUrl() }}" class="px-4 py-2 rounded-lg bg-orange-500 hover:bg-orange-600 text-sm font-medium text-white">Next</a>
                                @else
                                    <span class="px-4 py-2 rounded-lg bg-gray-100 text-gray-400 text-sm font-medium cursor-not-allowed">Next</span>
                                @endif
                            </div>
                        </div>
                    </div>
                @else
                    <div class="p-8 text-center text-gray-500">
                        Tidak ada data riwayat pada filter yang dipilih.
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
