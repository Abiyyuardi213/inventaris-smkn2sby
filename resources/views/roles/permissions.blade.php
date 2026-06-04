@extends('layouts.app')

@section('title', 'Hak Akses Peran - Inventaris SMKN 2 SBY')
@section('page_title', 'Hak Akses Peran')

@section('content')
<div class="max-w-5xl mx-auto space-y-6">
    <div class="flex flex-col sm:flex-row sm:items-start sm:justify-between gap-4">
        <div>
            <a href="{{ route('roles.index') }}" class="inline-flex items-center gap-1.5 text-sm text-zinc-500 hover:text-zinc-950 transition-colors mb-2">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                </svg>
                Kembali ke Daftar Peran
            </a>
            <h2 class="text-2xl font-bold tracking-tight text-zinc-900">Hak Akses {{ $role->nama_role }}</h2>
            <p class="text-sm text-zinc-500">Pilih modul yang boleh diakses oleh pengguna dengan role ini.</p>
        </div>
        <span class="inline-flex w-fit items-center rounded-md bg-zinc-100 px-2.5 py-1 text-xs font-mono font-medium text-zinc-800 border border-zinc-200">
            {{ $role->slug }}
        </span>
    </div>

    <form action="{{ route('roles.permissions.update', $role->id) }}" method="POST" class="space-y-6">
        @csrf
        @method('PUT')

        @if($role->slug === 'super-admin')
            <div class="rounded-md border border-amber-200 bg-amber-50 px-4 py-3 text-sm text-amber-800">
                Role Super Admin selalu memiliki semua hak akses agar tidak terkunci dari sistem.
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-4">
            @foreach($permissionGroups as $group => $permissions)
                <div class="rounded-lg border border-zinc-200 bg-white shadow-sm overflow-hidden">
                    <div class="border-b border-zinc-100 bg-zinc-50 px-5 py-3">
                        <h3 class="text-sm font-semibold text-zinc-900">{{ $group ?: 'Lainnya' }}</h3>
                    </div>
                    <div class="divide-y divide-zinc-100">
                        @foreach($permissions as $permission)
                            <label class="flex items-start gap-3 px-5 py-4 hover:bg-zinc-50 transition-colors cursor-pointer">
                                <input
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    class="mt-1 h-4 w-4 rounded border-zinc-300 text-zinc-900 focus:ring-zinc-950"
                                    @checked($role->slug === 'super-admin' || $role->permissions->contains('id', $permission->id))
                                    @disabled($role->slug === 'super-admin')
                                >
                                <span class="min-w-0">
                                    <span class="block text-sm font-medium text-zinc-900">{{ $permission->name }}</span>
                                    <span class="mt-1 inline-flex items-center rounded bg-zinc-100 px-2 py-0.5 text-[11px] font-mono text-zinc-600">
                                        {{ $permission->slug }}
                                    </span>
                                </span>
                            </label>
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>

        @error('permissions')
            <p class="text-sm font-medium text-red-500">{{ $message }}</p>
        @enderror

        <div class="flex items-center justify-end gap-3 rounded-lg border border-zinc-200 bg-white p-4 shadow-sm">
            <a href="{{ route('roles.index') }}" class="inline-flex items-center justify-center rounded-md border border-zinc-200 text-zinc-700 hover:text-zinc-950 bg-white hover:bg-zinc-50 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150">
                Batal
            </a>
            <button type="submit" class="inline-flex items-center justify-center rounded-md bg-zinc-900 text-zinc-50 hover:bg-zinc-800 h-10 px-4 py-2 text-sm font-medium shadow-sm transition-all duration-150 cursor-pointer">
                Simpan Hak Akses
            </button>
        </div>
    </form>
</div>
@endsection
