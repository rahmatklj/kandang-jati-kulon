<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFileCleanup;

class Maklumat extends Model
{
    use HasFactory, HasFileCleanup;

    protected array $fileAttributes = ['image'];

    protected $table = 'maklumats';

    protected $fillable = [
        'title',
        'subtitle',
        'content',
        'image',
        'signer_name',
        'signer_title',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function getImageUrlAttribute()
    {
        if (!$this->image) {
            return null;
        }
        if (\Illuminate\Support\Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }
        $cleanPath = ltrim(str_replace('storage/', '', $this->image), '/');
        return asset('storage/' . $cleanPath);
    }
}
