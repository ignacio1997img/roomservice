@extends('voyager::master')

@section('content')
    <div class="page-content">
        @include('voyager::alerts')
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body">
                    <div class="col-md-12">
                        <h3>Hola, {{ Auth::user()->name }}</h3>
                    </div>
                </div>
            </div>
        </div>

        @if(auth()->user()->hasPermission('graphic'))
            @php
                // $date = date()
                $saleproduct = App\Models\EgresDeatil::WhereHas('egres', function($query) {
                                $query->where('sale',1);
                            })
                    ->whereDate('created_at', '=', date('Y-m-d'))->where('deleted_at', null)->get();
                $saleproduct = $saleproduct->SUM('amount');

                $salefood = App\Models\EgresMenu::WhereHas('egres', function($query) {
                                $query->where('sale',1);
                            })
                    ->whereDate('created_at', '=', date('Y-m-d'))->where('deleted_at', null)->get();
                $salefood = $salefood->SUM('amount');

                $room = App\Models\Room::where('status',1)->where('deleted_at', null)->get();
                // $room = $room->SUM('amount');


                //para obtener los productos vendido del dia
                $foodDay = App\Models\EgresMenu::with('food')->where('deleted_at', null)->whereDate('created_at', '=', date('Y-m-d'))
                    ->selectRaw('COUNT(food_id) as count,SUM(amount) as total, food_id')
                    ->groupBy('food_id')->orderBy('total', 'DESC')->limit(5)->get();
                // dd($products);

            @endphp

            <div class="col-md-3">
                <div class="panel panel-bordered" style="border-left: 5px solid #52BE80">
                    <div class="panel-body" style="height: 100px;padding: 15px 20px">
                        <div class="col-md-9">
                            <h5><i class="fa-solid fa-cart-shopping"></i> Ventas de productos del día</h5>
                            <h2><small>Bs.</small>{{ number_format($saleproduct, 2, ',', '.') }}</h2>
                        </div>
                        <div class="col-md-3 text-right">
                            <i class="icon voyager-dollar" style="color: #52BE80"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-bordered" style="border-left: 5px solid #52BE80">
                    <div class="panel-body" style="height: 100px;padding: 15px 20px">
                        <div class="col-md-9">
                            <h5><i class="fa-solid fa-bowl-food"></i> Ventas de comida del día</h5>
                            <h2><small>Bs.</small>{{ number_format($salefood, 2, ',', '.') }}</h2>
                        </div>
                        <div class="col-md-3 text-right">
                            <i class="icon voyager-dollar" style="color: #52BE80"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-bordered" style="border-left: 5px solid #3498DB">
                    <div class="panel-body" style="height: 100px;padding: 15px 20px">
                        <div class="col-md-9">
                            <h5><i class="fa-solid fa-person-booth"></i> Habitaciones Libres</h5>
                            <h2>{{ $room->where('status', 1)->count() }}</h2>
                        </div>
                        <div class="col-md-3 text-right">
                            <i class="icon voyager-people" style="color: #3498DB"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="panel panel-bordered" style="border-left: 5px solid #E74C3C">
                    <div class="panel-body" style="height: 100px;padding: 15px 20px">
                        <div class="col-md-9">
                            <h5>Deuda total</h5>
                            {{-- <h2><small>Bs.</small>{{ number_format($total_debt, 2, ',', '.') }}</h2> --}}
                        </div>
                        <div class="col-md-3 text-right">
                            <i class="icon voyager-book" style="color: #E74C3C"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body" style="height: 250px">
                        <canvas id="line-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body" style="height: 250px">
                        <canvas id="bar-chart"></canvas>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="panel">
                    <div class="panel-body" style="height: 250px">
                        <canvas id="doughnut-chart"></canvas>
                    </div>
                </div>
            </div>
        
        {{-- <div class="analytics-container"> --}}
            
        @endif
        
            <div class="row" style="text-align: center">
                @php
                    $pdf =  \App\Models\CategoriesFacility::where('deleted_at',null)->get();
                @endphp
                @forelse ($pdf as $item)
                    <div class="col-md-4" style="text-align: center">
                        <div class="col-md-2"></div>
                        <div class="col-md-8" id="myDiv" style="background-color: #DFDFDF; margin-top: 2em; border-radius: 20px; height:320px">
                            <br>
                            <i class="fa-solid fa-house" style="color: #545454; font-size: 3em;"></i>
                            <p style="font-size: 22px; color: #ffffff;"><small>{{$item->name}}</small></p>                            
                            <a href="{{route('view.planta', ['planta'=>$item->id])}}" class="btn btn-primary" data-toggle="modal">
                                    <i class="fa-solid fa-eye"></i><span class="hidden-xs hidden-sm"> Ver</span>
                            </a>
                            <br><br><br><br>
                            @php
                                $libre =  \App\Models\Room::where('categoryFacility_id', $item->id)->where('status', 1)->where('deleted_at',null)->get();
                                $ocupada =  \App\Models\Room::where('categoryFacility_id', $item->id)->where('status', 0)->where('deleted_at',null)->get();
                                
                            @endphp
                            <p style="text-align: left"><small>Habitaciones Libres: <span style="font-size: 15px">{{count($libre)}}</span></small></p>
                            <p style="text-align: left"><small>Habitaciones Ocupada: <span style="font-size: 15px">{{count($ocupada)}}</span></small></p>
                            <p style="text-align: left"><small>Total de Habitaciones: <span style="font-size: 15px">{{count($libre)+count($ocupada)}}</span></small></p>


                        </div>   
                        <div class="col-md-2"></div>

                    </div>
               
                @empty
                    <tr style="text-align: center">
                        <td colspan="7" style="font-size: 50px" class="dataTables_empty">No hay planta de habitaciones disponibles</td>
                    </tr>
                @endforelse

            </div>
            
            
            
        {{-- </div> --}}
    </div>
