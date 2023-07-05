@extends('voyager::master')

@section('page_title', 'Crear Ingreso de limpieza')

@if (auth()->user()->hasPermission('add_cleaningproducts'))

    @section('page_header')
        <h1 id="titleHead" class="page-title">
            <i class="fa-sharp fa-solid fa-cart-shopping"></i> Crear Ingreso Para la Limpieza
        </h1>
        <a href="{{ route('cleaningproducts.index') }}" class="btn btn-warning">
            <i class="fa-solid fa-rotate-left"></i> <span>Volver</span>
        </a>
    @stop

    @section('content')
        <div class="page-content edit-add container-fluid">    
            <form id="agent" action="{{route('cleaningproducts.store')}}" method="POST">
                @csrf
                <div class="row">
                    <div class="col-md-8">
                        <div class="panel panel-bordered">
                            <div class="panel-body">
                                <div class="col-md-12">
                                    <div class="form-group">
                                        <label for="product_id">Buscar producto</label>
                                        <select class="form-control" id="select-product_id"></select>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <div class="table-responsive">
                                        <table id="dataTable" class="table table-bordered table-hover">
                                            <thead>
                                                <tr>
                                                    <th style="width: 30px">N&deg;</th>
                                                    <th style="text-align: center">Detalle</th>                      
                                                    <th style="text-align: center; width: 120px">Precio Unit.</th>
                                                    <th style="text-align: center; width: 120px">Cantidad</th>             
                                                    <th style="text-align: center; width: 120px">Sub Total</th>
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
                                    <label for="dni">Numero de Factura</label>
                                    <input type="text" name="numberFactura" id="input-dni" value="" class="form-control" placeholder="Numero de factura">
                                </div>
                                <div class="form-group col-md-6">
                                    <label for="date">Fecha</label>
                                    <input type="date" name="dateFactura" class="form-control">
                                </div>
                                <div class="form-group col-md-12">
                                    <textarea name="observation" class="form-control" rows="3" placeholder="Observaciones"></textarea>
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
                                    <a href="{{ route('cleaningproducts.index') }}" >Volver a la lista</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                
            </form>              
        </div>
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
        <script>

            $(document).ready(function(){
                var productSelected;
                
                $('#select-product_id').select2({
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
                        url: "{{ url('admin/income/article/ajax') }}",        
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

                        
                        return opt.name?opt.name+' - '+opt.presentation:'<i class="fa fa-search"></i> Buscar... ';
                    }
                }).change(function(){
                    if($('#select-product_id option:selected').val()){
                        let product = productSelected;
                        if($('.table').find(`#tr-item-${product.id}`).val() === undefined){
                            $('#table-body').append(`
                                <tr class="tr-item" id="tr-item-${product.id}">
                                    <td class="td-item"></td>
                                    <td>
                                        <b class="label-description" id="description-${product.id}"><small>Artículo:</small> ${product.name}<br><small>Unidad Medida:</small> ${product.presentation}<br><small>Categoría:</small> ${product.category.name}</small></b>
                                        <input type="hidden" name="product_id[]" value="${product.id}" />
                                    </td>
                                    
                                    <td>
                                        <input type="number" name="price[]" min="0.01" step=".01" id="select-price-${product.id}" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" onkeypress="return filterFloat(event,this);" style="text-align: right" class="form-control text" required>
                                    </td>
                                    <td>
                                        <input type="number" name="cant[]" min="0.01" step=".01" id="input-quantity-${product.id}" onkeyup="getSubtotal(${product.id})" onchange="getSubtotal(${product.id})" onkeypress="return filterFloat(event,this);" style="text-align: right" class="form-control text" required>
                                    </td>
                                    <td class="text-right"><h4 class="label-subtotal" id="label-subtotal-${product.id}">0</h4></td>
                                    <td class="text-right"><button type="button" onclick="removeTr(${product.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                                </tr>
                            `);
                            // popover
                            let image = "{{ asset('image/default.jpg') }}";
                            if(product.image){
                                image = "{{ asset('storage') }}/" + product.image.replace('.', '-cropped.');
                                
                            }                            

                            tippy(`#description-${product.id}`, {
                                content: `  <div style="display: flex; flex-direction: row">
                                                <div style="margin-right:10px">
                                                    <img src="${image}" width="60px" alt="${product.name}" />
                                                </div>
                                                <div>
                                                    <b>Artículo: ${product.name}</b><br>
                                                    <b>Unidad Medida: ${product.presentation}</b><br>
                                                    <b>Categoría: ${product.category.name}</b>    
                                                </div>
                                            </div>`,
                                allowHTML: true,
                                maxWidth: 450,
                            });
                        }else{
                            toastr.info('EL producto ya está agregado', 'Información')
                        }
                        setNumber();
                        getSubtotal(product.id);
                        // $(`#select-price-${product.id}`).select2({tags: true})
                    }
                });
                

            })

            function formatResultCustomers(option){
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
                                    <b style="font-size: 16px">${option.name} ${option.presentation}</b><br>
                                    <small>Categoría: </small>${option.category.name}
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
                let quantity = $(`#input-quantity-${id}`).val() ? parseFloat($(`#input-quantity-${id}`).val()) : 0;
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
                // $('#input-amount').attr('max', total.toFixed(2));
                
                // // Si la opción de ingresar el monto recibido está deshabilitada se debe autocompletar el input
                // if(!typeAmountReceived && !$('#checkbox-proforma').is(':checked')){
                //     $('#input-amount').attr('value', total.toFixed(2));
                // }
            }

            function removeTr(id){
                $(`#tr-item-${id}`).remove();
                $('#select-product_id').val("").trigger("change");
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
    @stop

@endif