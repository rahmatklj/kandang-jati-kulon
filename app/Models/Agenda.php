<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFileCleanup;

class Agenda extends Model
{
    use HasFactory, HasFileCleanup;

    protected $fillable = [
        'title',
        'description',
        'date',
        'end_date',
        'time',
        'end_time',
        'location',
        'organizer',
        'image',
        'is_active',
    ];

    protected $casts = [
        'date' => 'date',
        'end_date' => 'date',
        'is_active' => 'boolean',
    ];

    /**
     * Automatically purge agendas that have passed their date / end_date.
     */
    public static function purgeExpired(): int
    {
        $today = date('Y-m-d');
        
        $expiredAgendas = static::where(function ($q) use ($today) {
            $q->whereNotNull('end_date')->where('end_date', '<', $today);
        })->orWhere(function ($q) use ($today) {
            $q->whereNull('end_date')->where('date', '<', $today);
        })->get();

        $count = 0;
        foreach ($expiredAgendas as $agenda) {
            if ($agenda->image && \Illuminate\Support\Facades\Storage::disk('public')->exists($agenda->image)) {
                \Illuminate\Support\Facades\Storage::disk('public')->delete($agenda->image);
            }
            $agenda->delete();
            $count++;
        }

        return $count;
    }

    /**
     * Accessor for time attribute to ensure standard 00:00 WIB format
     */
    public function getTimeAttribute($value)
    {
        if (!$value) return null;
        $val = str_replace('.', ':', trim($value));
        if (preg_match('/^\d{1,2}:\d{2}$/', $val)) {
            return $val . ' WIB';
        }
        return $val;
    }

    /**
     * Accessor for end_time attribute to ensure standard 00:00 WIB format
     */
    public function getEndTimeAttribute($value)
    {
        if (!$value) return null;
        $val = str_replace('.', ':', trim($value));
        if (preg_match('/^\d{1,2}:\d{2}$/', $val)) {
            return $val . ' WIB';
        }
        return $val;
    }
}
