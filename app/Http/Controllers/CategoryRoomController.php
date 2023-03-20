<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CategoriesRoom;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CategoryRoomController extends Controller
{
    public function index()
    {
        return view('structHotel.categoryHotel.browse');
    }
}
