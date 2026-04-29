<div class="flex gap-3 p-4 border-b border-modern hover-modern transition-all duration-200">
    <a href="<?php echo e(route('profile.edit')); ?>">
        <img src="<?php echo e($post->user->profile_photo_url); ?>" class="w-11 h-11 rounded-full object-cover shrink-0 ring-1 ring-white/10" alt="">
    </a>
    <div class="flex-1 min-w-0">
        <div class="flex items-center gap-2 text-[15px]">
    <?php if($post->user->is_own_profile): ?>
        <a href="<?php echo e(route('profile.edit')); ?>" class="font-bold truncate hover:underline"><?php echo e($post->user->name); ?></a>
    <?php else: ?>
        <span class="font-bold truncate text-white"><?php echo e($post->user->name); ?></span>
    <?php endif; ?>
            <span class="text-gray-500 truncate text-sm"><?php echo e($post->username); ?> · <?php echo e($post->created_at->diffForHumans()); ?></span>
        </div>
        
        
        <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="block mt-1">
            <p class="text-[15px] leading-relaxed text-gray-200"><?php echo linkHashtags($post->content); ?></p>
        </a>
        
        
        <?php if($post->image_path): ?>
        <a href="<?php echo e(route('posts.show', $post->id)); ?>">
            <img src="<?php echo e(Storage::url($post->image_path)); ?>" class="mt-3 rounded-xl border border-modern max-w-xs w-full h-auto object-cover ring-1 ring-white/5" alt="Gambar Post">
        </a>
        <?php endif; ?>
        
        
        <?php if($post->file_path): ?>
        <a href="<?php echo e(Storage::url($post->file_path)); ?>" download="<?php echo e($post->file_name); ?>" class="inline-flex items-center gap-2 mt-3 px-3 py-2 bg-white/5 border border-modern rounded-xl text-blue-400 text-sm hover:bg-white/10 transition-colors">
            <i data-lucide="paperclip" class="w-4 h-4"></i> 
            <span><?php echo e($post->file_name); ?></span>
            <i data-lucide="download" class="w-3.5 h-3.5 ml-1"></i>
        </a>
        <?php endif; ?>
        
        
        <div class="flex items-center gap-1 mt-3 -ml-2">
            <a href="<?php echo e(route('posts.show', $post->id)); ?>" class="flex items-center gap-1.5 text-gray-500 hover:text-blue-400 transition-colors p-2 rounded-full hover:bg-blue-500/10 text-sm">
                <i data-lucide="message-circle" class="w-[18px] h-[18px]"></i>
                <span><?php echo e($post->comments->count()); ?></span>
            </a>
            
            
            <button type="button" onclick="event.stopPropagation(); <?php echo e(auth()->check() ? "togglePostLike(this, $post->id)" : "guestRedirect()"); ?>" class="flex items-center gap-1.5 text-sm transition-colors p-2 rounded-full hover:bg-pink-500/10 <?php echo e(auth()->check() && $post->isLikedByAuthUser() ? 'text-pink-500' : 'text-gray-500 hover:text-pink-400'); ?>">
                <i data-lucide="heart" class="w-[18px] h-[18px]"></i>
                <span class="like-count"><?php echo e($post->likes->count()); ?></span>
            </button>

            
            <?php if(auth()->guard()->check()): ?>
            <?php if($post->user_id === Auth::id()): ?>
                <a href="<?php echo e(route('posts.edit', $post->id)); ?>" class="text-gray-600 hover:text-blue-400 transition-colors p-2 rounded-full hover:bg-blue-500/10">
                    <i data-lucide="pencil" class="w-[18px] h-[18px]"></i>
                </a>
                <form method="POST" action="<?php echo e(route('posts.destroy', $post->id)); ?>" class="inline" onsubmit="event.stopPropagation(); return confirm('Hapus postingan ini?');">
                    <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="text-gray-600 hover:text-red-400 transition-colors p-2 rounded-full hover:bg-red-500/10">
                        <i data-lucide="trash-2" class="w-[18px] h-[18px]"></i>
                    </button>
                </form>
            <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div><?php /**PATH C:\laragon\www\vyona\resources\views/partials/post-card.blade.php ENDPATH**/ ?>