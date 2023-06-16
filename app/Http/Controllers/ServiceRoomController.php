<?php

namespace App\Http\Controllers;

use App\Models\CategoriesFacility;
use App\Models\CategoriesRoom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Room;
use App\Models\ServiceRoom;
use App\Models\ServiceRoomsDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\IncomesDetail;
use App\Models\People;
use Illuminate\Support\Facades\Http;

class ServiceRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        DB::beginTransaction();
        $people = People::where('id', $request->people_id)->first();
        try {      

            $ok = Room::where('id', $request->room_id)->where('deleted_at', null)->first();
            // return $ok;
            if($ok->status == 0)
            {
                return redirect()->route('view.planta', ['planta'=>$ok->categoryFacility_id])->with(['message' => 'La habitación se encuentra asignada.', 'alert-type' => 'warning']);
            }

            if($request->amount == 'aire')
            {
                $aux = $ok->amount1;
            }
            else
            {
                $aux = $ok->amount;
            }

            $category = CategoriesRoom::where('id', $ok->categoryRoom_id)->first();
            $facility = CategoriesFacility::where('id', $ok->categoryFacility_id)->first();

            $ser = ServiceRoom::create([
                'people_id'=>$request->people_id,
                'room_id'=>$request->room_id,
                'number' => $ok->number,
                'category'=>$category->name,    
                'facility'=>$facility->name,

                'typeAmount'=> $request->amount,
                'typePrice'=> $aux,
                
                'amount'=>$aux,

                'start' => $request->start,
                // 'finish' => $request->finish,
                'status' => $request->type,
                'reserve'=> $request->type=='asignado'?0:1,
                'registerUser_id'=>Auth::user()->id
            ]);
            // return 1;
            for ($i=0; $i < count($request->part); $i++) { 
                ServiceRoomsDetail::create([
                    'serviceRoom_id'=>$ser->id,
                    'name'=>$request->part[$i],
                    'registerUser_id'=>Auth::user()->id
                ]);
            }

            if($request->type=='asignado')
            {
                Http::get('http://api.what.capresi.net/?number=591'.$people->cell_phone.'&message=Hola *'.$people->first_name.' '.$people->last_name.'*.%0A%0A      PARA CONECTARSE AL WIFI%0A%0ANombre: '.$facility->wifiName.'%0AContraseña: '.$facility->wifiPassword);
                Http::get('http://api.what.capresi.net/?number=591'.$people->cell_phone.'&message=Hola *'.$people->first_name.' '.$people->last_name.'*.%0A%0ASe le asigno la habitacion Nº '.$ok->number.'.%0ACategoria: '.$category->name.'.%0ACosto de la habitacion con '.($request->amount=='ventilador'?'Ventilador':'Aire Acondicionado').' por dia Bs. '.$aux);
                $ok->update(['status'=>0]);
            }
            
            
            return 1;

            DB::commit();
            return redirect()->route('view.planta', ['planta'=>$ok->categoryFacility_id])->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return 0;
            return redirect()->route('view.planta', ['planta'=>$ok->categoryFacility_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function closeFinishRoom(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $service =  ServiceRoom::where('room_id', $request->room_id)->where('status', 'asignado')->where('deleted_at',null)->first(); 
            // return $service;
            $user = Auth::user()->id;

            $room = Room::where('id', $request->room_id)->first();
            $room->update(['status'=> 1]);

            $service->update(['status'=>'finalizado', 'amountFinish'=>$request->amountFinish, 'qr'=>$request->qr]);

            DB::commit();
        
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Hospedaje Finalizado.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function hospedajeCancel(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $room = Room::where('id', $request->room_id)->first();
            $room->update(['status'=> 1]);

            $service = ServiceRoom::where('room_id', $request->room_id)->where('status', 'asignado')->where('deleted_at', null)->first();
            // return $service;
            $service->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);

            DB::commit();       
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Hospedaje cancelada exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
    

    //Para la reserva 
    public function reservaCancelar(Request $request)
    {        // return $request;
        DB::beginTransaction();
        try {
            $room = Room::where('id', $request->room_id)->first();
            $room->update(['status'=> 1]);

            $service = ServiceRoom::where('room_id', $request->room_id)->where('status', 'reservado')->where('reserve', 1)->where('deleted_at', null)->first();
            // return $service;
            $service->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);
            DB::commit();       
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Reserva cancelada exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
    
    public function reservaStart(Request $request)
    {    
        // return $request;
        DB::beginTransaction();
        try {

            $planta = CategoriesFacility::where('id', $request->planta_id)->first();
            $service = ServiceRoom::where('room_id', $request->room_id)->where('status', 'reservado')->where('reserve', 1)->where('deleted_at', null)->first();
            // return $service;
            $people = People::where('id', $service->people_id)->first();

            $service->update(['status'=>'asignado', 'start'=>$request->start]);

            // return 1;

            Http::get('http://api.what.capresi.net/?number=591'.$people->cell_phone.'&message=Hola *'.$people->first_name.' '.$people->last_name.'*.%0A%0A      PARA CONECTARSE AL WIFI%0A%0ANombre: '.$planta->wifiName.'%0AContraseña: '.$planta->wifiPassword);
            Http::get('http://api.what.capresi.net/?number=591'.$people->cell_phone.'&message=Hola *'.$people->first_name.' '.$people->last_name.'*.%0A%0ASe le asigno la habitacion Nº '.$service->number.'.%0ACategoria: '.$service->category.'.%0ACosto de la habitacion con '.($request->typeAmount=='ventilador'?'Ventilador':'Aire Acondicionado').' por dia Bs. '.$service->amount);

            // return 1;

            DB::commit();       
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Hospedaje iniciado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    

}
