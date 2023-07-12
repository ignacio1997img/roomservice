<?php

namespace App\Http\Controllers;

use App\Models\CategoriesFacility;
use App\Models\CleaningAsignation;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CleaningController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('cleaningProduct.income.browse');
    }



    public function indexAsignation()
    {
        $data = User::where('role_id', 5)->where('deleted_at', null)->where('status', 1)->orderBy('id', 'DESC')->get();
        // return $data;
        return view('cleaning.cleaningAsignation.browse');
    }

    public function ListAsignation($search = null)
    {
        $paginate = request('paginate') ?? 10;
        // return 1;
       
        // $data = CleaningProduct::with(['user'])
        //             ->where(function($query) use ($search){
        //                 if($search){
        //                     $query->OrWhereRaw($search ? "numberFactura like '%$search%'" : 1)
        //                     ->OrWhereRaw($search ? "dateFactura like '%$search%'" : 1)
        //                     ->OrWhereRaw($search ? "amount like '%$search%'" : 1);
        //                 }
        //             })
        //             ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);

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
            // return $ok;
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
