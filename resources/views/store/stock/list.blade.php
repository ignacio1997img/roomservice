<div class="col-md-12">
    <div class="table-responsive">
        <table id="dataTable" class="table table-bordered table-hover">
            <thead>
                <tr>
                    <th style="text-align: center">Categoría</th>
                    <th style="text-align: center">Article</th>
                    <th style="text-align: center">Cantidad Disponible</th>    
                    <th style="text-align: center">Precio</th>    
                    <th style="text-align: center">Total</th>    
                </tr>
            </thead>
            <tbody>
                @forelse ($data as $item)
                <tr>
                    <td>{{ $item->article->category->name }}</td>
                    <td>{{ $item->article->name }}</td>
                    <td style="text-align: right">{{ number_format($item->stock, 2, ',', '.') }}</td>
                    <td style="text-align: right">{{ number_format($item->price, 2, ',', '.') }}</td>
                    <td style="text-align: right"><small>Bs.</small> {{ number_format(($item->stock*$item->price), 2, ',', '.') }}</td>
                    
                  
                    
                    
                </tr>
                @empty
                    <tr>
                        <td style="text-align: center" valign="top" colspan="5" class="dataTables_empty">No hay datos disponibles en la tabla</td>
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