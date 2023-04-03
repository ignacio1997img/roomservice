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
                        <div class="col-md-12" id="myDiv" style="margin-top: 1em; border-radius: 20px; height:320px; @if($item->status == 0) box-shadow: #F44E3E 0px 35px 60px -12px inset;@endif">
                            <br>
                            @php
                                if($item->status==0)
                                {
                                    $service =  \App\Models\ServiceRoom::where('room_id', $item->id)->where('status', 1)->where('deleted_at',null)->first();  
                                    $egre = \DB::table('egres as e')
                                            ->join('egres_deatils as d', 'd.egre_id', 'e.id')
                                            ->join('articles as a', 'a.id', 'd.article_id')
                                            ->where('e.serviceRoom_id', $service->id)
                                            ->where('e.sale', 1)
                                            ->where('e.deleted_at', null)
                                            ->where('d.deleted_at', null)
                                            // ->where('d.sale', 1)

                                            ->select('a.name', 'd.article_id', 'd.egre_id',  'd.price','d.amount')->groupBy('name', 'article_id', 'egre_id', 'price')->get();
                                    $totalaux = $egre->SUM('amount');


                                    $menu = DB::table('egres as e')
                                            ->join('egres_menus as d', 'd.egre_id', 'e.id')
                                            ->join('food as f', 'f.id', 'd.food_id')
                                            ->where('e.serviceRoom_id', $service->id)
                                            ->where('e.sale', 1)
                                            ->where('e.deleted_at', null)
                                            ->where('d.deleted_at', null)
                                            ->select('f.name', 'd.cant',  'd.price', 'd.amount')->get();
                                    $totalMenu = $menu->SUM('amount');
                                    // $menu =  \App\Models\EgresMenu::where('serviceRoom_id', $service->id)->where('deleted_at',null)->get()->SUM('amount');
                                    // dd($menu);
                                }
                            @endphp
                            
                            <p style="font-size: 22px; color: #ffffff;"><small>Pieza N° {{$item->number}}</small></p>                            
                            @if ($item->status == 1)
                                @if (auth()->user()->hasPermission('add_assign'))
                                    <a href="{{route('view-planta.room', ['room'=>$item->id])}}" class="btn btn-success" data-toggle="modal">
                                        <i class="fa-solid fa-key" style="color:rgb(46, 46, 46)"></i> Asignar</span>
                                    </a>     
                                @endif
                            @else
                                <small style="font-size: 10px; color: red">{{ date('d-m-Y h:i', strtotime($service->start)) }} <br> Hasta <br> {{ date('d-m-Y h:i', strtotime($service->finish)) }}</small>
                            @endif
                            <br>
                            @if ($item->status==1)
                                <small style="font-size: 20px; color: rgb(0, 0, 0)">Bs. {{$item->amount??0}}</small>
                            @else  

                                <small style="font-size: 20px; color: rgb(0, 0, 0)">Bs. {{$service?$service->amount+$totalaux+$totalMenu:0}}</small>                                
                            @endif
                            <br>
                            <small style="font-size: 15px; color: rgb(0, 0, 0)">Categoría: {{$category->name}}</small>
                            
                            @if ($item->status == 0)
                            <br>
                                @if (auth()->user()->hasPermission('read_assign'))
                                    <a href="{{route('view-planta-room.read', ['room'=>$item->id])}}" class="btn btn-dark" data-toggle="modal">
                                        <i class="fa-solid fa-eye"></i> Ver</span>
                                    </a>     
                                @endif
                                @if (auth()->user()->hasPermission('add_product'))
                                    <a href="#" data-toggle="modal" data-target="#modal_producto" data-id="{{$item->id}}" data-pieza="{{$item->number}}" data-planta="{{$item->categoryFacility_id}}" title="Vender producto al almacen" class="btn btn-success">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->hasPermission('add_food'))
                                    <a href="#" data-toggle="modal" data-target="#modal_menu" data-id="{{$item->id}}" data-pieza="{{$item->number}}" data-planta="{{$item->categoryFacility_id}}" title="Comidas del menú" class="btn btn-primary">
                                        <i class="fa-solid fa-bowl-food"></i>
                                    </a>
                                @endif
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

        {{-- Para vender productos del almacen --}}
        <form lass="form-submit" id="irremovability-form" action="{{route('serviceroom-article.store')}}" method="post">
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
                                <small id="label-pieza" style="font-size: 15px"></small>
                                <input type="hidden" name="room_id" id="room_id">
                                <input type="hidden" name="planta_id" id="planta_id">
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

        {{-- para la venta de comidas ala pieza o habitacion --}}

        <form lass="form-submit" id="menu-form" action="{{route('serviceroom-foodmenu.store')}}" method="post">
            @csrf
            <div class="modal  fade" id="modal_menu" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-primary">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-solid fa-bowl-food"></i> Menú del Día</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <small id="label-pieza" style="font-size: 15px"></small>
                                <input type="hidden" name="room_id" id="room_id">
                                <input type="hidden" name="planta_id" id="planta_id">
                            </div>
                            <div class="form-group">
                                <label>Menú</label>
                                <select class="form-control" id="select_menu"></select>
                            </div>
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="dataTable" class="tables tablesMenu table-bordered table-hover">
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
                                        <tbody id="table-bodyMenu">
                                            <tr id="tr-emptyMenu">
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
                                                <small>Bs.</small> <b id="label-totalMenu">0.00</b>
                                                <input type="hidden" name="amount" id="input-totalMenu" value="0">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary btn-submit" value="Guardar">
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
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

