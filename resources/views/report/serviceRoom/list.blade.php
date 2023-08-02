
<div class="col-md-12 text-right">

    {{-- <button type="button" onclick="report_excel()" class="btn btn-success"><i class="fa-solid fa-file-excel"></i> Excel</button> --}}
    <button type="button" onclick="report_print()" class="btn btn-dark"><i class="glyphicon glyphicon-print"></i> Imprimir</button>

</div>
<div class="col-md-12">
<div class="panel panel-bordered">
    <div class="panel-body">
        <div class="table-responsive">
            @forelse ($data as $item)
                <table id="dataTable" style="width:100%"  class="table table-bordered table-striped table-sm">
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
                            <td style="text-align: center">{{$item->number}}</td>
                            <td style="text-align: center">{{$item->category}}</td>
                            <td style="text-align: center">{{$item->facility}}</td>
                            <td style="text-align: center">{{date('d/m/Y H:i:s', strtotime($item->start))}}</td>
                            <td style="text-align: center">{{$item->finish?date('d/m/Y H:i:s', strtotime($item->finish)):'SN'}}</td>
                            <td style="text-align: center">{{$item->day}}</td>
                            <td style="text-align: right">{{ number_format($item->amountTotal, 2, ',', '.') }}</td>
                        </tr>
                    </tbody>
                    <tbody>
                        <tr>
                            <td colspan="7" style="text-align: center"><small style="font-size: 15px">Cliente/Personas Hospedada en la Habitacion N&deg; {{$item->number}}</small></td>
                        </tr>
                        @foreach ($item->client as $client)
                            <tr>
                                <th style="width:8%">NOMBRE</th>
                                <td colspan="3" style="text-align: left">{{$client->people->first_name}} {{$client->people->last_name}}</td>
                                <th style="width:8%">NACIONALIDAD</th>
                                <td colspan="2" style="text-align: left">{{$client->people->nationality?$client->people->nationality->name:'SN'}}</td>
                            </tr>
                            <tr>
                                <th style="width:8%">CI / PASAPORTE</th>
                                <td style="text-align: left">{{$client->people->ci}}</td>
                                <th style="width:8%">F. NACIMIENTO</th>
                                <td style="text-align: left">{{date('d/m/Y H:i:s', strtotime($client->people->birth_date))}}</td>
                                <th style="width:8%">CELULER</th>
                                <td style="text-align: left">{{$client->people->cell_phone??'SN'}}</td>

                                <td style="text-align: right">{{ number_format($item->amountTotal, 2, ',', '.') }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <br><br><br>
                
            @empty
                
            @endforelse
            
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function(){

})
</script>