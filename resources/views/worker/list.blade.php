<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Nombre completo</th>                    
                    <th>Fecha nac.</th>
                    <th>Telefono</th>
                    <th>Estado</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    {{-- <td>{{ $item->id }}</td> --}}
                    <td>
                        <table>
                            @php
                                $image = asset('image/default.jpg');
                                if($item->people->image){
                                    $image = asset('storage/'.str_replace('.', '-cropped.', $item->people->image));
                                }
                                $now = \Carbon\Carbon::now();
                                $birthday = new \Carbon\Carbon($item->people->birth_date);
                                $age = $birthday->diffInYears($now);
                            @endphp
                            <tr>
                                <td><img src="{{ $image }}" alt="{{ $item->people->first_name }} " style="width: 60px; height: 60px; border-radius: 30px; margin-right: 10px"></td>
                                <td>
                                    <small>CI. </small>{{ $item->people->ci }}
                                        <br>
                                    {{ strtoupper($item->people->first_name) }} {{ strtoupper($item->people->last_name) }}
                                </td>
                            </tr>
                        </table>
                    </td>
                    <td>{{ date('d/m/Y', strtotime($item->people->birth_date)) }} <br> <small>{{ $age }} años</small> </td>
                    <td>{{ $item->people->cell_phone?$item->people->cell_phone:'SN' }}</td>
                    <td style="text-align: center">
                        @if ($item->status==1)
                            <label class="label label-success">Activo</label>
                        @endif
                        @if ($item->status==0)
                            <label class="label label-warning">Inactivo</label>
                        @endif                       
                    </td>
                    <td class="no-sort no-click bread-actions text-right">
                       
                        <a href="{{ route('worker.show', ['worker' => $item->id]) }}" title="Ver" class="btn btn-sm btn-warning view">
                            <i class="voyager-eye"></i> <span class="hidden-xs hidden-sm">Ver</span>
                        </a>
                        <button title="Borrar" class="btn btn-sm btn-danger delete" onclick="deleteItem('{{ route('worker.destroy', ['worker' => $item->id]) }}')" data-toggle="modal" data-target="#delete-modal">
                            <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                        </button>
                    </td>
                </tr>
                @empty
                    <tr style="text-align: center">
                        <td colspan="7" class="dataTables_empty">No hay datos disponibles en la tabla</td>
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