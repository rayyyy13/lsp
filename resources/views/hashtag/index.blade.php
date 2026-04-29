@extends('layout.app')
@section('title', $pageTitle)

@section('content')
    <div class="sticky top-0 z-20 glass border-b border-modern px-4 py-3">
        <a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-300 text-sm font-semibold flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
        <h1 class="text-xl font-extrabold tracking-tight gradient-text inline-block mt-1">#{{ $tag }}</h1>
    </div>

    {{-- Tampilkan Postingan --}}
    @forelse($posts as $post)
        @include('partials.post-card')
    @empty
        <div class="text-center py-10 px-4"><p class="text-gray-500 text-sm">Tidak ada postingan dengan hashtag ini.</p></div>
    @endforelse

    {{-- Tampilkan Komentar (Utama & Balasan) --}}
    @forelse($comments as $comment)
        <div class="flex gap-3 px-4 py-3 border-b border-modern hover-modern transition-colors">
            <img src="{{ $comment->user->profile_photo_url }}" class="w-10 h-10 rounded-full object-cover shrink-0" alt="">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 text-sm flex-wrap">
                    <span class="font-bold text-gray-200">{{ $comment->user->name }}</span>
                    <span class="text-gray-600"> {{ $comment->username }} · {{ $comment->created_at->diffForHumans() }}</span>
                    
                    {{-- Jika ini balasan, tampilkan konteksnya --}}
                    @if($comment->parent)
                    <span class="text-xs bg-white/5 px-2 py-0.5 rounded-full text-gray-500 flex items-center gap-1">
                        <i data-lucide="reply" class="w-3 h-3"></i> Membalas {{ $comment->parent->username }}
                    </span>
                    @else
                    <span class="text-xs bg-white/5 px-2 py-0.5 rounded-full text-gray-500">Komentar Utama</span>
                    @endif
                </div>
                <p class="text-[15px] mt-1 leading-relaxed text-gray-300">{!! linkHashtags($comment->content) !!}</p>
                
                {{-- Link menuju postingan asalnya --}}
                <a href="{{ route('posts.show', $comment->post_id) }}" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Lihat di thread asli →</a>
            </div>
        </div>
    @empty
        <div class="text-center py-10 px-4"><p class="text-gray-500 text-sm">Tidak ada komentar dengan hashtag ini.</p></div>
    @endforelse
@endsection