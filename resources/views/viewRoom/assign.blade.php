@extends('voyager::master')

@section('page_title', 'Asignar habitación')
@if (auth()->user()->hasPermission('add_assign'))

@section('page_header')
    <h1 class="page-title">
        <i class="fa-solid fa-key"></i> Asignar Habitación
        <a href="{{ route('view.planta', ['planta'=>$room->categoryFacility_id]) }}" class="btn btn-warning">
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
                        <div class="panel-body">
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
                                <label><small>Recomendado Por</small></label>
                                <div class="input-group">
                                    <select name="recommended_id" class="form-control" id="select_recommended_id"></select>
                                    <span class="input-group-btn">
                                        <button class="btn btn-primary" title="Nueva persona" data-target="#modal-create-customer" data-toggle="modal" style="margin: 0px" type="button">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                  
                        <div class="col-md-12">
                            <div class="panel-body">
                                <label><small>Cliente</small></label>
                                <div class="input-group">
                                    <select class="form-control" id="select_people_id" ></select>
                                    <span class="input-group-btn">  
                                        <button class="btn btn-primary" title="Nueva persona" data-target="#modal-create-customer" data-toggle="modal" style="margin: 0px" type="button">
                                            <span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
                                        </button>
                                    </span>
                                </div>
                                <br>
                                <div class="table-responsive">
                                    <table id="dataTable" class="tables tablesClient table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="text-align: center; width: 5%">N&deg;</th>
                                                <th style="text-align: center; width: 150px">Nombre Completo</th>  
                                                <th style="text-align: center; width: 80px">Nacionalidad</th>  
                                                <th style="text-align: center; width: 80px">Fecha de Nacimiento</th>  
                                                <th style="text-align: center; width: 80px">Telefono</th>  
                                                <th style="text-align: center; width: 80px">Dirección</th>  
                                                <th style="text-align: center; width: 5%">Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-bodyClient">
                                            <tr id="tr-emptyClient">
                                                <td colspan="7" style="height: 120px">
                                                    <h4 class="text-center text-muted" style="margin-top: 10px">
                                                        <i class="fa-solid fa-list" style="font-size: 30px"></i> <br><br>
                                                        Lista de cliente en la habitación vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                            
                        </div>   
                        
                        
                        
                        
                        {{-- <div class="col-md-12">
                            <div class="panel-body">
                                <div class="form-group">
                                    <input type="radio" id="html" name="type" value="asignado" checked>
                                    <label for="html"><small style="font-size: 15px">Asignar</small></label>
                                    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                    <input type="radio" id="css" name="type" value="reservado">
                                    <label for="css"><small style="font-size: 15px">Reservar</small></label><br>
                                </div>
                            </div>
                        </div>  --}}
                        <div class="col-md-3">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label><small>País de Procedencia</small></label>
                                    <select name="country_id" class="form-control select2" id="select-country_id" required>
                                        @foreach ($country as $item)
                                            <option value="{{$item->id}}" @if($item->id==1) selected @endif>{{$item->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 div-nacional">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="state_id"><small>Departamento</small></label>
                                    <select name="state_id" id="select-state_id" class="form-control select2">
                                        <option value="" disabled selected>--Selecciona el departamento--</option>
                                        @foreach (\App\Models\Department::with('provinces.cities')->where('deleted_at', NULL)->get() as $item)
                                            <option value="{{ $item->id }}" data-provinces="{{ $item->provinces }}">{{ $item->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>                            
                        </div>

                        <div class="col-md-3 div-nacional">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="province_id"><small>Provincia</small></label>
                                    <select name="province_id" id="select-province_id" class="form-control select2">
                                    </select>
                                </div>
                            </div>                            
                        </div>

                        <div class="col-md-3 div-nacional">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="city_id"><small>Ciudad</small></label>
                                    <select name="city_id" id="select-city_id" class="form-control select2">
                                    </select>
                                </div>
                            </div>                               
                        </div>



                        <div class="col-md-9 div-extranjero" style="display: none">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label for="origin"><small>Procedencia</small></label>
                                    <input type="text" class="form-control" name="origin" placeholder="Lugar de ingreso al país">
                                </div>
                            </div>                            
                        </div>
                     
                        <div class="col-md-2">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label><small>Motivo Hospedaje</small></label>
                                    <select name="typeHospedaje" class="form-control select2" id="typeHospedaje" required>
                                        {{-- <option value="" selected disabled>--Seleccione una opción--</option> --}}
                                        <option value="turismo">Turismo.</option>
                                        <option value="trabajo">Trabajo.</option>
                                        <option value="salud">Salud.</option>
                                        <option value="otros">Otros.</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label><small>Tipo</small></label>
                                    <select name="type" class="form-control select2" id="type" required>
                                        <option value="" selected disabled>--Seleccione una opción--</option>
                                        <option value="asignado">Asignar hab.</option>
                                        <option value="reservado">Reservar hab.</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="panel-body">
                                <div class="form-group">
                                    <label><small>Monto</small></label>
                                    <select name="amount" class="form-control select2" id="select_amount" required>
                                        <option value="" selected disabled>--Seleccione una opción--</option>
                                        <option value="ventilador">Ventilador: 1 día Bs.{{$room->amount}} </option>
                                        <option value="aire">Aire Acond.: 1 día Bs.{{$room->amount1?$room->amount1:0}}</option>
                                        <option value="personalizado">Monto Personalizado</option>
                                    </select>
                                </div>
                            </div>
                        </div>       
                        
                        <div class="col-md-2" id="div_price" style="display:none">
                            <div class="panel-body">                            
                                <div class="form-group">
                                    <label><small>Precio</small></label>
                                    <input type="number" id="input" name="price" min="1" step="1" value="{{$room->amount}}" style="text-align: right" class="form-control text">
                                </div>
                            </div>
                        </div>  
                                 
                        <div class="col-md-3">
                            <div class="panel-body">
                                <label><small>Fecha Inicio</small></label>
                                <input type="datetime-local" name="start" value="{{date('Y-m-d H:i') }}" class="form-control" required>
                            </div>
                        </div>
                        
                        {{-- <div class="col-md-3">
                            <div class="panel-body">
                                <label><small>Fecha Fin</small></label>
                                <input type="datetime-local" id="finish" name="finish" value="{{date('Y-m-d h:i',strtotime(date('Y-m-d h:i')."+ 1 days"))}}" class="form-control" required>
                            </div>
                        </div> --}}
                       
                        <div class="col-md-7">
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
                                        @forelse ($room->part as $item)
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
                                    {{-- <button type="submit" id="btn_submit" class="btn btn-primary">Guardar</button> --}}
                                
                                </div>
                            </div>                            
                        </div>
                        <div class="col-md-5 carouselTamano">
                            <div class="tamano" >
                                <div id="myCarousel" class="carousel slide" data-ride="carousel">

                                    <!-- Indicators -->
                                    @if (count($room->file) == 0)
                                        <ol class="carousel-indicators">
                                            <li data-target="#myCarousel" data-slide-to="0" class="active"></li>
                                        </ol>

                                        <div class="carousel-inner" role="listbox">                                     
                                            <div class="item active">
                                                <img src="{{asset('image/default.jpg')}}" alt="Facebook" class="img-responsive">
                                            </div> 
                                        </div>
                                    @endif
                                    @php
                                        $i = 0;
                                        // dump();
                                    @endphp
                                    <ol class="carousel-indicators">
                                        @foreach ($room->file as $item)
                                            <li data-target="#myCarousel" data-slide-to="{{$i}}" @if ($i==0)class="active"  @endif></li>
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </ol>

                                    @php
                                        $i = 0;
                                    @endphp
                                    <div class="carousel-inner" role="listbox">
                                        @foreach ($room->file as $item)                                        
                                            <div @if ($i==0) class="item active" @else class="item" @endif>
                                                <img src="{{asset('storage/'.$item->image)}}" alt="Facebook" class="img-responsive">
                                            </div>                                        
                                            @php
                                                $i++;
                                            @endphp
                                        @endforeach
                                    </div>
                                
                                
                                    <!-- Left and right controls -->
                                    <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
                                      <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
                                      <span class="sr-only">Previous</span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
                                      <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
                                      <span class="sr-only">Next</span>
                                    </a>
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
                            <div class="form-group col-md-12">
                                <label>Nacionalidad</label>
                                <select name="nationality_id" class="form-control select2" id="nationality_id" required>
                                    <option value="" selected disabled>--Seleccione una opción--</option>
                                    @foreach ($nacionalidad as $item)
                                        <option value="{{$item->id}}" >{{$item->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
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
                        <div class="row">
                            <div class="form-group col-md-6">
                                <label for="profession">Profesión</label>
                                <input type="text" name="profession" class="form-control" placeholder="Profesión">
                            </div>
                            <div class="form-group col-md-6">
                                <label for="civilStatus">Estado Civil</label>
                                <select name="civilStatus" class="form-control">
                                    <option value="Soltero(a)">Soltero(a)</option>
                                    <option value="Casado(a)">Casado(a)</option>
                                    <option value="Divorciado(a)">Divorciado(a)</option>
                                    <option value="Viudo(a)">Viudo(a)</option>
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
        .carousel-inner img {
            width: 100%;
            /* max-height: 460px; */
        }
     
      

        /* .carousel-inner{
        height: 200px;
        } */
    </style>
@stop

@section('javascript')



    <script>

        $(document).ready(function(){
                $('#agent').submit(function(e){
                    $('#btn-submit').text('Guardando...');
                    $('#btn-submit').attr('disabled', true);

                });
        })
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
                var peopleSelected;
                var recommendedSelected;
                
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
                        peopleSelected = opt;

                        
                        return opt.id?opt.first_name+' '+opt.last_name:'<i class="fa fa-search"></i> Buscar... ';
                    }
                }).change(function(){
                    if($('#select_people_id option:selected').val()){
                        let people = peopleSelected;
                        if($('.tablesClient').find(`#tr-item-client-${people.id}`).val() === undefined){
                        // alert(product.name);

                            $('#table-bodyClient').append(`
                                <tr class="tr-item" id="tr-item-client-${people.id}">
                                    <td style="text-align: center" class="td-itemClient"></td>
                                    <td>
                                        <b class="label-description" ><small>CI: ${people.ci}</small></b><br>
                                        <b class="label-description" ><small>Nombre: ${people.first_name} ${people.last_name}</small></b><br>
                                        <input type="hidden" name="people_id[]" value="${people.id}" />

                                    </td>

                                    <td>
                                        <b class="label-description" ><small>${people.nationality?people.nationality.name:'SN'}</small></b>
                                    </td>
                                    <td>
                                        <b class="label-description" ><small>${people.birth_date?people.birth_date:'SN'}</small></b>
                                    </td>
                                    <td>
                                        <b class="label-description" ><small>${people.cell_phone?people.cell_phone:'SN'}</small></b>
                                    </td>
                                    <td>
                                        <b class="label-description" ><small>${people.address?people.address:'SN'}</small></b>
                                    </td>
                                    <td class="text-right"><button type="button" onclick="removeTrClient(${people.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                                </tr>
                            `);
                            toastr.success('Persona agregada a la habitación', 'Información')
                        }else{
                            toastr.error('La persona ya está agregada', 'Información')
                        }
                        setNumberClient();
                    }
                });

                $('#select_recommended_id').select2({
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
                        recommendedSelected = opt;

                        
                        return opt.id?opt.first_name+' '+opt.last_name:'<i class="fa fa-search"></i> Buscar... ';
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

                // #################################################################################################################
                var provinces_country = [];

                $('#select-state_id').change(function(){
                    let provinces = $('#select-state_id option:selected').data('provinces');
                    let provinces_list = '<option value="">--Selecciona la provincia--</option>';
                    if(provinces.length){
                        provinces_country = provinces; 
                        provinces.map(province => {
                            provinces_list += `<option value="${province.id}">${province.name}</option>`;
                        });
                    }else{
                        provinces_list += `<option value="">Ninguna</option>`;
                    }
                    $('#select-province_id').html(provinces_list);
                    // inicializar_select2('province_id');
                    $('#select-city_id').html('');
                });

                $('#select-province_id').change(function(){
                    let id = $('#select-province_id option:selected').val();
                    let cities = [];
                    provinces_country.map(item => {
                        if(id == item.id){
                            cities = item.cities;
                        }
                    });

                    let cities_list = '';
                    if(cities.length){
                        cities.map(city => {
                            cities_list += `<option value="${city.id}">${city.name}</option>`;
                        });
                    }else{
                        cities_list += `<option value="">Ninguna</option>`;
                    }
                    $('#select-city_id').html(cities_list);
                    // inicializar_select2('city_id');
                });


                $('#select-country_id').change(function(){
                    let id = $('#select-country_id option:selected').val();
                    // alert(id)
                    if(id == 1){
                        $('#select-state_id').val(1).change();
                        // $('#select-state_id').reset('');
                        $('.div-nacional').fadeIn();
                        $('.div-extranjero').fadeOut();
                        
                    }else{
                        $('#select-city_id').html('');
                        
                        $('.div-nacional').fadeOut();
                        $('.div-extranjero').fadeIn();
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
                                    <b style="font-size: 16px">${option.first_name} ${option.last_name}<br>
                                    <small>Nacionalidad: </small>${option.nationality?option.nationality.name:'SN'}
                                </div>
                            </div>`);
            }


            //para la opcion de menu
        function setNumberClient(){
            var length = 0;
            $(".td-itemClient").each(function(index) {
                $(this).text(index +1);
                length++;
            });

            if(length > 0){
                $('#tr-emptyClient').css('display', 'none');
            }else{
                $('#tr-emptyClient').fadeIn('fast');
            }
        }

        function removeTrClient(id){
            $(`#tr-item-client-${id}`).remove();
            $('#select_people_id').val("").trigger("change");
            setNumberClient();
        }


            
    </script>
@stop

@endif
