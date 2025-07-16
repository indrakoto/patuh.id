<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'description',
        'file_path',
        'file_name',
        'file_size',
        'file_type',
        'thumbnail_path',
        'is_public',
        'price',
        'download_count',
        'created_by',
        'category_id'
    ];

    protected $casts = [
        'is_public' => 'boolean',
        'price' => 'decimal:2',
    ];

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function tokens()
    {
        return $this->hasMany(DocumentToken::class);
    }

    public function categories()
    {
        return $this->belongsTo(Category::class, 'category_id'); // Kolom 'category_id' sebagai foreign key
    }

    public function isFree()
    {
        return $this->is_public;
    }

    public function getShortTitleAttribute()
    {
        return Str::words($this->title, 7, '...');
    }


    protected static function booted()
    {
        static::creating(function ($document) {
            if (! $document->isDirty('created_by')) {
                $document->created_by = Auth::id();
            }
        });

    }


    // Document.php
    public function getDownloadFilename()
    {
        $slug = Str::slug($this->slug ?: $this->title);
        $shortSlug = collect(explode('-', $slug))->take(5)->implode('-');
        $hash = substr(sha1($this->id . '-' . $this->created_at), 0, 6);
        $ext = pathinfo($this->file_path, PATHINFO_EXTENSION);

        return $shortSlug . '-' . $hash . '.' . $ext;
    }

}