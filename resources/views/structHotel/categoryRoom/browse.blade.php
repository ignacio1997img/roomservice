@extends('voyager::master')

@section('page_title', 'Viendo Personal Del Hotel')

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-8" style="padding: 0px">
                            <h1 class="page-title">
                                <i class="voyager-categories"></i> Categorias de habitaciones
                            </h1>
                        </div>
                        <div class="col-md-4 text-right" style="margin-top: 30px">
                          
                            <a href="#" data-toggle="modal" data-target="#modal_create" class="btn btn-success">
                                <i class="voyager-plus"></i> <span>Crear</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@stop

@section('content')
    <div class="page-content browse container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-sm-10">
                                <div class="dataTables_length" id="dataTable_length">
                                    <label>Mostrar <select id="select-paginate" class="form-control input-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> registros</label>
                                </div>
                            </div>
                            <div class="col-sm-2">
                                <input type="text" id="input-search" class="form-control">
                            </div>
                        </div>
                        

                        <div class="row" id="div-results" style="min-height: 120px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <form lass="form-submit" id="irremovability-form" action="{{route('categories-rooms.store')}}" method="post">
        @csrf
        <div class="modal modal-success fade" id="modal_create" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="voyager-categories"></i> Registrar Categoria</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tipo Habitación</label>
                            <input type="text" name="name" class="form-control" placeholder="Ingrese la categoria de la habitación" required>
                        </div>
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea name="description" class="form-control" rows="5"></textarea>
                        </div>
                        <hr>
                        <div class="form-group">
                            <label>Partes de la Habitación</label>
                            <select class="form-control" id="selected_parts" required></select>
                        </div>
                        <div class="form-group">
                            <div class="table-responsive">
                                <table id="dataTable" class="tables table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width: 30px">N&deg;</th>
                                            <th style="text-align: center">Detalle</th>  
                                            <th width="15px">Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody id="table-body">
                                        <tr id="tr-empty">
                                            <td colspan="3" style="height: 150px">
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

    <div class="modal modal-danger fade" data-backdrop="static" tabindex="-1" id="delete-modal" role="dialog">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title"><i class="voyager-trash"></i> Desea eliminar el siguiente registro?</h4>
                </div>
                <div class="modal-footer">
                    <form action="#" id="delete_form" method="POST">
                        {{ method_field('DELETE') }}
                        {{ csrf_field() }}
                        <input type="hidden" name="id" id="id">

                            <div class="text-center" style="text-transform:uppercase">
                                <i class="voyager-trash" style="color: red; font-size: 5em;"></i>
                                <br>
                                
                                <p><b>Desea eliminar el siguiente registro?</b></p>
                            </div>
                        <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Sí, eliminar">
                    </form>
                    <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                </div>
            </div>
        </div>
    </div>

   


 
@stop

@section('css')
    <style>
        .select2{
                width: 100% !important;
            }
        
    </style>
@stop

@section('javascript')
    {{-- <script src="{{ url('js/main.js') }}"></script> --}}

    <script src="{{ asset('vendor/tippy/popper.min.js') }}"></script>
        <script src="{{ asset('vendor/tippy/tippy-bundle.umd.min.js') }}"></script>
    <script>
        $(document).ready(function(){
                var productSelected;

                $('#selected_parts').select2({
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
                        url: "{{ url('admin/categories-rooms/parthotel/ajax') }}",        
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
                    templateResult: formatResultWorker,
                    templateSelection: (opt) => {
                        productSelected = opt;

                        
                        return opt.name?opt.name:'<i class="fa fa-search"></i> Buscar... ';
                    }
                }).change(function(){
                    // alert(2)
                    if($('#selected_parts option:selected').val()){
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
                                    <b style="font-size: 16px">${option.first_name} ${option.last_name}
                                </div>
                            </div>`);
            }

            function formatResultWorker(option){
            // Si está cargando mostrar texto de carga
                if (option.loading) {
                    return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
                }
                
                // Mostrar las opciones encontradas
                return $(`  <div style="display: flex">
                                <div>
                                    <b style="font-size: 16px">${option.name}
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
                $('#selected_parts').val("").trigger("change");
            }
            
    </script>
    <script>
        var countPage = 10, order = 'id', typeOrder = 'desc';
        $(document).ready(() => {
            list();
            
            $('#input-search').on('keyup', function(e){
                if(e.keyCode == 13) {
                    list();
                }
            });

            $('#select-paginate').change(function(){
                countPage = $(this).val();
               
                list();
            });
        });

        function list(page = 1){
            // $('#div-results').loading({message: 'Cargando...'});
            var loader = '<div class="col-md-12 bg"><div class="loader" id="loader-3"></div></div>'
            $('#div-results').html(loader);

            let url = '{{ url("admin/categories-rooms/ajax/list") }}';
            let search = $('#input-search').val() ? $('#input-search').val() : '';

            $.ajax({
                url: `${url}/${search}?paginate=${countPage}&page=${page}`,
                type: 'get',
                
                success: function(result){
                    $("#div-results").html(result);
                }
            });

        }

        function deleteItem(url){
            $('#delete_form').attr('action', url);
        }

       
    </script>

    <script>
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