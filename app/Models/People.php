<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class People extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nationality_id',
        'profession',
        'civilStatus',
        'ci',
        'first_name',
        'last_name',
        'birth_date',
        'email',
        'cell_phone',
        'phone',
        'address',
        'gender',
        'image',
        'facebook',
        'tiktok',
        'status',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];
    


    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'nationality_id');
    }
}
