<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftarkan Mahasiswa Baru</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="max-w-md w-full bg-slate-800 rounded-xl border border-slate-700 shadow-2xl p-6 md:p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white">👤 Registrasi Mahasiswa</h2>
            <p class="text-slate-400 text-sm mt-1">Tambahkan data mahasiswa baru ke dalam sistem akademik.</p>
        </div>
<form action="{{ route('mahasiswa.storeMahasiswa') }}" method="POST" class="space-y-4">
    @csrf
            
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Nomor Induk Mahasiswa (NIM)</label>
                <input type="text" name="nim" required placeholder="Contoh: 241204004" 
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-blue-500 text-sm placeholder:text-slate-600">
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Nama Lengkap</label>
                <input type="text" name="nama" required placeholder="Contoh: Muhammad Reyhan" 
                    class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-blue-500 text-sm placeholder:text-slate-600">
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <a href="{{ route('mahasiswa.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm font-medium transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-500 hover:to-blue-400 text-white font-medium rounded-lg text-sm shadow-lg transition">Daftarkan</button>
            </div>
        </form>
    </div>

</body>
</html>