<script>

        $('#modal_producto').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var pieza = button.data('pieza');
            var planta = button.data('planta');
            var modal = $(this);
            modal.find('.modal-body #room_id').val(id);
            modal.find('.modal-body #planta_id').val(planta);
            modal.find('.modal-body #label-pieza').text('Pieza N° '+pieza);

            $('#table-body').empty();

            $('#label-total').text(0);
            $('#input-total').val(0)
            $('#select_producto').val("").trigger("change");

        })

        $('#modal_menu').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var pieza = button.data('pieza');
            var planta = button.data('planta');
            var modal = $(this);
            modal.find('.modal-body #room_id').val(id);
            modal.find('.modal-body #planta_id').val(planta);
            modal.find('.modal-body #label-pieza').text('Pieza N° '+pieza);

            $('#table-bodyMenu').empty();

            $('#label-totalMenu').text(0);
            $('#input-totalMenu').val(0)
            $('#select_menu').val("").trigger("change");
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
                                    <b class="label-description" id="description-${product.id}"><small>${product.article.name}</small><br>
                                    <b class="label-description"><small> ${ product.expiration? 'Expira: '+ moment(product.expiration).format('DD-MM-YYYY'):''}</small>
                                    <input type="hidden" name="income[]" value="${product.article.id}" />
                                    <input type="hidden" name="expiration[]" value="${product.expiration}" />
                                </td>
                                <td style="text-align: right">
                                    <b class="label-description"><small>Bs. ${product.price}</small>
                                    <input type="hidden" name="price[]" id="select-price-${product.id}" value="${product.price}" />
                                </td>
                                <td>
                                    <input type="number" name="cant[]" min="0" max="${product.cantRestante}"  id="select-cant-${product.id}" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" onkeypress="return filterFloat(event,this);" style="text-align: right" class="form-control text" required>
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


            //para la seleccion del menu del dia
            $('#select_menu').select2({
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
                    url: "{{ url('admin/food/menu/list/ajax') }}",        
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
                templateResult: formatResultMenu,
                templateSelection: (opt) => {
                    productSelected = opt;

                    
                    return opt.id?opt.food.name:'<i class="fa fa-search"></i> Buscar... ';
                }
            }).change(function(){
                // alert(1)
                if($('#select_menu option:selected').val()){
                    let product = productSelected;
                    if($('.tablesMenu').find(`#tr-item-menu-${product.id}`).val() === undefined){
                    // alert(product.name);

                        $('#table-bodyMenu').append(`
                            <tr class="tr-item" id="tr-item-menu-${product.id}">
                                <td class="td-itemMenu"></td>
                                <td>
                                    <b class="label-description" id="description-${product.id}"><small>${product.food.name}</small><br>
                                    <input type="hidden" name="food[]" value="${product.food.id}" />
                                </td>
                                <td style="text-align: right">
                                    <b class="label-description"><small>Bs. ${product.amount}</small>
                                    <input type="hidden" name="price[]" id="select-amount-${product.id}" value="${product.amount}" />
                                </td>
                                <td>
                                    <input type="number" name="cant[]" min="0"  id="select-cant-menu-${product.id}" onkeyup="getSubtotalMenu(${product.id})" onchange="getSubtotalMenu(${product.id})" onkeypress="return filterFloat(event,this);" style="text-align: right" class="form-control text" required>
                                </td>
                                <td class="text-right"><h4 class="label-subtotal-menu" id="label-subtotal-menu-${product.id}">0</h4></td>
                                <td class="text-right"><button type="button" onclick="removeTrMenu(${product.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                            </tr>
                        `);
                    }else{
                        toastr.info('EL detalle ya está agregado', 'Información')
                    }
                    setNumberMenu();
                    getSubtotalMenu(product.id);
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
            
            // Mostrar las opciones encontradas
            return $(`  <div style="display: flex">
                            <div style="margin: 0px 10px">
                                <img src="${image}" width="50px" />
                            </div>
                            <div>
                                <b style="font-size: 16px">${option.article.name} </b> <br>
                                <small>Stock: </small>${option.cantRestante}<br>
                                <small>Precio: </small>Bs. ${option.price}<br>
                                ${ option.expiration? '<small style="color: red">Expira: '+ moment(option.expiration).format('DD-MM-YYYY')+'</small>':''}
                            </div>
                        </div>`);
        }

        function formatResultMenu(option){
        // Si está cargando mostrar texto de carga
            if (option.loading) {
                return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
            }
            let image = "{{ asset('image/default.jpg') }}";
            if(option.food.image){
                image = "{{ asset('storage') }}/"+option.food.image.replace('.', '-cropped.');
                // alert(image)
            }
            
            // Mostrar las opciones encontradas
            return $(`  <div style="display: flex">
                            <div style="margin: 0px 10px">
                                <img src="${image}" width="50px" />
                            </div>
                            <div>
                                <b style="font-size: 16px">${option.food.name} </b> <br>
                                <small>Precio: </small>Bs. ${option.amount}
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

        //para la opcion de menu
        function setNumberMenu(){
            var length = 0;
            $(".td-itemMenu").each(function(index) {
                $(this).text(index +1);
                length++;
            });

            if(length > 0){
                $('#tr-emptyMenu').css('display', 'none');
            }else{
                $('#tr-emptyMenu').fadeIn('fast');
            }
        }

        function getSubtotalMenu(id){
                let price = $(`#select-amount-${id}`).val() ? parseFloat($(`#select-amount-${id}`).val()) : 0;
                let quantity = $(`#select-cant-menu-${id}`).val() ? parseFloat($(`#select-cant-menu-${id}`).val()) : 0;
                $(`#label-subtotal-menu-${id}`).text((price * quantity).toFixed(2));
                getTotalMenu();
        }
        function getTotalMenu(){
                let total = 0;
                $(".label-subtotal-menu").each(function(index) {
                    total += parseFloat($(this).text());
                });
                $('#label-totalMenu').text(total.toFixed(2));
                $('#input-totalMenu').val(total.toFixed(2));
        }
        function removeTrMenu(id){
            $(`#tr-item-menu-${id}`).remove();
            $('#select_menu').val("").trigger("change");
            setNumberMenu();
            getTotalMenu();
        }
        
</script>
    

@stop
