@extends('voyager::master')

@section('page_title', 'Ver Personal')

@section('page_header')
    <h1 class="page-title">
        <i class="fa-solid fa-person"></i> Viendo Personal
        <a href="{{ route('worker.index') }}" class="btn btn-warning">
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
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Nombre(s)</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->people->first_name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Apellidos</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->people->last_name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">CI</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->people->ci }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Fecha de nacimiento</h3>
                            </div>
                            @php
                                $now = \Carbon\Carbon::now();
                                $birthday = new \Carbon\Carbon($data->people->birth_date);
                                $age = $birthday->diffInYears($now);
                            @endphp
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ date('d/m/Y', strtotime($data->people->birth_date)) }} - {{ $age }} años</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Telefono</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->people->phone ?? 'No definido' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Dirección</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->people->address }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Email</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->people->email ?? 'No definido' }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-6">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Género</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->people->gender }}</p>
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
                                    <i class="fa-solid fa-person-digging"></i> Especialidad Laboral
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
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php
                                        $cont = 0;
                                    @endphp
                                    @forelse ($data->category as $item)
                                        @php
                                            $cont++;
                                        @endphp
                                        <tr>
                                            <td>{{ $cont }}</td>
                                            <td>{{ $item->cate->name }}</td>
                                            <td>{{ $item->observation }}</td>
                                            <td class="no-sort no-click bread-actions text-right">
                                                <button title="Borrar" class="btn btn-sm btn-danger delete" onclick="deleteItem('{{ route('worker-category.delete', ['worker' => $item->id]) }}')" data-toggle="modal" data-target="#delete-modal">
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


    <form lass="form-submit" id="irremovability-form" action="{{route('worker-category.store')}}" method="post">
        @csrf
        <div class="modal modal-success fade" id="modal_create" role="dialog">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title"><i class="fa-solid fa-person"></i> Registrar Personal</h4>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <input type="hidden" name="worker_id" value="{{$data->id}}">
                            <label>Personal</label>
                            <select name="category_id" class="form-control select2" required>
                                <option value="" selected disabled>--Seleccione una opción--</option>
                                @foreach ($category as $item)
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
                        <input type="hidden" name="worker_id" value="{{$data->id}}">


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
    </script>
@stop
