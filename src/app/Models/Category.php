<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'parent'];

    public function documents()
    {
        return $this->hasMany(Document::class);
    }

    //public function parent()
    //{
    //    return $this->belongsTo(Category::class, 'parent');
    //}

    public function children()
    {
        return $this->hasMany(Category::class, 'parent');
    }

    public function parentRelation()
    {
        return $this->belongsTo(Category::class, 'parent'); // Kolom 'parent' sebagai foreign key
    }

    // Ambil menu utama saja (yang tidak punya parent)
    public static function getParentItems()
    {
        return self::with('children')
            ->whereNull('parent')
            ->orderBy('name')
            ->get();
    }
}