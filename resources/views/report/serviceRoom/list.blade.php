
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

                        </tr>
                    </tbody>
                </table>
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