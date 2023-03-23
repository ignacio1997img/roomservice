<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRoomsPart;
use App\Models\PartsHotel;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\IncomesDetail;
use Illuminate\Support\Facades\DB;

class ViewController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index($planta)
    {

        // $data = IncomesDetail::with(['article','article.category'])
        //     // ->whereRaw($q ? '(name like "%'.$q.'%" )' : 1)
        //     ->select('article_id', DB::raw("SUM(cantRestante) as cantRestante"))
        //     ->where('cantRestante','>', 0)->where('deleted_at', null)->where('expirationStatus', 1)->groupBy('article_id', 'price', 'expiration')->get();
        // return $data;


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
