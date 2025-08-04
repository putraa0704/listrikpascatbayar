@extends('layouts.app')

@section('title', 'Daftar Tarif Listrik Petugas')

@section('content')
<div class="bg-white p-6 rounded-xl shadow-md">
    <h1 class="text-3xl font-bold text-green-800 mb-6">Daftar Tarif Listrik</h1>

    <div class="overflow-x-auto">
        <table class="min-w-full bg-white border border-green-200 rounded-xl overflow-hidden shadow-sm">
            <thead class="bg-gradient-to-r from-green-500 to-green-600 text-white">
                <tr>
                    <th class="py-3 px-5 text-left font-semibold">Nomor</th>
                    <th class="py-3 px-5 text-left font-semibold">Daya (VA)</th>
                    <th class="py-3 px-5 text-left font-semibold">Tarif per kWh (Rp)</th>
                    <th class="py-3 px-5 text-left font-semibold">Terakhir Diperbarui</th>
                    <th class="py-3 px-5 text-center font-semibold">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse($tarifs as $tarif)
                    <tr class="hover:bg-green-50 transition duration-200">
                        <td class="py-3 px-5 border-b border-green-100">{{ $loop->iteration }}</td>
                        <td class="py-3 px-5 border-b border-green-100">{{ number_format($tarif->daya, 0, ',', '.') }}</td>
                        <td class="py-3 px-5 border-b border-green-100">Rp {{ number_format($tarif->tarif_perkwh, 2, ',', '.') }}</td>
                        <td class="py-3 px-5 border-b border-green-100">{{ $tarif->updated_at->format('d M Y H:i') }}</td>
                        <td class="py-3 px-5 border-b border-green-100 text-center">
                            <span class="text-gray-500 text-sm italic">Tidak ada aksi</span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-5 px-5 text-center text-gray-500 italic">
                            Belum ada data tarif.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
