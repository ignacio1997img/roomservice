<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class IncomesDetail extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'income_id',
        'article_id',
        'cantSolicitada',
        'cantRestante',
        'price',
        'amount',
        'expiration',
        'expirationStatus',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];

    public function income()
    {
        return $this->belongsTo(Income::class, 'income_id');
    }
    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    // public function articles()
    // {
    //     return $this->belongsTo(Article::class, 'article_id');
    // }
}
