<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\CleaningProduct;
use App\Models\CleaningProductsDetail;
use Illuminate\Support\Carbon;

class CleaningProductController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        return view('cleaningProduct.income.browse');
    }

    public function list($search = null)
    {
        $paginate = request('paginate') ?? 10;
        // return 1;
       
        $data = Income::with(['user'])
                    ->where(function($query) use ($search){
                        if($search){
                            $query->OrWhereRaw($search ? "numberFactura like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "dateFactura like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "amount like '%$search%'" : 1);
                        }
                    })
                    ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);
        // dump($data);
        return view('store.income.list', compact('data'));

    }


    public function create()
    {
        return view('cleaningProduct.income.add');
    }

    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            if($request->amount==0)
            {
                return redirect()->route('cleaningproducts.create')->with(['message' => 'No ha agregado detalle de producto.', 'alert-type' => 'error']);
            }
            $income = CleaningProduct::create([
                'year'=>date('Y'),
                'dateFactura'=>$request->dateFactura,
                'numberFactura'=>$request->numberFactura,
                'observation'=>$request->observation,
                'amount'=>$request->amount,
                'registerUser_id'=>Auth::user()->id
            ]);

            for ($i=0; $i < count($request->cant); $i++)
            {
                CleaningProductsDetail::create([
                    'cleaningProduct_id'=>$income->id,
                    'article_id'=>$request->product_id[$i],
                    'cantSolicitada'=>$request->cant[$i],
                    'cantRestante'=>$request->cant[$i],
                    'price'=>$request->price[$i],
                    'amount'=>$request->price[$i] * $request->cant[$i],
                    'registerUser_id'=>Auth::user()->id
                ]);
            }

            DB::commit();
            return redirect()->route('cleaningproducts.index')->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            // return 0;
            return redirect()->route('cleaningproducts.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
}
