<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gray-100">
    <div class="container mx-auto mt-10 p-5 bg-white shadow-lg rounded-lg">
        <div class="flex justify-between items-center">
            <div>
                <h1 class="text-3xl font-bold text-gray-800">
                    Halo Admin, {{ Auth::user()->name }}!
                </h1>
                <p class="text-xl text-green-600 mt-2">
                    Selamat Datang di Dashboard Admin.
                </p>
            </div>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded">
                    Logout
                </button>
            </form>
        </div>

        <div class="mt-8 border-t pt-6">
            <h2 class="text-2xl font-semibold mb-4">Manajemen Data</h2>
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <a href="{{ route('admin.peminjaman.aktif') }}"
                    class="block p-6 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700">
                    <h3 class="text-xl font-bold">Peminjaman Aktif</h3>
                </a>

                {{-- <a href="{{ route('admin.peminjaman.history') }}"
                    class="block p-6 bg-yellow-600 text-white rounded-lg shadow-md hover:bg-yellow-700">
                    <h3 class="text-xl font-bold">Riwayat Peminjaman</h3>
                </a> --}}

                <a href="{{ route('admin.units.index') }}"
                    class="block p-6 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700">
                    <h3 class="text-xl font-bold">Manage Units</h3>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="block p-6 bg-indigo-600 text-white rounded-lg shadow-md hover:bg-indigo-700">
                    <h3 class="text-xl font-bold">Manage Kategori</h3>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="block p-6 bg-gray-700 text-white rounded-lg shadow-md hover:bg-gray-800">
                    <h3 class="text-xl font-bold">Manage Users</h3>
                </a>
            </div>
        </div>
    </div>
    </div>
</body>

</html>
