<?php

namespace App\Services;

use App\Models\Inventaris;
use Illuminate\Support\Str;

class InventarisCodeGenerator
{
    public static function generate(string $namaBarang, array $reservedCodes = []): string
    {
        $words = collect(preg_split('/\s+/', Str::upper($namaBarang), -1, PREG_SPLIT_NO_EMPTY))
            ->map(fn (string $word) => preg_replace('/[^A-Z0-9]/', '', $word))
            ->filter();

        $prefix = $words->map(fn (string $word) => Str::substr($word, 0, 1))->implode('');
        $prefix = Str::substr($prefix ?: Str::slug($namaBarang, ''), 0, 8) ?: 'BRG';

        $base = 'INV-' . $prefix;
        $sequence = 1;

        do {
            $code = $base . '-' . str_pad((string) $sequence, 4, '0', STR_PAD_LEFT);
            $sequence++;
        } while (Inventaris::where('kode_inventaris', $code)->exists() || in_array($code, $reservedCodes, true));

        return $code;
    }
}
