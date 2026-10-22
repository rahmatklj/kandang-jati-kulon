<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Traits\HasFileCleanup;

class Setting extends Model
{
    use HasFactory, HasFileCleanup;
    
    protected $guarded = [];

    /**
     * Dapatkan daftar atribut yang berisi berkas file jika key Setting berupa berkas/gambar.
     */
    public function getFileCleanupAttributes(): array
    {
        $val = $this->value;
        if (is_string($val) && !empty($val)) {
            $lower = strtolower($val);
            $imageKeys = [
                'foto_lurah', 'kadin_photo', 'logo_kelurahan', 'hero_background',
                'foto_sejarah', 'foto_lpmk', 'foto_sekretaris', 'foto_kasi_pemerintahan',
                'foto_kasi_trantib', 'foto_kasi_kesra', 'gambar_bagan_struktur', 'qr_code_image'
            ];
            if (in_array($this->key, $imageKeys) || Str::startsWith($lower, ['settings/', 'avatars/', 'uploads/']) || Str::endsWith($lower, ['.jpg', '.jpeg', '.png', '.webp', '.gif', '.svg', '.pdf'])) {
                return ['value'];
            }
        }
        return [];
    }
}
