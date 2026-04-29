@extends('layout.app')
@section('title', 'Edit Postingan — Vyona')

@section('content')
    {{-- Header dengan tombol Batal yang langsung ke Beranda --}}
    <div class="sticky top-0 z-20 glass border-b border-modern px-4 py-3 flex items-center gap-6">
        <a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-300 text-sm font-semibold flex items-center gap-1">
            <i data-lucide="x" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <div class="p-6">
        <form method="POST" action="{{ route('posts.update', $post->id) }}" enctype="multipart/form-data" class="space-y-4">
            @csrf @method('PUT')
            
            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                    @foreach ($errors->all() as $error) {{ $error }} @endforeach
                </div>
            @endif

            <div>
                <textarea name="content" maxlength="250" required
                    class="input-modern w-full rounded-xl p-4 text-white resize-none min-h-[120px]"
                    oninput="document.getElementById('eCharCount').textContent=250-this.value.length">{{ old('content', $post->content) }}</textarea>
                <span id="eCharCount" class="text-xs text-gray-600 mt-1 block">{{ 250 - strlen(old('content', $post->content)) }}</span>
            </div>

            <div class="flex flex-wrap gap-3">
                <label class="flex items-center gap-2 text-sm text-gray-400 px-4 py-2 border border-dashed border-modern rounded-xl hover:border-blue-500/50 hover:text-blue-400 cursor-pointer transition-colors">
                    <i data-lucide="image" class="w-4 h-4"></i> Ganti Gambar
                    <input type="file" name="image" accept="image/*" class="hidden">
                </label>
                <label class="flex items-center gap-2 text-sm text-gray-400 px-4 py-2 border border-dashed border-modern rounded-xl hover:border-blue-500/50 hover:text-blue-400 cursor-pointer transition-colors">
                    <i data-lucide="file-text" class="w-4 h-4"></i> Ganti File
                    <input type="file" name="file" class="hidden">
                </label>
            </div>

            @if($post->image_path)
                <div class="relative inline-block">
                    <img src="{{ Storage::url($post->image_path) }}" class="rounded-xl max-h-[200px] border border-modern ring-1 ring-white/5" alt="">
                    <p class="text-xs text-gray-600 mt-1">Gambar saat ini (upload baru untuk mengganti)</p>
                </div>
            @endif
            @if($post->file_path)
                <p class="text-xs text-gray-600">📎 File saat ini: {{ $post->file_name }} (upload baru untuk mengganti)</p>
            @endif

            <button type="submit" class="gradient-bg text-white font-bold rounded-xl px-8 py-3 hover:opacity-90 transition-opacity shadow-lg shadow-blue-500/20">Simpan Perubahan</button>
        </form>
    </div>
@endsection