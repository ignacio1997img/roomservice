<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoriesFacility extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'description',
        'deleted_at',
        'wifiName',
        'wifiPassword'

    ]; 

    public function room()
    {
        return $this->hasMany(Room::class, 'categoryFacility_id');
    }
}
