<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkersCategory extends Model
{
    use HasFactory;
    protected $fillable = [
        'worker_id',
        'categoryWorker_id',
        'observation',
        'registerUser_id',
        'deletedUser_id',
        'deleted_at'
    ];
    public function cate()
    {
        return $this->belongsTo(CategoriesWorker::class, 'categoryWorker_id');
    }
}
