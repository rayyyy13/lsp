<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar — Vyona</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #000; color: #fff; }
        .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); }
        .input-modern { background: #111; border: 1px solid rgba(255,255,255,0.1); transition: all 0.2s ease; }
        .input-modern:focus { border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2); outline: none; }
    </style>
</head>
<body class="flex items-center justify-center min-h-screen p-4">
    <div class="w-full max-w-md">
        <div class="text-center mb-8">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg mb-6 shadow-lg shadow-blue-500/20">
    <span class="text-white text-3xl font-black tracking-tighter">V</span>
</div>
            <h1 class="text-3xl font-extrabold tracking-tight">Buat Akun Baru</h1>
        </div>

        <div class="bg-[#0a0a0a] border border-white/[0.08] rounded-2xl p-8 shadow-2xl">
            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm">
                    @foreach ($errors->all() as $error) <div>• {{ $error }}</div> @endforeach
                </div>
            @endif

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div class="grid grid-cols-2 gap-4">
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Nama</label>
                        <input type="text" name="name" value="{{ old('name') }}" required class="input-modern w-full rounded-xl px-4 py-3 text-white placeholder-gray-600">
                    </div>
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block text-sm font-medium text-gray-400 mb-2">Username</label>
                        <input type="text" name="username" value="{{ old('username') }}" required class="input-modern w-full rounded-xl px-4 py-3 text-white placeholder-gray-600">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" value="{{ old('email') }}" required class="input-modern w-full rounded-xl px-4 py-3 text-white placeholder-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <input type="password" name="password" required class="input-modern w-full rounded-xl px-4 py-3 text-white placeholder-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Konfirmasi Password</label>
                    <input type="password" name="password_confirmation" required class="input-modern w-full rounded-xl px-4 py-3 text-white placeholder-gray-600">
                </div>
                <button type="submit" class="gradient-bg w-full text-white font-bold rounded-xl py-3.5 hover:opacity-90 transition-opacity shadow-lg shadow-blue-500/20 mt-2">Daftar</button>
            </form>
        </div>
        <p class="text-gray-500 text-sm mt-6 text-center">Sudah punya akun? <a href="{{ route('login') }}" class="text-blue-400 hover:text-blue-300 font-semibold hover:underline">Masuk</a></p>
    </div>
</body>
</html>