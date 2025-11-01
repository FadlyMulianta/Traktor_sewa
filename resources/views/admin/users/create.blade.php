<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah User Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-bold mb-4">Tambah User Baru</h1>
        <a href="{{ route('admin.users.index') }}" class="text-blue-500 mb-4 inline-block">Kembali</a>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.users.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="name" class="block text-gray-700">Nama</label>
                <input type="text" name="name" id="name" class="w-full px-3 py-2 border rounded-lg" value="{{ old('name') }}">
            </div>
            <div class="mb-4">
                <label for="email" class="block text-gray-700">Email</label>
                <input type="email" name="email" id="email" class="w-full px-3 py-2 border rounded-lg" value="{{ old('email') }}">
            </div>
            <div class="mb-4">
                <label for="role" class="block text-gray-700">Role</label>
                <select name="role" id="role" class="w-full px-3 py-2 border rounded-lg">
                    <option value="user" @if(old('role') == 'user') selected @endif>User (Anggota)</option>
                    <option value="admin" @if(old('role') == 'admin') selected @endif>Admin</option>
                </select>
            </div>
            <div class="mb-4">
                <label for="password" class="block text-gray-700">Password</label>
                <input type="password" name="password" id="password" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div class="mb-4">
                <label for="password_confirmation" class="block text-gray-700">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full px-3 py-2 border rounded-lg">
            </div>
            <div>
                <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg">Simpan User</button>
            </div>
        </form>
    </div>
</body>
</html>