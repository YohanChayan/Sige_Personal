@extends('layouts.app')

@section('content')
    <div class="container border col-3 d-flex justify-content-center">
        <form>
          <div class="form-row">

          <div class="form-group ">
            <label for="category"><p class="font-weight-bold mb-0">Seleccione categoría:</p>
            </label>
            <div class="input-group">
              <select class="custom-select" name="categoria" id="category">
                <option selected value="all"> Todos </option>
                <option value="academicos"> Solo académicos  </option>
                <option value="administrativos"> Solo administrativos  </option>
              </select>
            </div>
          </div>





          </div>

          <div class="form-row">
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
          </div>


          <div class="form-row">

              <div class="form-group">
                <label for="orderby"><p class="font-weight-bold mb-0">Ordenar por:</p>
                </label>
                <div class="input-group">
                  <select class="custom-select" name="ordenarPor" id="orderby">
                    <option selected value="0"> Código </option>
                    <option value="datos_personales"> Nombre y apellidos </option>
                    <option value="datos_minimos"> División </option>
                    <option value="datos_todos"> Categoría </option>
                  </select>
                </div>
              </div>
          </div>


          <button type="submit" class="btn btn-primary">Generar</button>
        </form>
    </div>

@endsection
