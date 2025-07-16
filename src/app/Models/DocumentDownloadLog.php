<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentDownloadLog extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'user_id',
        'document_id',
        'downloaded_at',
        'ip_address',
        'user_agent',
    ];

    protected $dates = ['downloaded_at'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}
