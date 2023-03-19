@extends('layout-print.template-print-alt')

@section('page_title', 'Reporte')

@section('content')
    @php
        $months = array('', 'Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre');    
    @endphp

    <table width="100%">
        <tr>
            <td style="width: 20%"><img src="{{ asset('images/icon.png') }}" alt="CAPRESI" width="70px"></td>
            <td style="text-align: center;  width:50%">
                <h3 style="margin-bottom: 0px; margin-top: 5px">
                    {{strtoupper(setting('admin.title'))}}<br>
                </h3>
                <h4 style="margin-bottom: 0px; margin-top: 5px">
                    REPORTE DETALLADO DE INGRESO DE ARTICULO AL ALMACEN
                    {{-- Stock Disponible {{date('d/m/Y', strtotime($start))}} Hasta {{date('d/m/Y', strtotime($finish))}} --}}
                </h4>
                {{-- <small style="margin-bottom: 0px; margin-top: 5px; font-size: 10px">
                        {{ date('d', strtotime($date)) }} DE {{ strtoupper($months[intval(date('m', strtotime($date)))] )}} DE {{ date('Y', strtotime($date)) }}
                </small> --}}
                {{-- <br>
                <small style="font-size: 10px">
                    COBRADO POR: 
                </small>
                <br>
                <small style="font-size: 10px">
                    <b>TOTAL COBRADO Bs.</b> 
                </small> --}}
            </td>
            <td style="text-align: right; width:30%">
                <h3 style="margin-bottom: 0px; margin-top: 5px">
                    <div id="qr_code">
                        {{-- {!! QrCode::size(80)->generate('Total Cobrado: Bs'.number_format($amount,2, ',', '.').', Cobrado Por: '.$agent.', Recaudado en Fecha '.date('d', strtotime($date)).' de '.strtoupper($months[intval(date('m', strtotime($date)))] ).' de '.date('Y', strtotime($date))); !!} --}}
                    </div>
                    <small style="font-size: 8px; font-weight: 100">Impreso por: {{ Auth::user()->name }} {{ date('d/M/Y H:i:s') }}</small>
                </h3>
            </td>
        </tr>
    </table>
    <br>
    <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
        <thead>
            <tr>
                <th rowspan="2" style="width:5px">N&deg;</th>   
                <th rowspan="2" style="text-align: center">CI</th>
                <th rowspan="2" style="text-align: center">CLIENTE</th>
                <th colspan="3" style="text-align: center">DETALLE DEL PRESTAMOS</th>
                <th colspan="3" style="text-align: center">DETALLE DE PAGO</th>
            </tr>
            <tr>
                <th style="text-align: center; width:5px">CODIGO PRESTAMO</th>
                <th style="text-align: center; width:5px">FECHA DE PRESTAMO</th>
                <th style="text-align: center; width:5px">TOTAL DEL PRESTAMO</th>

                <th style="text-align: center; width:5px">N. TRANS.</th>
                <th style="text-align: center; width:5px">FECHA DE PAGO</th>
                <th style="text-align: center; width:70px">TOTAL PAGADO</th>
            </tr>
        </thead>
        <tbody>
           
        </tbody>       
       

    </table>

    <br>
    <br>
    <table width="100%" style="font-size: 9px">
        <tr>
            <td style="text-align: center">
                ______________________
                <br>
                <b>Entregado Por</b><br>
                <b>{{ Auth::user()->name }}</b><br>
                <b>CI: {{ Auth::user()->ci }}</b>
            </td>
            <td style="text-align: center">
                {{-- ______________________
                <br>
                <b>Firma Responsable</b> --}}
            </td>
            <td style="text-align: center">
                ______________________
                <br>
                <b>Recibido Por</b><br>
                <b>................................................</b><br>
                <b>CI: ........................</b>
            </td>
        </tr>
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
