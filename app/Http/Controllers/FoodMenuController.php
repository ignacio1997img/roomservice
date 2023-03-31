<?php

namespace App\Http\Controllers;

use App\Models\EgresMenu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\Food;
use App\Models\FoodMenu;
use App\Models\People;
use App\Models\Room;
use App\Models\ServiceRoomsDetail;
use App\Models\ServiceRoom;

class FoodMenuController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    //para obntener los articulos con stock del almacen
    public function ajaxMenuExists()
    {
        $q = request('q');
        
        $data = FoodMenu::with(['food'])
            ->where(function($query) use ($q){
                if($q){
                    $query->OrwhereHas('food', function($query) use($q){
                        $query->whereRaw("(name like '%$q%')");
                    });
                }
            })
            ->where('deleted_at', null)->groupBy('id')->get();

        return response()->json($data);
    }
    public function storeEgressPieza(Request $request)
    {
        // return $request;
        if($request->amount<=0)
        {
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ingrese un menu para realizar el registro..', 'alert-type' => 'warning']);
        }

        // return $request;
        DB::beginTransaction();
        try {

            $service =  ServiceRoom::where('room_id', $request->room_id)->where('status', 1)->where('deleted_at',null)->first();  
            for ($i=0; $i < count($request->food) ; $i++) { 
                $egre = EgresMenu::create([
                    'registerUser_id' => Auth::user()->id,
                    'people_id' =>$service->people_id,
                    'room_id' => $request->room_id,
                    'price' => $request->price[$i],
                    'cant' => $request->cant[$i],
                    'amount' => $request->price[$i]*$request->cant[$i],
                    'serviceRoom_id'=>  $service->id,
                    'food_id'=>$request->food[$i]
                ]);
            }

            DB::commit();
            if($request->people_id)
            {
                return redirect()->route('sales.index')->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);
            }
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
}
