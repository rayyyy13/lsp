@extends('layout.app')
@section('title', 'Pengaturan Profil — Vyona')

@section('content')
    <div class="sticky top-0 z-20 glass border-b border-modern px-4 py-3 flex items-center gap-6">
        <a href="{{ route('home') }}" class="text-blue-400 hover:text-blue-300 text-sm font-semibold flex items-center gap-1">
            <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali
        </a>
    </div>

    <div class="p-6 max-w-lg">
        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf

            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/20 text-red-400 px-4 py-3 rounded-xl text-sm">
                    @foreach ($errors->all() as $error) • {{ $error }} <br> @endforeach
                </div>
            @endif

            {{-- Foto Profil --}}
            <div class="flex items-center gap-6">
                <img src="{{ $user->profile_photo_url }}" class="w-24 h-24 rounded-full object-cover ring-2 ring-white/10 shadow-xl" alt="">
                <div>
                    <label class="text-blue-400 text-sm font-bold cursor-pointer hover:text-blue-300 hover:underline transition-colors">
                        Ubah Foto Profil
                        <input type="file" name="profile_photo" accept="image/*" class="hidden">
                    </label>
                    <p class="text-xs text-gray-600 mt-1">JPG, PNG, GIF. Maksimal 2MB.</p>
                </div>
            </div>

            <div class="space-y-4 bg-[#0a0a0a] p-6 rounded-2xl border border-modern">
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Nama Lengkap</label>
                    <input type="text" name="name" value="{{ old('name', $user->name) }}" required maxlength="50"
                        class="input-modern w-full rounded-xl px-4 py-3 text-white">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Username</label>
                    <div class="relative">
                        <span class="absolute left-4 top-1/2 -translate-y-1/2 text-gray-600 text-sm">@</span>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}" required maxlength="20"
                            class="input-modern w-full rounded-xl pl-8 pr-4 py-3 text-white">
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-400 mb-2">Email (Tidak bisa diubah)</label>
                    <input type="text" value="{{ $user->email }}" disabled
                        class="w-full bg-black border border-modern rounded-xl px-4 py-3 text-gray-600 cursor-not-allowed">
                </div>
            </div>

            <div class="bg-[#0a0a0a] p-6 rounded-2xl border border-modern">
                <label class="block text-sm font-medium text-gray-400 mb-2">Bio</label>
                <textarea name="bio" maxlength="160" rows="3"
                    class="input-modern w-full rounded-xl px-4 py-3 text-white resize-none"
                    oninput="document.getElementById('bioCount').textContent=160-this.value.length">{{ old('bio', $user->bio) }}</textarea>
                <span id="bioCount" class="text-xs text-gray-600 mt-1 block">{{ 160 - strlen(old('bio', $user->bio ?? '')) }}</span>
            </div>

            <button type="submit" class="gradient-bg text-white font-bold rounded-xl px-8 py-3 hover:opacity-90 transition-opacity shadow-lg shadow-blue-500/20 w-full sm:w-auto">Simpan Perubahan</button>
        </form>
    </div>
@endsection