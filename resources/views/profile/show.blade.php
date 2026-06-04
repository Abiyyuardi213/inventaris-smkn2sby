@extends('layouts.app')

@section('title', 'Profil Saya - Inventaris SMKN 2 SBY')
@section('page_title', 'Profil Saya')

@section('content')
<div class="max-w-3xl mx-auto space-y-6">
    <nav class="flex items-center gap-1.5 text-sm text-zinc-500">
        <a href="{{ route('dashboard') }}" class="hover:text-zinc-900 transition-colors">Dashboard</a>
        <svg class="w-3.5 h-3.5 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
        </svg>
        <span class="font-medium text-zinc-900">Profil Saya</span>
    </nav>

    <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
        <div class="border-b border-zinc-100 bg-zinc-50/60 px-6 py-5">
            <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
                <div class="flex items-center gap-4">
                    <div class="flex h-14 w-14 items-center justify-center rounded-full bg-zinc-900 text-xl font-bold text-white">
                        {{ strtoupper(substr($user->nama ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="text-xl font-bold tracking-tight text-zinc-900">{{ $user->nama }}</h2>
                        <p class="text-sm text-zinc-500">{{ $user->role?->nama_role ?? 'Tanpa Role' }}</p>
                    </div>
                </div>
                <a href="{{ route('profile.edit') }}" class="inline-flex h-10 items-center justify-center rounded-md bg-zinc-900 px-4 text-sm font-medium text-white shadow-sm hover:bg-zinc-800">
                    Edit Profil
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 p-6">
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Nama Lengkap</span>
                <p class="mt-1 text-sm font-semibold text-zinc-900">{{ $user->nama }}</p>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Username</span>
                <p class="mt-1 text-sm font-mono text-zinc-700">{{ $user->username }}</p>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Email</span>
                <p class="mt-1 text-sm text-zinc-900">{{ $user->email }}</p>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Role</span>
                <p class="mt-1">
                    <span class="inline-flex rounded-md border border-zinc-200 bg-zinc-100 px-2.5 py-1 text-xs font-semibold text-zinc-700">
                        {{ $user->role?->nama_role ?? 'Tanpa Role' }}
                    </span>
                </p>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Terdaftar</span>
                <p class="mt-1 text-sm text-zinc-700">{{ $user->created_at?->format('d M Y, H:i') }}</p>
            </div>
            <div>
                <span class="block text-xs font-semibold uppercase tracking-wider text-zinc-400">Terakhir Diperbarui</span>
                <p class="mt-1 text-sm text-zinc-700">{{ $user->updated_at?->format('d M Y, H:i') }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
