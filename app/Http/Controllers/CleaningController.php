<?php

namespace App\Http\Controllers;

use App\Models\CategoriesFacility;
use App\Models\CleaningAsignation;
use App\Models\CleaningProductsDetail;
use App\Models\CleaningRoom;
use App\Models\CleaningRoomsProduct;
use App\Models\Room;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CleaningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('cleaning.cleaning.browse');
    }

    public function list($search = null)
    {
        $paginate = request('paginate') ?? 10;
        $user = Auth::user();

        $query_filter = 'c.user_id = '.$user->id;
        if(Auth::user()->hasRole('admin'))
        {
            $query_filter = 1;
        }
    
        $paginate = request('paginate') ?? 10;
        $data = DB::table('cleaning_asignations as c')
            ->join('users as u', 'u.id', 'c.user_id')
            ->join('rooms as r', 'r.id', 'c.room_id')
            ->join('categories_facilities as cf', 'cf.id', 'r.categoryFacility_id')
            ->join('categories_rooms as cr', 'cr.id', 'r.categoryRoom_id')
            ->where('r.deleted_at', null)
            ->where('c.deleted_at', null)
            // ->where('c.user_id', $user_id)
            ->whereRaw($query_filter)
            ->select('c.id', 'u.id as user_id', 'u.name as user', 'r.id as room_id', 'r.number as numero', 'cf.name as planta', 'cr.name as category')
            ->orderBy('numero', 'DESC')->paginate($paginate);

        // $data = User::where('role_id', 5)->where('deleted_at', null)->where('status', 1)->orderBy('id', 'DESC')->paginate($paginate);

        return view('cleaning.cleaning.list', compact('data'));

    }

    public function show($id)
    {
        // return $id;
        $cleaning = CleaningAsignation::with(['room', 'user'])->where('id', $id)->where('deleted_at', null)->first();

        $room = Room::with(['categoryfacility', 'caregoryroom'])->where('id', $cleaning->room->id)->where('deleted_at', null)->first();

        $data = CleaningRoom::with(['cleaningRoomProduct'=>function($q)
            {
                $q->where('deleted_at', null)
                ->select('article_id', 'cleaningRoom_id', 'id', 'price',  DB::raw("SUM(cant) as cant"))
                // ->select('article_id', 'id', 'price',  DB::raw("SUM(cant) as cantRestante"))
                ->groupBy('article_id', 'price');
            }, 'cleaningRoomProduct.article', 'startUser', 'finishUser'])
            ->where('deleted_at', null)
            ->where('room_id', $room->id)
            ->get();

        // return $data;

        return view('cleaning.cleaning.read', compact('cleaning', 'room', 'data'));

    }

    //para obntener los articulos con stock del almacen
    public function ajaxProductExists()
    {
        $q = request('q');
        
        $data = CleaningProductsDetail::with(['article','article.category'])
            ->where(function($query) use ($q){
                if($q){
                    $query->OrwhereHas('article', function($query) use($q){
                        $query->whereRaw("(name like '%$q%')");
                    });
                }
            })
            ->select('article_id', 'id', 'price',  DB::raw("SUM(cantRestante) as cantRestante"))
            ->where('cantRestante','>', 0)->where('deleted_at', null)->groupBy('article_id', 'price')->get();

        return response()->json($data);
    }


    public function storeRoomProduct(Request $request)
    {
        // return $request;

        if($request->amount<=0)
        {
            return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'Ingrese detalle de producto..', 'alert-type' => 'warning']);
        }

        DB::beginTransaction();
        try {
            $user = Auth::user();

            $pagar =0;
            for ($i=0; $i < count($request->income); $i++)
            {
                $total = CleaningProductsDetail::where('article_id',$request->income[$i])
                        ->where('price', $request->price[$i])
                        // ->whereRaw($expiration)
                        ->where('cantRestante', '>', 0)
                        ->where('deleted_at', null)->get()->SUM('cantRestante');
                // return $total;
                //por si falta item en el almacenn se retornara
                if($request->cant[$i] > $total)
                {
                    DB::rollBack();
                    return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'Error..', 'alert-type' => 'warning']);
                }

                $cantTotal = $request->cant[$i];
                $cant=0;
                $ok=false;
                // $detail = IncomesDetail::where('article_id',$request->income[$i])->where('price', $request->price[$i])->where($expiration)->where('cantRestante', '>', 0)->where('deleted_at', null)->first();
                while($cantTotal>0)
                {
                    
                    $detail = CleaningProductsDetail::where('article_id',$request->income[$i])->where('price', $request->price[$i])->where('cantRestante', '>', 0)->where('deleted_at', null)->first();
                    $aux = 0;
                    // cuando el total es mayor o igual se le saca todo del almacen de ese detalle
                    if($cantTotal >= $detail->cantRestante)
                    {
                        $cantTotal=$cantTotal-$detail->cantRestante;
                        $aux = $detail->cantRestante;
                    }
                    else
                    {
                        $aux = $cantTotal;
                        $cantTotal=0;
                    }

                    // return $detail;
                    $detail->decrement('cantRestante', $aux);

                    CleaningRoomsProduct::create([
                        'cleaningRoom_id'=>$request->id,
                        'cleaningProductDetail_id'=>$detail->id,

                        'cant'=>$aux,
                        'price'=>$detail->price,
                        'amount'=>$aux * $detail->price,
                        'article_id'=>$detail->article_id,

                        'userRegister_id' => Auth::user()->id

                    ]);
                }
                
            }
            DB::commit();
            return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return 0;
            return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }

        
    }


    public function cleaningStart(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $room = Room::where('id', $request->room_id)->where('cleaning', 0)->where('deleted_at', null)->first();
            if(!$room)
            {
                return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'La habitacion ya se encuentra en limpieza...', 'alert-type' => 'warning']);
            }
            // return $request;

            CleaningRoom::create([
                'cleaningAsignation_id'=>$request->cleaning_id,
                'room_id'=>$request->room_id,
                'date'=>Carbon::now(),
                'start'=>Carbon::now(),
                'starUser_id'=>Auth::user()->id,
            ]);

            $room->update(['cleaning'=>1]);
            DB::commit();
            return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'Limpieza iniciada exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    
    public function cleaningFinish(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $room = Room::where('id', $request->room_id)->where('cleaning', 1)->where('deleted_at', null)->first();
            if(!$room)
            {
                return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'La habitacion ya no se encuentra en limpieza...', 'alert-type' => 'warning']);
            }

            $cleaning = CleaningRoom::where('id', $request->id)->where('deleted_at', null)->first();

            $cleaning->update(['finish'=>Carbon::now(), 'finishUser_id'=>Auth::user()->id]);
            $room->update(['cleaning'=>0]);
            DB::commit();
            return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'Limpieza finalizada exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('cleaning.show', ['cleaning' => $request->cleaning_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }




    // :::::::::::::::::::::::::::::::



    public function indexAsignation()
    {
        $data = User::where('role_id', 5)->where('deleted_at', null)->where('status', 1)->orderBy('id', 'DESC')->get();
        // return $data;
        return view('cleaning.cleaningAsignation.browse');
    }

    public function ListAsignation($search = null)
    {
        $paginate = request('paginate') ?? 10;

        $data = User::where('role_id', 5)->where('deleted_at', null)->where('status', 1)->orderBy('id', 'DESC')->paginate($paginate);

        return view('cleaning.cleaningAsignation.list', compact('data'));

    }

    public function indexAsignationRoom($user_id)
    {
        $facility = CategoriesFacility::with(['room'=>function($q){$q->where('deleted_at', null);}])->where('deleted_at',null)->orderBy('name', 'ASC')->get();

        $user_id = $user_id;
        return view('cleaning.cleaningAsignationRoom.browse', compact('user_id', 'facility'));
    }

    public function ListAsignationRoom($user_id, $search = null)
    {
        // dump(1);
        $paginate = request('paginate') ?? 10;
        $data = DB::table('cleaning_asignations as c')
            ->join('users as u', 'u.id', 'c.user_id')
            ->join('rooms as r', 'r.id', 'c.room_id')
            ->join('categories_facilities as cf', 'cf.id', 'r.categoryFacility_id')
            ->where('r.deleted_at', null)
            ->where('c.deleted_at', null)
            ->where('c.user_id', $user_id)
            ->select('c.id', 'u.id as user_id', 'u.name as user', 'r.id as room_id', 'r.number as numero', 'cf.name as category')
            ->orderBy('numero', 'DESC')->paginate($paginate);
        // $data = User::where('role_id', 5)->where('deleted_at', null)->where('status', 1)->orderBy('id', 'DESC')->paginate($paginate);

        return view('cleaning.cleaningAsignationRoom.list', compact('data'));

    }

    public function storeAsignationRoom(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $ok = CleaningAsignation::where('room_id', $request->room_id)->where('user_id', $request->user_id)->where('deleted_at', null)->first();
            if($ok)
            {
                return redirect()->route('cleaning-asignation-room.index', ['user_id' => $request->user_id])->with(['message' => 'La habitacion ya se encuentra asignada a este usuario...', 'alert-type' => 'warning']);
            }
            // return $request;

            $room = CleaningAsignation::create([
                'room_id'=>$request->room_id,
                'user_id'=>$request->user_id,
            ]);
            DB::commit();
            return redirect()->route('cleaning-asignation-room.index', ['user_id' => $request->user_id])->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('cleaning-asignation-room.index', ['user_id' => $request->user_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function deleteAsignationRoom($id)
    {
        // return $id;
        DB::beginTransaction();
        try {
            $ok = CleaningAsignation::where('id', $id)->where('deleted_at', null)->first();
            $ok->update(['deleted_at'=>Carbon::now()]);
            
            DB::commit();
            return redirect()->route('cleaning-asignation-room.index', ['user_id' => $ok->user_id])->with(['message' => 'Eliminado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('cleaning-asignation-room.index', ['user_id' => $ok->user_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    
}
