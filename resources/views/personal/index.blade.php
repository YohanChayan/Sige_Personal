@extends('layouts.app')
@section('content')

@if(Auth::check())
    <div class="container-fluid">
        <div class="row">
        <div class="col-12">

            @if (session('message'))
                <div class="alert alert-success">
                    {{ session('message') }}
                </div>
            @endif
                @if($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach($errors->all() as $error)
                            <li>{{$error}}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <br>
        </div>
        </div>
        <div class="row">
            <div class="col-12">


        <form id="form" action="#btnSearch" >
          @csrf
          <div class="row align-items-center">
              <div class="col-md-3 offset-md-1 text-end">
                  <h3 class="card-title"><span class="text-success"><i class="fa fa-search"></span></i> Búsqueda</h3>
              </div>
              <div class="col-md-3">
                  <input type="text" class="form-control" id="filter" name="filter" placeholder="Buscar" />
              </div>

              <div class="col-md-2">
                <select class="form-select" id="filterBy" name="filterBy" aria-label="Default select example">
                  <option value="nombre" selected>Buscar por nombre</option>
                  <option value="codigo">Buscar por código</option>
                </select>
              </div>

              <div class="col-md-3">
                  <button class="btn btn-info" id="btnSearch" >Buscar</button>
              </div>
          </div>
        </form>

        <ul class="list-group" id="result">
        </ul>

            <h2>Listado de Personal </h2>
            <br>
                <p align="right">
                    <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
                    @can('cNormal_PERSONAL#editar')
                        <a href="{{ route('personal.create') }}" class="btn btn-success"> Capturar Personal</a>
                    @endcan
                    <a href="#" data-toggle="modal" data-target="#reportModal" class="btn btn-info" >Reportes</a>
                    {{-- <a  href="{{ route('personal.exportPDF') }}" class="btn btn-danger">Reportes en PDF</a> --}}
                </p>

            <table id="example" class="table table-striped table-bordered" style="width:100%">
                <thead>
                <tr>
                    <th>Acciones</th>
                    <th>Código</th>
                    <th>Nombre</th>
                    <th>Sexo</th>
                    <th>RFC</th>
                    <th>CURP</th>
                    <th>Adscribción</th>
                    <th>Contacto</th>
                </tr>
                </thead>
                <tbody id="tbody1">

                </tbody>
            </table>



        </div>
    </div>


    <p>
        <a href="{{ route('home') }}" class="btn btn-primary">< Regresar</a>
    </p>

    <!-- Modal -->
    <div class="modal fade" id="reportModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Reportes</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">

            <div class="col-6 mx-auto">

                <form method="post" action="{{route('personal.excel_form')}}">
                    @csrf

                    <div class="form-check">
                      <input type="checkbox" value="1" id="solobaja" name="solobaja">
                      <label  for="solobaja">
                        <strong>Solo dados de baja</strong>
                      </label>
                    </div>

                      <div class="form-row">

                      <div class="form-group ">
                        <label for="category"><p class="font-weight-bold mb-0">Seleccione categoría:</p>
                        </label>
                        <div class="input-group">
                          <select class="custom-select" name="categoria" id="category">
                            <option selected value="all"> Todos </option>
                            <option value="academic"> Solo académicos  </option>
                            <option value="admin"> Solo administrativos  </option>
                          </select>
                        </div>
                      </div>
                      </div>

                      {{-- <div class="form-row">
                          <div class="form-group">
                            <label for="data"><p class="font-weight-bold mb-0">Seleccione los datos de interés:</p>
                            </label>
                            <div class="input-group">
                              <select class="custom-select" name="datos" id="data">
                                <option selected value="0"> Datos principales </option>
                                <option value="datos_personales">Datos personales</option>
                                <option value="datos_minimos">Datos mínimos</option>
                                <option value="datos_todos"> Todos </option>
                              </select>
                            </div>
                          </div>
                      </div> --}}


                      <div class="form-row">
                          <div class="form-group">
                            <label for="orderby"><p class="font-weight-bold mb-0">Ordenar por:</p>
                            </label>
                            <div class="input-group">
                              <select class="custom-select" name="ordenarPor" id="orderby">
                                <option selected value="Codigo"> Código </option>
                                <option value="NombreYApellidos"> Nombre y apellidos </option>
                                <option value="Division"> División </option>
                                <option value="Categoria"> Categoría </option>
                              </select>
                            </div>
                          </div>
                      </div>


                      <button type="submit" class="btn btn-success">Generar</button>
                    </form>
                </div>

          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
          </div>
        </div>
      </div>
    </div>



</div>


{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"> </script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js"> </script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"> </script> --}}

<script>

    document.getElementById('btnSearch').addEventListener('click', function(){
        var query = $('#filter').val();
        var filterBy = $('#filterBy').val();
        $.ajax({
            url:"./personal_search",
            // data: $('#form').serialize(),
            data: {
                query: query,
                filterBy: filterBy,
            },
            success:function(data){
                console.log(data);
              $('#tbody1').html(data);
            }
          });
});

document.getElementById('form').addEventListener('submit', function(event){
    event.preventDefault();
});
</script>

@else
    Acceso No válido
@endif
@endsection
