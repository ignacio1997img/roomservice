<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;


    protected $fillable = [
        'people_id',
        'job_id',
        'code',
        'start',
        'finish',
        'details_work',
        'table_report',
        'details_report',
        'documents_contract',
        'status',
        'registerUser_id',
        'deleted_at'
    ];



    
}
