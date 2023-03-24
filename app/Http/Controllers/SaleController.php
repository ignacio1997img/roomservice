<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Income;
use App\Models\IncomesDetail;
use App\Models\Egre;
use App\Models\People;
use PhpParser\Node\Expr\FuncCall;
use App\Models\ServiceRoom;


class SaleController extends Controller
{
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
}
