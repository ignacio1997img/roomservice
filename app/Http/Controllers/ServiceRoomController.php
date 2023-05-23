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
            Http::get('https://api.whatsapp.trabajostop.com/?number=591'.$people->cell_phone.'&message=Hola *'.$people->first_name.' '.$people->last_name.'*.%0A%0A'.setting('admin.Whatsapp'));
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
        return $request;
        DB::beginTransaction();
        try {
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
        }
    }


    

}
