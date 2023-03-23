@extends('voyager::master')

@section('content')
    <div class="page-content">
        {{-- @include('voyager::alerts')
        @include('voyager::dimmers') --}}
        
        <div class="analytics-container">
            

        
            <div class="row" style="text-align: center">
                @php
                    $pdf =  \App\Models\CategoriesFacility::where('deleted_at',null)->get();
                @endphp
                @forelse ($pdf as $item)
                    <div class="col-md-4" style="text-align: center">
                        <div class="col-md-2"></div>
                        <div class="col-md-8" id="myDiv" style="background-color: #DFDFDF; margin-top: 2em; border-radius: 20px; height:320px">
                            <br>
                            <i class="fa-solid fa-house" style="color: #545454; font-size: 3em;"></i>
                            <p style="font-size: 22px; color: #ffffff;"><small>{{$item->name}}</small></p>                            
                            <a href="{{route('view.planta', ['planta'=>$item->id])}}" class="btn btn-primary" data-toggle="modal">
                                    <i class="fa-solid fa-eye"></i><span class="hidden-xs hidden-sm"> Ver</span>
                            </a>
                            <br><br><br><br>
                            @php
                                $libre =  \App\Models\Room::where('categoryFacility_id', $item->id)->where('status', 1)->where('deleted_at',null)->get();
                                $ocupada =  \App\Models\Room::where('categoryFacility_id', $item->id)->where('status', 0)->where('deleted_at',null)->get();
                                
                            @endphp
                            <p style="text-align: left"><small>Habitaciones Libres: <span style="font-size: 15px">{{count($libre)}}</span></small></p>
                            <p style="text-align: left"><small>Habitaciones Ocupada: <span style="font-size: 15px">{{count($ocupada)}}</span></small></p>
                            <p style="text-align: left"><small>Total de Habitaciones: <span style="font-size: 15px">{{count($libre)+count($ocupada)}}</span></small></p>


                        </div>   
                        <div class="col-md-2"></div>

                    </div>
               
                @empty
                    <tr style="text-align: center">
                        <td colspan="7" style="font-size: 50px" class="dataTables_empty">No hay planta de habitaciones disponibles</td>
                    </tr>
                @endforelse

            </div>
            
            
            
        </div>
    </div>
@stop
@section('css')
<style>
    div#myDiv{
        /* width:200px;
        height:200px; */
        background-image: url('https://fastrack-stamford.imgix.net/Stamford-Grand-Adelaide/Rooms/New-Suite-822-Bedroom.jpg?auto=%2Cformat%2Ccompress&fit=clip&ixlib=php-3.3.1&w=992');


        background-repeat:no-repeat;
        background-size:cover;
        background-position:center center;  
    }
</style>
@stop

@section('javascript')
<script>   

    $(document).on('change','.imageLengthpdf',function(){
        var fileName = this.files[0].name;
        var fileSize = this.files[0].size;

            if(fileSize > 10000000){
                Swal.fire({
                    icon: 'error',
                    title: 'Oops...',
                    text: 'El archivo no debe superar los 10 MB!'
                })
                this.value = '';
                this.files[0].name = '';
            }
            var ext = fileName.split('.').pop();
            ext = ext.toLowerCase();
            switch (ext) {
                case 'pdf': break;
                default:
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'El archivo no tiene la extensión adecuada!'
                    })
                    this.value = ''; // reset del valor
                    this.files[0].name = '';
            }
    });
</script>
    

@stop
