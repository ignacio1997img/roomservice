
<div class="col-md-12 text-right">

    {{-- <button type="button" onclick="report_excel()" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button> --}}
    <button type="button" onclick="report_print()" class="btn btn-dark"><i class="glyphicon glyphicon-print"></i> Imprimir</button>

</div>
<div class="col-md-12">
<div class="panel panel-bordered">
    <div class="panel-body">
        <div class="table-responsive">
            <table id="dataTable" style="width:100%"  class="table table-bordered table-striped table-sm">
                <thead>
                    <tr>
                        <th rowspan="2" style="width:5px">N&deg;</th>
                        <th rowspan="2" style="text-align: center">NOMBRES Y APELLIDOS</th>
                        <th rowspan="2" style="text-align: center">N&deg; PIEZA</th>
                        <th rowspan="2" style="text-align: center">NACIONALIDAD</th>
                        <th rowspan="2" style="text-align: center">EDAD</th>
                        <th rowspan="2" style="text-align: center">SEXO</th>
                        <th rowspan="2" style="text-align: center">E.C.</th>
                        <th rowspan="2" style="text-align: center">PROFESION</th>
                        <th rowspan="2" style="text-align: center">FECHA DE INGRESO</th>
                        <th rowspan="2" style="text-align: center">FECHA DE SALIDA</th>
                        <th colspan="2" style="text-align: center">MOTIVO DE VIAJE</th>
                        <th rowspan="2" style="text-align: center">C.I. Y/O PASAPORTE</th>
                    </tr>

                    <tr>
                        <th style="text-align: center">TRABAJO</th>
                        <th style="text-align: center">TURISMO</th>
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
                            <td style="text-align: center">{{date('d/m/Y H:i:s', strtotime($item->created_at))}}</td>
                            <td style="text-align: center">{{ $item->name}}</td>
                            <td style="text-align: right"><small>{{ number_format($item->cantSolicitada,2, ',', '.') }}</small></td>
                            <td style="text-align: right"><small>{{ number_format($item->price,2, ',', '.') }}</small></td>
                            <td style="text-align: right"><small>{{ number_format(($item->cantSolicitada * $item->price),2, ',', '.') }}</small></td>                                                                                
                            
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
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function(){

})
</script>