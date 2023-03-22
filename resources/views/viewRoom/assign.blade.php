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
                <div class="panel panel-bordered" style="padding-bottom:5px;">
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
                                <p>{{ $room->categoryfacility->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>                  
                  
                        <div class="col-md-12">
                            <div class="panel-body">
                                <label><small>Cliente</small></label>
                                <select name="people_id" class="form-control" id="select_people_id" required></select>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="panel-body">
                                <div class="col-md-8" style="padding: 0px">
                                    <h1 class="page-title">
                                        <i class="fa-solid fa-list"></i> Partes de la Habitación
                                    </h1>
                                </div>
                                
                                <table id="dataTable" class="table table-bordered table-hover">
                                    <thead>
                                        <tr>
                                            <th>N&deg;</th>
                                            <th>Nombre</th>
                                            <th>Descripción</th>
                                            <th style="width: 150px">Precio</th>
                                            {{-- <th style="width:150px" class="text-right">Acciones</th> --}}
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
                                                <td style="text-align: right"> <small>
                                                    <input type="number" name="price[]" min="0" step="1" value="{{$item->amount}}"  class="form-control text select-price" onkeyup="getTotal()" onchange="getSubtotal()" onkeypress="return filterFloat(event,this);" style="text-align: right" required>
                                                    </small> </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td style="text-align: center" valign="top" colspan="4" class="dataTables_empty">No hay datos disponibles en la tabla</td>
                                            </tr>
                                        @endforelse
                                        <tr>
                                            <td colspan="3" style="text-align: right"><b>TOTAL</b></td>
                                            <td style="text-align: right"><b><small id="total-label">{{ number_format($total, 2, ',', '.') }}</small></b></td>
                                            <input type="hidden" value="{{$total}}" name="amount" id="total-input">
                                        </tr>
                                    </tbody>
                                </table>
                                <div class="col-md-12" style="padding: 0px">
                                    <button type="submit" id="btn-submit"  class="btn btn-primary btn-block">Asignar Habitación <i class="voyager-basket"></i></button>
                                </div>
                            </div>
                            
                        </div>

                    </div>
                </div>
            </div>
        </div>
        </form>
    </div>


 



@stop

@section('javascript')
    <script>
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




            function getTotal(){
                // alert(1)
                let total = 0;
                $(".select-price").each(function(index) {
                    total += parseFloat($(this).val());
                });
                // alert(total)
                $('#total-label').text(total.toFixed(2));
                $('#total-input').val(total.toFixed(2));
                
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
