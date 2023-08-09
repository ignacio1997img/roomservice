
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
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function(){

})
</script>