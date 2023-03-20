<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Worker extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'people_id',
        'observation',
        'status',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];

    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    public function worker()
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    public function category()
    {
        return $this->hasMany(WorkersCategory::class, 'worker_id');
    }
}
