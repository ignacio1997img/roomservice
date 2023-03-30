
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
        </div>
    </div>
</div>
</div>

<script>
$(document).ready(function(){

})
</script>