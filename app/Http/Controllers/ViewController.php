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
        // return 1;

        // $foodDay = EgresMenu::with('food')->where('deleted_at', null)->whereDate('created_at', '=', date('Y-m-d'))
        //             ->selectRaw('COUNT(food_id) as count,SUM(amount) as total, food_id')
        //             ->groupBy('food_id')->orderBy('total', 'DESC')->limit(5)->get();
        // return $foodDay;


        $data = Room::where('categoryFacility_id', $planta)->where('deleted_at', null)->orderBy('number', 'ASC')->get();
        // return $data;
        return view('viewRoom.listRoom', compact('data'));
    }

    public function viewAsignar($room)
    {
        // return $room;
        $room = Room::with(['file','part'=>function($q){$q->where('deleted_at', null);}, 'categoryfacility'])
                ->where('id', $room)->first();
        // return $room;

        return view('viewRoom.assign', compact('room'));
    }
    public function readAsignar($room)
    {
        //  return $room;
        $room = Room::with(['part'=>function($q){$q->where('deleted_at', null);}, 'categoryfacility'])
                ->where('id', $room)->first();
        // return $room;
        
        $service =  ServiceRoom::with(['people'])
            ->where('room_id', $room->id)->whereRaw('(status = "asignado" or status = "reservado")')->where('deleted_at', null)->first(); 
        // return $service; 
      
        $egre = DB::table('egres as e')
            ->join('egres_deatils as d', 'd.egre_id', 'e.id')
            ->join('articles as a', 'a.id', 'd.article_id')
            ->where('e.serviceRoom_id', $service->id)
            ->where('e.sale', 1)
            ->where('e.deleted_at', null)
            ->where('d.deleted_at', null)
            ->select('a.name', 'd.article_id', 'd.egre_id',  'd.price',DB::raw("SUM(d.cantSolicitada) as cantSolicitada"))->groupBy('name', 'article_id', 'egre_id', 'price')->get();

        $menu = DB::table('egres as e')
            ->join('egres_menus as d', 'd.egre_id', 'e.id')
            ->join('food as f', 'f.id', 'd.food_id')
            ->where('e.serviceRoom_id', $service->id)
            ->where('e.sale', 1)
            ->where('e.deleted_at', null)
            ->where('d.deleted_at', null)
            ->select('f.name', 'd.cant',  'd.price', 'd.amount')->get();

    

        return view('viewRoom.readAssign', compact('room', 'service', 'egre', 'menu'));
    }
}
