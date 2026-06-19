<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MHSAbsen - Sistem Presensi Real-Time</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
</head>
<body class="bg-slate-950 text-slate-100 font-sans antialiased min-h-screen flex flex-col justify-between selection:bg-red-500 selection:text-white">

    <nav class="bg-slate-950/40 backdrop-blur-md sticky top-0 z-50 px-8 py-4">
        <div class="max-w-7xl mx-auto flex justify-between items-center">
            <div class="flex items-center space-x-2">
                <span class="text-2xl font-black tracking-wider flex items-center gap-2">
                    <span class="text-red-500 text-3xl">🛑</span>
                    <span class="text-white">MHS</span><span class="text-slate-400 font-medium">Absen</span>
                </span>
            </div>
            <div class="text-xs text-slate-400 flex items-center gap-2 bg-slate-900/60 px-3 py-1.5 rounded-full border border-slate-800/80">
                <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                Kelas: <span class="text-slate-200 font-semibold">TI-24-A (Pemrograman Web)</span>
            </div>
        </div>
    </nav>

    <main class="flex-1 max-w-7xl w-full mx-auto p-6 md:p-8 flex flex-col lg:flex-row gap-8 items-center my-auto">
        
        <div class="w-full lg:w-5/12 space-y-8">
            <div class="space-y-3">
                <h1 class="text-4xl md:text-5xl font-black tracking-tight text-white leading-tight">
                    Presensi <br>Kehadiran <br>Mahasiswa
                </h1>
                <p class="text-slate-400 text-sm max-w-sm leading-relaxed">
                    Kelola dan catat kehadiran mahasiswa secara real-time hari ini dengan sistem terintegrasi.
                </p>
            </div>

            @if(session('success'))
            <div class="p-3.5 bg-emerald-500/10 border border-emerald-500/20 text-emerald-400 rounded-xl text-xs flex items-center gap-2 animate-fade-in">
                <span>✅</span> {{ session('success') }}
            </div>
            @endif

            <div class="flex flex-col gap-3 max-w-xs">
                <a href="{{ route('mahasiswa.register') }}" class="group bg-slate-900 hover:bg-slate-850 text-slate-200 font-semibold px-5 py-3 rounded-xl border border-slate-800 hover:border-slate-700 transition-all duration-200 flex items-center gap-3 text-sm shadow-md">
                    <span class="text-base group-hover:scale-110 transition">👤</span> Daftarkan Mahasiswa
                </a>
                
                <a href="{{ route('mahasiswa.create') }}" class="group bg-gradient-to-r from-red-600 to-rose-600 hover:from-red-500 hover:to-rose-500 text-white font-bold px-5 py-3 rounded-xl shadow-lg shadow-red-950/50 hover:shadow-red-500/20 transition-all duration-200 flex items-center gap-3 text-sm">
                    <span class="text-base group-hover:scale-110 transition">📝</span> Rekap Absensi Baru
                </a>
            </div>

            <div class="flex items-center gap-3 bg-slate-900/20 border border-slate-900 p-3 rounded-2xl w-fit">
                <div class="text-center px-4 py-2 border-r border-slate-900">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-500">Total Rekap</p>
                    <p class="text-2xl font-black text-white mt-0.5">{{ $total }}</p>
                </div>
                <div class="text-center px-4 py-2 border-r border-slate-900">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1 justify-center"><span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Hadir</p>
                    <p class="text-xl font-black text-emerald-400 mt-0.5">{{ $hadir }} <span class="text-[10px] text-slate-500 font-normal">Mhs</span></p>
                </div>
                <div class="text-center px-4 py-2 border-r border-slate-900">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1 justify-center"><span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span> Izin</p>
                    <p class="text-xl font-black text-amber-400 mt-0.5">{{ $izin }} <span class="text-[10px] text-slate-500 font-normal">Mhs</span></p>
                </div>
                <div class="text-center px-4 py-2">
                    <p class="text-[10px] font-bold uppercase tracking-wider text-slate-400 flex items-center gap-1 justify-center"><span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Alpa</p>
                    <p class="text-xl font-black text-red-400 mt-0.5">{{ $alpa }} <span class="text-[10px] text-slate-500 font-normal">Mhs</span></p>
                </div>
            </div>
        </div>

        <div class="w-full lg:w-7/12 bg-slate-900/20 backdrop-blur-md rounded-2xl border border-slate-900 shadow-2xl overflow-hidden self-stretch flex flex-col justify-between">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="border-b border-slate-900 text-slate-400 font-bold text-[11px] uppercase tracking-widest bg-slate-900/40">
                            <th class="p-4 pl-6">NIM</th>
                            <th class="p-4">Nama Mahasiswa</th>
                            <th class="p-4">Waktu Absen</th>
                            <th class="p-4 text-center">Status Kehadiran</th>
                            <th class="p-4 pr-6 text-center">Tindakan</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-900/50 text-slate-300 text-xs">
                        @forelse($absensi as $row)
                        <tr class="hover:bg-slate-900/40 transition group">
                            <td class="p-4 pl-6 font-mono text-slate-400 font-bold group-hover:text-white">{{ $row->nim }}</td>
                            <td class="p-4 font-bold text-white group-hover:text-red-400 transition">{{ $row->nama }}</td>
                            <td class="p-4 font-mono text-[11px] text-slate-500">{{ $row->waktu_absen }}</td>
                            <td class="p-4 text-center">
                                @if($row->status == 'Hadir')
                                    <span class="bg-emerald-500/10 text-emerald-400 border border-emerald-500/20 text-[10px] px-2.5 py-0.5 rounded-full font-black tracking-wider">HADIR</span>
                                @elseif($row->status == 'Izin')
                                    <span class="bg-amber-500/10 text-amber-400 border border-amber-500/20 text-[10px] px-2.5 py-0.5 rounded-full font-black tracking-wider">IZIN</span>
                                @else
                                    <span class="bg-red-500/10 text-red-400 border border-red-500/20 text-[10px] px-2.5 py-0.5 rounded-full font-black tracking-wider">ALPA</span>
                                @endif
                            </td>
                            <td class="p-4 pr-6">
                                <div class="flex justify-center items-center gap-2">
                                    <a href="{{ route('mahasiswa.edit', $row->id) }}" class="px-2 py-1 bg-slate-900 hover:bg-slate-800 text-slate-300 rounded-lg text-[11px] font-semibold transition border border-slate-800">Ubah</a>
                                    
                                    <form action="{{ route('mahasiswa.destroy', $row->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus rekap absensi ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="px-2 py-1 bg-red-500/10 hover:bg-red-500 hover:text-white text-red-400 text-[11px] font-semibold rounded-lg transition border border-red-500/10">Hapus</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="p-16 text-center text-slate-500 font-medium">
                                <div class="text-xl mb-2">📬</div>
                                Belum ada rekap absensi hari ini. <br>Silakan klik tombol <span class="text-red-400 font-semibold">"Rekap Absensi Baru"</span>.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="bg-slate-950/40 px-6 py-3 border-t border-slate-900 flex items-center justify-between text-[11px] text-slate-500">
                <div>Menampilkan <span class="text-slate-300 font-bold">{{ $absensi->count() }}</span> Mahasiswa Terdaftar</div>
                <div>Pembaruan otomatis berkala harian</div>
            </div>
        </div>

    </main>

    <footer class="text-center py-4 text-[11px] text-slate-600 border-t border-slate-950">
        &copy; 2026 MHSAp Absensi. Built with Laravel & Tailwind CSS.
    </footer>

</body>
</html>