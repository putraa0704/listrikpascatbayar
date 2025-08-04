@extends('layouts.app')

@section('title', 'Riwayat Penggunaan Listrik')

@section('content')
<div class="bg-white p-6 rounded-lg shadow-md">
    <h1 class="text-3xl font-bold text-green-800 mb-6">Riwayat Penggunaan Listrik</h1>

    <div class="overflow-x-auto rounded-md shadow">
        <table class="min-w-full bg-white border border-gray-200">
            <thead class="bg-green-100 text-green-800">
                <tr>
                    <th class="py-2 px-4 border-b text-left">No</th>
                    <th class="py-2 px-4 border-b text-left">Bulan/Tahun</th>
                    <th class="py-2 px-4 border-b text-left">Meter Awal</th>
                    <th class="py-2 px-4 border-b text-left">Meter Akhir</th>
                    <th class="py-2 px-4 border-b text-left">Jumlah Meter</th>
                    <th class="py-2 px-4 border-b text-left">Dicatat Pada</th>
                </tr>
            </thead>
            <tbody>
                @forelse($riwayatPenggunaan as $penggunaan)
                <tr class="hover:bg-green-50 transition">
                    <td class="py-2 px-4 border-b">{{ $loop->iteration }}</td>
                    <td class="py-2 px-4 border-b">{{ $penggunaan->bulan }} {{ $penggunaan->tahun }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($penggunaan->meter_awal, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b">{{ number_format($penggunaan->meter_akhir, 0, ',', '.') }}</td>
                    <td class="py-2 px-4 border-b text-green-700 font-semibold">{{ number_format($penggunaan->jumlah_meter, 0, ',', '.') }} KWH</td>
                    <td class="py-2 px-4 border-b">{{ $penggunaan->updated_at->format('d M Y H:i') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="py-4 px-4 text-center text-gray-500 italic">Belum ada riwayat penggunaan listrik.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
         {{-- Pagination --}}
        @if ($riwayatPenggunaan->hasPages())
            <div class="mt-6 flex justify-center">
                {{ $riwayatPenggunaan->onEachSide(1)->links('vendor.pagination.tailwind-hijau') }}
            </div>
         @endif
    </div>
</div>
@endsection
