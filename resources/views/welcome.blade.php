<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vyona</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #000; color: #e7e9ea; }
        .border-dark { border-color: #2f3336; }
        .hover-gray:hover { background: #181818; }
        .btn-blue:hover { background: #1a8cd8; }
        .heart-active { color: #f91880; }
        .heart-active svg { fill: #f91880; }
    </style>
</head>
<body>

    <div class="max-w-[540px] mx-auto border-x border-dark min-h-screen">

        <!-- Header -->
        <div class="sticky top-0 z-10 bg-black/80 backdrop-blur-md border-b border-dark px-4 py-3 flex items-center justify-between">
            <h1 class="text-lg font-bold">Beranda</h1>
            <i data-lucide="settings" class="w-5 h-5 text-gray-500 cursor-pointer hover:text-white transition-colors"></i>
        </div>

        <!-- Composer -->
        <div class="flex gap-3 p-4 border-b border-dark">
            <img src="https://picsum.photos/seed/me/100/100" class="w-10 h-10 rounded-full object-cover" alt="me">
            <div class="flex-1">
                <textarea id="input" class="w-full bg-transparent text-[15px] resize-none outline-none placeholder-gray-500" placeholder="Apa yang sedang terjadi?" rows="2" oninput="toggleBtn()"></textarea>
                <div class="flex justify-between items-center pt-2">
                    <i data-lucide="image" class="w-5 h-5 text-sky-500 cursor-pointer"></i>
                    <button id="btn" onclick="post()" disabled class="bg-sky-500 text-white text-sm font-semibold rounded-full px-5 py-1.5 btn-blue transition-colors opacity-40 cursor-not-allowed">Posting</button>
                </div>
            </div>
        </div>

        <!-- Feed -->
        <div id="feed">

            <div class="flex gap-3 p-4 border-b border-dark hover-gray transition-colors cursor-pointer">
                <img src="https://picsum.photos/seed/a1/100/100" class="w-10 h-10 rounded-full object-cover shrink-0" alt="">
                <div class="flex-1">
                    <div class="flex gap-1 text-[15px]"><span class="font-semibold">Ahmad</span><span class="text-gray-500">@ahmad · 2j</span></div>
                    <p class="text-[15px] mt-1">Baru belajar Laravel, ternyata seru banget! 🔥</p>
                    <div class="flex gap-12 mt-2 text-gray-500 text-sm">
                        <span class="cursor-pointer hover:text-sky-500 transition-colors"><i data-lucide="message-circle" class="w-4 h-4 inline"></i> 4</span>
                        <span class="cursor-pointer hover:text-emerald-500 transition-colors"><i data-lucide="repeat-2" class="w-4 h-4 inline"></i> 12</span>
                        <span onclick="like(this)" class="cursor-pointer hover:text-pink-500 transition-colors"><i data-lucide="heart" class="w-4 h-4 inline"></i> 38</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 p-4 border-b border-dark hover-gray transition-colors cursor-pointer">
                <img src="https://picsum.photos/seed/a2/100/100" class="w-10 h-10 rounded-full object-cover shrink-0" alt="">
                <div class="flex-1">
                    <div class="flex gap-1 text-[15px]"><span class="font-semibold">Sari</span><span class="text-gray-500">@sari · 5j</span></div>
                    <p class="text-[15px] mt-1">Tips: jangan lupa backup database sebelum migration 😅</p>
                    <div class="flex gap-12 mt-2 text-gray-500 text-sm">
                        <span class="cursor-pointer hover:text-sky-500 transition-colors"><i data-lucide="message-circle" class="w-4 h-4 inline"></i> 11</span>
                        <span class="cursor-pointer hover:text-emerald-500 transition-colors"><i data-lucide="repeat-2" class="w-4 h-4 inline"></i> 45</span>
                        <span onclick="like(this)" class="cursor-pointer hover:text-pink-500 transition-colors"><i data-lucide="heart" class="w-4 h-4 inline"></i> 120</span>
                    </div>
                </div>
            </div>

            <div class="flex gap-3 p-4 border-b border-dark hover-gray transition-colors cursor-pointer">
                <img src="https://picsum.photos/seed/a3/100/100" class="w-10 h-10 rounded-full object-cover shrink-0" alt="">
                <div class="flex-1">
                    <div class="flex gap-1 text-[15px]"><span class="font-semibold">Budi</span><span class="text-gray-500">@budi · 8h</span></div>
                    <p class="text-[15px] mt-1">Coding dulu, overthinking nanti aja 💻</p>
                    <div class="flex gap-12 mt-2 text-gray-500 text-sm">
                        <span class="cursor-pointer hover:text-sky-500 transition-colors"><i data-lucide="message-circle" class="w-4 h-4 inline"></i> 2</span>
                        <span class="cursor-pointer hover:text-emerald-500 transition-colors"><i data-lucide="repeat-2" class="w-4 h-4 inline"></i> 30</span>
                        <span onclick="like(this)" class="cursor-pointer hover:text-pink-500 transition-colors"><i data-lucide="heart" class="w-4 h-4 inline"></i> 89</span>
                    </div>
                </div>
            </div>

        </div>
    </div>

    <script>
        lucide.createIcons();

        function toggleBtn() {
            const btn = document.getElementById('btn');
            const val = document.getElementById('input').value.trim();
            if (val) {
                btn.disabled = false;
                btn.classList.remove('opacity-40', 'cursor-not-allowed');
            } else {
                btn.disabled = true;
                btn.classList.add('opacity-40', 'cursor-not-allowed');
            }
        }

        function post() {
            const input = document.getElementById('input');
            const text = input.value.trim();
            if (!text) return;

            const el = document.createElement('div');
            el.className = 'flex gap-3 p-4 border-b border-dark hover-gray transition-colors cursor-pointer';
            el.innerHTML = `
                <img src="https://picsum.photos/seed/me/100/100" class="w-10 h-10 rounded-full object-cover shrink-0" alt="">
                <div class="flex-1">
                    <div class="flex gap-1 text-[15px]"><span class="font-semibold">User Vyona</span><span class="text-gray-500">@uservyona · Baru saja</span></div>
                    <p class="text-[15px] mt-1">${text.replace(/</g,'&lt;').replace(/\n/g,'<br>')}</p>
                    <div class="flex gap-12 mt-2 text-gray-500 text-sm">
                        <span class="cursor-pointer hover:text-sky-500 transition-colors"><i data-lucide="message-circle" class="w-4 h-4 inline"></i> 0</span>
                        <span class="cursor-pointer hover:text-emerald-500 transition-colors"><i data-lucide="repeat-2" class="w-4 h-4 inline"></i> 0</span>
                        <span onclick="like(this)" class="cursor-pointer hover:text-pink-500 transition-colors"><i data-lucide="heart" class="w-4 h-4 inline"></i> 0</span>
                    </div>
                </div>`;

            document.getElementById('feed').prepend(el);
            lucide.createIcons();
            input.value = '';
            toggleBtn();
        }

        function like(el) {
            el.classList.toggle('heart-active');
            const nums = el.textContent.trim().match(/\d+/);
            if (nums) {
                const n = parseInt(nums[0]);
                const add = el.classList.contains('heart-active') ? 1 : -1;
                el.innerHTML = el.innerHTML.replace(/\d+/, n + add);
            }
        }
    </script>
</body>
</html>