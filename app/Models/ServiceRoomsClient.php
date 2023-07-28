<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRoomsClient extends Model
{
    use HasFactory;

    protected $fillable = [
        'people_id',
        'serviceRoom_id',
        'payment',
        'deleted_at'
    ];


    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
