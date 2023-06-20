<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Province extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable =[
        'department_id',
        'name',
        'description',
        'deleted_at'
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'province_id');
    }
}
