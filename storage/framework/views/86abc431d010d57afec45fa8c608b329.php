<div class="py-3 border-b border-modern/50 hover-modern transition-all pl-2">
    <div class="flex gap-3">
        <img src="<?php echo e($comment->user->profile_photo_url); ?>" class="w-9 h-9 rounded-full object-cover shrink-0 ring-1 ring-white/10" alt="">
        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 text-sm">
                <?php if($comment->user->is_own_profile): ?>
    <a href="<?php echo e(route('profile.edit')); ?>" class="font-bold text-gray-200 hover:underline"><?php echo e($comment->user->name); ?></a>
<?php else: ?>
    <span class="font-bold text-gray-200"><?php echo e($comment->user->name); ?></span>
<?php endif; ?>
                <span class="text-gray-600"> <?php echo e($comment->username); ?> · <?php echo e($comment->created_at->diffForHumans()); ?></span>
            </div>
            <p class="text-[15px] mt-1 leading-relaxed text-gray-300"><?php echo linkHashtags($comment->content); ?></p>
            
            <?php if($comment->image_path): ?>
                <img src="<?php echo e(Storage::url($comment->image_path)); ?>" class="mt-3 rounded-xl border border-modern w-full max-w-xs h-auto object-cover ring-1 ring-white/5" alt="">
            <?php endif; ?>
            <?php if($comment->file_path): ?>
                <a href="<?php echo e(Storage::url($comment->file_path)); ?>" download="<?php echo e($comment->file_name); ?>" class="inline-flex items-center gap-1.5 mt-2 px-2.5 py-1.5 bg-white/5 border border-modern rounded-lg text-blue-400 text-xs hover:bg-white/10 transition-colors">
                    <i data-lucide="paperclip" class="w-3 h-3"></i> <?php echo e($comment->file_name); ?>

                </a>
            <?php endif; ?>
            
            
            <div class="flex items-center gap-4 mt-2">
                <button type="button" onclick="event.stopPropagation(); toggleCommentLike(this, <?php echo e($comment->id); ?>)" 
                        class="flex items-center gap-1.5 text-sm transition-colors p-1.5 rounded-full hover:bg-pink-500/10 <?php echo e($comment->isLikedByAuthUser() ? 'text-pink-500' : 'text-gray-600 hover:text-pink-400'); ?>">
                    <i data-lucide="heart" class="w-[16px] h-[16px]"></i>
                    <span class="like-count text-xs"><?php echo e($comment->likes->count()); ?></span>
                </button>

                
                <button onclick="document.getElementById('reply-<?php echo e($comment->id); ?>').classList.toggle('hidden')" class="text-xs text-gray-600 hover:text-blue-400 font-medium transition-colors flex items-center gap-1">
                    <i data-lucide="message-circle" class="w-3 h-3"></i> Balas
                </button>

                <?php if(auth()->guard()->check()): ?>
                <?php if($comment->user_id === Auth::id()): ?>
                    <a href="<?php echo e(route('comments.edit', $comment->id)); ?>" class="text-xs text-gray-600 hover:text-blue-400 font-medium transition-colors flex items-center gap-1">
                        <i data-lucide="pencil" class="w-3 h-3"></i> Edit
                    </a>
                    <form method="POST" action="<?php echo e(route('comments.destroy', $comment->id)); ?>" class="inline" onsubmit="return confirm('Hapus komentar ini?')">
                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                        <button type="submit" class="text-xs text-gray-600 hover:text-red-400 font-medium transition-colors flex items-center gap-1">
                            <i data-lucide="trash-2" class="w-3 h-3"></i> Hapus
                        </button>
                    </form>
                <?php endif; ?>
                <?php endif; ?>
            </div>

            
            <div id="reply-<?php echo e($comment->id); ?>" class="hidden mt-3 p-3 bg-[#080808] border border-modern/30 rounded-xl">
                <form method="POST" action="<?php echo e(route('comments.store', $comment->post_id)); ?>" enctype="multipart/form-data" class="flex gap-2">
                    <?php echo csrf_field(); ?>
                    <input type="hidden" name="parent_id" value="<?php echo e($comment->id); ?>">
                    <img src="<?php echo e(auth()->check() ? Auth::user()->profile_photo_url : ''); ?>" class="w-7 h-7 rounded-full object-cover shrink-0 mt-1" alt="">
                    <div class="flex-1 flex flex-col gap-2">
                        <textarea name="content" maxlength="250" required placeholder="Tulis balasan..." class="w-full bg-transparent text-sm resize-none outline-none placeholder-gray-600 min-h-[40px]"></textarea>
                        
                        
                        <div id="reply-preview-container-<?php echo e($comment->id); ?>" class="hidden">
                            <div id="reply-image-box-<?php echo e($comment->id); ?>" class="hidden relative inline-block">
                                <img id="reply-image-preview-<?php echo e($comment->id); ?>" src="" class="max-w-[150px] h-auto rounded-lg border border-modern" alt="Preview">
                                <button type="button" onclick="clearReplyImagePreview(<?php echo e($comment->id); ?>)" class="absolute top-1 right-1 bg-black/70 text-white rounded-full p-0.5 hover:bg-red-500 transition-colors">
                                    <i data-lucide="x" class="w-3 h-3"></i>
                                </button>
                            </div>
                        </div>

                        <div class="flex justify-between items-center">
                            <label class="p-1.5 rounded-full hover:bg-blue-500/10 cursor-pointer transition-colors">
                                <i data-lucide="image" class="w-4 h-4 text-blue-500"></i>
                                <input type="file" name="image" accept="image/*" class="hidden" onchange="previewReplyImage(this, <?php echo e($comment->id); ?>)">
                            </label>
                            <button type="submit" class="gradient-bg text-white text-xs font-bold rounded-lg px-4 py-1.5 hover:opacity-90 transition-opacity">Balas</button>
                        </div>
                    </div>
                </form>
            </div>

                        
            <?php if($comment->replies->count() > 0): ?>
                <div class="mt-2 ml-12 space-y-0">
                    <?php $__currentLoopData = $comment->replies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $reply): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php echo $__env->make('partials.comment-card', ['comment' => $reply], array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            <?php endif; ?>

        </div>
    </div>
</div><?php /**PATH C:\laragon\www\vyona\resources\views/partials/comment-card.blade.php ENDPATH**/ ?>