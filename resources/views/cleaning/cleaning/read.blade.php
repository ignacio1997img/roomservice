@extends('voyager::master')

@section('page_title', 'Ver habitación asignada')
{{-- @if (auth()->user()->hasPermission('read_assign')) --}}

@section('page_header')


<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="panel panel-bordered">
                <div class="panel-body" style="padding: 0px">
                    <div class="col-md-8" style="padding: 0px">
                        <h1 id="titleHead" class="page-title">
                            <i class="fa-solid fa-broom-ball"></i> Detalle De la Habitacion Nro. {{$cleaning->room->number}}
                            
                        </h1>                            
                    </div>

                    <div class="col-md-4 text-right" style="margin-top: 30px">
                        <a href="{{ route('cleaning.index') }}" class="btn btn-warning">
                            <span class="glyphicon glyphicon-list"></span>&nbsp;
                            Volver
                        </a>
                        @if ($room->cleaning == 0)
                            <a href="#" class="btn btn-dark" data-toggle="modal" data-target="#start-modal">
                                <i class="fa-solid fa-broom-ball"></i> Limpiar
                            </a>
                        @endif                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Habitación</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p><small>Pieza N° {{ $room->number }}</small></p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-4">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Categoría</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p><small>{{ $room->caregoryroom->name }}</small></p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Planta de Hotel</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p><small>{{ $room->categoryfacility->name }}</small></p>
                            </div>
                            <hr style="margin:0;">
                        </div>  
                        
                        <div class="col-md-2">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha De Limpieza</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p><small>{{ date('d-m-Y') }}</small></p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
        @forelse ($data as $item)
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="row">
                            
                            <div class="col-md-3">
                                <div class="panel-heading" style="border-bottom:0;">
                                    <h3 class="panel-title">Iniciado Por</h3>
                                </div>
                                <div class="panel-body" style="padding-top:0;">
                                    <p><small>{{ $item->startUser->name }}</small></p>
                                    <p><small>{{ date('d-m-Y', strtotime($item->start)) }}</small></p>

                                </div>
                                <hr style="margin:0;">
                            </div>  

                            <div class="col-md-3">
                                <div class="panel-heading" style="border-bottom:0;">
                                    <h3 class="panel-title">Finalizado Por</h3>
                                </div>
                                <div class="panel-body" style="padding-top:0;">
                                    @if ($item->finish)
                                        <p><small>{{ $item->finishUser->name }}</small></p>
                                        <p><small>{{ date('d-m-Y', strtotime($item->finish)) }}</small></p>
                                    @else
                                        <p><small style="color: rgb(255, 0, 0); font-size: 15px">Sin</small></p>
                                        <p><small style="color: rgb(255, 0, 0); font-size: 15px">Finalizar</small></p>
                                    @endif

                                </div>
                                <hr style="margin:0;">
                            </div>  
                            <div class="col-md-6 text-right">
                                @if (!$item->finish)
                                    <a href="#" class="btn btn-success" data-toggle="modal" data-target="#modal_producto" data-id="{{$item->id}}">
                                        <i class="fa-solid fa-broom-ball"></i> Articulo / Producto
                                    </a>
                                    <a href="#" class="btn btn-danger" data-toggle="modal" data-target="#finish-modal" data-id="{{$item->id}}">
                                        <i class="fa-solid fa-clock"></i> Finalizar
                                    </a>
                                @endif
                            </div>  
                            
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th colspan="6" style="text-align: center">Artículo / Producto</th>
                                                </tr>
                                                <tr>
                                                    <th width="5%">N&deg;</th>
                                                    <th style="text-align: center">Artículo / Producto</th>
                                                    <th style="text-align: center">Cantidad</th>
                                                    <th style="text-align: center">Precio</th>
                                                    <th style="text-align: center">Total</th>
                                                    @if (!$item->finish)
                                                        <th width="5%" style="text-align: right">Acciones</th>
                                                    @endif
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @php
                                                    $i=0;
                                                @endphp
                                                @forelse ($item->cleaningRoomProduct as $product)
                                                    {{-- @dump($product); --}}
                                                    @php
                                                        $i++;
                                                    @endphp
                                                    <tr>
                                                        <td>{{$i}}</td>
                                                        <td style="text-align: center"><small>{{$product->article->name}}</small></td>
                                                        <td style="text-align: center"><small>{{$product->cant}}</small></td>
                                                        <td style="text-align: center"><small>{{ number_format($product->price, 2, ',', '.') }}</small></td>
                                                        <td style="text-align: center"><small>{{ number_format($product->cant * $product->price, 2, ',', '.') }}</small></td>

                                                        @if (!$item->finish)
                                                            <td class="no-sort no-click bread-actions text-right">
                                                                {{-- <button title="Borrar" class="btn btn-sm btn-danger delete" onclick="deleteItem('{{ route('cleaning-asignation-room.delete', ['id' => $item->id]) }}')" data-toggle="modal" data-target="#delete-modal">
                                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm"></span>
                                                                </button>  --}}
                                                                <button title="Borrar" class="btn btn-sm btn-danger delete"  data-toggle="modal" data-target="#delete-modal">
                                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm"></span>
                                                                </button>                                                               
                                                            </td>
                                                        @endif
                                                    </tr>
                                                @empty
                                                    <tr>
                                                        <td style="text-align: center" valign="top" @if (!$item->finish)  colspan="6" @else colspan="5" @endif class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                                    </tr>
                                                @endforelse                                                
                                            </tbody>
                                        </table>
                                    </div>                            
                                </div>                            
                            </div> 
                            
                        </div>
                    </div>
                </div>
            </div>

        @empty
            <div class="row">
                <div class="col-md-12">
                    <div class="panel panel-bordered">
                        <div class="panel-body">
                            <h1 class="text-center">No se ha realizado la limpieza el dia de hoy</h1>
                        </div>
                    </div>
                </div>
            </div>
        @endforelse 
    </div>


    {{-- Para vender productos del almacen --}}
    <form lass="form-submit" id="irremovability-form" action="{{route('cleaning-room-product.store')}}" method="post">
        @csrf
        <div class="modal modal-success fade" id="modal_producto" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-categories"></i> Agregar Productos</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            {{-- <small id="label-pieza" style="font-size: 15px"></small> --}}
                            <input type="hidden" name="room_id" value="{{$room->id}}">
                            <input type="hidden" name="cleaning_id" value="{{$cleaning->id}}">
                            <input type="hidden" name="id" id="id">
                        </div>
                        <div class="form-group">
                            <label>Productos</label>
                            <select class="form-control" id="select_producto"></select>
                        </div>
                        <div class="form-group">
                            <div class="table-responsive">
                                <table id="dataTable" class="tables table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">N&deg;</th>
                                            <th style="text-align: center">Detalle</th>  
                                            <th style="text-align: center; width: 80px">Precio</th>  
                                            <th style="text-align: center; width: 80px">Cantidad</th>  
                                            <th style="text-align: center; width: 80px">Sub Total</th>
                                            <th width="15px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        <tr id="tr-empty">
                                            <td colspan="6" style="height: 150px">
                                                <h4 class="text-center text-muted" style="margin-top: 50px">
                                                    <i class="fa-solid fa-list" style="font-size: 50px"></i> <br><br>
                                                    Lista de detalle vacía
                                                </h4>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tr>
                                        <td colspan="4" style="text-align: right">
                                            Total
                                        </td>
                                        <td style="text-align: right">
                                            <small>Bs.</small> <b id="label-total">0.00</b>
                                            <input type="hidden" name="amount" id="input-total" value="0">
                                        </td>
                                        <td></td>
                                    </tr>
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


    <form action="{{ route('cleaning.start') }}" id="form-create-customer" method="POST">
    @csrf  
        <div class="modal modal-primary fade" data-backdrop="static" tabindex="-1" id="start-modal" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa-solid fa-broom-ball"></i> Iniciar Limpieza</h4>
                    </div>
                    <div class="modal-footer">
                        <input type="hidden" name="cleaning_id" value="{{$cleaning->id}}">
                        <input type="hidden" name="room_id" value="{{$room->id}}">
                            <div class="text-center" style="text-transform:uppercase">
                                <i class="fa-solid fa-clock" style="color: #353d47; font-size: 5em;"></i>
                                <br>
                                    
                                <p><b>Desea iniciar la limpieza?</b></p>
                            </div>
                        <input type="submit" class="btn btn-dark pull-right delete-confirm" value="Sí, iniciar">
                        <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

        <form action="{{ route('cleaning.finish') }}" id="form-create-customer" method="POST">
            @csrf  
            <div class="modal modal-danger fade" data-backdrop="static" tabindex="-1" id="finish-modal" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-solid fa-broom-ball"></i> Finalizar Limpieza</h4>
                        </div>
                        <div class="modal-footer">
                            


                            <input type="text" name="room_id" value="{{$room->id}}">
                            <input type="text" name="cleaning_id" value="{{$cleaning->id}}">
                            <input type="text" name="id" id="id">


                                <div class="text-center" style="text-transform:uppercase">
                                    <i class="fa-solid fa-clock" style="color: #353d47; font-size: 5em;"></i>
                                    <br>
                                        
                                    <p><b>Desea finalizar la limpieza?</b></p>
                                </div>
                            <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Sí, finalizar">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>









    {{-- <form action="{{ route('serviceroom-hospedaje.addmoney') }}" id="form-create-customer" method="POST">
        @csrf                    
        <div class="modal fade" tabindex="-1" id="modal-create-customer" role="dialog">
            <div class="modal-dialog modal-success">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa-solid fa-money-bill"></i> Adicionar Pago</h4>
                    </div>
                    <div class="modal-body">                       
                        <div class="form-group col-md-12">
                            <label for="full_name">Monto</label>
                            <input type="number" style="text-align: right" name="amount" min="0.1" step="0.1" class="form-control" placeholder="0.0" required>
                        </div>

                        <div class="form-group col-md-12">
                            <input type="radio" id="html" name="qr" value="0" checked>
                            <label for="html"><small style="font-size: 15px">Efectivo</small></label>
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                            <input type="radio" id="css" name="qr" value="1">
                            <label for="css"><small style="font-size: 15px">QR</small></label>
                        </div>    
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                        <input type="submit" class="btn btn-success btn-save-customer" value="Guardar">
                    </div>
                </div>
            </div>
        </div>
    </form> --}}
