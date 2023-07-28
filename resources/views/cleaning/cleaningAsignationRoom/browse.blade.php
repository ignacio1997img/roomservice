@extends('voyager::master')

@section('page_title', 'Viendo Ingreso')

@if (auth()->user()->hasPermission('browse_cleaningasignationindex'))

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-8" style="padding: 0px">
                            <h1 id="titleHead" class="page-title">
                                <i class="fa-solid fa-person-booth"></i> Habitaciones asiganadas para limpiar
                                <a href="{{ route('cleaning-asignation.index') }}" class="btn btn-warning">
                                    <span class="glyphicon glyphicon-list"></span>&nbsp;
                                    Volver a la lista
                                </a>
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
                            <div class="col-sm-8">
                                <div class="dataTables_length" id="dataTable_length">
                                    <label>Mostrar <select id="select-paginate" class="form-control input-sm">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select> registros</label>
                                </div>
                            </div>
                            <div class="col-sm-4" style="margin-bottom: 0px">
                                <input type="text" id="input-search" class="form-control" placeholder="Ingrese busqueda..."> <br>
                            </div>
                            
                        </div>
                        <div class="row" id="div-results" style="min-height: 120px"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <form lass="form-submit" id="irremovability-form" action="{{route('cleaning-asignation-room.store')}}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="modal modal-success fade" id="modal_create" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa-solid fa-person-booth"></i> Asignar Habitación</h4>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="user_id" value="{{$user_id}}">
                        <div class="form-group">
                            <label>Planta de Hotel</label>
                            <select name="category_id" id="category_id" class="form-control select2" required>
                                <option value=""disabled selected>--Seleccione una categoría--</option>
                                @foreach ($facility as $item)
                                    <option value="{{$item->id}}" data-rooms="{{ $item->room }}">{{$item->name}}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Habitaciones</label>
                            <select name="room_id" id="room_id" class="form-control select2" required>
                                
                            </select>
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

@stop

@section('javascript')
    <script>

        var countPage = 10, order = 'id', typeOrder = 'desc';

        $(document).ready(() => {
            list();

            $('.radio-type').click(function(){
                list();
            });
            
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

            var loader = '<div class="col-md-12 bg"><div class="loader" id="loader-3"></div></div>'
            $('#div-results').html(loader);
            let user_id = '{{$user_id}}';

            // alert(user_id);

            let url = "{{ url('admin/cleaning/asignation/room/list') }}";
            // alert(1)
            let search = $('#input-search').val() ? $('#input-search').val() : '';

            $.ajax({
                url: `${url}/${user_id}/${search}?paginate=${countPage}&page=${page}`,
                type: 'get',
                
                success: function(result){
                    $("#div-results").html(result);
                }
            });

        }


        $('#category_id').change(function(){
            let rooms = $('#category_id option:selected').data('rooms');
            let rooms_list = '<option value="" disabled selected>--Seleccione una habitacion--</option>';
            alert(rooms)
            // if(rooms.length){
 
                rooms.map(room => {
                    rooms_list += `<option value="${room.id}">${room.number}</option>`;
                });
            // }else{
            //     rooms_list += `<option value="">Ninguna</option>`;
            // }
            $('#room_id').html(rooms_list);
        });

        function deleteItem(url){
            $('#delete_form').attr('action', url);
        }
        




    </script>
@stop
@endif