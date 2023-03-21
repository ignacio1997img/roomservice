<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\CategoriesRoom;
use App\Models\CategoriesRoomsPart;
use App\Models\PartsHotel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;

class CategoryRoomController extends Controller
{
    public function index()
    {
        // return 1;
        return view('structHotel.categoryRoom.browse');
    }

    public function list($search = null){
        $paginate = request('paginate') ?? 10;

        $data = CategoriesRoom::where(function($query) use ($search){
                        if($search){
                            $query->OrWhereRaw($search ? "name like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "description like '%$search%'" : 1);
                        }
                    })
                    ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);

        // dump($data);
        return view('structHotel.categoryRoom.list', compact('data'));
    }

    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $cat = CategoriesRoom::create([
                'name'=>$request->name,
                'description'=>$request->description,
                'registerUser_id'=>Auth::user()->id
            ]);
            if(count($request->category) > 0)
            {
                for ($i=0; $i < count($request->category); $i++) { 
                    CategoriesRoomsPart::create([
                        'categoryRoom_id'=>$cat->id,
                        'partHotel_id'=>$request->category[$i],
                        'amount'=>$request->price[$i],
                        'registerUser_id'=>Auth::user()->id
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('voyager.categories-rooms.index')->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('voyager.categories-rooms.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function destroy($room)
    {
        DB::beginTransaction();
        try {
            $ok = CategoriesRoom::where('id', $room)->where('deleted_at', null)->first();
            CategoriesRoomsPart::where('categoryRoom_id', $ok->id)->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);
            $ok->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);

            DB::commit();
            return redirect()->route('voyager.categories-rooms.index')->with(['message' => 'Eliminado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('voyager.categories-rooms.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function show($room)
    {
        // return $room;
        $data = CategoriesRoom::with(['part'=>function($q){
                    $q->where('deleted_at', null);
                }])
                ->where('id', $room)
                ->where('deleted_at', null)->first();
        $part = PartsHotel::where('deleted_at', null)->get();

        // return $data;
        return view('structHotel.categoryRoom.read' ,compact('data', 'part'));

    }

    public function deletePart(Request $request, $part)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $ok = CategoriesRoomsPart::where('id', $part)->where('deleted_at', null)->first();
            $ok->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);

            DB::commit();
            return redirect()->route('voyager.categories-rooms.show', ['room' => $request->room_id])->with(['message' => 'Eliminado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('voyager.categories-rooms.show', ['room' => $request->room_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }


    public function ajaxPartsHotel()
    {
        $q = request('q');
        
        $data = PartsHotel::whereRaw($q ? '(name like "%'.$q.'%" )' : 1)
        ->where('deleted_at', null)->get();

        return response()->json($data);
    }
}
