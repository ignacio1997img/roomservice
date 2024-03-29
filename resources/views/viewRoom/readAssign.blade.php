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


                        <div class="col-md-12">
                            <div class="panel-body text-center">                                          
                                <small style="font-size: 20px">Clientes / Personas hospedad en la habitación</small>
                                <hr style="border-radius: 5px; border: 3px solid #22a7f0;">
                            </div>
                        </div>


                        @foreach ($service->client as $item)
                            <div class="col-md-3">
                                <div class="panel-heading" style="border-bottom:0;">
                                    <h3 class="panel-title">CI / Pasaporte</h3>
                                </div>
                                <div class="panel-body" style="padding-top:0;">
                                    <p>{{$item->people->ci}}</p>
                                </div>
                                <hr style="margin:0;">
                            </div>  
                            <div class="col-md-8">
                                <div class="panel-heading" style="border-bottom:0;">
                                    <h3 class="panel-title">Nombre</h3>
                                </div>
                                <div class="panel-body" style="padding-top:0;">
                                    <p>{{$item->people->first_name}} {{$item->people->last_name}}</p>
                                </div>
                                <hr style="margin:0;">
                            </div> 

                            <div class="col-md-3">
                                <div class="panel-heading" style="border-bottom:0;">
                                    <h3 class="panel-title">País de Procedencia</h3>
                                </div>
                                <div class="panel-body" style="padding-top:0;">
                                    <p>{{$item->country->name}}</p>
                                </div>
                                <hr style="margin:0;">
                            </div> 
                            @if ($item->country_id==1)
                                <div class="col-md-3">
                                    <div class="panel-heading" style="border-bottom:0;">
                                        <h3 class="panel-title">Departamento</h3>
                                    </div>
                                    <div class="panel-body" style="padding-top:0;">
                                        <p>{{$item->department?$item->department->name:'SN'}}</p>
                                    </div>
                                    <hr style="margin:0;">
                                </div>
                                <div class="col-md-3">
                                    <div class="panel-heading" style="border-bottom:0;">
                                        <h3 class="panel-title">Provincia</h3>
                                    </div>
                                    <div class="panel-body" style="padding-top:0;">
                                        <p>{{$item->province?$item->province->name:'SN'}}</p>
                                    </div>
                                    <hr style="margin:0;">
                                </div>
                                <div class="col-md-3">
                                    <div class="panel-heading" style="border-bottom:0;">
                                        <h3 class="panel-title">Ciudad</h3>
                                    </div>
                                    <div class="panel-body" style="padding-top:0;">
                                        <p>{{$item->city?$item->city->name:'SN'}}</p>
                                    </div>
                                    <hr style="margin:0;">
                                </div>
                            @else
                                <div class="col-md-9">
                                    <div class="panel-heading" style="border-bottom:0;">
                                        <h3 class="panel-title">Procedencia</h3>
                                    </div>
                                    <div class="panel-body" style="padding-top:0;">
                                        <p>{{$item->origin}}</p>
                                    </div>
                                    <hr style="margin:0;">
                                </div> 
                            @endif

                            <div class="col-md-12">
                                <div class="panel-body text-center">                                   
                                    <hr style="border-radius: 5px; border: 3px solid #22a7f0;">
                                </div>
                            </div>
                        @endforeach
                         
                            
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha Inicio</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ date('d-m-Y h:i', strtotime($service->start)) }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>       
                        <div class="col-md-9">
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

                           $totalF =0;
                           $totalA =0;
                           $totalE =0;
                       @endphp
                        
                        @if ($service->status == 'asignado')                            

                            <div class="col-md-4" style="display: none">
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
                                                    @php
                                                        $totalA = $total;
                                                    @endphp
                                                    <td colspan="3" style="text-align: right">Total</td>
                                                    <td style="text-align: right" colspan="2"><strong><small>Bs. {{ number_format($total,2, ',', '.') }}</small></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                            
                                </div>                            
                            </div>
                            <div class="col-md-4" style="display: none">
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
                                                    @php
                                                        $totalF = $total;
                                                    @endphp
                                                    <td colspan="3" style="text-align: right">Total</td>
                                                    <td style="text-align: right" colspan="2"><strong><small>Bs. {{ number_format($total,2, ',', '.') }}</small></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                            
                                </div>                            
                            </div>

                            <div class="col-md-4" style="display: none">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="3" style="text-align: center"><i class="fa-solid fa-cart-plus"></i> Servicios Extras</th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 50px">N&deg;</th>
                                                    <th style="text-align: center">Detalles</th>
                                                    <th style="width: 100px; text-align: center">Precio</th>
                                                    {{-- <th style="width: 50px">Acción</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $cont = 0;
                                                    $total = 0;
                                                @endphp
                                                @forelse ($extra as $item)               
                                                        @php
                                                            $cont++;
                                                            $total = $total + $item->amount;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $cont }}</td>
                                                            <td>{{ $item->detail}}</td>
                                                            <td style="text-align: right">{{ $item->amount}}</td>
                                                        
                                                        </tr>
                                                    
                                                @empty
                                                    <tr>
                                                        <td style="text-align: center" valign="top" colspan="3" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                                    </tr>
                                                @endforelse
                                                <tr>
                                                    @php
                                                        $totalE = $total;
                                                    @endphp
                                                    <td colspan="2" style="text-align: right">Total</td>
                                                    <td style="text-align: right"><strong><small>Bs. {{ number_format($total,2, ',', '.') }}</small></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                            
                                </div>                            
                            </div>

                            {{-- <input type="text">                             --}}

                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="4" style="text-align: center"><i class="fa-solid fa-money-bill"></i> Pagos Realizados
                                                        
                                                    </th>
                                                    <th style="text-align: right; width:12%">
                                                    
                                                        <button class="btn btn-success" title="Nueva persona" data-target="#modal-create-customer" data-toggle="modal" style="margin: 0px" type="button">
                                                                <span class="glyphicon glyphicon-plus"></span>Adicionar Pago
                                                        </button>
                                                        
                                                    </th>
                                                </tr>
                                                <tr>
                                                    <th style="text-align: center; width:12%">N&deg; Transacción</th>
                                                    <th style="text-align: center; width:10%">Tipo de Pago</th>
                                                    <th style="text-align: center">Fecha</th>
                                                    <th style="text-align: center">Atendido Por</th>
                                                    <th style="text-align: center">Monto</th>

                                                    {{-- <th style="text-align: right; width: 150px">Acciones</th> --}}
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
                                                        <td style="text-align: center">{{$item->id}}</td>
                                                        <td style="text-align: center">{{$item->qr==1?'QR':'Efectivo'}}</td>
                                                        
                                                        <td style="text-align: center">
                                                            {{date('d/m/Y H:i:s', strtotime($item->created_at))}}<br><small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}
                                                        </td>
                                                        <td style="text-align: center">{{$item->register->name}} <br> {{$item->registerRol}}</td>
                                                        <td style="text-align: right">
                                                            @if ($item->deleted_at)
                                                                <del>BS. {{$item->amount}} <br></del>
                                                                <label class="label label-danger">Anulado por {{$item->eliminado}}</label>
                                                            @else
                                                            BS. {{$item->amount}}
                                                            @endif
                                                        </td>
                                                        {{-- <td class="no-sort no-click bread-actions text-right">
                                                            @if(!$item->deleted_at)
                                                                <a onclick="printDailyMoney({{$item->id}}, {{$item->id}})" title="Imprimir"  class="btn btn-danger">
                                                                    <i class="glyphicon glyphicon-print"></i>
                                                                </a>
                                                            @endif
                                                        </td> --}}
                                                    </tr>
                                                    
                                                @empty
                                                    <tr>
                                                        <td style="text-align: center" valign="top" colspan="5" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                                    </tr>
                                                @endforelse
                                                <tr>
                                                    <td colspan="4" style="text-align: right">Total De dinero abonado en transacciones</td>
                                                    <td style="text-align: right" ><strong><small>Bs. {{ number_format($total,2, ',', '.') }}</small></strong></td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align: right">Total a pagar de los servicios, extra y hospedajes</td>
                                                    <td style="text-align: right" ><strong><small>Bs. {{ number_format($auxTotal->totalPagar+$totalA+$totalF+$totalE,2, ',', '.') }}</small></strong></td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                {{-- <table>
                                                    <tr>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </table> --}}
                                                {{-- <small></small> --}}
                                                <tr>
                                                    <td colspan="4" style="text-align: right">Total de dinero a devolver</td>
                                                    <td style="text-align: right" ><strong><small style="color: red">
                                                        Bs. 
                                                        @if ($total > $auxTotal->totalPagar+$totalA+$totalF+$totalE)
                                                            {{ number_format($total-($auxTotal->totalPagar+$totalA+$totalF+$totalE),2, ',', '.') }}
                                                        @else
                                                            {{ number_format(0,2, ',', '.') }}
                                                        @endif
                                                        
                                                        </small></strong>
                                                    </td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                                <tr>
                                                    <td colspan="4" style="text-align: right">Total de dinero a cobrar</td>
                                                    <td style="text-align: right" ><strong><small>Bs. 
                                                        @if ($total < $auxTotal->totalPagar+$totalA+$totalF+$totalE)
                                                            {{ number_format(($auxTotal->totalPagar+$totalA+$totalF+$totalE) -$total,2, ',', '.') }}
                                                        @else
                                                            {{ number_format(0,2, ',', '.') }}
                                                        @endif
                                                    </small></strong></td>
                                                    {{-- <td></td> --}}
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                            
                                </div>                            
                            </div>   

                            <div class="col-md-12">  
                                <div class="panel-body">                          
                                    <div class="alert alert-success">
                                        <strong>Pago Total de servicio:</strong>
                                        <p><small>Total a pagar de los servicio de los articulo:</small> {{NumerosEnLetras::convertir($totalA,'Bolivianos',true,'Centavos')}} </p>
                                        <p><small>Total a pagar de los servicios de comida:</small> {{NumerosEnLetras::convertir($totalF,'Bolivianos',true,'Centavos')}} </p>
                                        <p><small>Total a pagar de los servicios extra:</small> {{NumerosEnLetras::convertir($totalE,'Bolivianos',true,'Centavos')}} </p>
                                        <p><small>Total a pagar del servicio de hospedaje con {{$auxTotal->typeAmount=='ventilador'? 'Ventilador':'Aire Acondicionado'}} de un total de {{$auxTotal->dia}} {{$auxTotal->dia>1?'días':'día'}}:</small> {{NumerosEnLetras::convertir($auxTotal->totalPagar,'Bolivianos',true,'Centavos')}} </p>
                                        <br>
                                        <p><small>Total a pagar:</small> {{NumerosEnLetras::convertir($auxTotal->totalPagar+$totalA+$totalF+$totalE,'Bolivianos',true,'Centavos')}} </p>
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
                                                    <th style="text-align: center">Nombre</th>
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
                                                    @php
                                                        $totalA = $total;
                                                    @endphp
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
                                                    <th style="text-align: center">Nombre</th>
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
                                                    @php
                                                        $totalF = $total;
                                                    @endphp
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
                                                    <th colspan="3" style="text-align: center"><i class="fa-solid fa-cart-plus"></i> Servicios Extras</th>
                                                </tr>
                                                <tr>
                                                    <th style="width: 50px">N&deg;</th>
                                                    <th style="text-align: center">Detalles</th>
                                                    <th style="width: 100px; text-align: center">Precio</th>
                                                    {{-- <th style="width: 50px">Acción</th> --}}
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $cont = 0;
                                                    $total = 0;
                                                @endphp
                                                @forelse ($extra as $item)               
                                                        @php
                                                            $cont++;
                                                            $total = $total + $item->amount;
                                                        @endphp
                                                        <tr>
                                                            <td>{{ $cont }}</td>
                                                            <td>{{ $item->detail}}</td>
                                                            <td style="text-align: right">{{ $item->amount}}</td>
                                                        
                                                        </tr>
                                                    
                                                @empty
                                                    <tr>
                                                        <td style="text-align: center" valign="top" colspan="3" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                                    </tr>
                                                @endforelse
                                                <tr>
                                                    <td colspan="2" style="text-align: right">Total</td>
                                                    <td style="text-align: right"><strong><small>Bs. {{ number_format($total,2, ',', '.') }}</small></strong></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>                            
                                </div>                            
                            </div>
                        @endif
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
                        
                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>


    <form action="{{ route('serviceroom-hospedaje.addmoney') }}" id="form-create-customer" method="POST">
        @csrf                    
        <div class="modal fade" tabindex="-1" id="modal-create-customer" role="dialog">
            <div class="modal-dialog modal-success">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa-solid fa-money-bill"></i> Adicionar Pago</h4>
                    </div>
                    <div class="modal-body">                       
                        <div class="form-group col-md-12">
                            <label for="full_name">Monto</label>
                            <input type="number" style="text-align: right" name="amount" min="0.1" step="0.1" class="form-control" placeholder="0.0" required>
                        </div>

                        <input type="hidden" name="serviceRoom_id" value="{{$service->id}}">

                        <div class="form-group col-md-12">
                            <input type="radio" id="html" name="qr" value="0" checked>
                            <label for="html"><small style="font-size: 15px">Efectivo</small></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="css" name="qr" value="1">
                            <label for="css"><small style="font-size: 15px">QR</small></label>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success btn-save-customer" value="Guardar">
                    </div>
                </div>
            </div>
        </div>
    </form>
@stop

@section('javascript')
    <script>
       

            
    </script>
@stop
@endif
