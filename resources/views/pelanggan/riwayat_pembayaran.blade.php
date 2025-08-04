@extends('layouts.app')

@section('title', 'Riwayat Pembayaran')

@section('content')
    <div class="bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-3xl font-bold text-green-800 mb-6">Riwayat Pembayaran</h1>

        <form method="GET" class="mb-4 flex flex-wrap gap-2">
            <input type="text" name="q" value="{{ request('q') }}" placeholder="Cari bulan/tahun/total bayar"
                class="px-3 py-1 border border-gray-300 rounded shadow-sm focus:ring focus:ring-green-200">
            <select name="sort" class="px-3 py-1 border border-gray-300 rounded shadow-sm">
                <option value="tanggal_pembayaran" {{ request('sort') == 'tanggal_pembayaran' ? 'selected' : '' }}>Tanggal Pembayaran</option>
                <option value="total_bayar" {{ request('sort') == 'total_bayar' ? 'selected' : '' }}>Total Bayar</option>
            </select>
            <select name="direction" class="px-3 py-1 border border-gray-300 rounded shadow-sm">
                <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>Terbaru</option>
                <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>Terlama</option>
            </select>
            <button type="submit" class="bg-green-600 hover:bg-green-700 text-white px-4 py-1 rounded-md shadow">Cari / Sortir</button>
        </form>

        <div class="overflow-x-auto rounded-lg shadow">
            <table class="min-w-full bg-white border border-gray-200">
                <thead class="bg-green-100 text-green-800">
                    <tr>
                        <th class="py-2 px-4 border-b text-left">ID Pembayaran</th>
                        <th class="py-2 px-4 border-b text-left">No. Tagihan</th>
                        <th class="py-2 px-4 border-b text-left">Periode Tagihan</th>
                        <th class="py-2 px-4 border-b text-left">Total Tagihan</th>
                        <th class="py-2 px-4 border-b text-left">Biaya Admin</th>
                        <th class="py-2 px-4 border-b text-left">Total Dibayar</th>
                        <th class="py-2 px-4 border-b text-left">Tanggal Pembayaran</th>
                        <th class="py-2 px-4 border-b text-left">Dicatat Oleh</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($riwayatPembayaran as $pembayaran)
                        <tr class="hover:bg-green-50 transition">
                            <td class="py-2 px-4 border-b">{{ $pembayaran->id }}</td>
                            <td class="py-2 px-4 border-b">{{ $pembayaran->tagihan->id ?? 'N/A' }}</td>
                            <td class="py-2 px-4 border-b">
                                {{ ($pembayaran->tagihan->bulan ?? 'N/A') . ' ' . ($pembayaran->tagihan->tahun ?? '') }}
                            </td>
                            <td class="py-2 px-4 border-b text-green-700 font-semibold">Rp {{ number_format($pembayaran->tagihan->total_tagihan ?? 0, 2, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b">Rp {{ number_format($pembayaran->biaya_admin, 2, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b font-bold text-green-800">Rp {{ number_format($pembayaran->total_bayar, 2, ',', '.') }}</td>
                            <td class="py-2 px-4 border-b">{{ $pembayaran->tanggal_pembayaran->format('d M Y') }}</td>
                            <td class="py-2 px-4 border-b">{{ $pembayaran->user->nama_user ?? 'Dibayar Oleh Pelanggan' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-4 px-4 text-center text-gray-500 italic">Belum ada riwayat pembayaran.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-4">
            {{ $riwayatPembayaran->links() }}
        </div>
    </div>
@endsection
