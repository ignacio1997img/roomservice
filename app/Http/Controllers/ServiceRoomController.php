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
use App\Models\ServiceTransaction;
use Illuminate\Support\Facades\Http;
use DateTime;


class ServiceRoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function store(Request $request)
    {
        // return $request;
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
            if($request->amount == 'ventilador')
            {
                $aux = $ok->amount;
            }
            if($request->amount == 'personalizado')
            {
                $aux = $request->price;
            }

            $category = CategoriesRoom::where('id', $ok->categoryRoom_id)->first();
            $facility = CategoriesFacility::where('id', $ok->categoryFacility_id)->first();

            // return $request->amount;
            // return $aux;

            $ser = ServiceRoom::create([
                'people_id'=>$request->people_id,
                'recommended_id'=>$request->recommended_id??null,
                'room_id'=>$request->room_id,
                'number' => $ok->number,
                'category'=>$category->name,    
                'facility'=>$facility->name,

                'typeAmount'=> $request->amount,
                'typePrice'=> $aux,
                
                'amount'=>$aux,
                'typeHospedaje'=>$request->typeHospedaje,

                'start' => $request->start,
                // 'finish' => $request->finish,
                'status' => $request->type,
                'reserve'=> $request->type=='asignado'?0:1,
                'registerUser_id'=>Auth::user()->id

            ]);

            if($request->country_id==1)
            {
                $ser->update([
                    'foreign'=>0,
                    'country_id'=>$request->country_id,
                    'department_id'=>$request->state_id??null,
                    'province_id'=>$request->province_id??null,
                    'city_id'=>$request->city_id??null
                ]);
            }
            else
            {
                $ser->update([
                    'foreign'=>1,
                    'country_id'=>$request->country_id,
                    'origin'=>$request->origin
                ]);
            }
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
            }
            $ok->update(['status'=>0]);

            
            
            // return 1;

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
        DB::beginTransaction();
        try {
            $service =  ServiceRoom::where('room_id', $request->room_id)->where('status', 'asignado')->where('deleted_at',null)->first(); 
            $user = Auth::user();

            $room = Room::where('id', $request->room_id)->first();
            $room->update(['status'=> 1]);
            // return $service;
            $pago = $request->subTotalDetalle+$request->subTotalMenu+$request->pagarf;

            ServiceTransaction::create(['amount'=>$pago, 'serviceRoom_id'=> $service->id, 'qr'=>$request->qr, 'registerUser_id'=>$user->id, 'registerRol'=>$user->role->name]);


            $service->update(['status'=>'finalizado', 'amount'=>$pago, 'qr'=>$request->qr]);


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

    // funcion para adicionar dinero al servicio de la habitacion para ir pagando
    public function addMoney(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $service =  ServiceRoom::where('id', $request->serviceRoom_id)->where('status', 'asignado')->where('deleted_at',null)->first(); 
            // return $service;
            $user = Auth::user();

            ServiceTransaction::create(['amount'=>$request->amount, 'serviceRoom_id'=> $service->id, 'qr'=>$request->qr, 'registerUser_id'=>$user->id, 'registerRol'=>$user->role->name]);

            // $service->update(['status'=>'finalizado', 'amount'=>$pago, 'qr'=>$request->qr]);
            // return 1;
            DB::commit();        
            return redirect()->route('view-planta-room.read', ['room'=>$service->room_id])->with(['message' => 'Hospedaje Finalizado.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('view-planta-room.read', ['room'=>$service->room_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }



    // PARA SACAR LOS DIAS QUE SE DEBE DE LA HABITACION PARA PODER FINALIZAR EL HOSPEDAJE MEDIANTE LA FECHA DE INICIO
    public function ajaxFinishPieza($id, $dateFinishClose)
    {
        $service =  ServiceRoom::where('room_id',$id)->where('status', 'asignado')->where('deleted_at',null)
            ->select('id', 'room_id','number', 'start', 'typePrice', 'typeAmount')
            ->first();  

        // dump('________________________________________  INICIO  ___________________________________________________');

        //Para calcular el inicio del hospedaje
        $dateStart = date('Y-m-d', strtotime($service->start));
        // dump($dateStart);
        $dateStart = new DateTime($dateStart);
        $hourStart = date('H', strtotime($service->start));
        // $hourStart = date('5');
        // dump($hourStart);

        // dump('_____________________________________________________________________________________________________');
        $dateFinish = date('Y-m-d', strtotime($dateFinishClose));
        // $dateFinish = $dateFinish; 
        // $dateFinish = date('2023-06-16');
        $dateFinish = new DateTime($dateFinish);
        $hourFinish = date('H', strtotime($dateFinishClose));
        // $hourFinish = date('H');
        // $hourFinish = date('18');
 
        // dump(date('Y-m-d'));
        // dump($hourFinish);
        // dump('________________________________________   FIN  ____________________________________________________');


        $diasTotal =$dateStart->diff($dateFinish);
        $diasTotal = $diasTotal->format('%d')+1;
     
        // dump('Total Dias '.$diasTotal);
        $total =0;
      
        for($i=1; $i<=$diasTotal; $i++)
        {
            // Para el primer dia si el hospedaje llega ante de las 5 de la mañana y e queda asta las 12 pm  es un dia de hospedaje 
            if($i==1 && $hourStart < 5 && $hourFinish<=12)
            {
                $total = $total + 1;                
            }

            if($i==1 && $hourStart < 5 && $hourFinish > 12)
            {
                $total = $total + 2;
            }

            if($i==1 && $hourStart >= 5)
            {
                $total = $total + 1;
            }

            // Para el segundo dia o mas
            if($i!=1 && $i < $diasTotal)
            {
                $total = $total + 1;
            }

            // Para el ultimo dia
            if($i!=1 && $i == $diasTotal && $hourFinish > 12)
            {
                $total = $total + 1;
            }

            // dump($i);
           
        }
        $service->dia = $total;
        $service->totalPagar = $total*$service->typePrice;
        
        return $service;
    }

    

}
