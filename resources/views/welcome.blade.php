<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Selamat Datang</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 flex items-center justify-center min-h-screen">
    <div class="text-center">
        <h1 class="text-4xl font-bold mb-4">Sistem Sewa Unit</h1>
        <p class="text-xl mb-8">Silakan login atau daftar untuk melanjutkan.</p>
        <div>
            <a href="{{ route('login.show') }}" class="bg-blue-500 text-white py-2 px-4 rounded text-lg mr-4">Login</a>
            <a href="{{ route('register.show') }}" class="bg-green-500 text-white py-2 px-4 rounded text-lg">Register</a>
        </div>
    </div>
</body>
</html>