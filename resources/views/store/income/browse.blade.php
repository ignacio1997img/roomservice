@extends('voyager::master')

@section('page_title', 'Viendo Ingreso')

{{-- @if (auth()->user()->hasPermission('browse_loans')) --}}

@section('page_header')
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-12">
                <div class="panel panel-bordered">
                    <div class="panel-body" style="padding: 0px">
                        <div class="col-md-4" style="padding: 0px">
                            <h1 id="titleHead" class="page-title">
                                <i class="fa-sharp fa-solid fa-cart-shopping"></i> Ingresos
                            </h1>

                            
                        </div>
                        <div class="col-md-8 text-right" style="margin-top: 30px">
                            {{-- @if (auth()->user()->hasPermission('add_people')) --}}
                            <a href="{{ route('incomes.create') }}" class="btn btn-success">
                                <i class="voyager-plus"></i> <span>Crear</span>
                            </a>
                            {{-- @endif --}}
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




@stop

@section('css')

@stop

@section('javascript')
    <script>

    




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
            // $('#div-results').loading({message: 'Cargando...'});

            // $("#div-results").LoadingOverlay("show");
            let type = $(".radio-type:checked").val();
            // alert(type)

            var loader = '<div class="col-md-12 bg"><div class="loader" id="loader-3"></div></div>'
            $('#div-results').html(loader);

            let url = "{{ url('admin/loans/ajax/list')}}/"+cashier_id;
            let search = $('#input-search').val() ? $('#input-search').val() : '';

            $.ajax({
                url: `${url}/${type}/${search}?paginate=${countPage}&page=${page}`,
                type: 'get',
                
                success: function(result){
                $("#div-results").html(result);
            }});

        }

        function deleteItem(url){
            $('#delete_form').attr('action', url);
        }

        //Para la destruccion de un prestamos pero con caja cerrada 
        function destroyItem(url){
            $('#destroy_form').attr('action', url);
        }
        
        function rechazarItem(url){
            $('#rechazar_form').attr('action', url);
        }
        function successItem(url){
            $('#success_form').attr('action', url);
        }

        function agentItem(url){
            $('#agent_form').attr('action', url);
        }

        var loanC = 0;

        function deliverItem(url, id, amountTotal){
            $('#deliver_form').attr('action', url);
            loanC = id;
            if(amountTotal > balance && cashier_id!=0)
            {
                // $('#btn-submit-delivered').attr('disabled', 'disabled');
                $('#btn-submit-delivered').css('display', 'none');

                Swal.fire({
                    target: document.getElementById('deliver_form'),
                    icon: 'error',
                    title: 'Oops...',
                    text: 'Su saldo disponible de Caja es insuficiente!',
                    // footer: '<a href="">Why do I have this issue?</a>'
                })
            }
            if(amountTotal < balance && cashier_id!=0)
            {
                
                $('#btn-submit-delivered').css('display', 'block');
            }
        }

        


        function miFunc() {

            let phone = $('#phone').val();
            let name = $('#name').val();

            let timerInterval
            Swal.fire({
                title: 'Notificacion enviada',
                html: '<h2><i class="fa-regular fa-envelope"></i></h2>',
                timer: 2000,
                timerProgressBar: true,
                didOpen: () => {
                    Swal.showLoading()
                    const b = Swal.getHtmlContainer().querySelector('b')
                    timerInterval = setInterval(() => {
                    b.textContent = Swal.getTimerLeft()
                    }, 50)
                },
                willClose: () => {
                    clearInterval(timerInterval)
                }
                }).then((result) => {
                if (result.dismiss === Swal.DismissReason.timer) {
                    console.log('I was closed by the timer')
                }
            })

            url = "http://whatsapp.capresi.net/?number=591"+phone+"&message=Hola *"+name+"*.%0A%0A*SU SOLICITUD DE PRESTAMO HA SIDO APROBADA EXITOSAMENTE*%0A%0APase por favor por las oficinas para entregarle su solicitud de prestamos%0A%0AGracias🤝😊";

            const xhr = new XMLHttpRequest();
            xhr.open("GET", url);
            xhr.send();
            // xhr.responseType = "json";

            // window.open("http://api.trabajostop.com:3001/?number=59167285914&message=hola")
            $("#notificar-modal").modal('hide');
        }
        $('#notificar-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var phone = button.data('phone')
            var name = button.data('name')
            var modal = $(this)
            modal.find('.modal-body #name').val(name)
            modal.find('.modal-body #phone').val(phone)
        });


        function loan(id)
        {
            // alert(id);
            loanC = id;
            printContract();
        }

        function printContract(){
            // window.open("https://trabajostop.com", "Recibo", `width=700, height=500`)
            window.open("{{ url('admin/loans/contract/daily') }}/"+loanC, "Recibo", `width=700, height=500`)
        }




        $('#deliver-modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget) 
            var data = button.data('fechass')
            // alert(data)
            var modal = $(this)
            modal.find('.modal-footer #fechass').val(data)
        });




        
        

    </script>
@stop
{{-- @endif --}}