<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Unit Baru</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-bold mb-4">Tambah Unit Baru</h1>
        <a href="{{ route('admin.units.index') }}" class="text-blue-500 mb-4 inline-block">Kembali</a>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.units.store') }}" method="POST">
            @csrf
            <div class="mb-4">
                <label for="nama_unit" class="block text-gray-700">Nama Unit</label>
                <input type="text" name="nama_unit" id="nama_unit" class="w-full px-3 py-2 border rounded-lg" value="{{ old('nama_unit') }}">
            </div>
            <div class="mb-4">
                <label for="kode_unit" class="block text-gray-700">Kode Unit</label>
                <input type="text" name="kode_unit" id="kode_unit" class="w-full px-3 py-2 border rounded-lg" value="{{ old('kode_unit') }}">
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Kategori (Poin 6: Bisa multiple)</label>
                @foreach ($categories as $category)
                    <div class="flex items-center">
                        <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" class="mr-2">
                        <label for="category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            <div>
                <button type="submit" class="w-full bg-green-500 text-white py-2 rounded-lg">Simpan Unit</button>
            </div>
        </form>
    </div>
</body>
</html>