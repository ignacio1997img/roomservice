<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRoomsPart;
use App\Models\PartsHotel;
use App\Models\Room;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($planta)
    {
        $data = Room::where('categoryFacility_id', $planta)->where('deleted_at', null)->get();
        // return $data;
        return view('viewRoom.listRoom', compact('data'));
    }

    public function viewAsignar($room)
    {
        // return $room;
        $room = Room::with(['caregoryroom.part'=>function($q){$q->where('deleted_at', null);}, 'categoryfacility'])
                ->where('id', $room)->first();
        // return $room;

        $data = PartsHotel::where('deleted_at', null)->get();
        return view('viewRoom.assign', compact('room', 'data'));
    }
}
