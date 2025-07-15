<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PaymentLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'event_type',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array'
    ];
    
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }
}
