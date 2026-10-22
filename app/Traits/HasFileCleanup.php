<?php

namespace App\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

trait HasFileCleanup
{
    /**
     * Boot the trait to attach Eloquent model event listeners for automatic file cleanup.
     */
    protected static function bootHasFileCleanup(): void
    {
        // Event listener saat data diperbarui (Updating)
        static::updating(function ($model) {
            $fileAttributes = $model->getFileCleanupAttributes();
            foreach ($fileAttributes as $attribute) {
                if ($model->isDirty($attribute)) {
                    $oldPath = $model->getOriginal($attribute);
                    $newPath = $model->$attribute;

                    // Hapus file fisik lama jika berkas fisik telah diganti
                    if (!empty($oldPath) && $oldPath !== $newPath) {
                        static::deletePhysicalFile($oldPath);
                    }
                }
            }
        });

        // Event listener saat data dihapus (Deleting)
        static::deleting(function ($model) {
            $fileAttributes = $model->getFileCleanupAttributes();
            foreach ($fileAttributes as $attribute) {
                $path = $model->$attribute;
                if (!empty($path)) {
                    static::deletePhysicalFile($path);
                }
            }
        });
    }

    /**
     * Dapatkan daftar atribut/kolom berkas file dari model.
     * Dapat disesuaikan di Model via properti `$fileAttributes` atau `$fileCleanupAttributes`.
     */
    public function getFileCleanupAttributes(): array
    {
        if (property_exists($this, 'fileAttributes') && is_array($this->fileAttributes)) {
            return $this->fileAttributes;
        }

        if (property_exists($this, 'fileCleanupAttributes') && is_array($this->fileCleanupAttributes)) {
            return $this->fileCleanupAttributes;
        }

        // Tentukan kandidat nama kolom berkas secara otomatis
        $candidates = [
            'file_path',
            'thumbnail',
            'image_path',
            'cover_image',
            'logo',
            'image',
            'avatar',
            'pdf_file',
            'berkas_laporan_pdf',
            'photo_path',
            'file'
        ];
        $found = [];
        foreach ($candidates as $cand) {
            if (array_key_exists($cand, $this->attributes) || in_array($cand, $this->getFillable())) {
                $found[] = $cand;
            }
        }
        return array_unique($found);
    }

    /**
     * Helper method statis untuk menghapus berkas fisik dari storage disk secara aman.
     *
     * @param string|null $path
     * @param string $disk
     * @return bool
     */
    public static function deletePhysicalFile(?string $path, string $disk = 'public'): bool
    {
        if (empty($path)) {
            return false;
        }

        // Jangan hapus jika berupa URL eksternal (HTTP / HTTPS)
        if (Str::startsWith($path, ['http://', 'https://'])) {
            return false;
        }

        // Jangan hapus jika berupa berkas default / preset bawaan aplikasi
        $defaultKeywords = [
            'default',
            'placeholder',
            'logo-prob',
            'sample',
            'assets/',
            'images/default',
            'favicon',
            'no-image'
        ];
        foreach ($defaultKeywords as $keyword) {
            if (Str::contains(strtolower($path), strtolower($keyword))) {
                return false;
            }
        }

        // Normalisasi path fisik (hilangkan /storage/, storage/, /public/, public/ dll.)
        $cleanPath = ltrim($path, '/\\');
        while (preg_match('/^(storage|public|app\/public|storage\/app\/public)[\/\\\\]/i', $cleanPath)) {
            $cleanPath = preg_replace('/^(storage|public|app\/public|storage\/app\/public)[\/\\\\]/i', '', $cleanPath);
            $cleanPath = ltrim($cleanPath, '/\\');
        }

        try {
            // 1. Coba hapus lewat Storage facade (disk public)
            if (Storage::disk($disk)->exists($cleanPath)) {
                return Storage::disk($disk)->delete($cleanPath);
            }

            // 2. Fallback: Coba hapus berkas fisik langsung dari folder storage/app/public/
            $storageFullPath = storage_path('app/public/' . $cleanPath);
            if (file_exists($storageFullPath) && is_file($storageFullPath)) {
                return @unlink($storageFullPath);
            }

            // 3. Fallback: Coba hapus berkas fisik langsung dari folder public/
            $publicFullPath = public_path($cleanPath);
            if (file_exists($publicFullPath) && is_file($publicFullPath)) {
                return @unlink($publicFullPath);
            }

            // 4. Fallback: Coba hapus berkas fisik dari public/storage/
            $publicStoragePath = public_path('storage/' . $cleanPath);
            if (file_exists($publicStoragePath) && is_file($publicStoragePath)) {
                return @unlink($publicStoragePath);
            }
        } catch (Throwable $e) {
            logger()->warning("Gagal menghapus berkas fisik '{$path}': " . $e->getMessage());
        }

        return false;
    }
}
