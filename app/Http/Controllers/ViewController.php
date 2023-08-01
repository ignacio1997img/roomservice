<?php

namespace App\Http\Controllers;

use App\Models\CategoriesRoomsPart;
use App\Models\Country;
use App\Models\Egre;
use App\Models\EgresDeatil;
use App\Models\EgresMenu;
use App\Models\PartsHotel;
use App\Models\Room;
use Illuminate\Http\Request;
use App\Models\IncomesDetail;
use App\Models\Nationality;
use Illuminate\Support\Facades\DB;
use App\Models\ServiceRoom;
use DateTime;
use App\Http\Controllers\ServiceRoomController;
use App\Models\ServiceRoomsClient;
use App\Models\ServiceRoomsExtra;
use GuzzleHttp\Promise\Create;

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
        $service =  ServiceRoom::where('room_id',2)->where('status', 'asignado')->where('deleted_at',null)
            ->select('id', 'room_id','number', 'start', 'typePrice', 'typeAmount')
            ->first();  
        // $service->dia=;

        // return $service;


        $service = ServiceRoom::where('deleted_at', null)->get();

        // return $service;
        foreach($service as $item)
        {
            ServiceRoomsClient::create([
                'people_id'=>$item->people_id,

                'payment' => $item->status=='finalizado'?1:0,
                'serviceRoom_id'=>$item->id,

                'foreign'=>$item->foreign,
                'country_id'=>$item->country_id,
                'department_id'=>$item->department_id,
                'province_id'=>$item->province_id,
                'city_id'=>$item->city_id,
                'origin'=>$item->origin,

            ]);
        }
      




























        // return $horaInicio;

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
        $country = Country::where('deleted_at', null)->get();
        $nacionalidad = Nationality::where('deleted_at', null)->get();
        // return $room;

        return view('viewRoom.assign', compact('room', 'country', 'nacionalidad'));
    }
    public function readAsignar($room)
    {
        // date('Y'):
        // return $room;

        $obj = new ServiceRoomController;       


        // return $room;
        $room = Room::with(['part'=>function($q){$q->where('deleted_at', null);}, 'categoryfacility'])
                ->where('id', $room)->first();
        // return $room;
        
        $service =  ServiceRoom::with(['people', 'recommended' , 'transaction', 'client.people', 'client.country', 'client.department', 'client.province', 'client.city'])
            ->where('room_id', $room->id)->whereRaw('(status = "asignado" or status = "reservado")')->where('deleted_at', null)->first(); 
      
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
        
        $extra = ServiceRoomsExtra::where('serviceRoom_id', $service->id)->where('deleted_at', null)->get();

        $auxTotal =0;
        if($service->status=='asignado')
        {
            $auxTotal = $obj->ajaxFinishPieza($room->id, date('Y-m-d H:i'));
            // $service->
        }
        // return $service; 
        // return $auxTotal;


    

        return view('viewRoom.readAssign', compact('room', 'service', 'egre', 'menu', 'auxTotal', 'extra'));
    }
}
