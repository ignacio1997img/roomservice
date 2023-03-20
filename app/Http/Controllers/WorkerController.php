<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\People;

class WorkerController extends Controller
{
    public function index()
    {
        return view('worker.browse');
    }

    public function list($search = null){
        $paginate = request('paginate') ?? 10;


        $data = Worker::with(['people'])
                    ->where(function($query) use ($search){
                        if($search){
                            $query->OrwhereHas('people', function($query) use($search){
                                $query->whereRaw("(ci like '%$search%' or first_name like '%$search%' or last_name like '%$search%' or CONCAT(first_name, ' ', last_name) like '%$search%')");
                            });
                            // ->OrWhereRaw($search ? "typeLoan like '%$search%'" : 1)
                            // ->OrWhereRaw($search ? "code like '%$search%'" : 1);
                        }
                    })
                    ->where('deleted_at', NULL)->where('status', 'pendiente')->orderBy('date', 'DESC')->paginate($paginate);

        // dump($data);
        return view('worker.list', compact('data'));
    }

    public function ajaxPeople()
    {
        $q = request('q');
        $data = People::whereRaw($q ? '(ci like "%'.$q.'%" or first_name like "%'.$q.'%" or last_name like "%'.$q.'%" )' : 1)
        ->where('deleted_at', null)->get();

        return response()->json($data);
    }
}
