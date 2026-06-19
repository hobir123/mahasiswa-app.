<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MHS Absen - Dashboard Real-time</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-[#0b0f19] text-slate-200 font-sans min-h-screen selection:bg-blue-600 selection:text-white">

    <div class="container mx-auto p-4 lg:p-8 max-w-7xl">
        
        @if(session('success'))
            <div class="mb-6 flex items-center p-4 rounded-xl bg-emerald-950/40 border border-emerald-500/30 text-emerald-400 shadow-lg shadow-emerald-950/20 animate-fade-in">
                <span class="mr-2">✓</span> {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="mb-6 flex items-center p-4 rounded-xl bg-red-950/40 border border-red-500/30 text-red-400 shadow-lg shadow-red-950/20">
                <span class="mr-2">⚠</span> {{ session('error') }}
            </div>
        @endif

        <header class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-8 pb-6 border-b border-slate-800">
            <div>
                <div class="flex items-center gap-3">
                    <div class="h-8 w-8 rounded-lg bg-gradient-to-tr from-blue-600 to-indigo-600 flex items-center justify-center font-bold text-white shadow-md shadow-blue-900/30">M</div>
                    <h1 class="text-2xl font-bold tracking-tight text-white">MHS <span class="text-blue-500">Absen</span></h1>
                </div>
                <p class="text-sm text-slate-400 mt-1">Sistem Manajemen Presensi & Kelas Terintegrasi Kelas TI-24-A</p>
            </div>
            <div class="flex items-center gap-3">
                <button onclick="openModal('modalMahasiswa')" class="bg-slate-800 hover:bg-slate-700 text-white font-medium px-4 py-2.5 rounded-xl border border-slate-700/60 transition duration-200 text-sm flex items-center gap-2">
                    👥 Tambah Mahasiswa
                </button>
            </div>
        </header>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="space-y-6">
                <div class="bg-[#111827] rounded-2xl border border-slate-800/80 p-6 shadow-xl">
                    <h2 class="text-lg font-semibold text-white mb-4 flex items-center gap-2">
                        <span>📝</span> Pencatatan Presensi Hari Ini
                    </h2>
                    <form action="{{ route('absensi.store') }}" method="POST" class="space-y-4">
                        @csrf
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Pilih Mahasiswa</label>
                            <select name="nim" required class="w-full bg-[#1f2937] border border-slate-700 rounded-xl px-4 py-3 text-slate-200 text-sm focus:outline-none focus:border-blue-500 transition">
                                <option value="" disabled selected>-- Pilih NIM / Nama Mahasiswa --</option>
                                @foreach($mahasiswa as $m)
                                    <option value="{{ $m->nim }}">{{ $m->nim }} - {{ $m->nama }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-semibold uppercase tracking-wider text-slate-400 mb-2">Status Kehadiran</label>
                            <div class="grid grid-cols-3 gap-2">
                                <label class="border border-slate-700 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-800 transition text-center">
                                    <input type="radio" name="status" value="Hadir" required class="mb-1 accent-emerald-500">
                                    <span class="text-xs font-medium text-emerald-400">Hadir</span>
                                </label>
                                <label class="border border-slate-700 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-800 transition text-center">
                                    <input type="radio" name="status" value="Izin" class="mb-1 accent-yellow-500">
                                    <span class="text-xs font-medium text-yellow-400">Izin</span>
                                </label>
                                <label class="border border-slate-700 rounded-xl p-3 flex flex-col items-center justify-center cursor-pointer hover:bg-slate-800 transition text-center">
                                    <input type="radio" name="status" value="Alpa" class="mb-1 accent-red-500">
                                    <span class="text-xs font-medium text-red-400">Alpa</span>
                                </label>
                            </div>
                        </div>
                        <button type="submit" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-700 hover:to-indigo-700 text-white font-medium py-3 rounded-xl shadow-lg shadow-blue-950/40 transition duration-200 text-sm mt-2">
                            Simpan Rekap Absensi
                        </button>
                    </form>
                </div>

                <div class="bg-[#111827] rounded-2xl border border-slate-800/80 p-6 shadow-xl">
                    <h3 class="text-sm font-semibold uppercase tracking-wider text-slate-400 mb-4">Statistik Kehadiran Hari Ini</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div class="bg-[#1f2937]/50 rounded-xl p-4 border border-slate-800">
                            <span class="text-xs text-slate-400 block">Total Kelas</span>
                            <span class="text-2xl font-bold text-white block mt-1">{{ $totalMahasiswa }}</span>
                        </div>
                        <div class="bg-emerald-950/20 rounded-xl p-4 border border-emerald-900/30">
                            <span class="text-xs text-emerald-400 block">🟢 Hadir</span>
                            <span class="text-2xl font-bold text-emerald-400 block mt-1">{{ $totalHadir }}</span>
                        </div>
                        <div class="bg-yellow-950/20 rounded-xl p-4 border border-yellow-900/30">
                            <span class="text-xs text-yellow-400 block">🟡 Izin</span>
                            <span class="text-2xl font-bold text-yellow-400 block mt-1">{{ $totalIzin }}</span>
                        </div>
                        <div class="bg-red-950/20 rounded-xl p-4 border border-red-900/30">
                            <span class="text-xs text-red-400 block">🔴 Alpa</span>
                            <span class="text-2xl font-bold text-red-400 block mt-1">{{ $totalAlpa }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-2">
                <div class="bg-[#111827] rounded-2xl border border-slate-800/80 overflow-hidden shadow-xl">
                    <div class="px-6 py-5 border-b border-slate-800 bg-[#111827] flex items-center justify-between">
                        <h2 class="text-lg font-semibold text-white">Tabel Rekap Presensi Absen</h2>
                        <span class="text-xs font-medium px-2.5 py-1 rounded-full bg-slate-800 text-slate-400 border border-slate-700">{{ now()->format('d M Y') }}</span>
                    </div>
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-[#1f2937]/40 text-slate-400 text-xs font-semibold uppercase border-b border-slate-800 tracking-wider">
                                    <th class="px-6 py-4">NIM</th>
                                    <th class="px-6 py-4">Nama Mahasiswa</th>
                                    <th class="px-6 py-4">Waktu Absen</th>
                                    <th class="px-6 py-4">Status</th>
                                    <th class="px-6 py-4 text-center">Aksi</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-800/60 text-sm text-slate-300">
                                @forelse($mahasiswa as $item)
                                    <tr class="hover:bg-slate-800/20 transition duration-150">
                                        <td class="px-6 py-4 font-mono text-slate-400 text-xs">{{ $item->nim }}</td>
                                        <td class="px-6 py-4 font-medium text-white">{{ $item->nama }}</td>
                                        <td class="px-6 py-4 text-xs text-slate-400">{{ $item->waktu_absen ?? '-- : --' }}</td>
                                        <td class="px-6 py-4">
                                            @if($item->status == 'Hadir')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-emerald-950 text-emerald-400 border border-emerald-800/60">● Hadir</span>
                                            @elseif($item->status == 'Izin')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-yellow-950 text-yellow-400 border border-yellow-800/60">● Izin</span>
                                            @elseif($item->status == 'Alpa')
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-950 text-red-400 border border-red-800/60">● Alpa</span>
                                            @else
                                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-slate-800 text-slate-400 border border-slate-700">Belum Absen</span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-4 text-center space-x-1">
                                            <button onclick="openEditModal('{{ $item->mahasiswa_id }}', '{{ $item->nim }}', '{{ $item->nama }}')" class="p-1 px-2.5 bg-slate-800 text-slate-300 hover:text-white rounded-lg border border-slate-700 hover:bg-slate-700 transition text-xs">
                                                Edit
                                            </button>
                                            <form action="/mahasiswa/delete/{{ $item->mahasiswa_id }}" method="POST" class="inline-block" onsubmit="return confirm('Hapus mahasiswa ini beserta seluruh riwayat absennya?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="p-1 px-2.5 bg-red-950/40 text-red-400 hover:bg-red-900 hover:text-white rounded-lg border border-red-900/40 transition text-xs">
                                                    Hapus
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="5" class="px-6 py-16 text-center text-slate-500">
                                            <p class="text-base font-medium text-slate-400">Tidak ada mahasiswa terdaftar.</p>
                                            <p class="text-xs text-slate-600 mt-1">Klik tombol "+ Tambah Mahasiswa" di atas untuk mengisi database.</p>
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div id="modalMahasiswa" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-[#111827] border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-white">Form Registrasi Mahasiswa</h3>
                <button onclick="closeModal('modalMahasiswa')" class="text-slate-400 hover:text-white text-xl">&times;</button>
            </div>
            <form action="{{ route('mahasiswa.storeMahasiswa') }}" method="POST" class="space-y-4">
                @csrf
                <div>
                    <label class="block text-xs uppercase text-slate-400 font-semibold mb-2">Nomor Induk Mahasiswa (NIM)</label>
                    <input type="text" name="nim" required placeholder="Contoh: 4124038" class="w-full bg-[#1f2937] border border-slate-700 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs uppercase text-slate-400 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" name="nama" required placeholder="Contoh: Muhammad Hobir" class="w-full bg-[#1f2937] border border-slate-700 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('modalMahasiswa')" class="px-4 py-2 bg-slate-800 rounded-xl text-sm font-medium border border-slate-700 hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-blue-600 rounded-xl text-sm font-medium text-white hover:bg-blue-700">Daftarkan</button>
                </div>
            </form>
        </div>
    </div>

    <div id="modalEditMahasiswa" class="fixed inset-0 bg-black/70 backdrop-blur-sm z-50 hidden flex items-center justify-center p-4">
        <div class="bg-[#111827] border border-slate-800 rounded-2xl max-w-md w-full p-6 shadow-2xl">
            <div class="flex justify-between items-center mb-4">
                <h3 class="text-lg font-bold text-white">Ubah Data Mahasiswa</h3>
                <button onclick="closeModal('modalEditMahasiswa')" class="text-slate-400 hover:text-white text-xl">&times;</button>
            </div>
            <form id="formEditMahasiswa" method="POST" class="space-y-4">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-xs uppercase text-slate-400 font-semibold mb-2">Nomor Induk Mahasiswa (NIM)</label>
                    <input type="text" id="edit_nim" name="nim" required class="w-full bg-[#1f2937] border border-slate-700 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-xs uppercase text-slate-400 font-semibold mb-2">Nama Lengkap</label>
                    <input type="text" id="edit_nama" name="nama" required class="w-full bg-[#1f2937] border border-slate-700 rounded-xl px-4 py-2.5 text-slate-200 text-sm focus:outline-none focus:border-blue-500">
                </div>
                <div class="flex justify-end gap-2 pt-2">
                    <button type="button" onclick="closeModal('modalEditMahasiswa')" class="px-4 py-2 bg-slate-800 rounded-xl text-sm font-medium border border-slate-700 hover:bg-slate-700">Batal</button>
                    <button type="submit" class="px-4 py-2 bg-amber-600 text-white rounded-xl text-sm font-medium hover:bg-amber-700">Simpan Perubahan</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function openModal(id) {
            document.getElementById(id).classList.remove('hidden');
        }
        function closeModal(id) {
            document.getElementById(id).classList.add('hidden');
        }
        function openEditModal(id, nim, nama) {
            document.getElementById('formEditMahasiswa').action = '/mahasiswa/update/' + id;
            document.getElementById('edit_nim').value = nim;
            document.getElementById('edit_nama').value = nama;
            openModal('modalEditMahasiswa');
        }
    </script>
</body>
</html>