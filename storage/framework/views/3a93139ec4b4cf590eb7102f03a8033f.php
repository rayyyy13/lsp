
<?php $__env->startSection('title', 'Beranda — Vyona'); ?>

<?php $__env->startSection('content'); ?>
    
    <div class="sticky top-0 z-20 glass border-b border-modern px-4 py-3">
        <h1 class="text-xl font-extrabold tracking-tight">Beranda</h1>
    </div>

    
    <div class="p-4 border-b border-modern bg-[#0a0a0a]">
        <form method="POST" action="<?php echo e(route('posts.store')); ?>" enctype="multipart/form-data" class="flex gap-3">
            <?php echo csrf_field(); ?>
            <img src="<?php echo e(Auth::user()->profile_photo_url); ?>" class="w-11 h-11 rounded-full object-cover shrink-0 ring-1 ring-white/10" alt="">
            <div class="flex-1">
                <textarea name="content" maxlength="250" required placeholder="Apa yang sedang terjadi?"
                    class="w-full bg-transparent text-[15px] resize-none outline-none placeholder-gray-600 min-h-[60px]"
                    oninput="document.getElementById('charCount').textContent=250-this.value.length"><?php echo e(old('content')); ?></textarea>
                
                
                <div id="previewContainer" class="hidden mt-3 space-y-2">
                    
                    <div id="imagePreviewBox" class="hidden relative inline-block">
                        <img id="imagePreview" src="" class="max-w-full h-auto rounded-xl border border-modern ring-1 ring-white/5" alt="Preview">
                        <button type="button" onclick="clearImagePreview()" class="absolute top-2 right-2 bg-black/70 text-white rounded-full p-1 hover:bg-red-500 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                    
                    <div id="filePreviewBox" class="hidden flex items-center gap-2 px-3 py-2 bg-white/5 border border-modern rounded-xl text-sm text-blue-400 w-fit">
                        <i data-lucide="file-text" class="w-4 h-4"></i>
                        <span id="filePreviewName" class="truncate max-w-[200px]"></span>
                        <button type="button" onclick="clearFilePreview()" class="text-gray-500 hover:text-red-400 transition-colors">
                            <i data-lucide="x" class="w-4 h-4"></i>
                        </button>
                    </div>
                </div>

                <div class="flex justify-between items-center pt-3 mt-2 border-t border-modern/50">
                    <div class="flex gap-1">
                        <label class="p-2 rounded-full hover:bg-blue-500/10 cursor-pointer transition-colors">
                            <i data-lucide="image" class="w-5 h-5 text-blue-500"></i>
                            <input type="file" name="image" id="imageInput" accept="image/*" class="hidden" onchange="previewImage(this)">
                        </label>
                        <label class="p-2 rounded-full hover:bg-blue-500/10 cursor-pointer transition-colors">
                            <i data-lucide="paperclip" class="w-5 h-5 text-blue-500"></i>
                            <input type="file" name="file" id="fileInput" class="hidden" onchange="previewFile(this)">
                        </label>
                    </div>
                    <div class="flex items-center gap-3">
                        <span id="charCount" class="text-xs text-gray-600 font-medium">250</span>
                        <button type="submit" class="gradient-bg text-white text-sm font-bold rounded-xl px-5 py-2 hover:opacity-90 transition-opacity shadow-lg shadow-blue-500/20">Posting</button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    
    <?php $__empty_1 = true; $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
        <?php echo $__env->make('partials.post-card', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
        <div class="text-center py-20 px-4">
            <i data-lucide="inbox" class="w-12 h-12 text-gray-700 mx-auto mb-4"></i>
            <p class="text-xl font-bold text-gray-400">Belum ada postingan</p>
            <p class="text-sm text-gray-600 mt-1">Jadilah yang pertama memposting sesuatu.</p>
        </div>
    <?php endif; ?>
<?php $__env->stopSection(); ?>


<?php $__env->startSection('sidebar'); ?>
    <div class="p-5">
        <div class="flex items-center gap-2 mb-4">
            <i data-lucide="hash" class="w-5 h-5 text-blue-500"></i>
            <h2 class="text-lg font-bold">Hashtag Trending</h2>
        </div>

        <div class="space-y-1">
            <?php $__empty_1 = true; $__currentLoopData = $hashtags; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $tag => $count): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <a href="/hashtag/<?php echo e($tag); ?>" class="flex items-center justify-between p-3 rounded-xl hover:bg-white/5 transition-colors group cursor-pointer">
                    <div>
                        <p class="font-bold text-white group-hover:text-blue-400 transition-colors">#<?php echo e($tag); ?></p>
                        <p class="text-xs text-gray-600 mt-0.5"><?php echo e($count); ?> postingan</p>
                    </div>
                    <i data-lucide="trending-up" class="w-4 h-4 text-gray-700 group-hover:text-blue-500 transition-colors"></i>
                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <p class="text-gray-600 text-sm text-center py-8">Belum ada hashtag yang dibuat.</p>
            <?php endif; ?>
        </div>

        <div class="mt-8 pt-4 border-t border-modern text-xs text-gray-700 leading-relaxed">
            <p>Vyona &copy; <?php echo e(date('Y')); ?></p>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
    // Fungsi untuk menampilkan preview gambar
    function previewImage(input) {
        const previewBox = document.getElementById('imagePreviewBox');
        const previewImg = document.getElementById('imagePreview');
        const container = document.getElementById('previewContainer');
        
        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.type.startsWith('image/')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    previewImg.src = e.target.result;
                    previewBox.classList.remove('hidden');
                    container.classList.remove('hidden');
                    lucide.createIcons(); // Render ulang ikon X
                }
                reader.readAsDataURL(file);
            }
        }
    }

    // Fungsi untuk membatalkan pilihan gambar
    function clearImagePreview() {
        document.getElementById('imageInput').value = '';
        document.getElementById('imagePreview').src = '';
        document.getElementById('imagePreviewBox').classList.add('hidden');
        checkPreviewContainer();
    }

    // Fungsi untuk menampilkan nama file yang dipilih
    function previewFile(input) {
        const previewBox = document.getElementById('filePreviewBox');
        const previewName = document.getElementById('filePreviewName');
        const container = document.getElementById('previewContainer');
        
        if (input.files && input.files[0]) {
            previewName.textContent = input.files[0].name;
            previewBox.classList.remove('hidden');
            container.classList.remove('hidden');
            lucide.createIcons(); // Render ulang ikon
        }
    }

    // Fungsi untuk membatalkan pilihan file
    function clearFilePreview() {
        document.getElementById('fileInput').value = '';
        document.getElementById('filePreviewName').textContent = '';
        document.getElementById('filePreviewBox').classList.add('hidden');
        checkPreviewContainer();
    }

    // Menyembunyikan kotak preview jika keduanya kosong
    function checkPreviewContainer() {
        const imgBox = document.getElementById('imagePreviewBox');
        const fileBox = document.getElementById('filePreviewBox');
        const container = document.getElementById('previewContainer');
        
        if (imgBox.classList.contains('hidden') && fileBox.classList.contains('hidden')) {
            container.classList.add('hidden');
        }
    }
</script>
<?php $__env->stopPush(); ?>
<?php echo $__env->make('layout.app', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\laragon\www\vyona\resources\views/home.blade.php ENDPATH**/ ?>