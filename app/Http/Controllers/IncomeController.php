<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Income;
use App\Models\IncomesDetail;
use App\Models\Article;
use App\Models\Category;
use App\Models\Egre;
use App\Models\EgresDeatil;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use App\Models\ServiceRoom;

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
                ->where('deleted_at', NULL)->where('cantRestante','>',0)->select('article_id', 'expiration', 'price', DB::raw("SUM(cantRestante) as stock"))->orderBy('id', 'DESC')->groupBy('article_id', 'price', 'expiration')->paginate($paginate);

        // return $data;
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
        if($request->amount<=0)
        {
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ingrese detalle de producto..', 'alert-type' => 'warning']);
        }

        // return $request;
        DB::beginTransaction();
        try {

            $service =  ServiceRoom::where('room_id', $request->room_id)->where('status', 1)->where('deleted_at',null)->first();  

            $user = Auth::user()->id;
            $egre = Egre::create([
                    'registerUser_id' => $user,
                    'people_id' => $request->people_id?$request->people_id:$service->people_id,
                    'room_id' => $request->people_id?null:$request->room_id,
                    'amount' => $request->amount,
                    'serviceRoom_id'=> $request->people_id?null: $service->id
            ]);

            $pagar =0;
            for ($i=0; $i < count($request->income); $i++)
            {
                $expiration = 1;
                if(!$request->expiration[$i])
                {
                    $expiration = 'expiration ='.$request->expiration[$i];
                }
                // return $request;
                $total = IncomesDetail::where('article_id',$request->income[$i])->where('price', $request->price[$i])->whereRaw($expiration)->where('cantRestante', '>', 0)->where('deleted_at', null)->get()->SUM('cantRestante');
                //por si falta item en el almacenn se retornara
                if($request->cant[$i] > $total)
                {
                    DB::rollBack();
                    return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ingrese detalle de producto..', 'alert-type' => 'warning']);
                }

                $cantTotal = $request->cant[$i];
                $cant=0;
                $ok=false;
                // $detail = IncomesDetail::where('article_id',$request->income[$i])->where('price', $request->price[$i])->whereRaw($expiration)->where('cantRestante', '>', 0)->where('deleted_at', null)->first();

                while($cantTotal>0)
                {
                    $detail = IncomesDetail::where('article_id',$request->income[$i])->where('price', $request->price[$i])->whereRaw($expiration)->where('cantRestante', '>', 0)->where('deleted_at', null)->first();
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

                    EgresDeatil::create([
                        'egre_id'=>$egre->id,
                        'cantSolicitada'=>$aux,
                        'price'=>$detail->price,
                        'amount'=>$aux * $detail->price,
                        'article_id'=>$detail->article_id,
                        'incomeDetail_id'=>$detail->id,
                        'registerUser_id' => Auth::user()->id

                    ]);
                }
                
            }
            DB::commit();
            if($request->people_id)
            {
                return redirect()->route('sales.index')->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);
            }
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->route('view.planta', ['planta'=>$request->planta_id])->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }


}
