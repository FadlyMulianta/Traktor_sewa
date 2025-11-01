<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Laporan Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        /* Sembunyikan elemen yang tidak perlu saat dicetak */
        @media print {
            body {
                -webkit-print-color-adjust: exact;
            }
        }
    </style>
</head>
<body class="bg-white p-8">
    <div class="container mx-auto">
        <h1 class="text-2xl font-bold mb-2 text-center">Laporan Riwayat Peminjaman</h1>
        <p class="text-center text-gray-600 mb-6">Dicetak pada: {{ $tanggal_cetak }}</p>

        <table class="min-w-full bg-white border">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-2 px-3 border">Peminjam</th>
                    <th class="py-2 px-3 border">Unit</th>
                    <th class="py-2 px-3 border">Tgl Pinjam</th>
                    <th class="py-2 px-3 border">Batas Kembali</th>
                    <th class="py-2 px-3 border">Tgl Dikembalikan</th>
                    <th class="py-2 px-3 border">Denda</th>
                    <th class="py-2 px-3 border">Status</th>
                </tr>
            </thead>
            <tbody class="text-gray-700 text-sm">
                @forelse ($peminjamans as $pinjam)
                    <tr class="border-b">
                        <td class="py-2 px-3 border">{{ $pinjam->user->name }}</td>
                        <td class="py-2 px-3 border">{{ $pinjam->unit->nama_unit }}</td>
                        <td class="py-2 px-3 border">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
                        <td class="py-2 px-3 border">{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}</td>
                        <td class="py-2 px-3 border">
                            {{ $pinjam->tanggal_pengembalian_sebenarnya ? \Carbon\Carbon::parse($pinjam->tanggal_pengembalian_sebenarnya)->format('d M Y') : '-' }}
                        </td>
                        <td class="py-2 px-3 border">Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</td>
                        <td class="py-2 px-3 border">{{ $pinjam->status }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="py-3 px-4 text-center border">Belum ada riwayat peminjaman.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>