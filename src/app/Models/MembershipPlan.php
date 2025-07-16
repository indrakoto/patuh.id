<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MembershipPlan extends Model
{
    protected $fillable = ['name', 'price', 'description'];

    public function userMemberships()
    {
        return $this->hasMany(UserMembership::class, 'membership_plan_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'membership_plan_id');
    }

    /**
     * Format price to IDR currency
     */
    public function getFormattedPriceAttribute(): string
    {
        return number_format($this->price, 0, ',', '.');
    }

}


/*
Relasi antara UserMembership dan Payment tidak langsung — karena Uda memisahkan pembayaran hanya ke membership_plan, maka alurnya:

User memilih plan

Dibuat payment → redirect Midtrans

Jika berhasil → buat UserMembership aktif
*/