@stop

@section('css')
<style>
    .select2{
            width: 100% !important;
        }
    
</style>

@stop

@section('javascript')
<script src="{{ url('js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>    
    <script>
        $('#modal_producto').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-body #id').val(id);

            $('#table-body').empty();
            $('#select_producto').val("").trigger("change");

        })
        $('#finish-modal').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var modal = $(this);
            modal.find('.modal-footer #id').val(id);
        })

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
                    url: "{{ url('admin/cleaning/article/stock/ajax') }}",        
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
                if($('#select_producto option:selected').val()){
                    let product = productSelected;
                    if($('.tables').find(`#tr-item-${product.id}`).val() === undefined){

                        $('#table-body').append(`
                            <tr class="tr-item" id="tr-item-${product.id}">
                                <td class="td-item"></td>
                                <td>
                                    <b class="label-description" id="description-${product.id}"><small>${product.article.name}</small><br>
                                    <input type="hidden" name="income[]" value="${product.article.id}" />
                                </td>
                                <td style="text-align: right">
                                    <b class="label-description"><small>Bs. ${product.price}</small>
                                    <input type="hidden" name="price[]" id="select-price-${product.id}" value="${product.price}" />
                                </td>
                                <td>
                                    <input type="number" name="cant[]" min="0" max="${product.cantRestante}" step="1" id="select-cant-${product.id}" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" onkeypress="return filterFloat(event,this);" style="text-align: right" class="form-control text" required>
                                </td>
                                <td class="text-right"><h4 class="label-subtotal" id="label-subtotal-${product.id}">0</h4></td>
                                <td class="text-right"><button type="button" onclick="removeTr(${product.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                            </tr>
                        `);
                    }else{
                        toastr.info('EL detalle ya está agregado', 'Información')
                    }
                    setNumber();
                    getSubtotal(product.id);
                }
            });           
        })
        function formatResultCustomers(option){
        // Si está cargando mostrar texto de carga
            if (option.loading) {
                return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
            }
            let image = "{{ asset('image/default.jpg') }}";
            if(option.article.image){
                image = "{{ asset('storage') }}/"+option.article.image.replace('.', '-cropped.');
                // alert(image)
            }
            
            // ${ option.expiration? '<small style="color: red">Expira: '+ moment(option.expiration).format('DD-MM-YYYY')+'</small>':''}
            // Mostrar las opciones encontradas
            return $(`  <div style="display: flex">
                            <div style="margin: 0px 10px">
                                <img src="${image}" width="50px" />
                            </div>
                            <div>
                                <b style="font-size: 16px">${option.article.name} </b> <br>
                                <small>Stock: </small>${option.cantRestante}<br>
                                <small>Precio: </small>Bs. ${option.price}<br>
                                
                            </div>
                        </div>`);
        }


        // Para los articulos
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
        function getSubtotal(id){
                let price = $(`#select-price-${id}`).val() ? parseFloat($(`#select-price-${id}`).val()) : 0;
                let quantity = $(`#select-cant-${id}`).val() ? parseFloat($(`#select-cant-${id}`).val()) : 0;
                $(`#label-subtotal-${id}`).text((price * quantity).toFixed(2));
                getTotal();
        }
        function getTotal(){
                let total = 0;
                $(".label-subtotal").each(function(index) {
                    total += parseFloat($(this).text());
                });
                $('#label-total').text(total.toFixed(2));
                $('#input-total').val(total.toFixed(2));
        }
        function removeTr(id){
            $(`#tr-item-${id}`).remove();
            $('#select_producto').val("").trigger("change");
            setNumber();
            getTotal();
        }

            
    </script>
@stop
{{-- @endif --}}
