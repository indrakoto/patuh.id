<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Payment extends Model
{
    use HasFactory;
    // Payment status constants
    const STATUS_PENDING = 'pending';
    const STATUS_SUCCESS = 'success';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELLED = 'cancelled';
    
    protected $fillable = [
        'user_id',
        'membership_plan_id',
        'order_id',
        'price',
        'payment_type',
        'payment_method',
        'payment_status',
        'payment_url',
        'payload',
    ];

    protected $casts = [
        'payload' => 'array',
        'price' => 'double'
    ];
    


    public function membershipPlan()
    {
        return $this->belongsTo(MembershipPlan::class, 'membership_plan_id');
    }

    // Relasi ke PaymentLog
    public function paymentLogs()
    {
        return $this->hasMany(PaymentLog::class, 'payment_id');
    }
    //atau
    public function logs()
    {
        return $this->hasMany(PaymentLog::class, 'payment_id');
    }

    /**
     * Check if payment is successful
     */
    public function isSuccessful(): bool
    {
        return $this->payment_status === self::STATUS_SUCCESS;
    }

    /**
     * Format price to IDR currency
     */
    public function getFormattedPriceAttribute(): string
    {
        return 'Rp ' . number_format($this->price, 0, ',', '.');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

