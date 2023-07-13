<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th style="text-align: center">Nro de Habitación</th>
                    <th style="text-align: center">Categoria</th>  
                    <th style="text-align: center">Planta</th>  
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @php
                    $i =0;
                @endphp
                @forelse ($data as $item)
                @php
                    $i++;
                @endphp
                <tr>
                    <td>{{$i}} {{$item->id}}</td>
                    <td style="text-align: center"><small>Nro. {{$item->numero}}</small></td>
                    <td style="text-align: center"> {{$item->category}}</td>
                    <td style="text-align: center"> {{$item->planta}}</td>
                    
                    
                    <td class="no-sort no-click bread-actions text-right">

                        <a href="{{ route('cleaning.show', ['cleaning' => $item->id]) }}" title="Ver Detalle" class="btn btn-sm btn-warning">
                            <i class="voyager-eye"></i><span class="hidden-xs hidden-sm"> Ver</span>
                        </a>

                        
                    </td>
                </tr>
                @empty
                    <tr>
                        <td style="text-align: center" valign="top" colspan="4" class="dataTables_empty">No hay datos disponibles en la tabla</td>
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