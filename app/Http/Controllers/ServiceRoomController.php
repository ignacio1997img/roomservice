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

class ServiceRoomController extends Controller
{
    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $ok = Room::where('id', $request->room_id)->where('deleted_at', null)->first();
            // return $ok;
            if($ok->status == 0)
            {
                return redirect()->route('view.planta', ['planta'=>$ok->categoryFacility_id])->with(['message' => 'La habitación se encuentra asignada.', 'alert-type' => 'warning']);
            }

            if($request->amount<=0)
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
                'number' => $request->number,
                'category'=>$category->name,
                'facility'=>$facility->name,
                'amount'=>$request->amount,
                'start' => Carbon::now(),
                'registerUser_id'=>Auth::user()->id
            ]);
            // return 1;
            for ($i=0; $i < count($request->part); $i++) { 
                ServiceRoomsDetail::create([
                    'serviceRoom_id'=>$ser->id,
                    'name'=>$request->part[$i],
                    'amount'=>$request->price[$i],
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

}