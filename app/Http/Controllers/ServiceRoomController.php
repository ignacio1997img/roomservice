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
        // return 1;
        // return $request;
        DB::beginTransaction();
        $people = People::where('id', $request->people_id)->first();
        try {
            // return $people;
            Http::get('http://api.what.capresi.net/?number=591'.$people->cell_phone.'&message=Hola *'.$people->first_name.' '.$people->last_name.'*.%0A%0A'.setting('admin.Whatsapp'));
            
            // return $request;

            $ok = Room::where('id', $request->room_id)->where('deleted_at', null)->first();
            // return $ok;
            if($ok->status == 0)
            {
                return redirect()->route('view.planta', ['planta'=>$ok->categoryFacility_id])->with(['message' => 'La habitación se encuentra asignada.', 'alert-type' => 'warning']);
            }

            if($request->amount<=0 && $request->amount != 'personalizado')
            {
                return redirect()->route('view.planta', ['planta'=>$ok->categoryFacility_id])->with(['message' => 'Error al registrar...', 'alert-type' => 'warning']);
            }
            if($request->price<=0 && $request->amount == 'personalizado')
            {
                return redirect()->route('view.planta', ['planta'=>$ok->categoryFacility_id])->with(['message' => 'Error al registrar...', 'alert-type' => 'warning']);
            }
// return 1;
            $category = CategoriesRoom::where('id', $ok->categoryRoom_id)->first();
            // return $category;
            $facility = CategoriesFacility::where('id', $ok->categoryFacility_id)->first();
            // return $facility;


            $ser = ServiceRoom::create([
                'people_id'=>$request->people_id,
                'room_id'=>$request->room_id,
                'number' => $ok->number,
                'category'=>$category->name,    
                'facility'=>$facility->name,
                'amount'=>$request->price?$request->price:$request->amount,
                'start' => $request->start,
                'finish' => $request->finish,
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
            $ok->update(['status'=>0]);
            DB::commit();
            return redirect()->route('view.planta', ['planta'=>$ok->categoryFacility_id])->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
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

            $service = ServiceRoom::where('room_id', $request->room_id)->where('status', 'reservado')->where('reserve', 1)->where('deleted_at', null)->first();
            // return $service;
            $service->update(['status'=>'asignado']);
            DB::commit();       
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Hsopedaje iniciadp exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    

}
