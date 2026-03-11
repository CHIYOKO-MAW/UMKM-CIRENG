<x-layouts.app>
    <!-- Admin Orders Section -->
    <section class="min-h-screen pt-32 pb-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Header -->
            <div class="mb-12 flex justify-between items-center">
                <div>
                    <h1 class="font-poppins font-bold text-4xl text-gray-900 mb-2">Kelola Pesanan</h1>
                    <p class="text-lg text-gray-600">Pesanan yang sudah dibayar dan siap diproses admin</p>
                </div>
                <x-button variant="outline" href="{{ route('admin.dashboard') }}">
                    Kembali ke Dashboard
                </x-button>
            </div>

            <!-- Filters -->
            <div class="bg-white rounded-xl shadow-md p-6 mb-8">
                <form method="GET" action="{{ route('admin.orders.index') }}" class="flex gap-4">
                    @if(request('stage'))
                        <input type="hidden" name="stage" value="{{ request('stage') }}">
                    @endif
                    <div class="flex-1">
                        <input type="text" name="search" placeholder="Cari nomor pesanan atau nama pelanggan..." class="w-full px-4 py-2 rounded-lg border border-gray-200 focus:border-orange-500 outline-none" value="{{ request('search') }}">
                    </div>
                    <select name="status" class="px-4 py-2 rounded-lg border border-gray-200 focus:border-orange-500 outline-none">
                        <option value="">Semua Status</option>
                        <option value="payment_uploaded" {{ request('status') === 'payment_uploaded' ? 'selected' : '' }}>Menunggu Verifikasi</option>
                        <option value="confirmed" {{ request('status') === 'confirmed' ? 'selected' : '' }}>Dikonfirmasi</option>
                        <option value="processing" {{ request('status') === 'processing' ? 'selected' : '' }}>Diproses</option>
                        <option value="ready" {{ request('status') === 'ready' ? 'selected' : '' }}>Siap Dikirim</option>
                        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Selesai</option>
                        <option value="cancelled" {{ request('status') === 'cancelled' ? 'selected' : '' }}>Dibatalkan</option>
                    </select>
                    <button type="submit" class="btn btn-primary px-6 py-2 rounded-lg font-medium">
                        Filter
                    </button>
                </form>
            </div>

            @if(request('stage'))
                <div class="mb-6 p-4 rounded-lg bg-blue-50 border border-blue-100 text-sm text-blue-700">
                    Filter tahap aktif:
                    <span class="font-semibold">
                        {{ [
                            'waiting_verification' => 'Menunggu Verifikasi',
                            'processing' => 'Diproses',
                            'ready_to_ship' => 'Siap Dikirim',
                            'completed' => 'Selesai',
                        ][request('stage')] ?? request('stage') }}
                    </span>
                </div>
            @endif

            <!-- Orders Table -->
            <div class="bg-white rounded-xl shadow-md overflow-hidden">
                @if($orders->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-gray-200 bg-gray-50">
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Nomor Pesanan</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Pelanggan</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Total</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Status</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Tgl Pesanan</th>
                                    <th class="text-left py-4 px-6 font-bold text-gray-700">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($orders as $order)
                                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition-colors">
                                        <td class="py-4 px-6 font-medium text-gray-900">#{{ $order->order_number }}</td>
                                        <td class="py-4 px-6">
                                            <div>
                                                <p class="font-medium text-gray-900">{{ $order->user->name }}</p>
                                                <p class="text-xs text-gray-500">{{ $order->user->email }}</p>
                                            </div>
                                        </td>
                                        <td class="py-4 px-6 font-bold text-orange-600">Rp{{ number_format($order->total_price, 0, ',', '.') }}</td>
                                        <td class="py-4 px-6">
                                            @if($order->status === 'payment_uploaded')
                                                <span class="inline-block bg-blue-100 text-blue-800 px-2 py-1 rounded text-xs font-semibold">🔎 Menunggu Verifikasi</span>
                                            @elseif($order->status === 'confirmed' || $order->status === 'processing')
                                                <span class="inline-block bg-purple-100 text-purple-800 px-2 py-1 rounded text-xs font-semibold">👨‍🍳 Diproses</span>
                                            @elseif($order->status === 'ready')
                                                <span class="inline-block bg-indigo-100 text-indigo-800 px-2 py-1 rounded text-xs font-semibold">📦 Siap</span>
                                            @elseif($order->status === 'completed')
                                                <span class="inline-block bg-green-100 text-green-800 px-2 py-1 rounded text-xs font-semibold">✅ Selesai</span>
                                            @else
                                                <span class="inline-block bg-red-100 text-red-800 px-2 py-1 rounded text-xs font-semibold">❌ Batal</span>
                                            @endif
                                        </td>
                                        <td class="py-4 px-6 text-gray-700">{{ $order->created_at->format('d M Y') }}</td>
                                        <td class="py-4 px-6">
                                            <a href="{{ route('admin.orders.show', $order) }}" class="text-orange-600 hover:text-orange-700 font-medium text-sm">
                                                Detail
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="p-6 border-t border-gray-200">
                        {{ $orders->links() }}
                    </div>
                @else
                    <div class="text-center py-12">
                        <p class="text-gray-600 text-lg">Tidak ada pesanan ditemukan</p>
                    </div>
                @endif
            </div>
        </div>
    </section>
</x-layouts.app>
