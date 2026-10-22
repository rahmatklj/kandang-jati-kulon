<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\HasFileCleanup;

class Complaint extends Model
{
    use HasFactory, HasFileCleanup;

    protected $fillable = [
        'name',
        'nik',
        'phone',
        'category',
        'title',
        'location',
        'description',
        'photo_path',
        'status',
    ];
}
