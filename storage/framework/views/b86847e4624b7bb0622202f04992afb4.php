
<?php $__env->startSection('title', 'Postingan — Vyona'); ?>

<?php $__env->startSection('content'); ?>
    <div class="sticky top-0 z-20 glass border-b border-modern px-4 py-3 flex items-center gap-6">
        <a href="<?php echo e(route('home')); ?>" class="text-blue-400 hover:text-blue-300 text-sm font-semibold flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <?php echo $__env->make('partials.post-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

    
    <?php if(auth()->guard()->check()): ?>
    <div class="p-4 border-b border-modern bg-[#0a0a0a]">
        <form method="POST" action="<?php echo e(route('comments.store', $post->id)); ?>" enctype="multipart/form-data" class="flex gap-3">
            <?php echo csrf_field(); ?>
            <img src="<?php echo e(Auth::user()->profile_photo_url); ?>" class="w-9 h-9 rounded-full object-cover shrink-0 mt-0.5 ring-1 ring-white/10" alt="">
            <div class="flex-1">
                <textarea name="content" maxlength="250" required placeholder="Tulis komentar..."
                    class="w-full bg-transparent text-[15px] resize-none outline-none placeholder-gray-600 min-h-[50px]"
                    oninput="document.getElementById('cCharCount').textContent=250-this.value.length"></textarea>
                <div class="flex justify-between items-center pt-3 mt-2 border-t border-modern/50">
                    <div class="flex gap-1">
                        <label class="p-1.5 rounded-full hover:bg-blue-500/10 cursor-pointer transition-colors">
                            <i data-lucide="image" class="w-4 h-4 text-blue-500"></i>
                            <input type="file" name="image" accept="image/*" class="hidden">
                        </label>
                        <label class="p-1.5 rounded-full hover:bg-blue-500/10 cursor-pointer transition-colors">
                            <i data-lucide="paperclip" class="w-4 h-4 text-blue-500"></i>
                            <input type="file" name="file" class="hidden">
                        </label>
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="cCharCount" class="text-xs text-gray-600 font-medium">250</span>
                        <button type="submit" class="gradient-bg text-white text-sm font-bold rounded-xl px-5 py-1.5 hover:opacity-90 transition-opacity shadow-lg shadow-blue-500/20">Balas</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <?php endif; ?>

    <div class="px-4">
        <?php $__empty_1 = true; $__currentLoopData = $comments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $comment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <?php echo $__env->make('partials.comment-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <p class="text-gray-600 text-sm py-10 text-center">Belum ada komentar pada postingan ini.</p>
        <?php endif; ?>
    </div>
    <?php $__env->startPush('scripts'); ?>
<script>
    // Fungsi Preview Gambar untuk Form Balasan
    function previewReplyImage(input, id) {
        const previewBox = document.getElementById('reply-image-box-' + id);
        const previewImg = document.getElementById('reply-image-preview-' + id);
        const container = document.getElementById('reply-preview-container-' + id);
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewBox.classList.remove('hidden');
                    container.classList.remove('hidden');
                    lucide.createIcons();
                }
                reader.readAsDataURL(file);
            }
        }
    }

    // Fungsi Hapus Preview Gambar Balasan
    function clearReplyImagePreview(id) {
        const form = document.querySelector('#reply-' + id + ' form');
        const imageInput = form.querySelector('input[name="image"]');
        imageInput.value = ''; // Kosongkan file input
        
        document.getElementById('reply-image-preview-' + id).src = '';
        document.getElementById('reply-image-box-' + id).classList.add('hidden');
        document.getElementById('reply-preview-container-' + id).classList.add('hidden');
    }
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\vyona\resources\views/posts/show.blade.php ENDPATH**/ ?>