@stop
@section('css')
<style>
    div#myDiv{
        /* width:200px;
        height:200px; */
        background-image: url('https://fastrack-stamford.imgix.net/Stamford-Grand-Adelaide/Rooms/New-Suite-822-Bedroom.jpg?auto=%2Cformat%2Ccompress&fit=clip&ixlib=php-3.3.1&w=992');


        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;  
    }
</style>
@stop

@section('javascript')
 
    <script src="{{ asset('js/plugins/chart.min.js') }}"></script>
    <script>
        $(document).ready(function(){
            

            // ==============================================
       
            labels = [];
            values = [];

        
            labels.push('Ingreso del Día');
            values.push({{$saleproduct + $salefood}});
      

            var data = {
                labels,
                datasets: [{
                    label: 'Bs. Productos & Comidas del día',
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(39, 174, 96, 1)',
                        'rgba(155, 89, 182, 1)',
                        'rgba(235, 152, 78, 1)',
                        'rgba(52, 73, 94, 1)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(39, 174, 96, 1)',
                        'rgba(155, 89, 182, 1)',
                        'rgba(235, 152, 78, 1)',
                        'rgba(52, 73, 94, 1)'
                    ],
                }]
            };
            var config = {
                type: 'bar',
                data,
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top',
                        }
                    }
                },
            };
            var myChart = new Chart(
                document.getElementById('bar-chart'),
                config
            );

            // ==============================================
            let foodDay = @json($foodDay);
            labels = [];
            values = [];

            foodDay.map(item => {
                labels.push(item.food.name);
                values.push(parseInt(item.total));
            });

            var data = {
                labels,
                datasets: [{
                    label: 'Productos más vendidos',
                    data: values,
                    backgroundColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(39, 174, 96, 1)',
                        'rgba(255, 205, 86, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(235, 152, 78, 1)',
                    ],
                    hoverOffset: 4
                }]
            };
            var config = {
                type: 'doughnut',
                data
            };
            var myChart = new Chart(
                document.getElementById('doughnut-chart'),
                config
            );
            
        });
    </script>
    

@stop
