<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\EgresMenu;

class Egre extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'serviceRoom_id',
        'people_id',
        'amount',
        'type',
        'sale',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id'
    ];

    public function detail()
    {
        return $this->hasMany(EgresDeatil::class, 'egre_id');
    }

    public function menu()
    {
        return $this->hasMany(EgresMenu::class, 'egre_id');
    }

    public function serviceroom()
    {
        return $this->belongsTo(ServiceRoom::class, 'serviceRoom_id');
    }
    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }
}
