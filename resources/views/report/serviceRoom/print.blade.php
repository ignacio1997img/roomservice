@extends('layout-print.template-print-alt')

@section('page_title', 'Reporte')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
@section('content')
    @php
        $months = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');    
    @endphp

    <table width="100%">
        <tr>
            <td style="width: 20%">
                <?php $admin_favicon = Voyager::setting('admin.icon_image'); ?>
                @if($admin_favicon == '')
                    <img src="{{ asset('image/icon.png') }}" alt="{{strtoupper(setting('admin.title'))}}" width="70px">
                @else
                @php
                    // dd($admin_favicon);
                @endphp
                    <img src="{{ Voyager::image($admin_favicon) }}" alt="{{strtoupper(setting('admin.title'))}}" width="70px">
                @endif
            </td>
            <td style="text-align: center;  width:60%">
                <h3 style="margin-bottom: 0px; margin-top: 5px">
                    {{strtoupper(setting('admin.title'))}}<br>
                </h3>
                <h4 style="margin-bottom: 0px; margin-top: 5px">
                    REPORTE DETALLADO DE LAS HABITACIONES
                </h4>
                @if ($start == $finish)
                    <small style="margin-bottom: 0px; margin-top: 5px; font-size: 10px">
                            {{ date('d', strtotime($start)) }} DE {{ strtoupper($months[intval(date('m', strtotime($start)))] )}} DE {{ date('Y', strtotime($start)) }}
                    </small>
                @else
                    <small style="margin-bottom: 0px; margin-top: 5px; font-size: 10px">
                        {{ date('d', strtotime($start)) }} DE {{ strtoupper($months[intval(date('m', strtotime($start)))] )}} DE {{ date('Y', strtotime($start)) }} HASTA {{ date('d', strtotime($finish)) }} DE {{ strtoupper($months[intval(date('m', strtotime($finish)))] )}} DE {{ date('Y', strtotime($finish)) }}
                    </small>
                @endif
                
            </td>
            <td style="text-align: right; width:20%">
                <h3 style="margin-bottom: 0px; margin-top: 5px">
                    {{-- <div id="qr_code">
                        {!! QrCode::size(80)->generate('Total Cobrado: Bs'.number_format($amount,2, ',', '.').', Cobrado Por: '.$agent.', Recaudado en Fecha '.date('d', strtotime($date)).' de '.strtoupper($months[intval(date('m', strtotime($date)))] ).' de '.date('Y', strtotime($date))); !!}
                    </div> --}}
                    <small style="font-size: 8px; font-weight: 100">Impreso por: {{ Auth::user()->name }} <br> {{ date('d/m/Y H:i:s') }}</small>
                </h3>
            </td>
        </tr>
    </table>
    <br>
    @forelse ($data as $item)
            <table style="width: 100%; font-size: 8px"  cellspacing="0" cellpadding="4">
                <tbody>
                    <tr>
                        <td style="text-align: center"><small style="font-size: 15px">DETALLE DE LA HABITACION N&deg; {{$item->number}}</small></td>
                    </tr>
                </tbody>
            </table>
                <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                    <thead>
                        <tr>
                            <th style="width:8%">N&deg; Habitacion</th>
                            <th style="text-align: center">Categoría</th>
                            <th style="text-align: center">Planta de Hotel</th>
                            <th style="text-align: center">Fecha Inicio</th>
                            <th style="text-align: center">Fecha Fin</th>
                            <th style="text-align: center">Total Dias</th>
                            <th style="text-align: center; width:80px">Costo Ha.bitacion</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="text-align: center">N&deg; {{$item->number}}</td>
                            <td style="text-align: center">{{$item->category}}</td>
                            <td style="text-align: center">{{$item->facility}}</td>
                            <td style="text-align: center">{{date('d/m/Y H:i:s', strtotime($item->start))}}</td>
                            <td style="text-align: center">{{$item->finish?date('d/m/Y H:i:s', strtotime($item->finish)):'SN'}}</td>
                            <td style="text-align: center">{{$item->day}}</td>
                            <td style="text-align: right">{{ number_format($item->typePrice, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%; font-size: 8px"  cellspacing="0" cellpadding="4">
                    <tbody>
                        <tr>
                            <td style="text-align: center"><small style="font-size: 10px">Cliente/Personas Hospedada en la Habitacion N&deg; {{$item->number}}</small></td>
                        </tr>
                    </tbody>
                </table>
                @foreach ($item->client as $client)                    
                    <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                        <tbody>
                            @if ($client->payment == 1)
                                {{-- <tr style="  border-radius: 5px; border: 5px solid green;">
                                    sgaeg
                                </tr> --}}
                            @endif
                            <tr>
                                <th style="width:10%">NOMBRE</th>
                                <td colspan="5" style="width:65%; text-align: left">{{$client->people->first_name}} {{$client->people->last_name}}</td>
                                <th style="width:10%">NACIONALIDAD</th>
                                <td style="width:15%; text-align: left">{{$client->people->nationality?$client->people->nationality->name:'SN'}}</td>
                            </tr>
                            <tr>
                                <th style="width:10%">CI / PASAPORTE</th>
                                <td style="width:15%; text-align: left">{{$client->people->ci}}</td>
                                <th style="width:10%">FECHA N.</th>
                                <td style="width:15%; text-align: left">{{date('d/m/Y', strtotime($client->people->birth_date))}}</td>
                                <th style="width:10%">CELULER</th>
                                <td style="width:15%; text-align: left">{{$client->people->cell_phone??'SN'}}</td>
                                <th style="width:10%">GENERO</th>
                                <td style="width:15%; text-align: left">{{$client->people->gender=='masculino'?'MASCULINO':'FEMENINO'}}</td>                                
                            </tr>
                            <tr>
                                <th style="width:10%">DIRECCION</th>
                                <td colspan="7" style="width:65%; text-align: left">{{$client->address??'SN'}}</td>
                            </tr>
                        {{-- </tbody>
                    </table>
                   <br>
                    <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                        <tbody> --}}
                            @if ($client->country_id == 1)
                                <tr>
                                    <th style="width:10%">PAIS PROCEDENCIA</th>
                                    <td style="width:15%; text-align: left">{{$client->country->name}}</td>
                                    <th style="width:10%">DEPARTAMENTO</th>
                                    <td style="width:15%; text-align: left">{{$client->department->name}}</td>
                                    <th style="width:10%">PROVINCIA</th>
                                    <td style="width:15%; text-align: left">{{$client->province?$client->province->name:'SN'}}</td>
                                    <th style="width:10%">CIUDAD</th>
                                    <td style="width:15%; text-align: left">{{$client->city?$client->city->name:'SN'}}</td>
                                    
                                </tr>
                            @else
                                <tr>
                                    <th style="width:10%">PAIS PROCEDENCIA</th>
                                    <td colspan="5" style="width:65%; text-align: left">{{$client->country->name}}</td>
                                    <th style="width:10%">PROCEDENCIA</th>
                                    <td style="width:15%; text-align: left">{{$client->origin}}</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                    <br>
                @endforeach

                <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                    <thead>
                        <tr>
                            <th colspan="5" style="text-align: center"><i class="fa-solid fa-cart-shopping"></i> Pedidos del Hotel</th>
                        </tr>
                        <tr>
                            <th style="width:8%">N&deg;</th>
                            <th style="text-align: center">Nombre</th>
                            <th style="text-align: center">Precio</th>
                            <th style="text-align: center">Cantidad</th>
                            <th style="text-align: center; width:80px">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                            $detailTotal=0;
                        @endphp
                        @php
                            $detail = $item->egres->where('deleted_at', null)->first();
                        @endphp
                        @if ($detail)
                            @forelse ($detail->detail as $det)
                                <tr>
                                    <td style="text-align: center">{{$i}}</td>
                                    <td style="text-align: left">{{$det->article->name}}</td>
                                    <td style="text-align: right">{{ number_format($det->price, 2, ',', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($det->cantSolicitada, 2, ',', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($det->price*$det->cantSolicitada, 2, ',', '.') }}</td>
                                </tr>
                                @php
                                    $i++;
                                    $detailTotal+=$det->price*$det->cantSolicitada;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center">Sin datos...</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="5" style="text-align: center">Sin datos...</td>
                            </tr>
                        @endif  

                        <tr>
                            <td style="text-align: center"><p>Total</p></td>
                            <td colspan="4" style="text-align: right"><p>Bs. {{ number_format($detailTotal, 2, ',', '.') }}</p></td>
                        </tr> 
                    </tbody>
                </table>
                <br>
                <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                    <thead>
                        <tr>
                            <th colspan="5" style="text-align: center"><i class="fa-solid fa-bowl-food"></i> Pedidos del Hotel</th>
                        </tr>
                        <tr>
                            <th style="width:8%">N&deg;</th>
                            <th style="text-align: center">Nombre</th>
                            <th style="text-align: center">Precio</th>
                            <th style="text-align: center">Cantidad</th>
                            <th style="text-align: center; width:80px">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                            $menuTotal=0;
                        @endphp
                        @php
                            $menu = $item->egres->where('deleted_at', null)->first();
                        @endphp
                        @if ($menu)
                            @forelse ($menu->menu as $men)
                                <tr>
                                    <td style="text-align: center">{{$i}}</td>
                                    <td style="text-align: left">{{$men->food->name}}</td>
                                    <td style="text-align: right">{{ number_format($men->price, 2, ',', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($men->cant, 2, ',', '.') }}</td>
                                    <td style="text-align: right">{{ number_format($men->amount, 2, ',', '.') }}</td>
                                </tr>
                                @php
                                    $i++;
                                    $menuTotal+=$men->amount;
                                @endphp
                            @empty
                                <tr>
                                    <td colspan="5" style="text-align: center">Sin datos...</td>
                                </tr>
                            @endforelse
                        @else
                            <tr>
                                <td colspan="5" style="text-align: center">Sin datos...</td>
                            </tr>
                        @endif  

                        <tr>
                            <td style="text-align: center"><p>Total</p></td>
                            <td colspan="4" style="text-align: right"><p>Bs. {{ number_format($menuTotal, 2, ',', '.') }}</p></td>
                        </tr>                  
                    </tbody>
                </table>
                <br>
                <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                    <thead>
                        <tr>
                            <th colspan="5" style="text-align: center"><i class="fa-solid fa-cart-plus"></i> Servicios Extras</th>
                        </tr>
                        <tr>
                            <th style="width:8%">N&deg;</th>
                            <th style="text-align: center">Detalle</th>
                            <th style="text-align: center; width:10%">SubTotal</th>
                        </tr>
                    </thead>
                    <tbody>
                        @php
                            $i=1;
                            $extraTotal=0;
                        @endphp
                        @forelse ($item->extra as $extra)
                            <tr>
                                <td style="text-align: center">{{$i}}</td>
                                <td style="text-align: left">{{$extra->detail}}</td>
                                <td style="text-align: right">{{ number_format($extra->amount, 2, ',', '.') }}</td>
                            </tr>
                            @php
                                $i++;
                                $extraTotal+=$extra->amount;
                            @endphp
                        @empty
                            <tr>
                                <td colspan="3" style="text-align: center">Sin datos...</td>
                            </tr>
                        @endforelse    
                        <tr>
                            <td style="text-align: center"><p>Total</p></td>
                            <td colspan="2" style="text-align: right"><p>Bs. {{ number_format($extraTotal, 2, ',', '.') }}</p></td>
                        </tr>                 
                    </tbody>
                </table>
                <br>
                <table style="width: 100%; font-size: 8px"  cellspacing="0" cellpadding="4">
                    <thead>
                        <tr>
                            <th colspan="5" style="text-align: center">Total de pago</th>
                        </tr>
                    </thead>
                    <tbody> 
                        <tr>
                            <td colspan="4" style="text-align: right"><p>Total pedido de Articulos</p></td>
                            <td style="text-align: right"><p>Bs. {{ number_format($detailTotal, 2, ',', '.') }}</p></td>
                        </tr>  
                        <tr>
                            <td colspan="4" style="text-align: right"><p>Total pedido de Comida</p></td>
                            <td style="text-align: right"><p>Bs. {{ number_format($menuTotal, 2, ',', '.') }}</p></td>
                        </tr>  
                        <tr>
                            <td colspan="4" style="text-align: right"><p>Total de servicios Extras</p></td>
                            <td style="text-align: right"><p>Bs. {{ number_format($extraTotal, 2, ',', '.') }}</p></td>
                        </tr>  
                        <tr>
                            <td colspan="4" style="text-align: right"><p>Total de la Habitacion</p></td>
                            <td style="text-align: right"><p>Bs. {{ number_format($item->amountTotal, 2, ',', '.') }}</p></td>
                        </tr>                  
                    </tbody>
                </table>



                

                <br><br><br>
                
            @empty
                
            @endforelse



@endsection
@section('css')
    <style>
        table, th, td {
            border-collapse: collapse;
        }
          
    </style>
@stop
