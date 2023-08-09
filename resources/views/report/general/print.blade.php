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
                <h4 style="margin-bottom: 0px; margin-top: 5px">
                    ESTABLECIMIENTO: {{strtoupper(setting('configuracion.name'))}}<br>
                </h4>
                <h5 style="margin-bottom: 0px; margin-top: 5px">
                    DIRECION: {{strtoupper(setting('configuracion.address'))}}<br>
                    TELEFONO: {{setting('configuracion.phone')}}<br>
                </h5>
                
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
    <table width="100%">
        <tr>
            <td colspan="2" style="text-align: left;">
                <h6 style="margin-bottom: 0px; margin-top: 5px">
                    Para conocimientos de las autoridades del dep; se distribuye el siguiente parte diario.
                </h6>
            </td>
        </tr>

        <tr>
            <td style="text-align: left;">
                <h6 style="margin-bottom: 0px; margin-top: 5px">
                    Correspondiente a la fecha:
                    @if ($start == $finish)
                        {{ date('d', strtotime($start)) }} de {{ $months[intval(date('m', strtotime($start)))] }} de {{ date('Y', strtotime($start)) }}
                    @else
                        {{ date('d', strtotime($start)) }} de {{ $months[intval(date('m', strtotime($start)))] }} de {{ date('Y', strtotime($start)) }} hasta {{ date('d', strtotime($finish)) }} de {{ $months[intval(date('m', strtotime($finish)))] }} de {{ date('Y', strtotime($finish)) }}
                    @endif
                </h6>
            </td>
            <td style="text-align: left;">
                <h6 style="margin-bottom: 0px; margin-top: 5px">
                    Nro de Licencia de Funcionamiento: {{setting('configuracion.nrolicencia')}}
                </h6>
            </td>
        </tr>
    </table>
    <table style="width: 100%; font-size: 8px" border="1" cellspacing="0" cellpadding="4">
        <thead>
            <tr>
                <th style="width:5px">N&deg;</th>
                <th style="text-align: center">NOMBRES Y APELLIDOS</th>
                <th style="text-align: center">N&deg; PIEZA</th>
                <th style="text-align: center">NACIONALIDAD</th>
                <th style="text-align: center">EDAD</th>
                <th style="text-align: center">SEXO</th>
                <th style="text-align: center">E.C.</th>
                <th style="text-align: center">PROFESION</th>
                <th style="text-align: center">PROCEDENCIA</th>
                <th style="text-align: center">FECHA DE INGRESO</th>
                <th style="text-align: center">FECHA DE SALIDA</th>
                <th style="text-align: center">MOTIVO DE VIAJE</th>
                <th style="text-align: center">C.I. Y/O PASAPORTE</th>
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
                        @foreach ($item->client as $client)
                            <small>{{$client->people->first_name}} {{$client->people->last_name}}</small>                                    
                        @endforeach
                    </td>
                    <td style="text-align: center">{{$item->number}}</td>
                    <td style="text-align: center">
                        @foreach ($item->client as $client)
                            @if ($client->people->nationality)
                                <small>{{$client->people->nationality->name}}</small>                            
                            @else
                                <small>SN</small>
                            @endif
                        @endforeach

                       
                    </td>
                    <td style="text-align: center">
                        @foreach ($item->client as $client)
                            @php
                                $now = \Carbon\Carbon::now();
                                $birthday = new \Carbon\Carbon($client->people->birth_date);
                                $age = $birthday->diffInYears($now);
                            @endphp               
                            {{ date('d/m/Y', strtotime($client->people->birth_date)) }} <br> <small>{{ $age }} años</small>                    
                        @endforeach                                
                    </td>
                    <td style="text-align: center">
                        @foreach ($item->client as $client)
                            <small>{{strtoupper($client->people->gender)}}</small>                                    
                        @endforeach
                    </td>

                    <td style="text-align: center">
                        @foreach ($item->client as $client)                                          
                            @if ($client->people->civilStatus)
                                <small>{{$client->people->civilStatus}}</small>                             
                            @else
                                <small>SN</small>
                            @endif                             
                        @endforeach
                    </td>


                    <td style="text-align: center">
                        @foreach ($item->client as $client)                                          
                            @if ($client->people->profession)
                                <small>{{$client->people->profession}}</small>                             
                            @else
                                <small>SN</small>
                            @endif                             
                        @endforeach
                    </td>
                    <td style="text-align: center">
                        @foreach ($item->client as $client)                                          
                            @if ($client->people->profession)
                                <small>{{$client->people->profession}}</small>                             
                            @else
                                <small>SN</small>
                            @endif                             
                        @endforeach
                    </td>
                    <td style="text-align: center">{{date('d/m/Y H:i:s', strtotime($item->start))}}</td>
                    <td style="text-align: center">{{date('d/m/Y H:i:s', strtotime($item->finish))}}</td>

                    <td style="text-align: center">{{ strtoupper($item->typeHospedaje)}}</td>
                    <td style="text-align: center">
                        @foreach ($item->client as $client)
                            <small>{{strtoupper($client->people->ci)}}</small>                                    
                        @endforeach
                    </td>                                                                              
                    
                </tr>
                @php
                    $count++;                         
                @endphp
                
            @empty
                <tr style="text-align: center">
                    <td colspan="13">No se encontraron registros.</td>
                </tr>
            @endforelse
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
