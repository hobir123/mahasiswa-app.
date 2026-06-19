<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Isi Presensi Baru</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-900 text-slate-100 min-h-screen flex flex-col items-center justify-center p-6">

    <div class="max-w-md w-full bg-slate-800 rounded-xl border border-slate-700 shadow-2xl p-6 md:p-8">
        <div class="mb-6">
            <h2 class="text-2xl font-bold text-white">Input Absensi Mahasiswa</h2>
            <p class="text-slate-450 text-sm mt-1">Pilih status kehadiran mahasiswa untuk sesi kuliah ini.</p>
        </div>

        <form action="{{ route('mahasiswa.store') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Pilih Nama Mahasiswa</label>
                <select name="nama" required class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-red-500 text-sm">
                    <option value="">-- Pilih Mahasiswa --</option>
                    <option value="1">Achmad Hobir (241204001)</option>
                    <option value="2">Siti Aminah (241204002)</option>
                    <option value="3">Rian Hidayat (241204003)</option>
                </select>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Status Kehadiran</label>
                <div class="grid grid-cols-3 gap-3 mt-2">
                    <label class="flex flex-col items-center justify-center p-3 bg-slate-900 border border-slate-700 rounded-xl cursor-pointer hover:border-emerald-500 transition">
                        <input type="radio" name="status" value="Hadir" class="accent-emerald-500 mb-1" checked>
                        <span class="text-xs text-emerald-400 font-bold">Hadir</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 bg-slate-900 border border-slate-700 rounded-xl cursor-pointer hover:border-amber-500 transition">
                        <input type="radio" name="status" value="Izin" class="accent-amber-500 mb-1">
                        <span class="text-xs text-amber-400 font-bold">Izin</span>
                    </label>
                    <label class="flex flex-col items-center justify-center p-3 bg-slate-900 border border-slate-700 rounded-xl cursor-pointer hover:border-red-500 transition">
                        <input type="radio" name="status" value="Alpa" class="accent-red-500 mb-1">
                        <span class="text-xs text-red-400 font-bold">Alpa</span>
                    </label>
                </div>
            </div>

            <div>
                <label class="block text-sm font-medium text-slate-300 mb-1">Catatan / Keterangan (Opsional)</label>
                <textarea name="keterangan" rows="2" placeholder="Contoh: Sakit flu, Surat menyusul" class="w-full bg-slate-900 border border-slate-700 rounded-lg px-3 py-2 text-white focus:outline-none focus:border-red-500 text-sm placeholder:text-slate-600"></textarea>
            </div>

            <div class="flex justify-end space-x-3 pt-2">
                <a href="{{ route('mahasiswa.index') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 rounded-lg text-sm font-medium transition">Batal</a>
                <button type="submit" class="px-4 py-2 bg-gradient-to-r from-red-600 to-red-500 text-white font-medium rounded-lg text-sm shadow-lg transition">Submit Absen</button>
            </div>
        </form>
    </div>

</body>
</html>