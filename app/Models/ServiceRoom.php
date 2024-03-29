<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceRoom extends Model
{
    use HasFactory;

    protected $fillable = [
        'room_id',
        'people_id',
        'recommended_id',
        'number',
        'category',
        'facility',
        'amount',
        'amountTotal',
        'day',
        'typeAmount',
        'typePrice',
        'qr',
        'bill',
        'billNumber',
        'amountFinish',
        'observation',
        'status',
        'reserve',
        'start',
        'finish',
        'registerUser_id',
        'deleted_at',
        'deletedUser_id',
        
        'foreign',
        'country_id',
        'department_id',
        'province_id',
        'city_id',
        'origin',
        'typeHospedaje',
        'debt'
    ];

    public function client()
    {
        return $this->hasMany(ServiceRoomsClient::class, 'serviceRoom_id');
    }


    public function room()
    {
        return $this->belongsTo(Room::class, 'room_id');
    }
    public function servicedetail()
    {
        return $this->hasMany(ServiceRoomsDetail::class, 'serviceRoom_id');
    }
    public function people()
    {
        return $this->belongsTo(People::class, 'people_id');
    }

    public function recommended()
    {
        return $this->belongsTo(People::class, 'recommended_id');
    }
    public function transaction()
    {
        return $this->hasMany(ServiceTransaction::class, 'serviceRoom_id');
    }

    public function detailPart()
    {
        return $this->hasMany(ServiceRoomsDetail::class, 'serviceRoom_id');
    }

    public function extra()
    {
        return $this->hasMany(ServiceRoomsExtra::class, 'serviceRoom_id');
    }

    public function egres()
    {
        return $this->hasMany(Egre::class, 'serviceRoom_id');
    }
}
