<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'cover_image', 'author_or_guest', 'narrator', 'release_year',
        'short_summary', 'detailed_summary', 'section_id'
    ];

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_item');
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'item_tag');
    }

    public function section()
    {
        return $this->belongsTo(Section::class);
    }

    public function likes()
    {
        return $this->hasMany(Like::class);
    }

    public function saves()
    {
        return $this->hasMany(Save::class);
    }
}
