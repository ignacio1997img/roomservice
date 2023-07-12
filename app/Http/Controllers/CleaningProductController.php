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
       
        $data = CleaningProduct::with(['user'])
                    ->where(function($query) use ($search){
                        if($search){
                            $query->OrWhereRaw($search ? "numberFactura like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "dateFactura like '%$search%'" : 1)
                            ->OrWhereRaw($search ? "amount like '%$search%'" : 1);
                        }
                    })
                    ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);
        // dump($data);
        return view('cleaningProduct.income.list', compact('data'));

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

    public function show($id)
    {
        $income = CleaningProduct::where('id', $id)
                ->first();
        // return $income;
        $data = DB::table('cleaning_products_details as id')
            ->join('articles as a', 'a.id', 'id.article_id')
            ->join('categories as c', 'c.id', 'a.category_id')
            ->where('id.cleaningProduct_id', $income->id)
            ->select('id.cantSolicitada', 'id.price', 'id.amount', 'a.name as article', 'c.name as category')
            ->get();
        // return $data;
        return view('cleaningProduct.income.print', compact('income', 'data'));
    }



    //Para ver el stock del almacen
    public function indexStock()
    {
        // return 1;
        return view('cleaningProduct.stock.browse');
    }

    public function listStock($search = null)
    {
        // dump(1);
        $paginate = request('paginate') ?? 10;

        $data = CleaningProductsDetail::with(['article.category'])
                ->where('deleted_at', NULL)->where('cantRestante','>',0)->select('article_id',  'price', DB::raw("SUM(cantRestante) as stock"))->orderBy('id', 'DESC')->groupBy('article_id', 'price')->paginate($paginate);

        // return $data;
        // dump($data);
        return view('cleaningProduct.stock.list', compact('data'));

    }
}
