@extends('layouts.app')

@section('title', 'Edit Tarif Listrik')

@section('content')
<style>
    body {
        background: linear-gradient(135deg, #d1fae5, #f3f4f6); /* Hijau daun ke abu muda */
    }

    .form-container {
        background-color: #ffffff;
        padding: 2rem;
        border-radius: 1rem;
        box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
    }

    label {
        color: #065f46; /* Hijau daun */
        font-weight: 600;
    }

    input, select {
        border-color: #d1d5db;
    }

    input:focus, select:focus {
        border-color: #10b981; /* Fokus hijau */
        box-shadow: 0 0 0 3px rgba(16, 185, 129, 0.3);
    }

    .btn-green {
        background-color: #10b981;
    }

    .btn-green:hover {
        background-color: #059669;
    }

    .btn-cancel {
        color: #4b5563;
    }

    .btn-cancel:hover {
        color: #1f2937;
    }
</style>

<div class="form-container w-full max-w-lg mx-auto">
    <h1 class="text-3xl font-bold text-green-700 mb-6 text-center">Edit Tarif</h1>

    <form action="{{ route('admin.tarifs.update', $tarif->id) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="daya" class="block text-sm mb-2">Daya (VA):</label>
            <input type="number" id="daya" name="daya" 
                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring @error('daya') border-red-500 @enderror" 
                value="{{ old('daya', $tarif->daya) }}" required>
            @error('daya')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="mb-6">
            <label for="tarif_perkwh" class="block text-sm mb-2">Tarif per kWh (Rp):</label>
            <input type="number" step="0.01" id="tarif_perkwh" name="tarif_perkwh" 
                class="shadow border rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring @error('tarif_perkwh') border-red-500 @enderror" 
                value="{{ old('tarif_perkwh', $tarif->tarif_perkwh) }}" required>
            @error('tarif_perkwh')
                <p class="text-red-500 text-xs italic mt-2">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <button type="submit" class="btn-green text-white font-bold py-2 px-4 rounded focus:outline-none focus:ring">
                Update Tarif
            </button>
            <a href="{{ route('admin.tarifs.index') }}" class="btn-cancel font-bold text-sm">
                Batal
            </a>
        </div>
    </form>
</div>
@endsection
