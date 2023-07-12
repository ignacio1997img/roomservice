<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th>Nº</th>
                    <th style="text-align: center">Nombre</th>
                    <th style="text-align: center">Rol</th>  
                    <th style="text-align: center">Estado</th>    
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td>{{$item->id}}</td>
                    <td style="text-align: center"> {{$item->name}}</td>
                    <td style="text-align: center"> {{$item->role->name}}</td>
                    <td style="text-align: center">
                        @if ($item->status == 1)
                            <label class="label label-success">Activo</label>
                        @else
                            <label class="label label-danger">Inactivo</label>
                        @endif     
                    </td>
                    
                    <td class="no-sort no-click bread-actions text-right">
                        <a href="{{ route('cleaning-asignation-room.index', ['user_id' => $item->id]) }}" title="Ver" class="btn btn-sm btn-dark view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Habitaciones</span>
                        </a>
                        
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