@extends('voyager::master')

@section('content')
    <div class="page-content">
        
        <div class="analytics-container">
            <div class="row" style="text-align: center ">
                @forelse ($data as $item)
                    @php
                        $category =  \App\Models\CategoriesRoom::where('id', $item->categoryRoom_id)->first();
                   
                        if($item->status==0)
                        {
                            $service =  \App\Models\ServiceRoom::where('room_id', $item->id)->whereRaw('(status = "asignado" or status = "reservado")')->where('deleted_at',null)->first();  
                            // dump($service);
                            $egre = \DB::table('egres as e')
                                ->join('egres_deatils as d', 'd.egre_id', 'e.id')
                                ->join('articles as a', 'a.id', 'd.article_id')
                                ->where('e.serviceRoom_id', $service->id)
                                ->where('e.sale', 1)
                                ->where('e.deleted_at', null)
                                ->where('d.deleted_at', null)    
                                ->select('a.name', 'd.article_id', 'd.egre_id',  'd.price','d.amount')->groupBy('name', 'article_id', 'egre_id', 'price')->get();
                                    
                            $totalaux = $egre->SUM('amount');

                            $menu = DB::table('egres as e')
                                ->join('egres_menus as d', 'd.egre_id', 'e.id')
                                ->join('food as f', 'f.id', 'd.food_id')
                                ->where('e.serviceRoom_id', $service->id)
                                ->where('e.sale', 1)
                                ->where('e.deleted_at', null)
                                ->where('d.deleted_at', null)
                                ->select('f.name', 'd.cant',  'd.price', 'd.amount')->get();
                            $totalMenu = $menu->SUM('amount');
                            $totalFinish= $service->amount+$totalaux+$totalMenu;                                  
                        }
                    @endphp
                    <div class="col-md-3" class="grid-block ">
                        <div class="col-md-12" id="myDiv" style="margin-top: 1em; border-radius: 20px; height:370px; @if($item->status == 0 && $service->status=='asignado') box-shadow: #F44E3E 0px 35px 60px -12px inset;@endif @if($item->status == 0 && $service->status=='reservado') box-shadow: #f3a528 0px 35px 60px -12px inset;@endif">
                            <br>
                            
                            
                            <p style="font-size: 20px; color: #ffffff;"><small>Pieza N° {{$item->number}}</small></p>                            
                            @if ($item->status == 1)
                                @if (auth()->user()->hasPermission('add_assign'))
                                    <a href="{{route('view-planta.room', ['room'=>$item->id])}}" style="border-radius: 5px" class="btn btn-success" data-toggle="modal">
                                        <i class="fa-solid fa-key" style="color:rgb(46, 46, 46)"></i> Asignar</span>
                                    </a>     
                                @endif
                                {{-- <a href="{{route('view-planta.room', ['room'=>$item->id])}}" style="border-radius: 5px" class="btn btn-warning" data-toggle="modal">
                                    <i class="fa-solid fa-bed" style="color:rgb(46, 46, 46)"></i> Reservar </span>
                                </a>   --}}
                            @else
                                <small style="font-size: 10px; color: red">{{ date('d-m-Y h:i', strtotime($service->start)) }}
                                 {{-- <br> Hasta <br> {{ date('d-m-Y h:i', strtotime($service->finish))}} --}}
                                </small>
                            @endif
                            
                            @if ($item->status==1)
                                <br>
                                <small style="font-size: 18px; color: rgb(0, 0, 0)"><i class="fa-solid fa-fan"></i> Bs. {{$item->amount??0}} <br><i class="fa-solid fa-wind"></i> Bs. {{$item->amount1??0}}</small>
                            @else  
                                <br>
                                <small style="font-size: 18px; color: rgb(0, 0, 0)">Bs. {{$service?$totalFinish:0}}</small>                                
                            @endif
                            <br>
                            <small style="font-size: 12px; color: rgb(0, 0, 0)">Categoría: {{$category->name}}</small>
                            
                            @if ($item->status == 0)
                                <br>
                                @if (auth()->user()->hasPermission('read_assign') )
                                    <a href="{{route('view-planta-room.read', ['room'=>$item->id])}}" style="border-radius: 8px" class="btn btn-dark" data-toggle="modal" title="Ver Detalle">
                                        <i class="fa-solid fa-eye"></i>
                                    </a>     
                                @endif
                                @if (auth()->user()->hasPermission('add_product') && $service->status == 'asignado')
                                    <a href="#" data-toggle="modal" style="border-radius: 8px" data-target="#modal_producto" data-id="{{$item->id}}" data-pieza="{{$item->number}}" data-planta="{{$item->categoryFacility_id}}" title="Vender producto al almacen" class="btn btn-success">
                                        <i class="fa-solid fa-cart-shopping"></i>
                                    </a>
                                @endif
                                @if (auth()->user()->hasPermission('add_food') && $service->status == 'asignado')
                                    <a href="#" data-toggle="modal" style="border-radius: 8px" data-target="#modal_menu" data-id="{{$item->id}}" data-pieza="{{$item->number}}" data-planta="{{$item->categoryFacility_id}}" title="Comidas del menú" class="btn btn-primary">
                                        <i class="fa-solid fa-bowl-food"></i>
                                    </a>
                                @endif
                                @if ( $service->status == 'asignado')
                                    <a href="#" data-toggle="modal" style="border-radius: 8px" data-target="#modal_finish" data-id="{{$item->id}}" data-pieza="{{$item->number}}" data-planta="{{$item->categoryFacility_id}}" title="Finalizar Hospedaje" class="btn btn-danger">
                                        <i class="fa-solid fa-hourglass-end"></i> 
                                    </a>
                                    <a href="#" data-toggle="modal" style="border-radius: 8px" data-target="#modelFinish_cancelar"  data-id="{{$item->id}}" data-pieza="{{$item->number}}" data-planta="{{$item->categoryFacility_id}}" title="Cancelar Hospedaje" class="btn btn-danger">
                                        <i class="fa-solid fa-ban"></i>
                                    </a>
                                @endif
                                @if ( $service->status == 'reservado')
                                    <a href="#" data-toggle="modal" style="border-radius: 8px" data-target="#modalReserva_start" data-start="{{$service->start}}" data-amountfinish="{{$totalFinish}}"  data-room="{{$service->amount}}" data-id="{{$item->id}}" data-pieza="{{$item->number}}" data-planta="{{$item->categoryFacility_id}}" title="Iniciar Hospedaje" class="btn btn-success">
                                        <i class="fa-regular fa-circle-play"></i>
                                    </a>
                                    <a href="#" data-toggle="modal" style="border-radius: 8px" data-target="#modalReserva_cancelar"  data-id="{{$item->id}}" data-pieza="{{$item->number}}" data-planta="{{$item->categoryFacility_id}}" title="Cancelar Reserva" class="btn btn-danger">
                                        <i class="fa-solid fa-ban"></i>
                                    </a>
                                @endif
                            @endif


                        </div>   
                        {{-- <div class="col-md-3"></div> --}}

                    </div>
                @empty
                    <tr style="text-align: center">
                        <td colspan="7" style="font-size: 50px" class="dataTables_empty">No hay habitaciones disponibles</td>
                    </tr>
                @endforelse
            </div>
        </div>

        {{-- Para vender productos del almacen --}}
        <form lass="form-submit" id="irremovability-form" action="{{route('serviceroom-article.store')}}" method="post">
            @csrf
            <div class="modal modal-success fade" id="modal_producto" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="voyager-categories"></i> Agregar Productos</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <small id="label-pieza" style="font-size: 15px"></small>
                                <input type="hidden" name="room_id" id="room_id">
                                <input type="hidden" name="planta_id" id="planta_id">
                            </div>
                            <div class="form-group">
                                <label>Productos</label>
                                <select class="form-control" id="select_producto"></select>
                            </div>
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="dataTable" class="tables table-bordered table-hover">
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
                                                <td colspan="6" style="height: 150px">
                                                    <h4 class="text-center text-muted" style="margin-top: 50px">
                                                        <i class="fa-solid fa-list" style="font-size: 50px"></i> <br><br>
                                                        Lista de detalle vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tr>
                                            <td colspan="4" style="text-align: right">
                                                Total
                                            </td>
                                            <td style="text-align: right">
                                                <small>Bs.</small> <b id="label-total">0.00</b>
                                                <input type="hidden" name="amount" id="input-total" value="0">
                                            </td>
                                            <td></td>
                                        </tr>
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

        {{-- para la venta de comidas ala pieza o habitacion --}}

        <form lass="form-submit" id="menu-form" action="{{route('serviceroom-foodmenu.store')}}" method="post">
            @csrf
            <div class="modal  fade" id="modal_menu" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-primary">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-solid fa-bowl-food"></i> Menú del Día</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <small id="label-pieza" style="font-size: 15px"></small>
                                <input type="hidden" name="room_id" id="room_id">
                                <input type="hidden" name="planta_id" id="planta_id">
                            </div>
                            <div class="form-group">
                                <label>Menú</label>
                                <select class="form-control" id="select_menu"></select>
                            </div>
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="dataTable" class="tables tablesMenu table-bordered table-hover">
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
                                        <tbody id="table-bodyMenu">
                                            <tr id="tr-emptyMenu">
                                                <td colspan="6" style="height: 150px">
                                                    <h4 class="text-center text-muted" style="margin-top: 50px">
                                                        <i class="fa-solid fa-list" style="font-size: 50px"></i> <br><br>
                                                        Lista de detalle vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tr>
                                            <td colspan="4" style="text-align: right">
                                                Total
                                            </td>
                                            <td style="text-align: right">
                                                <small>Bs.</small> <b id="label-totalMenu">0.00</b>
                                                <input type="hidden" name="amount" id="input-totalMenu" value="0">
                                            </td>
                                            <td></td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary btn-submit" value="Guardar">
                        </div>
                    </div>
                </div>
            </div>
        </form>


        {{-- Para finalizar el hopedaje --}}
        <form lass="form-submit" id="menu-form" action="{{route('serviceroom-hospedaje-close')}}" method="post">
            @csrf
            <div class="modal fade" id="modal_finish" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-danger">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-solid fa-hourglass-end"></i> Finalizar Hospedaje</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="room_id" id="room_id">
                            <input type="hidden" name="planta_id" id="planta_id">
                            <input type="hidden" name="amountFinish" id="amountFinish">
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="dataTable" class="tables tablesMenu table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px">N&deg;</th>
                                                <th style="text-align: center">Detalle</th>  
                                                <th style="text-align: center; width: 80px">Precio</th>  
                                                <th style="text-align: center; width: 80px">Cantidad</th>  
                                                <th style="text-align: center; width: 80px">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-bodyFinish">
                                            <tr id="tr-emptyMenuFinish">
                                                <td colspan="5" style="height: 30px">
                                                    <h4 class="text-center text-muted" style="margin-top: 5px">
                                                        <i class="fa-solid fa-list" style="font-size: 20px"></i> <br>
                                                        Lista de detalle vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tr>
                                            <td colspan="4" style="text-align: right">
                                                Total <small>Bs.</small>
                                            </td>
                                            <td style="text-align: right">
                                                <small><b id="label-totalDetailFinish" class="label-totalDetailFinish">0.00</b></small>
                                                <input type="hidden" id="subTotalDetalle" name="subTotalDetalle">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="dataTable" class="tables tablesMenu table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px">N&deg;</th>
                                                <th style="text-align: center">Detalle</th>  
                                                <th style="text-align: center; width: 80px">Precio</th>  
                                                <th style="text-align: center; width: 80px">Cantidad</th>  
                                                <th style="text-align: center; width: 80px">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-bodyFinish1">
                                            <tr id="tr-emptyMenuFinish1">
                                                <td colspan="5" style="height: 30px">
                                                    <h4 class="text-center text-muted" style="margin-top: 5px">
                                                        <i class="fa-solid fa-list" style="font-size: 20px"></i> <br>
                                                        Lista de detalle vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tr>
                                            <td colspan="4" style="text-align: right">
                                                Total <small>Bs.</small>
                                            </td>
                                            <td style="text-align: right">
                                                <small><b id="label-totalDetailFinish1" class="label-totalDetailFinish1">0.00</b></small>
                                                <input type="hidden" id="subTotalMenu" name="subTotalMenu">
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                            </div>

                            {{-- Para mostrar el detalle de los ospedaje --}}
                            <div class="form-group">
                                <div class="table-responsive">
                                    <table id="dataTable" class="tables tablesMenu table-bordered table-hover">
                                        <thead>
                                            <tr>
                                                <th style="width: 30px">N&deg; Hab.</th>
                                                <th style="text-align: center; width: 150px">Fecha de Hospedaje</th>    
                                                <th style="text-align: center; width: 150px">Fecha Fin Hospedaje</th>  
                                                <th style="text-align: center; width: 80px">Precio Por Dia</th>    

                                                <th style="text-align: center; width: 80px">Dias Hosp.</th>
                                                <th style="text-align: center; width: 80px">Sub Total</th>
                                            </tr>
                                        </thead>
                                        <tbody id="table-bodyHospedaje">
                                            <tr id="tr-emptyHospedaje">
                                                <td colspan="6" style="height: 30px">
                                                    <h4 class="text-center text-muted" style="margin-top: 5px">
                                                        <i class="fa-solid fa-list" style="font-size: 20px"></i> <br>
                                                        Lista de detalle vacía
                                                    </h4>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-12">                            
                            <div class="alert alert-success">
                                <strong>Pago Total:</strong>
                                <p id="letra"></p>
                               
                            </div>
                            <div class="form-group">
                                <input type="radio" id="html" name="qr" value="0" checked>
                                <label for="html"><small style="font-size: 15px">Efectivo</small></label>
                                &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <input type="radio" id="css" name="qr" value="1">
                                <label for="css"><small style="font-size: 15px">QR</small></label><br>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-danger btn-submit" value="Finalizar">
                        </div>
                    </div>
                </div>
            </div>
        </form>

        {{-- Para cancelar el hospedaje cuando esta asignada la habitacion --}}
        <form lass="form-submit" id="menu-form" action="{{route('serviceroom-hospedaje.cancel')}}" method="post">
            @csrf
            <div class="modal fade" id="modelFinish_cancelar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-danger">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-solid fa-ban"></i> Cancelar Hospedaje</h4>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" name="room_id" id="room_id">
                            <input type="hidden" name="planta_id" id="planta_id">

                            <small id="label-pieza" style="font-size: 15px"></small>
                            
                        </div>
                        <div class="modal-footer">        
                            <div class="text-center" style="text-transform:uppercase">
                                <i class="fa-solid fa-ban" style="color: red; font-size: 5em;"></i>
                                <br>                                        
                                <p><b>Desea cancelar la reserva de la siguiente habitacion?</b></p>
                            </div>
                            <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Sí, cancelar hospedaje">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>



        <form lass="form-submit" id="menu-form" action="{{route('serviceroom-foodmenu.store')}}" method="post">
            @csrf
            <div class="modal  fade" id="modal_cancelar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-primary">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-solid fa-bowl-food"></i> Cancelar</h4>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <small id="label-pieza" style="font-size: 15px"></small>
                                <input type="hidden" name="room_id" id="room_id">
                                <input type="hidden" name="planta_id" id="planta_id">
                            </div>
                            <div class="form-group">
                                <label>Menú</label>
                                <select class="form-control" id="select_menu"></select>
                            </div>
                            <div class="form-group">
                                <div class="table-responsive">
                                   
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Cancelar</button>
                            <input type="submit" class="btn btn-primary btn-submit" value="Guardar servicio">
                        </div>
                    </div>
                </div>
            </div>
        </form>



        {{-- Para reserva del Hotel para las habitaciones --}}
        <form lass="form-submit" id="menu-form" action="{{route('serviceroom-hospedaje-reserva.cancel')}}" method="post">
            @csrf
            <div class="modal fade" id="modalReserva_cancelar" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content modal-danger">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-solid fa-ban"></i> Cancelar Reserva</h4>
                        </div>
                        <div class="modal-body">
                            <small id="label-pieza" style="font-size: 15px"></small>
                            <input type="hidden" name="room_id" id="room_id">
                            <input type="hidden" name="planta_id" id="planta_id">

                            
                        </div>
                        <div class="modal-footer">        
                            <div class="text-center" style="text-transform:uppercase">
                                <i class="fa-solid fa-ban" style="color: red; font-size: 5em;"></i>
                                <br>                                        
                                <p><b>Desea cancelar la reserva de la siguiente habitacion?</b></p>
                            </div>
                            <input type="submit" class="btn btn-danger pull-right delete-confirm" value="Sí, cancelar reserva">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>

        <form lass="form-submit" id="irremovability-form" action="{{route('serviceroom-hospedaje-reserva.start')}}" method="post">
            @csrf
            <div class="modal modal-success fade" id="modalReserva_start" role="dialog">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title"><i class="fa-regular fa-circle-play"></i> Iniciar hospedaje</h4>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <small id="label-pieza" style="font-size: 15px"></small>
                                <input type="hidden" name="room_id" id="room_id">
                                <input type="hidden" name="planta_id" id="planta_id">
                                </div>
                            </div>
                            <div class="text-center" style="text-transform:uppercase">
                                <i class="fa-regular fa-circle-play" style="color: #1abc9c; font-size: 5em;"></i>
                                <br>                                        
                                <p><b>Iniciar el Hospedaje?</b></p>
                            </div>
                            <div class="col-md-12">
                                <div class="panel-body">
                                    <label><small>Fecha Inicio de Hospedaje</small></label>
                                    <input type="datetime-local" name="start" id="start"  class="form-control" required>
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">        
                            
                            <input type="submit" class="btn btn-success pull-right delete-confirm" value="Sí, iniciar hospedaje">
                            <button type="button" class="btn btn-default pull-right" data-dismiss="modal">Cancelar</button>
                        </div>
                    </div>
                </div>
            </div>
        </form>



    </div>
