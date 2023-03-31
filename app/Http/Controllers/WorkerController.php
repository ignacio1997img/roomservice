<?php

namespace App\Http\Controllers;

use App\Models\CategoriesWorker;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Models\People;
use App\Models\WorkersCategory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class WorkerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }


    //para trabajadores del hotel
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
                    ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);

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

    public function ajaxCategory()
    {
        $q = request('q');
        
        $data = CategoriesWorker::whereRaw($q ? '(name like "%'.$q.'%" )' : 1)
        ->where('deleted_at', null)->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        // return $request;
        // return count($request->category);
        DB::beginTransaction();
        try {
            $ok = Worker::where('people_id', $request->people)->where('deleted_at', null)->first();
            if($ok)
            {
                return redirect()->route('worker.index')->with(['message' => 'El personal ya se encuenta registrado.', 'alert-type' => 'error']);
            }
            $worker = Worker::create([
                'people_id'=>$request->people,
                'observation'=>$request->observation,
                'registerUser_id'=>Auth::user()->id
            ]);
            if(count($request->category) > 0)
            {
                for ($i=0; $i < count($request->category); $i++) { 
                    WorkersCategory::create([
                        'worker_id'=>$worker->id,
                        'categoryWorker_id'=>$request->category[$i],
                        'registerUser_id'=>Auth::user()->id
                    ]);
                }
            }

            DB::commit();
            return redirect()->route('worker.index')->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('worker.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try {
            $ok = Worker::where('id', $id)->where('deleted_at', null)->first();
            // return $ok;
            // return 1;
            WorkersCategory::where('worker_id', $ok->id)->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);
            // return 1;
            $ok->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);


            DB::commit();
            return redirect()->route('worker.index')->with(['message' => 'Eliminado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('worker.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }

    public function show($id)
    {
        // return $id;
        $data = Worker::with(['people', 'category'=>function($q)
        {
            $q->where('deleted_at', null);
        }])
            ->where('id', $id)->where('deleted_at', NULL)->orderBy('id', 'DESC')->first();
            // return $data;
        $category = CategoriesWorker::where('deleted_at', null)->get();
        return view('worker.read', compact('data', 'category'));
    }

    public function storeCategory(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            $ok = WorkersCategory::where('worker_id', $request->worker_id)->where('categoryWorker_id', $request->category_id)->where('deleted_at', null)->first();
            if($ok)
            {
                return redirect()->route('worker.show', ['worker' => $request->worker_id])->with(['message' => 'El personal ya se encuenta registrado.', 'alert-type' => 'error']);
            }
            
            WorkersCategory::create([
                'worker_id'=>$request->worker_id,
                'categoryWorker_id'=>$request->category_id,
                'observation'=>$request->observation,
                'registerUser_id'=>Auth::user()->id
            ]);

            DB::commit();
            return redirect()->route('worker.show', ['worker' => $request->worker_id])->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('worker.show', ['worker' => $request->worker_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }       
    }
    public function deleteCategory(Request $request, $worker)
    {
        DB::beginTransaction();
        try {
            $ok = WorkersCategory::where('id', $worker)->where('deleted_at', null)->first();
            $ok->update(['deleted_at'=>Carbon::now(), 'deletedUser_id'=>Auth::user()->id]);

            DB::commit();
            return redirect()->route('worker.show', ['worker' => $request->worker_id])->with(['message' => 'Eliminado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('worker.show', ['worker' => $request->worker_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
}
