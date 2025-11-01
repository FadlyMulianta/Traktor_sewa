<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg">
        <h1 class="text-3xl font-bold mb-4">Manage Users (Anggota & Admin)</h1>
        <a href="{{ route('admin.dashboard') }}" class="text-blue-500 mb-4 inline-block">Kembali ke Dashboard</a>
        <a href="{{ route('admin.users.create') }}" class="bg-green-500 text-white py-2 px-4 rounded mb-4 inline-block float-right">
            + Tambah User
        </a>

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

        <table class="min-w-full bg-white">
            <thead class="bg-gray-800 text-white">
                <tr>
                    <th class="py-3 px-4">Nama</th>
                    <th class="py-3 px-4">Email</th>
                    <th class="py-3 px-4">Role</th>
                    <th class="py-3 px-4">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($users as $user)
                    <tr class="border-b">
                        <td class="py-3 px-4">{{ $user->name }}</td>
                        <td class="py-3 px-4">{{ $user->email }}</td>
                        <td class="py-3 px-4">
                            <span class="rounded-full px-3 py-1 text-sm font-semibold {{ $user->role == 'admin' ? 'bg-indigo-200 text-indigo-800' : 'bg-gray-200 text-gray-800' }}">
                                {{ $user->role }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="bg-yellow-500 text-white py-1 px-3 rounded">Edit</a>
                            
                            @if (auth()->id() != $user->id)
                                <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" class="inline-block" onsubmit="return confirm('Yakin ingin menghapus user ini?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="bg-red-500 text-white py-1 px-3 rounded">Hapus</button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="4" class="py-3 px-4 text-center">Tidak ada data user.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="mt-4">
            {{ $users->links() }}
        </div>
    </div>
</body>
</html>