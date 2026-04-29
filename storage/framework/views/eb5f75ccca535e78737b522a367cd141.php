
<?php $__env->startSection('title', $pageTitle); ?>

<?php $__env->startSection('content'); ?>
    <div class="sticky top-0 z-20 glass border-b border-modern px-4 py-3">
        <a href="<?php echo e(route('home')); ?>" class="text-blue-400 hover:text-blue-300 text-sm font-semibold flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
        <h1 class="text-xl font-extrabold tracking-tight gradient-text inline-block mt-1">#<?php echo e($tag); ?></h1>
    </div>

    
    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php echo $__env->make('partials.post-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-10 px-4"><p class="text-gray-500 text-sm">Tidak ada postingan dengan hashtag ini.</p></div>
    <?php endif; ?>

    
    <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <div class="flex gap-3 px-4 py-3 border-b border-modern hover-modern transition-colors">
            <img src="<?php echo e($comment->user->profile_photo_url); ?>" class="w-10 h-10 rounded-full object-cover shrink-0" alt="">
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 text-sm flex-wrap">
                    <span class="font-bold text-gray-200"><?php echo e($comment->user->name); ?></span>
                    <span class="text-gray-600"> <?php echo e($comment->username); ?> · <?php echo e($comment->created_at->diffForHumans()); ?></span>
                    
                    
                    <?php if($comment->parent): ?>
                    <span class="text-xs bg-white/5 px-2 py-0.5 rounded-full text-gray-500 flex items-center gap-1">
                        <i data-lucide="reply" class="w-3 h-3"></i> Membalas <?php echo e($comment->parent->username); ?>

                    </span>
                    <?php else: ?>
                    <span class="text-xs bg-white/5 px-2 py-0.5 rounded-full text-gray-500">Komentar Utama</span>
                    <?php endif; ?>
                </div>
                <p class="text-[15px] mt-1 leading-relaxed text-gray-300"><?php echo linkHashtags($comment->content); ?></p>
                
                
                <a href="<?php echo e(route('posts.show', $comment->post_id)); ?>" class="text-xs text-blue-500 hover:underline mt-1 inline-block">Lihat di thread asli →</a>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-10 px-4"><p class="text-gray-500 text-sm">Tidak ada komentar dengan hashtag ini.</p></div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\vyona\resources\views/hashtag/index.blade.php ENDPATH**/ ?>