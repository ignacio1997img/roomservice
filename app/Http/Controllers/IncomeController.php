<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\IncomesDetail;
use App\Models\Article;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        return view('store.income.browse');
    }
    public function create()
    {
        $category = Category::where('deleted_at', null)->get();
        return view('store.income.add', compact('category'));
    }

    public function ajaxArticle()
    {
        $q = request('q');
        $data = Article::with(['category'])
        ->whereRaw($q ? '(name like "%'.$q.'%" or presentation like "%'.$q.'%")' : 1)
        ->where('deleted_at', null)->get();

        return response()->json($data);
    }

    public function store(Request $request)
    {
        // return $request;
        DB::beginTransaction();
        try {
            if($request->amount==0)
            {
                return redirect()->route('incomes.create')->with(['message' => 'No ha agregado detalle de producto.', 'alert-type' => 'error']);
            }
            $income = Income::create([
                'year'=>date('Y'),
                'dateFactura'=>$request->dateFactura,
                'numberFactura'=>$request->numberFactura,
                'observation'=>$request->observation,
                'amount'=>$request->amount,
                'registerUser_id'=>Auth::user()->id
            ]);

            for ($i=0; $i < count($request->cant); $i++)
            {
                IncomesDetail::create([
                    'income_id'=>$income->id,
                    'article_id'=>$request->product_id[$i],
                    'cantSolicitada'=>$request->cant[$i],
                    'cantRestante'=>$request->cant[$i],
                    'price'=>$request->price[$i],
                    'amount'=>$request->price[$i] * $request->cant[$i],
                    'expiration'=>$request->date[$i],
                    'registerUser_id'=>Auth::user()->id
                ]);
            }

            DB::commit();
            return redirect()->route('incomes.index')->with(['message' => 'Registrado exitosamente...', 'alert-type' => 'success']);
        } catch (\Throwable $th) {
            DB::rollBack();
            return 0;
            return redirect()->route('incomes.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
}
