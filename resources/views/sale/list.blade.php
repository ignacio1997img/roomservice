<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th>Nombre completo</th>                    
                    <th>Fecha Hora de Compra.</th>
                    <th>Monto</th>
                    <th class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>    
                    <td>
                        <table>
                            @php
                                $image = asset('image/default.jpg');
                                if($item->people->image){
                                    $image = asset('storage/'.str_replace('.', '-cropped.', $item->people->image));
                                }
                                $now = \Carbon\Carbon::now();
                               
                            @endphp
                            <tr>
                                <td><img src="{{ $image }}" alt="{{ $item->people->first_name }} " style="width: 60px; height: 60px; border-radius: 30px; margin-right: 10px"></td>
                                <td>
                                    <small>CI / PASS. </small>{{ $item->people->ci }}
                                        <br>
                                    {{ strtoupper($item->people->first_name) }} {{ strtoupper($item->people->last_name) }}
                                    @if ($item->serviceRoom_id)<br>
                                        <small style="color: red">PIEZA N°. {{ $item->serviceroom->number }}</small>
                                    @endif
                                </td>
                                
                            </tr>
                        </table>
                    </td>
                    <td>{{ date('d/m/Y', strtotime($item->created_at)) }} </td>
                    <td style="text-align: right"><small>Bs. {{ number_format($item->amount,2, ',', '.') }}</small></td>
                    <td class="no-sort no-click bread-actions text-right">
                        @if (auth()->user()->hasPermission('print_sales'))                    
                            <a href="{{ route('voyager.people.show', ['id' => $item->id]) }}" title="Imprimir" class="btn btn-sm btn-dark view">
                                <i class="fa-solid fa-print"></i>
                            </a>
                        @endif
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