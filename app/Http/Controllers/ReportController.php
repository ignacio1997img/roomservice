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

class ReportController extends Controller
{
    //####################################Para ver la salida de producto del almacen para las habitaciones########################
    //############################################################################################################################
    public function egreServiceRoom()
    {      

        // $egre = DB::table('egres as e')
        //     ->join('egres_deatils as d', 'd.egre_id', 'e.id')
        //     ->join('articles as a', 'a.id', 'd.article_id')
        //     ->leftJoin('service_rooms as sr', 'sr.id', 'e.serviceRoom_id')
        //     ->leftJoin('rooms as r', 'r.id', 'sr.room_id')
        //     ->leftJoin('people as p', 'p.id', 'e.people_id')

        //     ->where('e.deleted_at', null)
        //     ->where('d.deleted_at', null)

        //     ->whereDate('e.created_at', '>=', date('Y-m-d', strtotime($request->start)))
        //     ->whereDate('e.created_at', '<=', date('Y-m-d', strtotime($request->finish)))
            
        //     ->select('sr.number', 'sr.category', 'sr.facility', 'p.first_name', 'p.last_name',
        //             'a.name', 'd.article_id', 'd.egre_id',  'd.price',DB::raw("SUM(d.cantSolicitada) as cantSolicitada"))
        //     ->groupBy('name', 'article_id', 'egre_id', 'price')->get();

        // return $egre;

        // return count($egre);


        return view('report.egreServiceRoom.report');
    }

    public function egreServiceRoomList(Request $request)
    {
        $data = DB::table('egres as e')
            ->join('users as u', 'u.id', 'e.registerUser_id')
            ->join('egres_deatils as d', 'd.egre_id', 'e.id')
            ->join('articles as a', 'a.id', 'd.article_id')
            ->leftJoin('service_rooms as sr', 'sr.id', 'e.serviceRoom_id')
            ->leftJoin('rooms as r', 'r.id', 'sr.room_id')
            ->leftJoin('people as p', 'p.id', 'e.people_id')
            
            ->where('e.deleted_at', null)
            ->where('d.deleted_at', null)

            ->whereDate('e.created_at', '>=', date('Y-m-d', strtotime($request->start)))
            ->whereDate('e.created_at', '<=', date('Y-m-d', strtotime($request->finish)))
            
            ->select('sr.number', 'u.name as user', 'sr.category', 'sr.facility', 'p.first_name', 'p.last_name',
                    'a.name', 'd.article_id','e.created_at', 'd.egre_id',  'd.price',DB::raw("SUM(d.cantSolicitada) as cantSolicitada"))
            ->groupBy('name', 'article_id', 'egre_id', 'price')->get();
     
        if($request->print){
            $start = $request->start;
            $finish = $request->finish;
            return view('report.egreServiceRoom.print', compact('data', 'start', 'finish'));
        }else{
            return view('report.egreServiceRoom.list', compact('data'));
        }
        
    }
}
