<div class="py-3 border-b border-modern/50 hover-modern transition-all pl-2">
    <div class="flex gap-3">
        <img src="{{ $comment->user->profile_photo_url }}" class="w-9 h-9 rounded-full object-cover shrink-0 ring-1 ring-white/10" alt="">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 text-sm">
                @if($comment->user->is_own_profile)
    <a href="{{ route('profile.edit') }}" class="font-bold text-gray-200 hover:underline">{{ $comment->user->name }}</a>
@else
    <span class="font-bold text-gray-200">{{ $comment->user->name }}</span>
@endif
                <span class="text-gray-600"> {{ $comment->username }} · {{ $comment->created_at->diffForHumans() }}</span>
            </div>
            <p class="text-[15px] mt-1 leading-relaxed text-gray-300">{!! linkHashtags($comment->content) !!}</p>
            
            @if($comment->image_path)
                <img src="{{ Storage::url($comment->image_path) }}" class="mt-3 rounded-xl border border-modern w-full max-w-xs h-auto object-cover ring-1 ring-white/5" alt="">
            @endif
            @if($comment->file_path)
                <a href="{{ Storage::url($comment->file_path) }}" download="{{ $comment->file_name }}" class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-1.5 bg-white/5 border border-modern rounded-lg text-blue-400 text-xs hover:bg-white/10 transition-colors">
                    <i data-lucide="paperclip" class="w-3 h-3"></i> {{ $comment->file_name }}
                </a>
            @endif
            
            {{-- AKSI: Like, Balas, Edit, Hapus --}}
            <div class="flex items-center gap-4 mt-2">
                <button type="button" onclick="event.stopPropagation(); toggleCommentLike(this, {{ $comment->id }})" 
                        class="flex items-center gap-1.5 text-sm transition-colors p-1.5 rounded-full hover:bg-pink-500/10 {{ $comment->isLikedByAuthUser() ? 'text-pink-500' : 'text-gray-600 hover:text-pink-400' }}">
                    <i data-lucide="heart" class="w-[16px] h-[16px]"></i>
                    <span class="like-count text-xs">{{ $comment->likes->count() }}</span>
                </button>

                {{-- TOMBOL BALAS --}}
                <button onclick="document.getElementById('reply-{{ $comment->id }}').classList.toggle('hidden')" class="text-xs text-gray-600 hover:text-blue-400 font-medium transition-colors flex items-center gap-1">
                    <i data-lucide="message-circle" class="w-3 h-3"></i> Balas
                </button>

                @auth
                @if($comment->user_id === Auth::id())
                    <a href="{{ route('comments.edit', $comment->id) }}" class="text-xs text-gray-600 hover:text-blue-400 font-medium transition-colors flex items-center gap-1">
                        <i data-lucide="pencil" class="w-3 h-3"></i> Edit
                    </a>
                    <form method="POST" action="{{ route('comments.destroy', $comment->id) }}" class="inline" onsubmit="return confirm('Hapus komentar ini?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="text-xs text-gray-600 hover:text-red-400 font-medium transition-colors flex items-center gap-1">
                            <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
                        </button>
                    </form>
                @endif
                @endauth
            </div>

            {{-- FORM BALAS (HIDDEN) --}}
            <div id="reply-{{ $comment->id }}" class="hidden mt-3 p-3 bg-[#080808] border border-modern/30 rounded-xl">
                <form method="POST" action="{{ route('comments.store', $comment->post_id) }}" enctype="multipart/form-data" class="flex gap-2">
                    @csrf
                    <input type="hidden" name="parent_id" value="{{ $comment->id }}">
                    <img src="{{ auth()->check() ? Auth::user()->profile_photo_url : '' }}" class="w-7 h-7 rounded-full object-cover shrink-0 mt-1" alt="">
                    <div class="flex-1 flex flex-col gap-2">
                        <textarea name="content" maxlength="250" required placeholder="Tulis balasan..." class="w-full bg-transparent text-sm resize-none outline-none placeholder-gray-600 min-h-[40px]"></textarea>
                        
                        {{-- PREVIEW GAMBAR BALASAN --}}
                        <div id="reply-preview-container-{{ $comment->id }}" class="hidden">
                            <div id="reply-image-box-{{ $comment->id }}" class="hidden relative inline-block">
                                <img id="reply-image-preview-{{ $comment->id }}" src="" class="max-w-[150px] h-auto rounded-lg border border-modern" alt="Preview">
                                <button type="button" onclick="clearReplyImagePreview({{ $comment->id }})" class="absolute top-1 right-1 bg-black/70 text-white rounded-full p-0.5 hover:bg-red-500 transition-colors">
                                    <i data-lucide="x" class="w-3 h-3"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <label class="p-1.5 rounded-full hover:bg-blue-500/10 cursor-pointer transition-colors">
                                <i data-lucide="image" class="w-4 h-4 text-blue-500"></i>
                                <input type="file" name="image" accept="image/*" class="hidden" onchange="previewReplyImage(this, {{ $comment->id }})">
                            </label>
                            <button type="submit" class="gradient-bg text-white text-xs font-bold rounded-lg px-4 py-1.5 hover:opacity-90 transition-opacity">Balas</button>
                        </div>
                    </div>
                </form>
            </div>

                        {{-- REKURSI: BALASAN MENJOROK KE KANAN (STYLE TWITTER) --}}
            @if($comment->replies->count() > 0)
                <div class="mt-2 ml-12 space-y-0">
                    @foreach($comment->replies as $reply)
                        @include('partials.comment-card', ['comment' => $reply])
                    @endforeach
                </div>
            @endif

        </div>
    </div>
</div>