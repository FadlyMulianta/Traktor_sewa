<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Peminjaman Aktif</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4">Peminjaman Aktif</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 mb-4 inline-block">Kembali ke Dashboard</a>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                {{ session('error') }}
            </div>
        @endif

        <div class="overflow-x-auto">
            <table class="min-w-full bg-white">
                <thead class="bg-gray-800 text-white">
                    <tr>
                        <th class="py-3 px-4">Nama Peminjam</th>
                        <th class="py-3 px-4">Unit Dipinjam</th>
                        <th class="py-3 px-4">Tgl Pinjam</th>
                        <th class="py-3 px-4">Batas Kembali</th>
                        <th class="py-3 px-4">Aksi</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @forelse ($peminjamans as $pinjam)
                        <tr class="border-b">
                            <td class="py-3 px-4">{{ $pinjam->user->name }}</td>
                            <td class="py-3 px-4">{{ $pinjam->unit->nama_unit }} ({{ $pinjam->unit->kode_unit }})</td>
                            <td class="py-3 px-4">{{ \Carbon\Carbon::parse($pinjam->tanggal_pinjam)->format('d M Y') }}</td>
                            <td class="py-3 px-4 font-bold 
                                @if (\Carbon\Carbon::now()->isAfter($pinjam->tanggal_kembali)) 
                                    text-red-600 
                                @endif">
                                {{ \Carbon\Carbon::parse($pinjam->tanggal_kembali)->format('d M Y') }}
                            </td>
                            <td class="py-3 px-4">
                                <form action="{{ route('admin.peminjaman.kembalikan', $pinjam->id) }}" method="POST" onsubmit="return confirm('Konfirmasi pengembalian unit ini?');">
                                    @csrf
                                    @method('PATCH')
                                    <button type="submit" class="bg-green-500 text-white py-1 px-3 rounded">
                                        Konfirmasi Pengembalian
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-3 px-4 text-center">Tidak ada unit yang sedang dipinjam.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</body>
</html>