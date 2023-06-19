<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\People;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PeopleController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('people.browse');
    }

    public function list($search = null){
        $paginate = request('paginate') ?? 10;
        $data = People::with(['nationality'])
                    ->where(function($query) use ($search){
                        $query->OrWhereRaw($search ? "id = '$search'" : 1)
                        ->OrWhereRaw($search ? "first_name like '%$search%'" : 1)
                        ->OrWhereRaw($search ? "last_name like '%$search%'" : 1)
                        ->OrWhereRaw($search ? "CONCAT(first_name, ' ', last_name) like '%$search%'" : 1)
                        ->OrWhereRaw($search ? "ci like '%$search%'" : 1);
                    })
                    ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);
        // dump($data);

        return view('people.list', compact('data'));
    }

    public function store(Request $request){
        DB::beginTransaction();
        try {
            $people = People::create($request->all());
            DB::commit();
            return response()->json(['people' => $people]);
        } catch (\Throwable $th) {
            DB::rollback();
            return response()->json(['error' => $th->getMessage()], 500);
        }
    }
}
