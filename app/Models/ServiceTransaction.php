<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use function PHPSTORM_META\map;

class ServiceTransaction extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'serviceRoom_id',
        'amount',
        'qr',
        'type',
        'registerUser_id',
        'registerRol',
        'deleteUser_id',
        'deleted_at',
        'deleteRol'
    ];
    public function register()
    {
        return $this->belongsTo(User::class, 'registerUser_id');
    }

    public function delete()
    {
        return $this->belongsTo(User::class, 'deleteUser_id');
    }
}
