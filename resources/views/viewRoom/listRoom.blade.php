@extends('voyager::master')

@section('content')
    <div class="page-content">
        {{-- @include('voyager::alerts')
        @include('voyager::dimmers') --}}
        
        <div class="analytics-container">
            <div class="row" style="text-align: center ">
                @forelse ($data as $item)
                    @php
                        $category =  \App\Models\CategoriesRoom::where('id', $item->categoryRoom_id)->first();
                        $aux =  \App\Models\CategoriesRoomsPart::where('categoryRoom_id', $item->categoryRoom_id)->where('deleted_at',null)->get();
                        $total =0;
                        foreach ($aux as $value) {
                            $total = $total + $value->amount;
                        }
                    @endphp
                    <div class="col-md-2" class="grid-block ">
                        {{-- <div class="col-md-3"></div> --}}
                        <div class="col-md-12" id="myDiv" style="margin-top: 1em; border-radius: 20px; height:300px; @if($item->status == 0) box-shadow: #F44E3E 0px 35px 60px -12px inset;@endif">
                            <br>
                            @php
                                if($item->status==0)
                                {
                                    $service =  \App\Models\ServiceRoom::where('room_id', $item->id)->where('status', 1)->first();  
                                }
                            @endphp
                            
                            <p style="font-size: 22px; color: #ffffff;"><small>Pieza N° {{$item->number}}</small></p>                            
                            @if ($item->status == 1)
                                <a href="{{route('view-planta.room', ['room'=>$item->id])}}" class="btn btn-success" data-toggle="modal">
                                    <i class="fa-solid fa-key" style="color:rgb(46, 46, 46)"></i> Asignar</span>
                                </a>     
                            @else
                                <small style="font-size: 10px; color: red">{{ date('d-m-Y h:i', strtotime($service->start)) }} <br> Hasta <br> {{ date('d-m-Y h:i', strtotime($service->finish)) }}</small>
                            @endif
                            <br>
                            @if ($item->status==1)
                                <small style="font-size: 20px; color: rgb(0, 0, 0)">Bs. {{$item->amount??0}}</small>
                            @else                                
                                <small style="font-size: 20px; color: rgb(0, 0, 0)">Bs. {{$service?$service->amount:0}}</small>                                
                            @endif
                            <br>
                            <small style="font-size: 15px; color: rgb(0, 0, 0)">Categoría: {{$category->name}}</small>
                            
                            @if ($item->status == 0)
                            <br>
                                <a href="{{route('view-planta.room', ['room'=>$item->id])}}" class="btn btn-dark" data-toggle="modal">
                                    <i class="fa-solid fa-eye"></i> Ver</span>
                                </a>     
                                <a href="#" data-toggle="modal" data-target="#modal_producto" title="Vender producto al almacen" class="btn btn-success">
                                    <i class="fa-solid fa-cart-shopping"></i>
                                </a>
                            @endif


                        </div>   
                        {{-- <div class="col-md-3"></div> --}}

                    </div>
                @empty
                    <tr style="text-align: center">
                        <td colspan="7" style="font-size: 50px" class="dataTables_empty">No hay habitaciones disponibles</td>
                    </tr>
                @endforelse
            </div>
        </div>


        <form lass="form-submit" id="irremovability-form" action="{{route('categories-rooms.store')}}" method="post">
            @csrf
            <div class="modal modal-success fade" id="modal_producto" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="voyager-categories"></i> Registrar Categoria</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label>Productos</label>
                                <select class="form-control" id="select_producto" required></select>
                            </div>
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="dataTable" class="tables table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px">N&deg;</th>
                                                <th style="text-align: center">Detalle</th>  
                                                <th style="text-align: center; width: 150px">Cantidad</th>  
                                                <th style="text-align: center; width: 150px">Precio</th>  
                                                <th width="15px">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-body">
                                            <tr id="tr-empty">
                                                <td colspan="5" style="height: 150px">
                                                    <h4 class="text-center text-muted" style="margin-top: 50px">
                                                        <i class="fa-solid fa-list" style="font-size: 50px"></i> <br><br>
                                                        Lista de detalle vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-success btn-submit" value="Guardar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
