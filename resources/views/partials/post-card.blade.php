<div class="flex gap-3 p-4 border-b border-modern hover-modern transition-all duration-200">
    <a href="{{ route('profile.edit') }}">
        <img src="{{ $post->user->profile_photo_url }}" class="w-11 h-11 rounded-full object-cover shrink-0 ring-1 ring-white/10" alt="">
    </a>
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 text-[15px]">
    @if($post->user->is_own_profile)
        <a href="{{ route('profile.edit') }}" class="font-bold truncate hover:underline">{{ $post->user->name }}</a>
    @else
        <span class="font-bold truncate text-white">{{ $post->user->name }}</span>
    @endif
            <span class="text-gray-500 truncate text-sm">{{ $post->username }} · {{ $post->created_at->diffForHumans() }}</span>
        </div>
        
        {{-- TEKS POSTINGAN --}}
        <a href="{{ route('posts.show', $post->id) }}" class="block mt-1">
            <p class="text-[15px] leading-relaxed text-gray-200">{!! linkHashtags($post->content) !!}</p>
        </a>
        
        {{-- GAMBAR POSTINGAN (Kalau ada) --}}
        @if($post->image_path)
        <a href="{{ route('posts.show', $post->id) }}">
            <img src="{{ Storage::url($post->image_path) }}" class="mt-3 rounded-xl border border-modern max-w-xs w-full h-auto object-cover ring-1 ring-white/5" alt="Gambar Post">
        </a>
        @endif
        
        {{-- FILE POSTINGAN (Kalau ada) --}}
        @if($post->file_path)
        <a href="{{ Storage::url($post->file_path) }}" download="{{ $post->file_name }}" class="inline-flex items-center gap-2 mt-3 px-3 py-2 bg-white/5 border border-modern rounded-xl text-blue-400 text-sm hover:bg-white/10 transition-colors">
            <i data-lucide="paperclip" class="w-4 h-4"></i> 
            <span>{{ $post->file_name }}</span>
            <i data-lucide="download" class="w-3.5 h-3.5 ml-1"></i>
        </a>
        @endif
        
        {{-- BARIS AKSI (Komentar, Like, Edit, Hapus) --}}
        <div class="flex items-center gap-1 mt-3 -ml-2">
            <a href="{{ route('posts.show', $post->id) }}" class="flex items-center gap-1.5 text-gray-500 hover:text-blue-400 transition-colors p-2 rounded-full hover:bg-blue-500/10 text-sm">
                <i data-lucide="message-circle" class="w-[18px] h-[18px]"></i>
                <span>{{ $post->comments->count() }}</span>
            </a>
            
            {{-- TOMBOL LIKE --}}
            <button type="button" onclick="event.stopPropagation(); {{ auth()->check() ? "togglePostLike(this, $post->id)" : "guestRedirect()" }}" class="flex items-center gap-1.5 text-sm transition-colors p-2 rounded-full hover:bg-pink-500/10 {{ auth()->check() && $post->isLikedByAuthUser() ? 'text-pink-500' : 'text-gray-500 hover:text-pink-400' }}">
                <i data-lucide="heart" class="w-[18px] h-[18px]"></i>
                <span class="like-count">{{ $post->likes->count() }}</span>
            </button>

            {{-- TOMBOL EDIT & HAPUS (Hanya untuk pemilik) --}}
            @auth
            @if($post->user_id === Auth::id())
                <a href="{{ route('posts.edit', $post->id) }}" class="text-gray-600 hover:text-blue-400 transition-colors p-2 rounded-full hover:bg-blue-500/10">
                    <i data-lucide="pencil" class="w-[18px] h-[18px]"></i>
                </a>
                <form method="POST" action="{{ route('posts.destroy', $post->id) }}" class="inline" onsubmit="event.stopPropagation(); return confirm('Hapus postingan ini?');">
                    @csrf @method('DELETE')
                    <button type="submit" class="text-gray-600 hover:text-red-400 transition-colors p-2 rounded-full hover:bg-red-500/10">
                        <i data-lucide="trash-2" class="w-[18px] h-[18px]"></i>
                    </button>
                </form>
            @endif
            @endauth
        </div>
    </div>
</div>