@extends('voyager::master')

@section('content')
    <div class="page-content">
        {{-- @include('voyager::alerts')
        @include('voyager::dimmers') --}}
        
        <div class="analytics-container">
            

        
            <div class="row" style="text-align: center ">
                @foreach ($data as $item)
                    @php
                        $category =  \App\Models\CategoriesRoom::where('id', $item->categoryRoom_id)->first();
                        $aux =  \App\Models\CategoriesRoomsPart::where('categoryRoom_id', $item->categoryRoom_id)->where('deleted_at',null)->get();
                        $total =0;
                        foreach ($aux as $value) {
                            $total = $total + $value->amount;
                        }
                    @endphp
                    <div class="col-md-2" class="grid-block ">
                        {{-- <div class="col-md-3"></div> --}}
                        <div class="col-md-12" id="myDiv" style="margin-top: 1em; border-radius: 20px; height:300px; @if($item->status == 0) box-shadow: #F44E3E 0px 35px 60px -12px inset;@endif">
                            <br>
                            {{-- <i class="fa-solid fa-key"></i> --}}
                            
                            <p style="font-size: 22px; color: #ffffff;"><small>Pieza N° {{$item->number}}</small></p>                            
                            @if ($item->status == 1)
                                <a href="{{route('view-planta.room', ['room'=>$item->id])}}" class="btn btn-success" data-toggle="modal">
                                    <i class="fa-solid fa-key" style="color:rgb(46, 46, 46)"></i> Asignar</span>
                                </a>     
                            @else
                                <small style="font-size: 20px; color: red">Habitación Ocupáda</small>
                            @endif
                            <br>
                            @if ($item->status==1)
                                <small style="font-size: 20px; color: rgb(0, 0, 0)">Bs. {{$total}}</small>
                            @else
                                @php
                                    $service =  \App\Models\ServiceRoom::where('room_id', $item->id)->where('status', 1)->first();                                    
                                @endphp
                                <small style="font-size: 20px; color: rgb(0, 0, 0)">Bs. {{$service?$service->amount:0}}</small>                                
                            @endif
                            <br>
                            <small style="font-size: 15px; color: rgb(0, 0, 0)">Categiría: {{$category->name}}</small>
                            @if ($item->status == 0)
                            <br>
                                <a href="{{route('view-planta.room', ['room'=>$item->id])}}" class="btn btn-dark" data-toggle="modal">
                                    <i class="fa-solid fa-eye"></i> Ver</span>
                                </a>     
                            @endif


                        </div>   
                        {{-- <div class="col-md-3"></div> --}}

                    </div>
                @endforeach
                

            </div>
            
            
            
        </div>
    </div>
@stop
@section('css')
<style>
    div#myDiv{
        /* width:200px;
        height:200px; */
        background-image: url('https://us.123rf.com/450wm/photo5963/photo59631709/photo5963170900061/85635272-fondo-habitaci%C3%B3n-vac%C3%ADa.jpg');
        /* background-color: rgba(145, 12, 12, 0.4) !important; */
        /* box-shadow: 5px 5px 15px rgb(223, 5, 5); */
        /* box-shadow: 35px 15px 15px rgb(255, 114, 114) inset; */

        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;  
    }
</style>

@stop

@section('javascript')

    

@stop
