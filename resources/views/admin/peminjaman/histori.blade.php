<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Riwayat Peminjaman</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4">Riwayat Peminjaman (Semua)</h1>
        <div class="flex justify-between items-center mb-4">
            <a href="{{ route('admin.dashboard') }}" class="text-blue-500">Kembali ke Dashboard</a>

            <a href="{{ route('admin.peminjaman.print') }}" target="_blank" class="bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700">
                Cetak Laporan
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">Peminjam</th>
                        <th class="py-3 px-4">Unit</th>
                        <th class="py-3 px-4">Tgl Pinjam</th>
                        <th class="py-3 px-4">Batas Kembali</th>
                        <th class="py-3 px-4">Tgl Dikembalikan</th>
                        <th class="py-3 px-4">Denda</th>
                        <th class="py-3 px-4">Status</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($peminjamans as $pinjam)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $pinjam->user->name }}</td>
                            <td class="py-3 px-4">{{ $pinjam->unit->nama_unit }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}</td>
                            <td class="py-3 px-4">
                                {{ $pinjam->tanggal_pengembalian_sebenarnya ? \Carbon\Carbon::parse($pinjam->tanggal_pengembalian_sebenarnya)->format('d M Y') : '-' }}
                            </td>
                            <td class="py-3 px-4">Rp {{ number_format($pinjam->denda, 0, ',', '.') }}</td>
                            <td class="py-3 px-4">
                                @if ($pinjam->status == 'dipinjam')
                                    <span class="rounded-full px-3 py-1 text-sm font-semibold bg-yellow-100 text-yellow-800">
                                        Dipinjam
                                    </span>
                                @else
                                    <span class="rounded-full px-3 py-1 text-sm font-semibold bg-green-100 text-green-800">
                                        Dikembalikan
                                    </span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-3 px-4 text-center">Belum ada riwayat peminjaman.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="mt-6">
            {{ $peminjamans->links() }}
        </div>
    </div>
</body>
</html>