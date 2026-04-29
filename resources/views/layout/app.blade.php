<!DOCTYPE html>
<html lang="id" class="dark">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Vyona')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body { font-family: 'Inter', sans-serif; background: #000; color: #e7e9ea; }
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-thumb { background: #333; border-radius: 10px; }
        ::-webkit-scrollbar-track { background: transparent; }
        .glass { background: rgba(0, 0, 0, 0.8); backdrop-filter: blur(20px); -webkit-backdrop-filter: blur(20px); }
        .border-modern { border-color: rgba(255, 255, 255, 0.08); }
        .hover-modern:hover { background: rgba(255, 255, 255, 0.05); }
        .gradient-bg { background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); }
        .gradient-text { background: linear-gradient(135deg, #3b82f6 0%, #8b5cf6 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; }
        .input-modern { background: #111; border: 1px solid rgba(255,255,255,0.1); transition: all 0.2s ease; }
        .input-modern:focus { border-color: #3b82f6; box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.2); outline: none; }
    </style>
</head>
<body class="antialiased bg-black min-h-screen">

    {{-- ===== NAVBAR ATAS (FULLWIDTH) ===== --}}
    <nav class="sticky top-0 z-50 glass border-b border-modern px-6 py-3">
        <div class="max-w-4xl mx-auto flex items-center justify-between">
                        {{-- Kiri: Logo & Search Bar --}}
            <div class="flex items-center gap-4 flex-1 max-w-xl">
                <a href="{{ route('home') }}" class="flex items-center gap-2 shrink-0">
                    <span class="text-xl font-extrabold gradient-text hidden sm:block">Vyona</span>
                </a>
                
                {{-- SEARCH BAR --}}
                <form onsubmit="handleHashtagSearch(event)" class="relative flex-1 hidden sm:block">
                    <i data-lucide="search" class="w-4 h-4 text-gray-500 absolute left-3 top-1/2 -translate-y-1/2 pointer-events-none"></i>
                    <input id="searchInput" type="text" placeholder="Cari hashtag (contoh: fyp)" 
                           class="w-full bg-white/5 border border-modern rounded-full py-2 pl-10 pr-4 text-sm focus:outline-none focus:border-blue-500/50 focus:bg-white/10 transition-all placeholder-gray-600">
                </form>
            </div>
            
            {{-- Kanan: Profil User & Logout --}}
            <div class="flex items-center gap-4">
                <div class="hidden sm:flex items-center gap-3 cursor-pointer group" onclick="window.location='{{ route('profile.edit') }}'">
                    <img src="{{ Auth::user()->profile_photo_url }}" class="w-8 h-8 rounded-full object-cover ring-2 ring-transparent group-hover:ring-blue-500 transition-all" alt="">
                    <span class="text-sm font-semibold text-gray-300 group-hover:text-white transition-colors">{{ Auth::user()->name }}</span>
                </div>
                
                <form method="POST" action="{{ route('logout') }}" class="inline-block">
                    @csrf
                    <button class="flex items-center gap-2 text-gray-500 hover:text-red-400 transition-colors p-2 rounded-xl hover:bg-red-500/10" title="Keluar">
                        <i data-lucide="log-out" class="w-5 h-5"></i>
                        <span class="hidden sm:block text-sm font-medium">Logout</span>
                    </button>
                </form>
            </div>
        </div>
    </nav>

    {{-- ===== KONTEN UTAMA (FULLSCREEN) ===== --}}
        {{-- ===== KONTEN UTAMA (FULLSCREEN FLEX) ===== --}}
    <div class="flex flex-1 overflow-hidden">
        
        {{-- KOLOM KIRI: Feed Utama --}}
        <main class="flex-1 min-h-screen overflow-y-auto border-r border-modern">
            {{-- Flash Message --}}
            @if(session('success'))
                <div class="max-w-2xl mx-auto mt-4 px-4">
                    <div class="bg-blue-500/10 border border-blue-500/20 text-blue-300 px-4 py-3 text-sm text-center rounded-xl">
                        <i data-lucide="check-circle" class="w-4 h-4 inline -mt-0.5"></i> {{ session('success') }}
                    </div>
                </div>
            @endif
            @yield('content')
        </main>

        {{-- KOLOM KANAN: Sidebar Hashtag (Hanya muncul jika halaman memanggilnya) --}}
        @hasSection('sidebar')
        <aside class="w-80 xl:w-96 min-h-screen overflow-y-auto bg-[#090909] hidden md:block border-r border-modern">
            @yield('sidebar')
        </aside>
        @endif

    </div>

    {{-- Script Like Komentar --}}
            <script>
                function handleHashtagSearch(event) {
            event.preventDefault(); // Cegah form reload biasa
            let input = document.getElementById('searchInput').value.trim();
            
            if (input === '') return; // Abaikan jika kosong
            
            // Hapus tanda '#' jika user mengetikkannya (misal: #fyp -> fyp)
            if (input.startsWith('#')) {
                input = input.substring(1);
            }
            
            // Redirect ke halaman filter hashtag
            window.location.href = `/hashtag/${input}`;
        }
        async function togglePostLike(btn, postId) {
            console.log("Tombol like diklik! Post ID:", postId); // DEBUG
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch(`/posts/${postId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Server Error: ' + response.status);
                const data = await response.json();
                console.log("Respon dari server:", data); // DEBUG
                
                const icon = btn.querySelector('svg');
                const countSpan = btn.querySelector('.like-count');

                if (data.liked) {
                    btn.classList.remove('text-gray-500');
                    btn.classList.add('text-pink-500');
                    if(icon) icon.style.fill = 'currentColor';
                } else {
                    btn.classList.remove('text-pink-500');
                    btn.classList.add('text-gray-500');
                    if(icon) icon.style.fill = 'none';
                }
                
                if(countSpan) {
                    countSpan.innerText = String(data.count);
                }
                
            } catch (error) {
                console.error("ERROR DI JAVASCRIPT:", error); // DEBUG
            }
        }

        async function toggleCommentLike(btn, commentId) {
            console.log("Tombol like komentar diklik! Comment ID:", commentId); // DEBUG
            try {
                const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
                const response = await fetch(`/comments/${commentId}/like`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                });

                if (!response.ok) throw new Error('Server Error: ' + response.status);
                const data = await response.json();
                console.log("Respon dari server:", data); // DEBUG
                
                const icon = btn.querySelector('svg');
                const countSpan = btn.querySelector('.like-count');

                if (data.liked) {
                    btn.classList.remove('text-gray-600');
                    btn.classList.add('text-pink-500');
                    if(icon) icon.style.fill = 'currentColor';
                } else {
                    btn.classList.remove('text-pink-500');
                    btn.classList.add('text-gray-600');
                    if(icon) icon.style.fill = 'none';
                }
                
                if(countSpan) {
                    countSpan.innerText = String(data.count);
                }
                
            } catch (error) {
                console.error("ERROR DI JAVASCRIPT:", error); // DEBUG
            }
        }
    </script>

    <script>lucide.createIcons();</script>
    @stack('scripts')
</body>
</html>