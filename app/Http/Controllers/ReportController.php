<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\People;
use App\Models\ServiceRoom;
use App\Models\Room;
use App\Models\Egre;
use App\Models\EgresDeatil;
use App\Models\EgresMenu;
use App\Models\Food;
use App\Models\FoodMenu;
use Facade\Ignition\DumpRecorder\DumpHandler;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    //####################################Para ver la salida o ventas  de producto del almacen para las habitaciones o personas ########################
    //############################################################################################################################
    public function saleProductServiceRoom()
    {    
        return view('report.saleProductServiceRoom.report');
    }

    public function saleProductServiceRoomList(Request $request)
    {
        $data = DB::table('egres as e')
            ->join('users as u', 'u.id', 'e.registerUser_id')
            ->join('egres_deatils as d', 'd.egre_id', 'e.id')
            ->join('articles as a', 'a.id', 'd.article_id')
            ->leftJoin('service_rooms as sr', 'sr.id', 'e.serviceRoom_id')
            ->leftJoin('rooms as r', 'r.id', 'sr.room_id')
            ->leftJoin('people as p', 'p.id', 'e.people_id')
            
            ->where('e.type', 'product')
            ->where('e.deleted_at', null)
            ->where('d.deleted_at', null)

            ->whereDate('e.created_at', '>=', date('Y-m-d', strtotime($request->start)))
            ->whereDate('e.created_at', '<=', date('Y-m-d', strtotime($request->finish)))
            
            ->select('sr.number', 'u.name as user', 'sr.category', 'sr.facility', 'p.first_name', 'p.last_name',
                    'a.name', 'd.article_id','e.created_at', 'd.egre_id',  'd.price',DB::raw("SUM(d.cantSolicitada) as cantSolicitada"))
            ->groupBy('name', 'article_id', 'egre_id', 'price')->orderBy('e.created_at', 'ASC')->get();
     
        // dump($data);
        if($request->print){
            $start = $request->start;
            $finish = $request->finish;
            return view('report.saleProductServiceRoom.print', compact('data', 'start', 'finish'));
        }else{
            return view('report.saleProductServiceRoom.list', compact('data'));
        }
        
    }

    //################################### Para la venta de comida "servivio a la habitacion" ###############################################
    public function saleFoodServiceRoom()
    {    
        return view('report.saleFoodServiceRoom.report');
    }

    public function saleFoodServiceRoomList(Request $request)
    {
        $data = DB::table('egres as e')
            ->join('users as u', 'u.id', 'e.registerUser_id')
            ->join('egres_menus as em', 'em.egre_id', 'e.id')

             ->join('food as f', 'f.id', 'em.food_id')
            ->leftJoin('service_rooms as sr', 'sr.id', 'e.serviceRoom_id')
            ->leftJoin('rooms as r', 'r.id', 'sr.room_id')
            ->leftJoin('people as p', 'p.id', 'e.people_id')

            ->where('e.type', 'food')
            ->where('e.deleted_at', null)
            ->where('em.deleted_at', null)

            ->whereDate('e.created_at', '>=', date('Y-m-d', strtotime($request->start)))
            ->whereDate('e.created_at', '<=', date('Y-m-d', strtotime($request->finish)))
            
            // ->select('sr.number', 'u.name as user', 'em.price', 'em.cant', 'em.amount',
            //         'em.created_at', 'f.name as food', 'sr.category', 'sr.facility', 'p.first_name', 'p.last_name')
            ->select('sr.number', 'u.name as user', 'sr.category', 'sr.facility', 'p.first_name', 'p.last_name',
                    'f.name', 'em.food_id','e.created_at', 'em.egre_id',  'em.price',DB::raw("SUM(em.cant) as cantSolicitada"))

            // ->select('*')
            ->groupBy('name', 'food_id', 'egre_id', 'price')->orderBy('e.created_at', 'ASC')->get();
            

        if($request->print){
            $start = $request->start;
            $finish = $request->finish;
            return view('report.saleFoodServiceRoom.print', compact('data', 'start', 'finish'));
        }else{
            return view('report.saleFoodServiceRoom.list', compact('data'));
        }
        
    }


    // ###############################################  PARA LAS HABITACIONES   #################################################
    public function serviceRoom()
    {    
        return view('report.serviceRoom.report');
    }

    public function serviceRoomList(Request $request)
    {
        $data = serviceRoom::with(['recommended',
            'detailPart',
            'extra:serviceRoom_id,id,detail,amount',
            'egres'=>function($q)
            {
                $q->where('deleted_at',null);
            },
            'egres.menu',
            'egres.detail'=>function($q)
            {
                $q->where('deleted_at',null)
                ->select('article_id', 'egre_id',  'price', DB::raw("SUM(cantSolicitada) as cantSolicitada"))
                ->groupBy('article_id', 'egre_id', 'price');
            },
            'transaction',
            'client:serviceRoom_id,people_id,payment,foreign,country_id,department_id,province_id,city_id,origin',
            'client.people',
            'client.country:id,name',
            'client.department:id,name',
            'client.province:id,name',
            'client.city:id,name'])
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=', date('Y-m-d', strtotime($request->start)))
            ->whereDate('created_at', '<=', date('Y-m-d', strtotime($request->finish)))
            ->where('status', $request->type)
            ->orderBy('id', 'ASC')->get();

        if($request->print){
            $start = $request->start;
            $finish = $request->finish;
            return view('report.serviceRoom.print', compact('data', 'start', 'finish'));
        }else{
            return view('report.serviceRoom.list', compact('data'));
        }
        
    }


    //  ############################################ GENERAL ###########################################
    public function general()
    {    
        return view('report.general.report');
    }

    public function generalList(Request $request)
    {
        // dump($request);
        $data = serviceRoom::with([
            'transaction',
            'client'=>function($q)
            {
                $q->where('payment',1)
                ->where('deleted_at', null);
            },
            'client.people',
            'client.people.nationality',
            'client.country',
            'client.department',
            'client.province',
            'client.city'])
            ->where('deleted_at', null)
            ->whereDate('created_at', '>=', date('Y-m-d', strtotime($request->start)))
            ->whereDate('created_at', '<=', date('Y-m-d', strtotime($request->finish)))
            // ->where('status', $request->type)
            ->orderBy('id', 'ASC')->get();

     
        // dump($data);
        if($request->print){
            $start = $request->start;
            $finish = $request->finish;
            return view('report.general.print', compact('data', 'start', 'finish'));
        }else{
            return view('report.general.list', compact('data'));
        }
        
    }
}
