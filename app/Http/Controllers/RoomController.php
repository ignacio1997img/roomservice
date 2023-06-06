<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\People;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Carbon;
use App\Models\CategoriesRoom;
use App\Models\CategoriesFacility;
use App\Models\RoomsFile;
use App\Models\CategoriesRoomsPart;
use App\Models\PartsHotel;

class RoomController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        $category = CategoriesRoom::where('deleted_at',null)->orderBy('name', 'ASC')->get();
        $facility = CategoriesFacility::where('deleted_at',null)->orderBy('name', 'ASC')->get();
        return view('structHotel.room.browse', compact('category', 'facility'));
    }

    public function list($search = null){
        $paginate = request('paginate') ?? 10;
        // return 1;

        $data = Room::with(['categoryfacility', 'caregoryroom'])
                    ->where(function($query) use ($search){
                        if($search){
                            $query->OrwhereHas('categoryfacility', function($query) use($search){
                                $query->whereRaw("(name like '%$search%')");
                            })
                            ->OrwhereHas('caregoryroom', function($query) use($search){
                                $query->whereRaw("(name like '%$search%')");
                            })
                            ->OrWhereRaw($search ? "number like '%$search%'" : 1);
                        }
                    })
                    ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);

        // dump($data);
        return view('structHotel.room.list', compact('data'));
    }

    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $ok = Room::where('number', $request->number)->where('categoryFacility_id', $request->facility)->where('deleted_at', null)->first();
            if($ok)
            {
                return redirect()->route('room.index')->with(['message' => 'El numero de habitacion ya se encuentra registrada en esa planta seleccionada.', 'alert-type' => 'warning']);
            }
            // return $request;

            $room = Room::create([
                'number'=>$request->number,
                'amount'=>$request->price,
                'categoryFacility_id'=>$request->facility,
                'categoryRoom_id'=>$request->category_id,
                'registerUser_id'=>Auth::user()->id
            ]);
            // return $room;
            
            // return count($request->image);
            $file = $request->file('image');
            if ($file)
            {
                for ($i=0; $i < count($request->image); $i++) { 
                    $image = $this->image($file[$i], $room->id, 'room');
                    // return $image;
                    RoomsFile::create([
                        'room_id'=>$room->id,
                        'image' => $image
                    ]);

                }
            }

            if(count($request->category) > 0)
            {
                for ($i=0; $i < count($request->category); $i++) { 
                    CategoriesRoomsPart::create([
                        'room_id'=>$room->id,
                        'partHotel_id'=>$request->category[$i],
                        'registerUser_id'=>Auth::user()->id
                    ]);
                }
            }
            DB::commit();
            return redirect()->route('voyager.rooms.index')->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('voyager.rooms.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function show($room)
    {
        // return $room;
        $data = Room::with(['part'=>function($q){
                    $q->where('deleted_at', null);
                }])
                ->where('id', $room)
                ->where('deleted_at', null)->first();

        $part = PartsHotel::where('deleted_at', null)->get();

        // return $data;
        return view('structHotel.room.read' ,compact('data', 'part'));

    }
    // Para agregar partes a una habitacion
    public function storePart(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            // $ok = CategoriesRoomsPart::where('room_id',$request->room_id)->where('partHotel_id',$request->part)->where('deleted_at', null)->first();
            // if($ok)
            // {
            //     return redirect()->route('voyager.rooms.show', ['id' => $request->room_id])->with(['message' => 'Ya existe en la lista.', 'alert-type' => 'warning']);
            // }
                CategoriesRoomsPart::create([
                    'room_id'=>$request->room_id,
                    'partHotel_id'=>$request->part,
                    'registerUser_id'=>Auth::user()->id,
                    'observation'=>$request->observation
                ]);   
            DB::commit();
            return redirect()->route('voyager.rooms.show', ['id' => $request->room_id])->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('voyager.rooms.show', ['id' => $request->room_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function deletePart(Request $request, $part)
    {
        // return $part;
        DB::beginTransaction();
        try {
            $ok = CategoriesRoomsPart::where('id', $part)->where('deleted_at', null)->where('room_id', $request->room_id)->first();
            $ok->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);

            DB::commit();
            return redirect()->route('voyager.rooms.show', ['id' => $request->room_id])->with(['message' => 'Eliminado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('voyager.rooms.show', ['id' => $request->room_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function destroy($id)
    {
        // return $id;
        DB::beginTransaction();
        try {
            $ok = Room::where('id', $id)->where('deleted_at', null)->first();
            CategoriesRoomsPart::where('room_id', $id)->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);
            $ok->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);

            DB::commit();
            return redirect()->route('voyager.rooms.index')->with(['message' => 'Eliminado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('voyager.rooms.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }



}
