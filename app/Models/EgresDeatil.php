<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EgresDeatil extends Model
{
    use HasFactory;

    protected $fillable = [
        'egre_id',
        'article_id',
        'incomeDetail_id',
        'cantSolicitada',
        'price',
        'amount',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];

    public function article()
    {
        return $this->belongsTo(Article::class, 'article_id');
    }

    public function egres()
    {
        return $this->belongsTo(Egre::class, 'egre_id');
    }
}
