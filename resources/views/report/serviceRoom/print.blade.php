@extends('layout-print.template-print-alt')

@section('page_title', 'Reporte')

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
                    REPORTE DETALLADO DE VENTA DE COMIDA
                    {{-- Stock Disponible {{date('d/m/Y', strtotime($start))}} Hasta {{date('d/m/Y', strtotime($finish))}} --}}
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
    @forelse ($data as $item)
                <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                    <thead>
                        <tr>
                            <th style="width:8%">N&deg; Habitacion</th>
                            <th style="text-align: center">Categoría</th>
                            <th style="text-align: center">Planta de Hotel</th>
                            <th style="text-align: center">Fecha Inicio</th>
                            <th style="text-align: center">Fecha Fin</th>
                            <th style="text-align: center">Total Dias</th>
                            <th style="text-align: center; width:80px">Total Bs.</th>
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
                            <td style="text-align: right">{{ number_format($item->amountTotal, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                </table>
                <table style="width: 100%; font-size: 8px"  cellspacing="0" cellpadding="4">
                    <tbody>
                        <tr>
                            <td style="text-align: center"><small style="font-size: 15px">Cliente/Personas Hospedada en la Habitacion N&deg; {{$item->number}}</small></td>
                        </tr>
                    </tbody>
                </table>
                @foreach ($item->client as $client)
                    <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                        <tbody>
                            <tr>
                                <th style="width:10%">NOMBRE</th>
                                <td colspan="5" style="width:65%; text-align: left">{{$client->people->first_name}} {{$client->people->last_name}}</td>
                                <th style="width:10%">NACIONALIDAD</th>
                                <td style="width:15%; text-align: left">{{$client->people->nationality?$client->people->nationality->name:'SN'}}</td>
                            </tr>
                            <tr>
                                <th style="width:10%">CI / PASAPORTE</th>
                                <td style="width:10%; text-align: left">{{$client->people->ci}}</td>
                                <th style="width:10%">FECHA N.</th>
                                <td style="width:15%; text-align: left">{{date('d/m/Y', strtotime($client->people->birth_date))}}</td>
                                <th style="width:10%">CELULER</th>
                                <td style="text-align: left">{{$client->people->cell_phone??'SN'}}</td>
                                <th style="width:10%">GENERO</th>
                                <td style="text-align: left">{{$client->people->gender=='masculino'?'MASCULINO':'FEMENINO'}}</td>                                
                            </tr>
                            <tr>
                                <th style="width:10%">DIRECCION</th>
                                <td colspan="5" style="width:65%; text-align: left">{{$client->address??'SN'}}</td>
                            </tr>
                        </tbody>
                    </table>
                    <br>
                    <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
                        <tbody>
                            @if ($client->country_id==1)

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
                @endforeach

                

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
