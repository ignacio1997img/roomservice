@extends('voyager::master')

@section('page_title', 'Ver habitación asignada')
@if (auth()->user()->hasPermission('read_assign'))

@section('page_header')
    <h1 class="page-title">
        <i class="fa-solid fa-key"></i> Habitación Asignada
        <a href="{{ route('worker.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            Volver a la lista
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <form id="agent" action="{{route('serviceroom.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="row">
                        <input type="hidden" name="room_id" value="{{$room->id}}">
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Habitación</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p><small>Pieza N° {{ $room->number }}</small></p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Categoría</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $room->caregoryroom->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Planta de Hotel</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $room->categoryfacility->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>

                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Estado</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                @if ($room->status == 1)
                                    <span class="label label-success">Habitacion Libre</span>
                                @else
                                    <span class="label label-danger">Habitacion Ocuṕada</span>
                                @endif
                            </div>
                            <hr style="margin:0;">
                        </div>  
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">CI / Pasaporte</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$service->people->ci}}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>       
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Nombre</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$service->people->first_name}} {{$service->people->last_name}}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>     
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha Inicio</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$service->people->ci}}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>       
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha Fin</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$service->people->first_name}} {{$service->people->last_name}}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>        
                  
                        
                       
                        <div class="col-md-4">
                            <div class="panel-body">
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="3" style="text-align: center">Accesorios</th>
                                        </tr>
                                        <tr>
                                            <th>N&deg;</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cont = 0;
                                            $total = 0;
                                        @endphp
                                        @forelse ($room->caregoryroom->part as $item)
                                            @php
                                                $cont++;
                                                $total = $total + $item->amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $cont }}</td>
                                                <td>{{ $item->name->name}}
                                                    <input type="hidden" name="part[]" value="{{ $item->name->name}}">
                                                </td>
                                                <td>{{ $item->name->Description}}</td>
                                               
                                            </tr>
                                        @empty
                                            <tr>
                                                <td style="text-align: center" valign="top" colspan="3" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="panel-body">
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="6" style="text-align: center"><i class="fa-solid fa-cart-shopping"></i> Pedidos del Hotel</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px">N&deg;</th>
                                            <th>Nombre</th>
                                            <th style="width: 50px">Precio</th>
                                            <th style="width: 50px">Cantidad</th>
                                            <th style="width: 50px">Sub Total</th>
                                            {{-- <th style="width: 50px">Acción</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cont = 0;
                                            $total = 0;
                                        @endphp
                                        @forelse ($egre as $item)               
                                                @php
                                                    $cont++;
                                                    $total = $total + ($item->price * $item->cantSolicitada);
                                                @endphp
                                                <tr>
                                                    <td>{{ $cont }}</td>
                                                    <td>{{ $item->name}}</td>
                                                    <td style="text-align: right">{{ $item->price}}</td>
                                                    <td style="text-align: right">{{ $item->cantSolicitada}}</td>
                                                    <td style="text-align: right">{{ $item->price * $item->cantSolicitada}}</td>
                                                    {{-- <td>{{ $item->name->Description}}</td> --}}
                                                
                                                </tr>
                                            
                                        @empty
                                            <tr>
                                                <td style="text-align: center" valign="top" colspan="5" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="3" style="text-align: right">Total</td>
                                            <td style="text-align: right" colspan="2"><strong><small>Bs. {{ number_format($total,2, ',', '.') }}</small></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                        <div class="col-md-4">
                            <div class="panel-body">
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th colspan="6" style="text-align: center"><i class="fa-solid fa-bowl-food"></i> Pedidos del Hotel</th>
                                        </tr>
                                        <tr>
                                            <th style="width: 50px">N&deg;</th>
                                            <th>Nombre</th>
                                            <th style="width: 50px">Precio</th>
                                            <th style="width: 50px">Cantidad</th>
                                            <th style="width: 50px">Sub Total</th>
                                            {{-- <th style="width: 50px">Acción</th> --}}
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cont = 0;
                                            $total = 0;
                                        @endphp
                                        @forelse ($menu as $item)               
                                                @php
                                                    $cont++;
                                                    $total = $total + ($item->price * $item->cant);
                                                @endphp
                                                <tr>
                                                    <td>{{ $cont }}</td>
                                                    <td>{{ $item->food->name}}</td>
                                                    <td style="text-align: right">{{ $item->price}}</td>
                                                    <td style="text-align: right">{{ $item->cant}}</td>
                                                    <td style="text-align: right">{{ $item->price * $item->cant}}</td>
                                                    {{-- <td>{{ $item->name->Description}}</td> --}}
                                                
                                                </tr>
                                            
                                        @empty
                                            <tr>
                                                <td style="text-align: center" valign="top" colspan="5" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="3" style="text-align: right">Total</td>
                                            <td style="text-align: right" colspan="2"><strong><small>Bs. {{ number_format($total,2, ',', '.') }}</small></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>                            
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>
@stop

@section('javascript')
    <script>
       

            
    </script>
@stop
@endif
