<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Unit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">

    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('units.index') }}" class="font-bold text-2xl text-blue-600">
                    SewaUnit
                </a>

                <div class="flex items-center space-x-4">
                    <a href="{{ route('profile.edit') }}" class="text-gray-600 hover:text-blue-600 hidden sm:block">
                        Profil Saya
                    </a>
                    <span class="text-gray-400">|</span>
                    <a href="{{ route('peminjaman.saya') }}" class="text-gray-600 hover:text-blue-600 hidden sm:block">
                        Peminjaman Saya
                    </a>
                    <span class="text-gray-400">|</span>
                    <span class_comment="Pemisah">|</span>
                    <span class="text-gray-700 hidden sm:block">
                        Halo, <strong>{{ Auth::user()->name }}!</strong>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit"
                            class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600 transition duration-300">
                            Logout
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </nav>
    <div class="bg-gray-800 text-white">
        <div class="container mx-auto px-6 py-24 text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-3">
                Sistem Peminjaman Unit
            </h1>
            <p class="text-xl md:text-2xl opacity-90">
                Cari dan pinjam unit yang Anda butuhkan dengan mudah.
            </p>
        </div>
    </div>
    <div class="container mx-auto px-6 -mt-16">
        <div class="bg-white p-6 md:p-8 rounded-lg shadow-xl">

            <h2 class="text-2xl font-semibold mb-5 text-gray-800">Cari Unit</h2>
            <form action="{{ route('units.index') }}" method="GET" class="mb-8 flex">
                <input type="text" name="search" placeholder="Cari berdasarkan nama unit..."
                    class="border-gray-300 border p-3 rounded-l-lg w-full focus:outline-none focus:ring-2 focus:ring-blue-500"
                    value="{{ request('search') }}">

                <button type="submit"
                    class="bg-blue-600 text-white py-3 px-6 rounded-r-lg hover:bg-blue-700 transition duration-300">
                    Cari
                </button>
            </form>
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
            <h2 class="text-2xl font-semibold mb-5 text-gray-800">Daftar Unit Tersedia</h2>
            <div class="overflow-x-auto">
                <table class="min-w-full bg-white">
                    <thead class="bg-gray-800 text-white">
                        <tr>
                            <th class="w-1/5 py-3 px-4 text-left">Kode Unit</th>
                            <th class="w-2/5 py-3 px-4 text-left">Nama Unit</th>

                            <th class="w-1/5 py-3 px-4 text-left">Kategori</th>
                            <th class="w-1/5 py-3 px-4 text-left">Harga per Hari</th>

                            <th class="w-1/5 py-3 px-4 text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @forelse ($units as $unit)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4">{{ $unit->kode_unit }}</td>
                                <td class="py-3 px-4 font-medium">{{ $unit->nama_unit }}</td>
                                <td class="py-3 px-4">
                                    @foreach ($unit->categories as $category)
                                        <span
                                            class="bg-gray-200 rounded-full px-3 py-1 text-sm font-semibold text-gray-700">
                                            {{ $category->name }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="py-3 px-4 font-bold text-gray-800">
                                    Rp {{ number_format($unit->harga_sewa_per_hari) }}
                                </td>
                                
                                <td class="py-3 px-4 text-center">

                                    @if ($unit->status == 'tersedia')
                                        <form action="{{ route('peminjaman.store') }}" method="POST" class="m-0">
                                            @csrf
                                            <input type="hidden" name="unit_id" value="{{ $unit->id }}">
                                            <button type="submit"
                                                class="bg-blue-600 text-white py-1 px-4 rounded-lg hover:bg-blue-700 transition duration-300">
                                                Pinjam
                                            </button>
                                        </form>
                                    @else
                                        <span
                                            class="rounded-full px-3 py-1 text-sm font-semibold bg-yellow-100 text-yellow-800">
                                            Dipinjam
                                        </span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="py-4 px-4 text-center text-gray-500">
                                    Data unit tidak ditemukan.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <div class="mt-6">
                {{ $units->appends(request()->query())->links() }}
            </div>

        </div>
    </div>
    <footer class="text-center py-8 mt-12 text-gray-500 text-sm">
        &copy; {{ date('Y') }} Sewa Unit. Dibuat dengan Laravel & Tailwind CSS.
    </footer>

</body>

</html>
