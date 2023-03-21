<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="width: 100px">N° de Habitacion</th>                    
                    <th>Categorria</th>
                    <th>Planta</th>
                    {{-- <th>Estado</th> --}}
                    <th style="width: 200px" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>                    
                    <td><small>Pieza N° </small>{{ $item->number }}</td>
                    <td>{{ $item->caregoryroom->name }}</td>
                    <td>{{ $item->categoryfacility->name }}</td>
                    <td class="no-sort no-click bread-actions text-right">
                       
                        <a href="{{ route('voyager.categories-rooms.show', ['room' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                        </a>
                        <button title="Borrar" class="btn btn-sm btn-danger delete" onclick="deleteItem('{{ route('room.destroy', ['room' => $item->id]) }}')" data-toggle="modal" data-target="#delete-modal">
                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                        </button>
                    </td>
                </tr>
                @empty
                    <tr style="text-align: center">
                        <td colspan="4" class="dataTables_empty">No hay datos disponibles en la tabla</td>
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