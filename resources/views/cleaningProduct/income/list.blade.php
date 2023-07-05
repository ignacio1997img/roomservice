<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>ID</th>
                    <th style="text-align: center">Numero Factura</th>
                    <th style="text-align: center">Fecha FActura</th>
                    <th style="text-align: center">Monto</th>    
                    <th style="text-align: center">Estado</th>    
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td><small>{{ $item->numberFactura?$item->numberFactura:'SN' }}</small></td>
                    <td>{{ $item->dateFactura?date("d-m-Y", strtotime($item->dateFactura)):'SN' }}</td>
                    <td style="text-align: right"> <small>Bs.</small> {{$item->amount}}</td>
                    <td style="text-align: right">
                        @if ($item->stock == 1)
                            <label class="label label-success">Con Stock</label>
                        @else
                            <label class="label label-danger">Sin Stock</label>
                        @endif     
                    </td>
                    <td class="no-sort no-click bread-actions text-right">
                        @if (auth()->user()->hasPermission('print_cleaningproducts'))
                            <a href="{{route('cleaningproducts.show',$item->id)}}" title="Ver" target="_blank" class="btn btn-sm btn-success view">
                                <i class="glyphicon glyphicon-print"></i>
                            </a>     
                        @endif
                        @if($item->status == 1)
                            {{-- <div class="btn-group" style="margin-right: 3px">
                                <button type="button" class="btn btn-info dropdown-toggle" data-toggle="dropdown">
                                    Mas <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" style="left: -90px !important">
                                    @if ($item->status == 'entregado' && $item->delivered == 'Si')
                                        <li><a href="{{ route('loans-list.transaction', ['loan'=>$item->id])}}" class="btn-transaction"  data-toggle="modal" title="Imprimir Calendario" ><i class="fa-solid fa-money-bill-transfer"></i> Transacciones</a></li> 
                                    @endif
                                    @if ($item->status != 'pendiente' && $item->status != 'verificado' && !auth()->user()->hasRole('cobrador'))
                                        <li><a href="{{ route('loans-print.calendar', ['loan'=>$item->id])}}" class="btn-rotation"  data-toggle="modal" target="_blank" title="Imprimir Calendario" ><i class="fa-solid fa-print"></i> Imprimir Calendario</a></li> 
                                    
                                        <li><a onclick="loan({{$item->id}})" class="btn-rotation"  data-toggle="modal" title="Imprimir Contrato" ><i class="fa-solid fa-print"></i> Imprimir Contrato</a></li>
                                        <li><a onclick="comprobanteDelivered({{$item->id}})" class="btn-rotation"  data-toggle="modal" title="Imprimir Comprobante de Entrega de Prestamos" ><i class="fa-solid fa-print"></i> Imprimir Comprobante Entrega</a></li>
                                    @endif                      
                                </ul>
                            </div> --}}
                        @endif
                    </td>
                    
                    
                </tr>
                @empty
                    <tr>
                        <td style="text-align: center" valign="top" colspan="6" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="col-md-12">
    <div class="col-md-4" style="overflow-x:auto">
        @if(count($data)>0)
            <p class="text-muted">Mostrando del {{$data->firstItem()}} al {{$data->lastItem()}} de {{$data->total()}} registros.</p>
        @endif
    </div>
    <div class="col-md-8" style="overflow-x:auto">
        <nav class="text-right">
            {{ $data->links() }}
        </nav>
    </div>
</div>

<script>
   
   var page = "{{ request('page') }}";
    $(document).ready(function(){
        $('.page-link').click(function(e){
            e.preventDefault();
            let link = $(this).attr('href');
            if(link){
                page = link.split('=')[1];
                list(page);
            }
        });
    });
</script>