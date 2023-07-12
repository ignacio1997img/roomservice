<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Income;
use App\Models\IncomesDetail;
use App\Models\Egre;
use App\Models\EgresDeatil;
use App\Models\People;
use PhpParser\Node\Expr\FuncCall;
use App\Models\ServiceRoom;


class SaleController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function index()
    {
        return view('sale.browse');
    }


    public function list($search = null){

        $paginate = request('paginate') ?? 10;

        // dump(1);

        $data = Egre::with(['people', 'serviceroom.room'])
                    ->where(function($query) use ($search){
                        if($search){
                            $query->OrwhereHas('people', function($query) use($search){
                                $query->whereRaw("(ci like '%$search%' or first_name like '%$search%' or last_name like '%$search%' or CONCAT(first_name, ' ', last_name) like '%$search%')");
                            })
                            ->OrWhereRaw($search ? "amount like '%$search%'" : 1);
                        }
                    })
                    ->where('deleted_at', NULL)->orderBy('id', 'DESC')->paginate($paginate);
        // dump($data);
        return view('sale.list', compact('data'));
    }

    public function create()
    {
        return view('sale.add');
    }


    public function store(Request $request)
    {
        // return $request;
        if($request->amount<=0)
        {
            return redirect()->route('sales.create')->with(['message' => 'Ingrese detalle de producto..', 'alert-type' => 'warning']);
        }

        // return $request;
        DB::beginTransaction();
        try {

            $service =  ServiceRoom::where('room_id', $request->room_id)->where('status', 'asignado')->where('deleted_at',null)->first();  

            $user = Auth::user();
            $egre = Egre::create([
                    'registerUser_id' => $user->id,
                    'people_id' => $request->people_id,
                    'amount' => $request->amount,
                    'sale'=>1,
                    'type'=>'product'
            ]);

            $pagar =0;
            for ($i=0; $i < count($request->income); $i++)
            {
                $expiration = 1;
                if(!$request->expiration[$i])
                {
                    $expiration = 'expiration ='.$request->expiration[$i];
                }
         
                $total = IncomesDetail::where('article_id',$request->income[$i])
                        ->where('price', $request->price[$i])
                        ->whereRaw($expiration)
                        ->where('cantRestante', '>', 0)
                        ->where('deleted_at', null)->get()->SUM('cantRestante');
                // return $total;
                //por si falta item en el almacenn se retornara
                if($request->cant[$i] > $total)
                {
                    // return $total;
                    DB::rollBack();
                    return redirect()->route('sales.index')->with(['message' => 'Ingrese detalle de producto..', 'alert-type' => 'warning']);
                }

                $cantTotal = $request->cant[$i];
                $cant=0;
                $ok=false;
                // $detail = IncomesDetail::where('article_id',$request->income[$i])->where('price', $request->price[$i])->where($expiration)->where('cantRestante', '>', 0)->where('deleted_at', null)->first();
                while($cantTotal>0)
                {
                    $expiration = 1;
                    if(!$request->expiration[$i])
                    {
                        $expiration = 'expiration ='.$request->expiration[$i];
                    }
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

            return redirect()->route('sales.index')->with(['message' => 'Registrado exitosamente.', 'alert-type' => 'success']);

        } catch (\Throwable $th) {
            DB::rollBack();
            // return 10101;
            return redirect()->route('sales.index')->with(['message' => 'Ocurrió un error.', 'alert-type' => 'error']);
        }
    }
}
