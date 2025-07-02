<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DocumentToken extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'document_id',
        'token',
        'expires_at',
        'is_used',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
        'is_used' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function document()
    {
        return $this->belongsTo(Document::class);
    }

    public function isValid()
    {
        return !$this->is_used && $this->expires_at->isFuture();
    }
}