<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profil</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">

    <nav class="bg-white shadow-md">
        <div class="container mx-auto px-6 py-4">
            <div class="flex justify-between items-center">
                <a href="{{ route('units.index') }}" class="font-bold text-2xl text-blue-600">SewaUnit</a>
                <div class="flex items-center space-x-4">
                    <span class="text-gray-700 hidden sm:block">
                        Halo, <strong>{{ Auth::user()->name }}!</strong>
                    </span>
                    <form action="{{ route('logout') }}" method="POST" class="m-0">
                        @csrf
                        <button type="submit" class="bg-red-500 text-white py-2 px-4 rounded-lg hover:bg-red-600">Logout</button>
                    </form>
                </div>
            </div>
        </div>
    </nav>

    <div class="container mx-auto px-6 py-12">
        <div class="max-w-2xl mx-auto bg-white p-8 rounded-lg shadow-xl">
            <h1 class="text-3xl font-bold mb-6 text-gray-800">Edit Profil Anda</h1>

            @if (session('success'))
                <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('profile.update') }}" method="POST">
                @csrf
                @method('PATCH')

                <div class="mb-4">
                    <label for="name" class="block text-gray-700 font-semibold mb-2">Nama</label>
                    <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg" value="{{ old('name', $user->name) }}" required>
                </div>

                <div class="mb-4">
                    <label for="email" class="block text-gray-700 font-semibold mb-2">Email</label>
                    <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg" value="{{ old('email', $user->email) }}" required>
                </div>

                <hr class="my-6">

                <p class="text-gray-600 mb-4">Ubah Password (Kosongkan jika tidak ingin diubah)</p>

                <div class="mb-4">
                    <label for="password" class="block text-gray-700 font-semibold mb-2">Password Baru</label>
                    <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div class="mb-6">
                    <label for="password_confirmation" class="block text-gray-700 font-semibold mb-2">Konfirmasi Password Baru</label>
                    <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-lg">
                </div>

                <div>
                    <button type="submit" class="w-full bg-blue-600 text-white py-3 rounded-lg hover:bg-blue-700 font-bold">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
</body>
</html>