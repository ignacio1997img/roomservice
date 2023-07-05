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
                    <img src="{{ Voyager::image($admin_favicon) }}" alt="{{strtoupper(setting('admin.title'))}}" width="70px">
                @endif
            </td>
            <td style="text-align: center;  width:50%">
                <h3 style="margin-bottom: 0px; margin-top: 5px">
                    {{strtoupper(setting('admin.title'))}}<br>
                </h3>
                <h4 style="margin-bottom: 0px; margin-top: 5px">
                    REPORTE DETALLADO DE INGRESO DE ARTICULO AL ALMACEN <br> PARA LIMPIEZA
                </h4>
            </td>
            <td style="text-align: right; width:30%">
                <h3 style="margin-bottom: 0px; margin-top: 5px">
                    <div id="qr_code">
                        {{-- {!! QrCode::size(80)->generate('Total Cobrado: Bs'.number_format($amount,2, ',', '.').', Cobrado Por: '.$agent.', Recaudado en Fecha '.date('d', strtotime($date)).' de '.strtoupper($months[intval(date('m', strtotime($date)))] ).' de '.date('Y', strtotime($date))); !!} --}}
                    </div>
                    <small style="font-size: 8px; font-weight: 100">Impreso por: {{ Auth::user()->name }} {{ date('d/m/Y H:i:s') }}</small>
                </h3>
            </td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; font-size: 8px" >
        <thead>
            <tr> 
                <th style="text-align: center">NRO FACTURA</th>
                <th style="text-align: center">FECHA FACTURA</th>
                <th style="text-align: center">MONTO</th>
            </tr>
            <tr> 
                <td style="text-align: center">{{$income->numberFactura?$income->numberFactura:'SN'}}</td>
                <td style="text-align: center">{{$income->dateFactura?$income->dateFactura:'SN'}}</td>
                <td style="text-align: center">{{$income->amount}}</td>
            </tr>
        </thead>   
    </table>
    <br>
    <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
        <thead>
            <tr>
                <th style="width:5px">N&deg;</th>   
                <th style="text-align: center">CATEGORIA</th>
                <th style="text-align: center">ARTICULO</th>
                <th style="text-align: center">CANTIDAD</th>
                <th style="text-align: center">PRECIO</th>
                <th style="text-align: center">TOTAL</th>
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
                    <td style="text-align: center">{{ $item->category}}</td>
                    <td style="text-align: center">{{ $item->article}}</td>
                    <td style="text-align: right">{{ number_format($item->cantSolicitada, 2, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($item->price, 2, ',', '.') }}</td>
                    <td style="text-align: right"><b>{{ number_format($item->amount, 2, ',', '.') }}</b></td>                          
                                                                            
                </tr>
                @php
                    $count++;                 
                    $total+= $item->amount;                    
                @endphp
            @empty
                <tr style="text-align: center">
                    <td colspan="6">No se encontraron registros.</td>
                </tr>
            @endforelse
            <tr>
                <th colspan="5" style="text-align: right">Total</th>
                <td style="text-align: right"><strong>Bs. {{ number_format($total,2, ',', '.') }}</strong></td>
            </tr>
           
        </tbody>       
       

    </table>
    <script>

    </script>

@endsection
@section('css')
    <style>
        table, th, td {
            border-collapse: collapse;
        }
          
    </style>
@stop
