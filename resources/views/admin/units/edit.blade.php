<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Edit Unit</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 p-8">
    <div class="container mx-auto bg-white p-6 rounded-lg shadow-lg max-w-lg">
        <h1 class="text-3xl font-bold mb-4">Edit Unit</h1>
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

        <form action="{{ route('admin.units.update', $unit->id) }}" method="POST">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label for="nama_unit" class="block text-gray-700">Nama Unit</label>
                <input type="text" name="nama_unit" id="nama_unit" class="w-full px-3 py-2 border rounded-lg" value="{{ old('nama_unit', $unit->nama_unit) }}">
            </div>
            <div class="mb-4">
                <label for="kode_unit" class="block text-gray-700">Kode Unit</label>
                <input type="text" name="kode_unit" id="kode_unit" class="w-full px-3 py-2 border rounded-lg" value="{{ old('kode_unit', $unit->kode_unit) }}">
            </div>
            <div class="mb-4">
                <label for="status" class="block text-gray-700">Status</label>
                <select name="status" id="status" class="w-full px-3 py-2 border rounded-lg">
                    <option value="tersedia" @if(old('status', $unit->status) == 'tersedia') selected @endif>Tersedia</option>
                    <option value="dipinjam" @if(old('status', $unit->status) == 'dipinjam') selected @endif>Dipinjam</option>
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700">Kategori</label>
                @foreach ($categories as $category)
                    <div class="flex items-center">
                        <input type="checkbox" name="categories[]" id="category_{{ $category->id }}" value="{{ $category->id }}" class="mr-2"
                            @if(in_array($category->id, old('categories', $unitCategoryIds))) checked @endif>
                        <label for="category_{{ $category->id }}">{{ $category->name }}</label>
                    </div>
                @endforeach
            </div>
            <div>
                <button type="submit" class="w-full bg-yellow-500 text-white py-2 rounded-lg">Update Unit</button>
            </div>
        </form>
    </div>
</body>
</html>