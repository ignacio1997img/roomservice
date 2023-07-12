<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    {{-- <th>ID</th> --}}
                    <th style="text-align: center">Nombre / Nro de Habitación</th>                    
                    <th width="10%" style="text-align: center">Fecha Hora de Compra.</th>
                    <th width="10%" style="text-align: center">Monto</th>
                    <th width="5%" class="text-right">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>    
                    <td>
                        <table>
                            @php
                                $image = asset('image/default.jpg');
                                if($item->people_id){
                                    if($item->people->image){
                                        $image = asset('storage/'.str_replace('.', '-cropped.', $item->people->image));
                                    }
                                }
                                $now = \Carbon\Carbon::now();
                               
                            @endphp
                            <tr>
                                <td ><img src="{{ $image }}" style="width: 60px; height: 60px; border-radius: 30px; margin-right: 10px"></td>
                                <td>
                                    
                                    @if ($item->people_id)
                                        <small>CI / PASS. </small>{{ $item->people->ci??'SN' }}
                                        <br>
                                        {{ strtoupper($item->people->first_name) }} {{ strtoupper($item->people->last_name) }}

                                        @if ($item->serviceRoom_id)<br>
                                            <small style="color: red">PIEZA N°. {{ $item->serviceroom->number }}</small>
                                        @endif
                                    @else
                                        <Small>SN</Small>
                                    @endif
                                    
                                    
                                </td>
                                
                            </tr>
                        </table>
                    </td>
                    <td style="text-align: center">{{ date('d-m-Y H:m:s', strtotime($item->created_at)) }} <br> <small>{{\Carbon\Carbon::parse($item->created_at)->diffForHumans()}}.</small> </td>
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