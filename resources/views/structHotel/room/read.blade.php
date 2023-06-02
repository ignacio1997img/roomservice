@extends('voyager::master')

@section('page_title', 'Ver Habitacion')
@if (auth()->user()->hasPermission('read_categories_rooms'))                          

@section('page_header')
    <h1 class="page-title">
        <i class="fa-solid fa-person-booth"></i> Categorias de habitaciones
        <a href="{{ route('room.index') }}" class="btn btn-warning">
            <span class="glyphicon glyphicon-list"></span>&nbsp;
            Volver a la lista
        </a>
    </h1>
@stop

@section('content')
    <div class="page-content read container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Nº Habitación</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <small>{{$data->number}}</small>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-2">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Precio</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <small>Bs. {{number_format($data->amount, 2, ',', ' ')}}</small>
                            </div>
                            <hr style="margin:0;">
                        </div>   
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Categoría</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <small>{{$data->caregoryroom->name}}</small>
                            </div>
                            <hr style="margin:0;">
                        </div>  
                        <div class="col-md-3">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Planta</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <small>{{$data->categoryfacility->name}}</small>
                            </div>
                            <hr style="margin:0;">
                        </div>  
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered" style="padding-bottom:5px;">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="col-md-8" style="padding: 0px">
                                <h1 class="page-title">
                                    <i class="fa-solid fa-list"></i> Partes de la Habitación
                                </h1>
                            </div>
                            <div class="col-md-4 text-right" style="margin-top: 30px">
                              
                                <a href="#" data-toggle="modal" data-target="#modal_create" class="btn btn-success">
                                    <i class="voyager-plus"></i> <span>Agregar</span>
                                </a>
                            </div>
                            
                            <table id="dataTable" class="table table-bordered table-hover">
                                <thead>
                                    <tr>
                                        <th>N&deg;</th>
                                        <th>Nombre</th>
                                        <th>Descripción</th>
                                        <th style="width: 150px">Precio</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 0;
                                    @endphp
                                    @forelse ($data->part as $item)
                                        @php
                                            $cont++;
                                        @endphp
                                        <tr>
                                            <td>{{ $cont }}</td>
                                            <td>{{ $item->name->name }}</td>
                                            <td>{{ $item->observation }}</td>
                                            <td style="text-align: right"> <small>Bs.</small> {{$item->amount}}</td>
                                            <td class="no-sort no-click bread-actions text-right">
                                                <button title="Borrar" class="btn btn-sm btn-danger delete" onclick="deleteItem('{{ route('room-rooms-part.delete', ['part' => $item->id]) }}')" data-toggle="modal" data-target="#delete-modal">
                                                    <i class="voyager-trash"></i> <span class="hidden-xs hidden-sm">Borrar</span>
                                                </button>
                                            </td>                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td style="text-align: center" valign="top" colspan="4" class="dataTables_empty">No hay datos disponibles en la tabla</td>
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


    <form lass="form-submit" id="irremovability-form" action="{{route('room-read-part.store')}}" method="post">
        @csrf
        <div class="modal modal-success fade" id="modal_create" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa-solid fa-person"></i> Registrar Partes de la Habitación</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="room_id" value="{{$data->id}}">
                            <label>Partes de la Habitación</label>
                            <select name="part" class="form-control select2" required>
                                <option value="" selected disabled>--Seleccione una opción--</option>
                                @foreach ($part as $item)
                                    <option value="{{$item->id}}">{{$item->name}}</option>
                                @endforeach
                            </select>


                        </div>

                        
                        <div class="form-group">
                            <label>Observaciones</label>
                            <textarea name="observation" class="form-control" rows="5"></textarea>
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
                        <input type="hidden" name="room_id" value="{{$data->id}}">


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

@section('javascript')
    <script>
        function deleteItem(url){
            $('#delete_form').attr('action', url);
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