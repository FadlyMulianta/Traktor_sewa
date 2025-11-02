<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Peminjaman Saya</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('units.index') }}" class="font-bold text-2xl text-blue-600">SewaUnit</a>
                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-blue-600 hidden sm:block">Profil Saya</a>
                    <span class="text-gray-400">|</span>
                    <a href="{{ route('peminjaman.saya') }}" class="text-blue-600 font-bold hidden sm:block">Peminjaman Saya</a>
                    <span class="text-gray-400">|</span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <div class="bg-white p-6 md:p-8 rounded-lg shadow-xl">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Riwayat Peminjaman Saya</h1>
            <p class="text-gray-600 mb-4">Sesuai Poin 12, hubungi Admin untuk melakukan pengembalian unit.</p>

            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="py-3 px-4 text-left">Unit</th>
                            <th class="py-3 px-4 text-left">Tgl Pinjam</th>
                            <th class="py-3 px-4 text-left">Batas Kembali</th>
                            <th class="py-3 px-4 text-left">Total Biaya (5 Hari)</th>
                            <th class="py-3 px-4 text-left">Sisa Waktu</th>
                            <th class="py-3 px-4 text-left">Denda</th> <th class="py-3 px-4 text-left">Status</th>
                        </tr>
                    </thead>
                    <tbody class="text-gray-700">
                        @forelse ($peminjamans as $pinjam)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $pinjam->unit->nama_unit }} ({{ $pinjam->unit->kode_unit }})</td>
                                <td class="py-3 px-4">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
                                <td class="py-3 px-4 font-bold text-red-600">{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}</td>
                                <td class="py-3 px-4 font-bold text-blue-600">
                                    Rp {{ number_format($pinjam->unit->harga_sewa_per_hari * 5) }}
                                </td>
                                <td class="py-3 px-4">
                                    @if ($pinjam->status == 'dipinjam')
                                        <span class="font-bold sisa-waktu" 
                                              data-tanggal-kembali="{{ $pinjam->tanggal_kembali }}">
                                            Menghitung...
                                        </span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                
                                <td class="py-3 px-4 font-bold">
                                    @if($pinjam->denda > 0)
                                        <span class="text-red-600">Rp {{ number_format($pinjam->denda) }}</span>
                                    @else
                                        <span>-</span>
                                    @endif
                                </td>
                                <td class="py-3 px-4">
                                    @if ($pinjam->status == 'dipinjam')
                                        <span class="rounded-full px-3 py-1 text-sm font-semibold bg-yellow-100 text-yellow-800">Dipinjam</span>
                                    @else
                                        <span class="rounded-full px-3 py-1 text-sm font-semibold bg-green-100 text-green-800">Dikembalikan</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 px-4 text-center text-gray-500"> Anda belum pernah meminjam unit.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            
            <div class="mt-6">
                {{ $peminjamans->links() }}
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const timerElements = document.querySelectorAll('.sisa-waktu');
            function updateTimers() {
                timerElements.forEach(timer => {
                    const targetDate = new Date(timer.dataset.tanggalKembali).getTime();
                    const now = new Date().getTime();
                    const distance = targetDate - now;
    
                    if (distance < 0) {
                        timer.innerHTML = "Waktu Habis";
                        timer.classList.add('text-red-600');
                    } else {
                        const days = Math.floor(distance / (1000 * 60 * 60 * 24));
                        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);
                        timer.innerHTML = `${days}h ${hours}j ${minutes}m ${seconds}d`;
                    }
                });
            }
            updateTimers();
            setInterval(updateTimers, 1000);
        });
    </script>
</body>
</html>