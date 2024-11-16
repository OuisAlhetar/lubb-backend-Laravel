<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MostViewed extends Model
{
    use HasFactory;
    protected $table = 'most_viewed';


    protected $fillable = [
        'item_id',
        'view_count'
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }
}
