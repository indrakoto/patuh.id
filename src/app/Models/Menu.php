<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    protected $table = 'menu';

    protected $fillable = [
        'name',
        'parent',
        'route',
        'order',
        'data',
    ];

    // Relasi parent menu (self join)
    public function parentMenu(): BelongsTo
    {
        return $this->belongsTo(Menu::class, 'parent');
    }

    // Relasi child menus (self join)
    public function childMenus(): HasMany
    {
        return $this->hasMany(Menu::class, 'parent');
    }
}
