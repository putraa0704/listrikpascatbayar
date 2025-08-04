<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register Pelanggan</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <form action="/register" method="POST" class="bg-white p-6 rounded shadow-md w-[400px]">
        @csrf
        <h2 class="text-2xl font-bold mb-4 text-center">Register Pelanggan</h2>

        <div class="mb-3">
            <label class="block mb-1">Nama</label>
            <input type="text" name="nama_pelanggan" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1">Username</label>
            <input type="text" name="username" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1">Password</label>
            <input type="password" name="password" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1">Konfirmasi Password</label>
            <input type="password" name="password_confirmation" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1">Alamat</label>
            <input type="text" name="alamat" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1">Daya (watt)</label>
            <input type="number" name="daya" class="w-full border px-3 py-2 rounded" required>
        </div>

        <div class="mb-3">
            <label class="block mb-1">Pilih Tarif</label>
            <select name="id_tarif" class="w-full border px-3 py-2 rounded" required>
                @foreach (\App\Models\Tarif::all() as $tarif)
                    <option value="{{ $tarif->id }}">{{ $tarif->daya }} watt - Rp{{ number_format($tarif->tarif_perkwh, 0) }}/kWh</option>
                @endforeach
            </select>
        </div>

        <button class="w-full bg-green-600 text-white py-2 rounded hover:bg-green-700">Daftar</button>

        <p class="text-sm mt-3 text-center">Sudah punya akun? <a href="/login" class="text-blue-600">Login</a></p>
    </form>
</body>
</html>