@stop
@section('css')
<style>
    div#myDiv{
        /* width:200px;
        height:200px; */
        background-image: url('https://us.123rf.com/450wm/photo5963/photo59631709/photo5963170900061/85635272-fondo-habitaci%C3%B3n-vac%C3%ADa.jpg');
        /* background-color: rgba(145, 12, 12, 0.4) !important; */
        /* box-shadow: 5px 5px 15px rgb(223, 5, 5); */
        /* box-shadow: 35px 15px 15px rgb(255, 114, 114) inset; */

        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;  
    }
    .select2{
            width: 100% !important;
        }
    
</style>

@stop

@section('javascript')
<script>
    $(document).ready(function(){
            var productSelected;

            $('#select_producto').select2({
            // tags: true,
                placeholder: '<i class="fa fa-search"></i> Buscar...',
                escapeMarkup : function(markup) {
                    return markup;
                },
                language: {
                    inputTooShort: function (data) {
                        return `Por favor ingrese ${data.minimum - data.input.length} o más caracteres`;
                    },
                    noResults: function () {
                        return `<i class="far fa-frown"></i> No hay resultados encontrados`;
                    }
                },
                quietMillis: 250,
                minimumInputLength: 2,
                ajax: {
                    url: "{{ url('admin/incomes/article/stock/ajax') }}",        
                    processResults: function (data) {
                        let results = [];
                        data.map(data =>{
                            results.push({
                                ...data,
                                disabled: false
                            });
                        });
                        return {
                            results
                        };
                    },
                    cache: true
                },
                templateResult: formatResultCustomers,
                templateSelection: (opt) => {
                    productSelected = opt;

                    
                    return opt.id?opt.article.name:'<i class="fa fa-search"></i> Buscar... ';
                }
            }).change(function(){
                // alert(2)
                if($('#select_producto option:selected').val()){
                    let product = productSelected;
                    if($('.tables').find(`#tr-item-${product.id}`).val() === undefined){
                    // alert(product.name);

                        $('#table-body').append(`
                            <tr class="tr-item" id="tr-item-${product.id}">
                                <td class="td-item"></td>
                                <td>
                                    <b class="label-description" id="description-${product.id}"><small>${product.name}</small>
                                    <input type="hidden" name="category[]" value="${product.id}" />
                                </td>
                                <td>
                                    <input type="number" name="price[]" min="0" step="1" id="select-price-${product.id}" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" onkeypress="return filterFloat(event,this);" style="text-align: right" class="form-control text" required>
                                </td>
                                <td class="text-right"><button type="button" onclick="removeTr(${product.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                            </tr>
                        `);
                    }else{
                        toastr.info('EL detalle ya está agregado', 'Información')
                    }
                    setNumber();
                }
            });
            

        })

        function formatResultCustomers(option){
        // Si está cargando mostrar texto de carga
            if (option.loading) {
                return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
            }
            // let image = "{{ asset('image/default.jpg') }}";
            // if(option.image){
            //     image = "{{ asset('storage') }}/"+option.image.replace('.', '-cropped.');
            //     // alert(image)
            // }
            
            // Mostrar las opciones encontradas
            return $(`  <div style="display: flex">
                            <div style="margin: 0px 10px">
                                <img src="" width="50px" />
                            </div>
                            <div>
                                <b style="font-size: 16px">${option.article.name} 
                            </div>
                        </div>`);
        }

        

        function setNumber(){
            var length = 0;
            $(".td-item").each(function(index) {
                $(this).text(index +1);
                length++;
            });

            if(length > 0){
                $('#tr-empty').css('display', 'none');
            }else{
                $('#tr-empty').fadeIn('fast');
            }
        }
        function removeTr(id){
            $(`#tr-item-${id}`).remove();
            $('#select_producto').val("").trigger("change");
        }
        
</script>
    

@stop
