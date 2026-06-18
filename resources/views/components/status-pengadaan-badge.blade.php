@props(['status'])

@php
    $config = match($status) {
        'pending' => [
            'class' => 'bg-amber-50 text-amber-700 border border-amber-200/50',
            'label' => 'Pending',
            'icon' => '<svg class="w-3.5 h-3.5 mr-1 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>'
        ],
        'disetujui_admin' => [
            'class' => 'bg-blue-50 text-blue-700 border border-blue-200/50',
            'label' => 'Menunggu Kepsek',
            'icon' => '<svg class="w-3.5 h-3.5 mr-1 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M8.625 12a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H8.25m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0H12m4.125 0a.375.375 0 1 1-.75 0 .375.375 0 0 1 .75 0Zm0 0h-.375M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 0 1-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8Z" /></svg>'
        ],
        'disetujui_kepsek' => [
            'class' => 'bg-emerald-50 text-emerald-700 border border-emerald-200/50',
            'label' => 'Disetujui Final',
            'icon' => '<svg class="w-3.5 h-3.5 mr-1 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2.5" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>'
        ],
        'ditolak' => [
            'class' => 'bg-red-50 text-red-700 border border-red-200/50',
            'label' => 'Ditolak Admin',
            'icon' => '<svg class="w-3.5 h-3.5 mr-1 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>'
        ],
        'ditolak_kepsek' => [
            'class' => 'bg-red-100 text-red-800 border border-red-300/50',
            'label' => 'Ditolak Kepsek',
            'icon' => '<svg class="w-3.5 h-3.5 mr-1 shrink-0" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" /></svg>'
        ],
        default => [
            'class' => 'bg-zinc-50 text-zinc-700 border border-zinc-200/50',
            'label' => $status,
            'icon' => ''
        ]
    };
@endphp

<span class="inline-flex items-center rounded-full px-2.5 py-0.5 text-xs font-semibold {{ $config['class'] }} shrink-0">
    {!! $config['icon'] !!}
    <span class="ml-1">{{ $config['label'] }}</span>
</span>
