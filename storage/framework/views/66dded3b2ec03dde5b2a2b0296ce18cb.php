<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — Vyona</title>
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
        <div class="text-center mb-10">
            <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl gradient-bg mb-6 shadow-lg shadow-blue-500/20">
    <span class="text-white text-3xl font-black tracking-tighter">V</span>
</div>
            <h1 class="text-3xl font-extrabold tracking-tight">Selamat Datang Kembali</h1>
            <p class="text-gray-500 mt-2">Masuk untuk melanjutkan ke Vyona</p>
        </div>

        <div class="bg-[#0a0a0a] border border-white/[0.08] rounded-2xl p-8 shadow-2xl">
            <?php if($errors->any()): ?>
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl mb-6 text-sm flex items-center gap-2">
                    <i data-lucide="alert-circle" class="w-4 h-4 shrink-0"></i> <?php echo e($errors->first('email')); ?>

                </div>
            <?php endif; ?>
            <?php if(session('success')): ?>
                <div class="bg-blue-500/10 border border-blue-500/20 text-blue-400 px-4 py-3 rounded-xl mb-6 text-sm"><?php echo e(session('success')); ?></div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5">
                <?php echo csrf_field(); ?>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email</label>
                    <input type="email" name="email" value="<?php echo e(old('email')); ?>" required class="input-modern w-full rounded-xl px-4 py-3 text-white placeholder-gray-600">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Password</label>
                    <input type="password" name="password" required class="input-modern w-full rounded-xl px-4 py-3 text-white placeholder-gray-600">
                </div>
                <button type="submit" class="gradient-bg w-full text-white font-bold rounded-xl py-3.5 hover:opacity-90 transition-opacity shadow-lg shadow-blue-500/20">Masuk</button>
            </form>
        </div>
        <p class="text-gray-500 text-sm mt-6 text-center">Belum punya akun? <a href="<?php echo e(route('register')); ?>" class="text-blue-400 hover:text-blue-300 font-semibold hover:underline">Daftar sekarang</a></p>
    </div>
</body>
</html><?php /**PATH C:\laragon\www\vyona\resources\views/auth/login.blade.php ENDPATH**/ ?>