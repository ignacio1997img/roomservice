<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CleaningRoomsProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'cleaningRoom_id',
        'cleaningProductDetail_id',
        'article_id',
        'cant',
        'amount',
        'userRegister_id',
        'deleted_at'
    ];


    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

}