@stop
@section('css')
<style>
    div#myDiv{
        background-image: url('https://us.123rf.com/450wm/photo5963/photo59631709/photo5963170900061/85635272-fondo-habitaci%C3%B3n-vac%C3%ADa.jpg');

        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;  
    }
    .select2{
            width: 100% !important;
        }
    
</style>

@stop

@section('javascript')

<script src="{{ url('js/main.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script>    

<script>

        $('#modal_producto').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var pieza = button.data('pieza');
            var planta = button.data('planta');
            var modal = $(this);
            modal.find('.modal-body #room_id').val(id);
            modal.find('.modal-body #planta_id').val(planta);
            modal.find('.modal-body #label-pieza').text('Pieza N° '+pieza);

            $('#table-body').empty();

            $('#label-total').text(0);
            $('#input-total').val(0)
            $('#select_producto').val("").trigger("change");

        })

        $('#modal_menu').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var pieza = button.data('pieza');
            var planta = button.data('planta');
            var modal = $(this);
            modal.find('.modal-body #room_id').val(id);
            modal.find('.modal-body #planta_id').val(planta);
            modal.find('.modal-body #label-pieza').text('Pieza N° '+pieza);

            $('#table-bodyMenu').empty();

            $('#label-totalMenu').text(0);
            $('#input-totalMenu').val(0)
            $('#select_menu').val("").trigger("change");
        })


        // Para finalizar el hospedaje y sacar cuanto ha consumido y su deuda total
        let aux =1;
        $('#modal_finish').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var pieza = button.data('pieza');
            var planta = button.data('planta');

            // var room = button.data('room');

            // let amountfinish = 0;
            // amountfinish = button.data('amountfinish');
            // amountfinish = parseFloat(amountfinish).toFixed(2);

            var modal = $(this);
            modal.find('.modal-body #room_id').val(id);
            modal.find('.modal-body #planta_id').val(planta);
            // modal.find('.modal-body #amountFinish').val(amountfinish);

            // $('#label-roomAmount').empty();
            // $('#label-roomAmount').text(room);           
       
            

      
            // var totalArticle =0;
            // var totalMenu =0;
            var TotalHosp =0;

            dateFinish = $('#dateFinishClose').val();
            // alert(dateFinish)
            $.get('{{route('serviceroom-finish.article')}}/'+id, function (data) {
                // alert(data);
                
                detailTotal=0;
                for (i = 0; i < data.length; i++) {
                    if(i==0)
                    {
                        $('#table-bodyFinish').empty();
                    }
                    for (x = 0; x < data[i].detail.length; x++) {
                        $('#table-bodyFinish').append(`   
                            <tr class="tr-item">
                                <td class="td-itemMenu">${i+1}</td>
                                <td>
                                    <small>${data[i].detail[x].article.name}</small><br>
                                </td>
                                <td style="text-align: right">
                                    <small>${data[i].detail[x].price}</small><br>
                                </td>
                                <td style="text-align: right">
                                    <small>${data[i].detail[x].cantSolicitada}</small><br>
                                </td>
                                <td style="text-align: right">
                                    <small>${data[i].detail[x].amount}</small><br>
                                </td>

                            </tr>
                        `
                        );
                        detailTotal = parseFloat(detailTotal) + parseFloat(data[i].detail[x].amount);
                    }
                }     
                $('#label-totalDetailFinish').text(detailTotal);
                $('#subTotalDetalle').val(detailTotal);

            });
            $.get('{{route('serviceroom-finish.menu')}}/'+id, function (data) {
                menuTotal=0;
                for (i = 0; i < data.length; i++) {
                    if(i==0)
                    {
                        $('#table-bodyFinish1').empty();
                    }
                    for (x = 0; x < data[i].menu.length; x++) {
                        $('#table-bodyFinish1').append(`   
                            <tr class="tr-item">
                                <td class="td-itemMenu">${i+1}</td>
                                <td>
                                    <small>${data[i].menu[x].food.name}</small><br>
                                </td>
                                <td style="text-align: right">
                                    <small>${data[i].menu[x].price}</small><br>
                                </td>
                                <td style="text-align: right">
                                    <small>${data[i].menu[x].cant}</small><br>
                                </td>
                                <td style="text-align: right">
                                    <small>${data[i].menu[x].amount}</small><br>
                                </td>

                            </tr>
                        `
                        );
                        menuTotal = parseFloat(menuTotal) + parseFloat(data[i].menu[x].amount);                        
                    }                    
                }                            // alert(data)
                $('#label-totalDetailFinish1').text(menuTotal);
                $('#subTotalMenu').val(menuTotal);

                // totalMenu= menuTotal;   
            });


            moment.locale('es');
            let now= moment();
            dateFinish = now.format('YYYY-MM-DD hh:mm');

            $.get('{{route('serviceroom-finish.rooms')}}/'+id+'/'+dateFinish, function (data) {
                        $('#table-bodyHospedaje').empty();
                        $('#table-bodyHospedaje').append(`   
                            <tr class="tr-item">
                                <td>
                                    <small>${data.number}</small><br>
                                    <input type="hidden" id="serviceRoom_idf" name="serviceRoom_idf" value="${data.room_id}">
                                </td>                                
                                <td style="text-align: right">
                                    <small>${moment(data.start).format('DD-MM-YYYY h:mm:ss a')}</small><br>
                                </td>
                                <td style="text-align: right">
                                    <input type="datetime-local" id="finishf" name="finishf" value="{{date('Y-m-d h:i') }}" onchange="subTotal()" onkeyup="subTotal()" class="form-control" required>
                                </td>
                                <td style="text-align: right">
                                    <small>${data.typePrice}</small><br>
                                    <input type="hidden" id="pricef" name="pricef" value="${data.typePrice}">
                                </td>
                                <td style="text-align: right">
                                    <small id="labelDia">${data.dia}</small><br>
                                    <input type="hidden" id="diaf" name="diaf" value="${data.dia}">
                                </td>
                                <td style="text-align: right">
                                    <small id="labelPagar">${data.totalPagar}</small><br>
                                    <input type="hidden" id="pagarf" name="pagarf" value="${data.totalPagar}">
                                </td>

                            </tr>
                        `
                        );
                
                TotalHosp=data.totalPagar;  

                $('#letra').empty();
                $('#letra').append('<small> Total a pagar de los servicios mas el hospedaje Bs '+(parseFloat(detailTotal+menuTotal+TotalHosp))+'</small>');     
            });
            // alert(parseFloat(totalArticle+totalMenu+TotalHosp))
            
            
            
        })
        function subTotal()
        {
            let dateFinishf = $("#finishf").val();
            // alert(dateFinishf)
            let id_f = $('#serviceRoom_idf').val();
            // alert(id_f)
            $.get('{{route('serviceroom-finish.rooms')}}/'+id_f+'/'+dateFinishf, function (data) {
                $('#labelDia').text(data.dia);
                $('#diaf').val(data.dia);

                $('#labelPagar').text(data.totalPagar);
                $('#pagarf').val(data.totalPagar);
                
                auxArticle = parseFloat($('#subTotalDetalle').val());
                auxMenu = parseFloat($('#subTotalMenu').val());
                totaPagar = parseFloat(data.totalPagar);
                

                $('#letra').empty();
                $('#letra').append('<small> Total a pagar de los servicios mas el hospedaje Bs '+(parseFloat(auxArticle+auxMenu+totaPagar))+'</small>');

            });
                
        }
        
        $('#modelFinish_cancelar').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var pieza = button.data('pieza');
            var planta = button.data('planta');
            var modal = $(this);
            modal.find('.modal-body #room_id').val(id);
            modal.find('.modal-body #planta_id').val(planta);
            modal.find('.modal-body #label-pieza').text('Pieza N° '+pieza);
        })


        //Para las reserva
        $('#modalReserva_cancelar').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var pieza = button.data('pieza');
            var planta = button.data('planta');
            var modal = $(this);
            modal.find('.modal-body #room_id').val(id);
            modal.find('.modal-body #planta_id').val(planta);
            modal.find('.modal-body #label-pieza').text('Pieza N° '+pieza);
        })
        $('#modalReserva_start').on('show.bs.modal', function (event)
        {
            var button = $(event.relatedTarget);
            var id = button.data('id');
            var pieza = button.data('pieza');
            var planta = button.data('planta');
            var start = button.data('start');
            var modal = $(this);
            modal.find('.modal-body #room_id').val(id);
            modal.find('.modal-body #planta_id').val(planta);
            modal.find('.modal-body #start').val(start);
            modal.find('.modal-body #label-pieza').text('Pieza N° '+pieza);

        })




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


            //para la seleccion del menu del dia
            $('#select_menu').select2({
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
                    url: "{{ url('admin/food/menu/list/ajax') }}",        
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
                templateResult: formatResultMenu,
                templateSelection: (opt) => {
                    productSelected = opt;

                    
                    return opt.id?opt.food.name:'<i class="fa fa-search"></i> Buscar... ';
                }
            }).change(function(){
                // alert(1)
                if($('#select_menu option:selected').val()){
                    let product = productSelected;
                    if($('.tablesMenu').find(`#tr-item-menu-${product.id}`).val() === undefined){
                    // alert(product.name);

                        $('#table-bodyMenu').append(`
                            <tr class="tr-item" id="tr-item-menu-${product.id}">
                                <td class="td-itemMenu"></td>
                                <td>
                                    <b class="label-description" id="description-${product.id}"><small>${product.food.name}</small><br>
                                    <input type="hidden" name="food[]" value="${product.food.id}" />
                                </td>
                                <td style="text-align: right">
                                    <b class="label-description"><small>Bs. ${product.amount}</small>
                                    <input type="hidden" name="price[]" id="select-amount-${product.id}" value="${product.amount}" />
                                </td>
                                <td>
                                    <input type="number" name="cant[]" min="0" step="1" id="select-cant-menu-${product.id}" onkeyup="getSubtotalMenu(${product.id})" onchange="getSubtotalMenu(${product.id})" onkeypress="return filterFloat(event,this);" style="text-align: right" class="form-control text" required>
                                </td>
                                <td class="text-right"><h4 class="label-subtotal-menu" id="label-subtotal-menu-${product.id}">0</h4></td>
                                <td class="text-right"><button type="button" onclick="removeTrMenu(${product.id})" class="btn btn-link"><i class="voyager-trash text-danger"></i></button></td>
                            </tr>
                        `);
                    }else{
                        toastr.info('EL detalle ya está agregado', 'Información')
                    }
                    setNumberMenu();
                    getSubtotalMenu(product.id);
                }
            });
            

        })

        function formatResultCustomers(option){
        // Si está cargando mostrar texto de carga
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

        function formatResultMenu(option){
        // Si está cargando mostrar texto de carga
            if (option.loading) {
                return '<span class="text-center"><i class="fas fa-spinner fa-spin"></i> Buscando...</span>';
            }
            let image = "{{ asset('image/default.jpg') }}";
            if(option.food.image){
                image = "{{ asset('storage') }}/"+option.food.image.replace('.', '-cropped.');
                // alert(image)
            }
            
            // Mostrar las opciones encontradas
            return $(`  <div style="display: flex">
                            <div style="margin: 0px 10px">
                                <img src="${image}" width="50px" />
                            </div>
                            <div>
                                <b style="font-size: 16px">${option.food.name} </b> <br>
                                <small>Precio: </small>Bs. ${option.amount}
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

        //para la opcion de menu
        function setNumberMenu(){
            var length = 0;
            $(".td-itemMenu").each(function(index) {
                $(this).text(index +1);
                length++;
            });

            if(length > 0){
                $('#tr-emptyMenu').css('display', 'none');
            }else{
                $('#tr-emptyMenu').fadeIn('fast');
            }
        }

        function getSubtotalMenu(id){
                let price = $(`#select-amount-${id}`).val() ? parseFloat($(`#select-amount-${id}`).val()) : 0;
                let quantity = $(`#select-cant-menu-${id}`).val() ? parseFloat($(`#select-cant-menu-${id}`).val()) : 0;
                $(`#label-subtotal-menu-${id}`).text((price * quantity).toFixed(2));
                getTotalMenu();
        }
        function getTotalMenu(){
                let total = 0;
                $(".label-subtotal-menu").each(function(index) {
                    total += parseFloat($(this).text());
                });
                $('#label-totalMenu').text(total.toFixed(2));
                $('#input-totalMenu').val(total.toFixed(2));
        }
        function removeTrMenu(id){
            $(`#tr-item-menu-${id}`).remove();
            $('#select_menu').val("").trigger("change");
            setNumberMenu();
            getTotalMenu();
        }
        
</script>
    

@stop
