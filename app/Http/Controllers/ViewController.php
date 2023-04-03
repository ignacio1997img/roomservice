<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRoomsPart;
use App\Models\Egre;
use App\Models\EgresDeatil;
use App\Models\EgresMenu;
use App\Models\PartsHotel;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\IncomesDetail;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRoom;

use function PHPUnit\Framework\returnSelf;

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

        return view('viewRoom.assign', compact('room'));
    }
    public function readAsignar($room)
    {
        //  return $room;
        $room = Room::with(['caregoryroom.part'=>function($q){$q->where('deleted_at', null);}, 'categoryfacility'])
                ->where('id', $room)->first();
        
        $service =  ServiceRoom::with(['people'])
            ->where('room_id', $room->id)->where('status', 1)->where('deleted_at',null)->first();  
            // return $service;

        // $egre = Egre::with(['detail.article'])
        //     ->where('serviceRoom_id', $service->id)->where('deleted_at', null)->get();
        $egre = DB::table('egres as e')
            ->join('egres_deatils as d', 'd.egre_id', 'e.id')
            ->join('articles as a', 'a.id', 'd.article_id')
            ->where('e.serviceRoom_id', $service->id)
            ->where('e.deleted_at', null)
            ->where('d.deleted_at', null)
            ->select('a.name', 'd.article_id', 'd.egre_id',  'd.price',DB::raw("SUM(d.cantSolicitada) as cantSolicitada"))->groupBy('name', 'article_id', 'egre_id', 'price')->get();

        $menu = DB::table('egres as e')
            ->join('egres_menus as d', 'd.egre_id', 'e.id')
            ->join('food as f', 'f.id', 'd.food_id')
            ->where('e.serviceRoom_id', $service->id)
            ->where('e.deleted_at', null)
            ->where('d.deleted_at', null)
            ->select('f.name', 'd.cant',  'd.price', 'd.amount')->get();

        //     return $menu;
        // $menu = EgresMenu::with(['food'])
        //     ->where('serviceRoom_id', $service->id)->where('deleted_at', null)->get();

        // $menu = EgresMenu::orWhereHas('egres', function($query) use ($search) {
        //         $query->whereRaw('full_name like "%'.$search.'%"');
        //     })
        //     ->where('serviceRoom_id', $service->id)->where('deleted_at', null)->get();


        // return $egre;        

        return view('viewRoom.readAssign', compact('room', 'service', 'egre', 'menu'));
    }
}
