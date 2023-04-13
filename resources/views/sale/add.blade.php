@extends('voyager::master')

@section('page_title', 'Registar Ventas')

@if (auth()->user()->hasPermission('add_sales'))


    @section('page_header')
        <h1 id="titleHead" class="page-title">
            <i class="fa-sharp fa-solid fa-cart-shopping"></i> Registar Ventas
        </h1>
        <a href="{{ route('sales.index') }}" class="btn btn-warning">
            <i class="fa-solid fa-rotate-left"></i> <span>Volver</span>
        </a>
    @stop

    @section('content')
        <div class="page-content edit-add container-fluid">    
            <form id="agent" action="{{route('serviceroom-article.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="product_id">Buscar producto</label>
                                        <select class="form-control" id="select_producto"></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-hover">
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
                                                    <td colspan="6" style="height: 290px">
                                                        <h4 class="text-center text-muted" style="margin-top: 50px">
                                                            <i class="glyphicon glyphicon-shopping-cart" style="font-size: 50px"></i> <br><br>
                                                            Lista de venta vacía
                                                        </h4>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                </div>                               
                                
                            </div>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="panel panel-bordered">
                            <div class="panel-body" style="padding-bottom: 0px">
                                <div class="form-group col-md-12">
                                    <label for="customer_id">Cliente</label>
                                    <div class="input-group">
                                        <select name="people_id" class="form-control" id="select_people_id" required></select>
                                        <span class="input-group-btn">
                                            <button class="btn btn-primary" title="Nueva persona" data-target="#modal-create-customer" data-toggle="modal" style="margin: 0px" type="button">
                                                <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                            </button>
                                        </span>
                                    </div>
                                </div>
                               
                                <div class="form-group col-md-4">
                                    <div class="checkbox">
                                        <label><input type="checkbox" id="checkbox-proforma" name="proforma" value="1" required>Aceptar</label>
                                    </div>
                                </div>
                                <div class="form-group col-md-8">
                                    <h2 class="text-right"><small>Total: Bs.</small> <b id="label-total">0.00</b></h2>
                                    <input type="hidden" name="amount" id="input-total" value="0">
                                </div>
                                <div class="form-group col-md-12 text-center">
                                    <button type="submit" id="btn-submit" class="btn btn-primary btn-block">Registrar <i class="voyager-basket"></i></button>
                                    <a href="{{ route('incomes.index') }}" >Volver a la lista</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>    
            </form>              
        </div>

        <form action="{{ url('admin/people/store') }}" id="form-create-customer" method="POST">
            <div class="modal fade" tabindex="-1" id="modal-create-customer" role="dialog">
                <div class="modal-dialog modal-primary">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-solid fa-person"></i> Registrar Persona</h4>
                        </div>
                        <div class="modal-body">
                            @csrf
                            {{-- <div class="form-group">
                                <label for="full_name">Nombre completo</label>
                                <input type="text" name="full_name" class="form-control" placeholder="Juan Perez" required>
                            </div> --}}
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="full_name">Nombre</label>
                                    <input type="text" name="first_name" class="form-control" placeholder="Nombre." required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="full_name">Apellido</label>
                                    <input type="text" name="last_name" class="form-control" placeholder="Apellido." required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="full_name">CI / Pasaporte</label>
                                    <input type="text" name="ci" class="form-control" placeholder="123456789" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="full_name">Celular</label>
                                    <input type="text" name="cell_phone" class="form-control" placeholder="6728591">
                                </div>
                            </div>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label for="full_name">Fecha Nacimiento</label>
                                    <input type="date" name="birth_date" class="form-control" required>
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="full_name">Género</label>
                                    <select name="gender" class="form-control">
                                        <option value="masculino">Masculino</option>
                                        <option value="femenino">Femenino</option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-group">
                                <label for="address">Dirección</label>
                                <textarea name="address" class="form-control" rows="3" placeholder="C/ 18 de nov. Nro 123 zona central"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary btn-save-customer" value="Guardar">
                        </div>
                    </div>
                </div>
            </div>
        </form>
    @stop

    @section('css')
        <style>
.label-description{
            cursor: pointer;
        }
        </style>
    @endsection

    @section('javascript')
        {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
        <script src="{{ asset('vendor/tippy/popper.min.js') }}"></script>
        <script src="{{ asset('vendor/tippy/tippy-bundle.umd.min.js') }}"></script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>

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
        // alert(option.article.name)
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









            function filterFloat(evt,input){
            // Backspace = 8, Enter = 13, ‘0′ = 48, ‘9′ = 57, ‘.’ = 46, ‘-’ = 43
                var key = window.Event ? evt.which : evt.keyCode;    
                var chark = String.fromCharCode(key);
                var tempValue = input.value+chark;
                if(key >= 48 && key <= 57){
                    if(filter(tempValue)=== false){
                        return false;
                    }else{       
                        return true;
                    }
                }else{
                    if(key == 8 || key == 0) {     
                        return true;              
                    }else if(key == 46){
                            if(filter(tempValue)=== false){
                                return false;
                            }else{       
                                return true;
                            }
                    }else{
                        return false;
                    }
                }
            }
            function filter(__val__){
                var preg = /^([0-9]+\.?[0-9]{0,2})$/; 
                if(preg.test(__val__) === true){
                    return true;
                }else{
                return false;
                }
                
            }

        </script>

        <script>
            $(document).ready(function(){
                var productSelected;
                
                $('#select_people_id').select2({
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
                        url: "{{ url('admin/worker/people/ajax') }}",        
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
                    templateResult: formatResultCustomers_people,
                    templateSelection: (opt) => {
                        productSelected = opt;

                        
                        return opt.first_name?opt.first_name+' '+opt.last_name:'<i class="fa fa-search"></i> Buscar... ';
                    }
                }).change(function(){
                   
                });


                $('#form-create-customer').submit(function(e){
                    e.preventDefault();
                    $('.btn-save-customer').attr('disabled', true);
                    $('.btn-save-customer').val('Guardando...');
                    $.post($(this).attr('action'), $(this).serialize(), function(data){
                        if(data.people.id){
                            toastr.success('Registrado exitosamente', 'Éxito');
                            $(this).trigger('reset');
                        }else{
                            toastr.error(data.error, 'Error');
                        }
                    })
                    .always(function(){
                        $('.btn-save-customer').attr('disabled', false);
                        $('.btn-save-customer').text('Guardar');
                        $('#modal-create-customer').modal('hide');
                    });
                });

            })

            function formatResultCustomers_people(option){
            // Si está cargando mostrar texto de carga
                if (option.loading) {
                    return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
                }
                let image = "{{ asset('image/default.jpg') }}";
                if(option.image){
                    image = "{{ asset('storage') }}/"+option.image.replace('.', '-cropped.');
                    // alert(image)
                }
                
                // Mostrar las opciones encontradas
                return $(`  <div style="display: flex">
                                <div style="margin: 0px 10px">
                                    <img src="${image}" width="50px" />
                                </div>
                                <div>
                                    <small>CI: </small>${option.ci}<br>
                                    <b style="font-size: 15px">${option.first_name} ${option.last_name}
                                </div>
                            </div>`);
            }

        </script>
    @stop

@endif