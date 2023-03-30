<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\People;
use App\Models\ServiceRoom;
use App\Models\Room;
use App\Models\Egre;
use App\Models\EgresDeatil;
use App\Models\EgresMenu;
use App\Models\Food;
use App\Models\FoodMenu;

class ReportController extends Controller
{
    //####################################Para ver la salida de producto del almacen para las habitaciones########################
    //############################################################################################################################
    public function egreServiceRoom()
    {      
        return view('report.egreServiceRomm.report');
    }
}
