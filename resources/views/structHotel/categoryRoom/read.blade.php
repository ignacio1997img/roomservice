@extends('voyager::master')

@section('page_title', 'Ver Categoria de habitaciones')
@if (auth()->user()->hasPermission('read_categories_rooms'))                          

@section('page_header')
    <h1 class="page-title">
        <i class="voyager-categories"></i> Categorias de habitaciones
        <a href="{{ route('voyager.categories-rooms.index') }}" class="btn btn-warning">
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
                                <h3 class="panel-title">Tipo de Habitación</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->name }}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>
                        <div class="col-md-12">
                            <div class="panel-heading" style="border-bottom:0;">
                                <h3 class="panel-title">Descripción</h3>
                            </div>
                            <div class="panel-body" style="padding-top:0;">
                                <p>{{ $data->description}}</p>
                            </div>
                            <hr style="margin:0;">
                        </div>     
                    </div>
                </div>
            </div>
        </div>
    </div>





@stop

@section('javascript')
    <script>
       
    </script>
@stop
@endif