<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CleaningProduct extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'year',
        'dateFactura',
        'numberFactura',
        'amount',
        'observation',
        'stock',
        'status',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];
    public function detail()
    {
        return $this->hasMany(IncomesDetail::class, 'cleaningProduct_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'registerUser_id');
    }
}
