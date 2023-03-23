@extends('voyager::master')

@section('page_title', 'Ver Personal')

@section('page_header')
    <h1 class="page-title">
        <i class="fa-solid fa-key"></i> Asignar Habitación
        <a href="{{ route('worker.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            Volver a la lista
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <form id="agent" action="{{route('serviceroom.store')}}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="row">
                        <input type="hidden" name="room_id" value="{{$room->id}}">
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Habitación</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p><small>Pieza N° {{ $room->number }}</small></p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Categoría</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $room->caregoryroom->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Planta de Hotel</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $room->categoryfacility->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>

                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Estado</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                @if ($room->status == 1)
                                    <span class="label label-success">Habitacion Libre</span>
                                @else
                                    <span class="label label-danger">Habitacion Ocuṕada</span>
                                @endif
                            </div>
                            <hr style="margin:0;">
                        </div>                  
                  
                        <div class="col-md-12">
                            <div class="panel-body">
                                <label><small>Cliente</small></label>
                                <div class="input-group">
                                    <select name="people_id" class="form-control" id="select_people_id" required></select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" title="Nueva persona" data-target="#modal-create-customer" data-toggle="modal" style="margin: 0px" type="button">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>    
                        <div class="col-md-3">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label><small>Monto</small></label>
                                    <select name="amount" class="form-control" id="select_amount" required>
                                        <option value="{{$room->amount}}" selected>1 día Bs.{{$room->amount}}</option>
                                        <option value="personalizado">Monto Personalizado</option>
                                    </select>
                                </div>
                            </div>
                        </div>       
                        
                        <div class="col-md-2" id="div_price" style="display:none">
                            <div class="panel-body">                            
                                <div class="form-group">
                                    <label><small>Precio</small></label>
                                    <input type="number" id="input" name="price" min="1" step="1"  style="text-align: right" class="form-control text">
                                </div>
                            </div>
                        </div>  
                                  
                        <div class="col-md-3">
                            <div class="panel-body">
                                <label><small>Fecha Inicio</small></label>
                                <input type="datetime-local" name="start" value="{{date('Y-m-d h:i') }}" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="panel-body">
                                <label><small>Fecha Fin</small></label>
                                <input type="datetime-local" id="finish" name="finish" value="{{date('Y-m-d h:i',strtotime(date('Y-m-d h:i')."+ 1 days"))}}" class="form-control" required>
                            </div>
                        </div>
                       
                        <div class="col-md-12">
                            <div class="panel-body">
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>N&deg;</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $cont = 0;
                                            $total = 0;
                                        @endphp
                                        @forelse ($room->caregoryroom->part as $item)
                                            @php
                                                $cont++;
                                                $total = $total + $item->amount;
                                            @endphp
                                            <tr>
                                                <td>{{ $cont }}</td>
                                                <td>{{ $item->name->name}}
                                                    <input type="hidden" name="part[]" value="{{ $item->name->name}}">
                                                </td>
                                                <td>{{ $item->name->Description}}</td>
                                               
                                            </tr>
                                        @empty
                                            <tr>
                                                <td style="text-align: center" valign="top" colspan="3" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <div class="col-md-12" style="padding: 0px">
                                    <button type="submit" id="btn-submit"  class="btn btn-success btn-block"><i class="fa-solid fa-key"></i> Asignar Habitación </button>
                                </div>
                            </div>
                            
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

@section('javascript')
    <script>
        $(document).ready(function() {
            $('#select_amount').change(function(e) {
                // alert( $(this).val())
                if ($(this).val() === "personalizado") {
                    $('#div_price').fadeIn();
                    $('#input').attr('required', 'required');
                    // $("#finish").val("");
                } else {
                    $('#div_price').fadeOut();
                    $('#input').removeAttr('required');
                }
            })
        });



        function deleteItem(url){
            $('#delete_form').attr('action', url);
        }

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
                    templateResult: formatResultCustomers,
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




            // function getTotal(){
            //     // alert(1)
            //     let total = 0;
            //     $(".select-price").each(function(index) {
            //         total += parseFloat($(this).val());
            //     });
            //     // alert(total)
            //     $('#total-label').text(total.toFixed(2));
            //     $('#total-input').val(total.toFixed(2));
                
            // }



           




            
    </script>
@stop
