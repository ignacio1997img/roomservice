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
        'registerUser_id',
        'registerRol',
        'deleteUser_id',
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