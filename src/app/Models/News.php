<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;

class News extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'content',
        'thumbnail',
        'is_published',
        'views',
    ];


    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Kolom 'category_id' sebagai foreign key
    }

    public function getShortTitleAttribute()
    {
        return Str::words($this->title, 7, '...');
    }

    public function getTanggalIndoAttribute()
    {
        return Carbon::parse($this->created_at)
            ->locale('id_ID') // Set locale ke Indonesia
            ->translatedFormat('j F Y'); // Format: 27 April 2025
    }
}
