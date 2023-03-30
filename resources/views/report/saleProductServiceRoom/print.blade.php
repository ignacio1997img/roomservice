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
            <td style="text-align: center;  width:50%">
                <h3 style="margin-bottom: 0px; margin-top: 5px">
                    {{strtoupper(setting('admin.title'))}}<br>
                </h3>
                <h4 style="margin-bottom: 0px; margin-top: 5px">
                    REPORTE DETALLADO DE VENTA DE PRODUCTOS
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
            <td style="text-align: right; width:30%">
                <h3 style="margin-bottom: 0px; margin-top: 5px">
                    {{-- <div id="qr_code">
                        {!! QrCode::size(80)->generate('Total Cobrado: Bs'.number_format($amount,2, ',', '.').', Cobrado Por: '.$agent.', Recaudado en Fecha '.date('d', strtotime($date)).' de '.strtoupper($months[intval(date('m', strtotime($date)))] ).' de '.date('Y', strtotime($date))); !!}
                    </div> --}}
                    <small style="font-size: 8px; font-weight: 100">Impreso por: {{ Auth::user()->name }} {{ date('d/M/Y H:i:s') }}</small>
                </h3>
            </td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
        <thead>
            <tr>
                <th style="width:5px">N&deg;</th>
                <th style="text-align: center">CLIENTE</th>
                <th style="text-align: center">ATENDIDO POR</th>
                <th style="text-align: center">FECHA</th>
                <th style="text-align: center">PRODUCTO</th>
                <th style="text-align: center; width:5px">CANTIDAD</th>
                <th style="text-align: center; width:5px">PRECIO</th>

                <th style="text-align: center; width:80px">TOTAL</th>
            </tr>
        </thead>
        <tbody>
                    @php
                        $count = 1;
                        $total = 0;
                    @endphp
                    @forelse ($data as $item)
                        <tr>
                            <td>{{ $count }}</td>
                            <td>
                                <small>Nombre:</small> {{ $item->first_name}} {{ $item->last_name}}<br>
                                <small>Nro Habitación:</small> {{ $item->number}}
                            </td>
                            <td style="text-align: center">{{$item->user}}</td>
                            <td style="text-align: center">{{date('d/m/Y', strtotime($item->created_at))}}</td>
                            <td style="text-align: right">{{ $item->name}}</td>
                            <td style="text-align: right">{{ number_format($item->cantSolicitada,2, ',', '.') }}</td>
                            <td style="text-align: right">{{ number_format($item->price,2, ',', '.') }}</td>
                            <td style="text-align: right">{{ number_format(($item->cantSolicitada * $item->price),2, ',', '.') }}</td>
                                                                                
                            
                        </tr>
                        @php
                            $count++;
                            $total = $total + ($item->cantSolicitada * $item->price);                            
                        @endphp
                        
                    @empty
                        <tr style="text-align: center">
                            <td colspan="10">No se encontraron registros.</td>
                        </tr>
                    @endforelse

                    <tr>
                        <td colspan="7" style="text-align: right"><b>TOTAL</b></td>
                        <td style="text-align: right"><b><small>Bs. </small>{{ number_format($total, 2, ',', '.') }}</b></td>
                    </tr>
        </tbody>       
       

    </table>



@endsection
@section('css')
    <style>
        table, th, td {
            border-collapse: collapse;
        }
          
    </style>
@stop
