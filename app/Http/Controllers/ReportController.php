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
        // dump($request);


        

        $data = serviceRoom::with(['recommended', 'recommended' , 'transaction', 'client.people', 'client.country', 'client.department', 'client.province', 'client.city'])
            ->where('deleted_at', null)
            // ->groupBy('name', 'food_id', 'egre_id', 'price')
            ->orderBy('id', 'ASC')->get();
        
        // dump($data);
        
        // $data = DB::table('egres as e')
        //     ->join('users as u', 'u.id', 'e.registerUser_id')
        //     ->join('egres_menus as em', 'em.egre_id', 'e.id')

        //      ->join('food as f', 'f.id', 'em.food_id')
        //     ->leftJoin('service_rooms as sr', 'sr.id', 'e.serviceRoom_id')
        //     ->leftJoin('rooms as r', 'r.id', 'sr.room_id')
        //     ->leftJoin('people as p', 'p.id', 'e.people_id')

        //     ->where('e.type', 'food')
        //     ->where('e.deleted_at', null)
        //     ->where('em.deleted_at', null)

        //     ->whereDate('e.created_at', '>=', date('Y-m-d', strtotime($request->start)))
        //     ->whereDate('e.created_at', '<=', date('Y-m-d', strtotime($request->finish)))
            
        //     // ->select('sr.number', 'u.name as user', 'em.price', 'em.cant', 'em.amount',
        //     //         'em.created_at', 'f.name as food', 'sr.category', 'sr.facility', 'p.first_name', 'p.last_name')
        //     ->select('sr.number', 'u.name as user', 'sr.category', 'sr.facility', 'p.first_name', 'p.last_name',
        //             'f.name', 'em.food_id','e.created_at', 'em.egre_id',  'em.price',DB::raw("SUM(em.cant) as cantSolicitada"))

        //     // ->select('*')
        //     ->groupBy('name', 'food_id', 'egre_id', 'price')->orderBy('e.created_at', 'ASC')->get();
            

        if($request->print){
            $start = $request->start;
            $finish = $request->finish;
            return view('report.serviceRoom.print', compact('data', 'start', 'finish'));
        }else{
            return view('report.serviceRoom.list', compact('data'));
        }
        
    }
}
