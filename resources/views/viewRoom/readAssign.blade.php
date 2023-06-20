@extends('voyager::master')

@section('page_title', 'Ver habitación asignada')
@if (auth()->user()->hasPermission('read_assign'))

@section('page_header')
    <h1 class="page-title">
        <i class="fa-solid fa-key"></i> Habitación Asignada
        <a href="{{ route('view.planta', ['planta'=>$room->categoryFacility_id]) }}" class="btn btn-warning">
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
                                @if ($service->status == 'asignado')
                                    <span class="label label-danger">Habitacion Ocuṕada</span>
                                @else
                                    <span class="label label-warning">Habitacion Reservada</span>
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
                                <p>{{ date('d-m-Y h:i', strtotime($service->start)) }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>       
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Recomendado Por</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{$service->recommended? $service->people->first_name.' '.$service->people->last_name:'SN' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>        
                  
                        
                       @php
                           $deuda =0;
                       @endphp
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="table-responsive">
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
                                                $deuda = $deuda + $service->amount;
                                                
                                            @endphp
                                            @forelse ($room->part as $item)
                                                
                                                <tr>
                                                    <td>{{ $cont = $cont +1 }}</td>
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
                        </div>
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="table-responsive">
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
                                                        $deuda=$deuda+($item->price * $item->cantSolicitada);
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
                        </div>
                        <div class="col-md-4">
                            <div class="panel-body">
                                <div class="table-responsive">
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
                                                        $total = $total + $item->amount;
                                                        $deuda=$deuda+$item->amount;
                                                    @endphp
                                                    <tr>
                                                        <td>{{ $cont }}</td>
                                                        <td>{{ $item->name}}</td>
                                                        <td style="text-align: right">{{ $item->price}}</td>
                                                        <td style="text-align: right">{{ $item->cant}}</td>
                                                        <td style="text-align: right">{{ $item->amount}}</td>
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
                        <div class="col-md-12">
                            <div class="panel-body">
                                <div class="table-responsive">
                                    <table id="dataTable" class="table table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th colspan="5" style="text-align: center"><i class="fa-solid fa-money-bill"></i> Pagos Realizados</th>
                                            </tr>
                                            <tr>
                                                <th style="text-align: center; width:12%">N&deg; Transacción</th>
                                                <th style="text-align: center">Monto</th>
                                                <th style="text-align: center">Fecha</th>
                                                <th style="text-align: center">Atendido Por</th>
                                                <th style="text-align: right">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @php
                                                $cont = 0;
                                                $total = 0;
                                            @endphp
                                            @forelse ($service->transaction as $item)       
                                                @php
                                                    $total = $total + $item->amount;
                                                @endphp        
                                                <tr>
                                                    <td style="text-align: center">{{$item->transaction}}</td>
                                                    <td style="text-align: center">
                                                        @if ($item->deleted_at)
                                                            <del>BS. {{$item->amount}} <br></del>
                                                            <label class="label label-danger">Anulado por {{$item->eliminado}}</label>
                                                        @else
                                                        BS. {{$item->amount}}
                                                        @endif
                                                    </td>
                                                    <td style="text-align: center">
                                                        {{date('d/m/Y H:i:s', strtotime($item->created_at))}}<br><small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}
                                                    </td>
                                                    <td style="text-align: center">{{$item->agentType}} <br> {{$item->name}}</td>
                                                    <td class="no-sort no-click bread-actions text-right">
                                                        @if(!$item->deleted_at)
                                                            <a onclick="printDailyMoney({{$item->id}}, {{$item->id}})" title="Imprimir"  class="btn btn-danger">
                                                                <i class="glyphicon glyphicon-print"></i>
                                                            </a>
                                                        @endif
                                                    </td>
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
                        <div class="col-md-12">                            
                            <div class="alert alert-success">
                                <strong>Pago Total:</strong>
                                <p>Total a pagar de los servicios: {{NumerosEnLetras::convertir($deuda,'Bolivianos',true,'Centavos')}} </p>
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
