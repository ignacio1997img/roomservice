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
                @foreach ($pdf as $item)
                    <div class="col-md-4" style="text-align: center">
                        <div class="col-md-3"></div>
                        <div class="col-md-6" style="background-color: #DFDFDF; margin-top: 2em; border-radius: 20px; height:320px">
                            <br>
                            <i class="fa-solid fa-house" style="color: #545454; font-size: 6em;"></i>
                            <p style="font-size: 22px; color: #ffffff;"><small>{{$item->name}}</small></p>                            
                            <a href="{{route('view.planta', ['planta'=>$item->id])}}" class="btn btn-dark" data-toggle="modal">
                                    <i class="fa-solid fa-eye"></i><span class="hidden-xs hidden-sm"> Ver</span>
                            </a>
                            <br><br>
                            <p style="text-align: left"><small>Habitaciones Libres:</small></p>
                            <p style="text-align: left"><small>Habitaciones Ocupada:</small></p>
                            <p style="text-align: left"><small>Total de Habitaciones:</small></p>


                        </div>   
                        <div class="col-md-3"></div>

                    </div>
                @endforeach
                

            </div>
            
            
            
        </div>
    </div>
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
