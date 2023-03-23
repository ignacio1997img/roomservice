<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\IncomesDetail;
use App\Models\Article;
use App\Models\Category;
use App\Models\Egre;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;

class IncomeController extends Controller
{
    public function index()
    {
        return view('store.income.browse');
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
            // return 0;
            return redirect()->route('incomes.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
    public function show($id)
    {
        $income = Income::where('id', $id)
                ->first();
        // return $data;
        $data = DB::table('incomes_details as id')
            ->join('articles as a', 'a.id', 'id.article_id')
            ->join('categories as c', 'c.id', 'a.category_id')
            ->where('id.income_id', $income->id)
            ->select('id.cantSolicitada', 'id.price', 'id.amount', 'a.name as article', 'c.name as category')
            ->get();
        // return $data;
        return view('store.income.print', compact('income', 'data'));
    }


    //Para ver el stock del almacen
    public function indexStock()
    {
        return view('store.stock.browse');
    }

    public function listStock($search = null)
    {
        $paginate = request('paginate') ?? 10;

        $data = IncomesDetail::with(['article.category'])
                ->where('deleted_at', NULL)->where('cantRestante','>',0)->select('article_id', 'price', DB::raw("SUM(cantRestante) as stock"))->orderBy('id', 'DESC')->groupBy('article_id', 'price')->paginate($paginate);

        
        // dump($data);
        return view('store.stock.list', compact('data'));

    }


    //para obntener los articulos con stock del almacen
    public function ajaxProductExists()
    {
        $q = request('q');
        
        $data = IncomesDetail::with(['article','article.category'])
            ->where(function($query) use ($q){
                if($q){
                    $query->OrwhereHas('article', function($query) use($q){
                        $query->whereRaw("(name like '%$q%')");
                    });
                }
            })
            ->select('article_id', 'id', 'price', 'expiration',  DB::raw("SUM(cantRestante) as cantRestante"))
            ->where('cantRestante','>', 0)->where('deleted_at', null)->where('expirationStatus', 1)->groupBy('article_id', 'price', 'expiration')->get();

        return response()->json($data);
    }



    //Para sacar producto del almacen a las oficinas
    public function storeEgressPieza(Request $request)
    {
        return $request;

        if($request->amount<=0)
        {
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ingrese detalle de producto..', 'alert-type' => 'warning']);
        }

        // return $request;
        DB::beginTransaction();
        try {
            $user = Auth::user()->id;
            $client = Egre::create([
                    'registerUser_id' => $user,
                    'people_id' => $request->cashier_id,
                    'room_id' => $request->room_id,
                    'amount' => $request->amount,
            ]);

            $pagar =0;
            for ($i=0; $i < count($request->income); $i++)
            {
                $incomedetail = IncomesDetail::where('article_id',$request->income[$i])->get();
                return $incomedetail;
                $cant=0;
                $ok=false;
                if($request->cant_stock[$i] <= $wherehouse->item)
                {
                    $wherehouse->decrement('item', $request->cant_stock[$i]);

                    Item::create([
                        'wherehouseDetail_id' => $wherehouse->id,
                        'item' => $request->cant_stock[$i],
                        'itemEarnings' => $wherehouse->itemEarnings,
                        'amount' => $request->total_pagar[$i],
                        'client_id' => $client_id,
                        'indice' => $i,
                        'userRegister_id' => $user,

                    ]);
                    $pagar+= $request->total_pagar[$i];
                }
                else
                {
                    // para que pueda sacar productos de varios registro pero del mismo item y del mismo precio
                    $cant = $request->cant_stock[$i];
                    while($cant > 0)
                    {
                        $des=0;
                        $aux = WherehouseDetail::where('article_id', $wherehouse->article_id)->where('itemEarnings', $wherehouse->itemEarnings)
                                ->where('item', '>', 0)
                                ->where('deleted_at', null)
                                ->orderBy('id', 'ASC')->first();
                        $des = $cant > $aux->item ? $aux->item : $cant;
                        
                        $aux->decrement('item', $des);
                        $cant-= $des;
                        
                        Item::create([
                            'wherehouseDetail_id' => $aux->id,
                            'item' => $des,
                            'itemEarnings' => $aux->itemEarnings,
                            'amount' => $des * $aux->itemEarnings,
                            'client_id' => $client_id,
                            'indice' => $i,
                            'userRegister_id' => $user,


                        ]);
                        $pagar = $pagar + ($des * $aux->itemEarnings);
                    }
                }
                        
                $client->update(['amount'=>$pagar]);
                
            }
            Adition::create([
                'client_id' => $client_id,
                'cashier_id' => $request->cashier_id,
                'cant' => $request->credits? $request->subAmount:$request->amount,
                'observation' => 'Pago al momento del servicio',
                'type'=> 'producto',
                'userRegister_id' => $user
            ]);
            // return 'si';
                DB::commit();
            return redirect()->route('clients.index')->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('clients.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }


}
