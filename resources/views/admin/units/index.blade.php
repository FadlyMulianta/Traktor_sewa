<!DOCTYPE html>
<htm lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Units</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4">Manage Units</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 mb-4 inline-block">Kembali ke Dashboard</a>
        <a href="{{ route('admin.units.create') }}" class="bg-green-500 text-white py-2 px-4 rounded mb-4 inline-block float-right">
            + Tambah Unit
        </a>

        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif

        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4">Kode Unit</th>
                    <th class="py-3 px-4">Nama Unit</th>
                    <th class="py-3 px-4">Status</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($units as $unit)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $unit->kode_unit }}</td>
                        <td class="py-3 px-4">{{ $unit->nama_unit }}</td>
                        <td class="py-3 px-4">{{ $unit->status }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.units.edit', $unit->id) }}" class="bg-yellow-500 text-white py-1 px-3 rounded">Edit</a>
                            <form action="{{ route('admin.units.destroy', $unit->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-3 px-4 text-center">Tidak ada data unit.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $units->links() }}
        </div>
    </div>
</body>
</html>