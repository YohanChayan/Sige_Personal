@extends('layouts.app')
@section('content')

@can('cNormal_PERSONAL#editar')
    <div class="container">
        @if(Auth::check())
            @if (session('message'))
                <div class="alert alert-success">
                    <h2>{{ session('message') }}</h2>

                </div>
            @endif
            <div class="row">
                <h2>Captura de Personal</h2>
                <hr>
                <script type="text/javascript">

                    $(document).ready(function() {
                        $('#js-example-basic-single').select2();
                        $('#js-example-basic-single2').select2();
                        $('#equipos').select2();
                    });
                </script>
            </div>

            {{-- Form (create/edit)--}}
            @if(isset($personal))
                <form action="{{route('personal.update', $personal->id)}}" method="post" enctype="multipart/form-data" class="col-12">
                @method('PATCH')
            @else
                <form action="{{route('personal.store')}}" method="post" enctype="multipart/form-data" class="col-12">
            @endif


                <div class="row">
                    <div class="col">
                        @csrf
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

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="font-weight-bold" for="Codigo">Código</label>
                                    <input class="form-control" id="Codigo" name="Codigo" type="text" value="{{$personal->Codigo ?? ''}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NombreYApellidos">Nombres y apellidos</label>
                                    <input class="form-control" id="NombreYApellidos" name="NombreYApellidos" type="text" value="{{$personal->NombreYApellidos ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="AfiliacionIMSS">Afiliación IMSS </label>
                                    <input class="form-control" id="AfiliacionIMSS" name="AfiliacionIMSS" type="text" value="{{$personal->AfiliacionIMSS ?? ''}}">
                                </div>

                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="FechaNacimiento"> Fecha de nacimiento por ejemplo: 15/Jul/2007 </label>
                                    <input class="form-control" id="FechaNacimiento" name="FechaNacimiento" type="text" value="{{$personal->FechaNacimiento ?? ''}}">
                                </div>

                        </div>


                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-2">
                                    <label class="font-weight-bold" for="Sexo">Sexo </label>
                                    <select class="form-control" id="Sexo" name="Sexo">
                                        <option disabled >Elegir</option>
                                        <option value="M" {{ old('Sexo', ($personal->Sexo ?? '') == 'M' ? 'selected' : '') ?? '' }}>Masculino</option>
                                        <option value="F" {{ old('Sexo', ($personal->Sexo ?? '') == 'F' ? 'selected' : '') ?? '' }}>Femenino</option>
                                        <option value="Otro" {{ old('Sexo', ($personal->Sexo ?? '') == 'Otro' ? 'selected' : '') ?? '' }}>Otro</option>
                                    </select>
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Turno"> Turno </label>
                                    <input class="form-control" id="Turno" name="Turno" type="text" value="{{$personal->Turno ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Horario">Horario </label>
                                    <input class="form-control" id="Horario" name="Horario" type="text" value="{{$personal->Horario ?? ''}}">
                                </div>

                                <div class="col-md-4">
                                    <label class="font-weight-bold" for="RFC"> RFC </label>
                                    <input class="form-control" id="RFC" name="RFC" type="text" value="{{$personal->RFC ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="CURP">CURP</label>
                                    <input class="form-control" id="CURP" name="CURP" type="text" value="{{$personal->CURP ?? ''}}">
                                </div>
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Nacionalidad">Nacionalidad</label>
                                    <input class="form-control" id="Nacionalidad" name="Nacionalidad" type="text" value="{{$personal->Nacionalidad ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Escolaridad">Escolaridad </label>
                                    <input class="form-control" id="Escolaridad" name="Escolaridad" type="text" value="{{$personal->Escolaridad ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Division"> División </label>
                                    <input class="form-control" id="Division" name="Division" type="text" value="{{$personal->Division ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="DepartamentoAdscripcion"> Departamento Adscripción</label>
                                    <input class="form-control" id="DepartamentoAdscripcion" name="DepartamentoAdscripcion" type="text" value="{{$personal->DepartamentoAdscripcion ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="DepartamentoLabora">Departamento donde labora </label>
                                    <input class="form-control" id="DepartamentoLabora" name="DepartamentoLabora" type="text" value="{{$personal->DepartamentoLabora ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Categoria"> Categoría </label>
                                    <input class="form-control" id="Categoria" name="Categoria" type="text" value="{{$personal->Categoria ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NombramientoDefinitivo">NombramientoDefinitivo</label>
                                    <input class="form-control" id="NombramientoDefinitivo" name="NombramientoDefinitivo" type="text" value="{{$personal->NombramientoDefinitivo ?? ''}}">
                                </div>

                        </div>


                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="LetraNombramientoDef"> LetraNombramientoDef </label>
                                    <input class="form-control" id="LetraNombramientoDef" name="LetraNombramientoDef" type="text" value="{{$personal->LetraNombramientoDef ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="CargaNombramientoDef">Carga Nombramiento Definitivo</label>
                                    <input class="form-control" id="CargaNombramientoDef" name="CargaNombramientoDef" type="text" value="{{$personal->CargaNombramientoDef ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="FECHA_DE_EMISION_NOMBRAMIENTO_DEF"> Fecha emisión nombramiento DEF </label>
                                    <input class="form-control" id="FECHA_DE_EMISION_NOMBRAMIENTO_DEF" name="FECHA_DE_EMISION_NOMBRAMIENTO_DEF" type="text" value="{{$personal->FECHA_DE_EMISION_NOMBRAMIENTO_DEF ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NombramientoTemporal">Nombramiento Temporal</label>
                                    <input class="form-control" id="NombramientoTemporal" name="NombramientoTemporal" type="text" value="{{$personal->NombramientoTemporal ?? ''}}">
                                </div>

                        </div>


                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="LetraNombramientoTemporal"> Letra Nombramiento Temporal</label>
                                    <input class="form-control" id="LetraNombramientoTemporal" name="LetraNombramientoTemporal" type="text" value="{{$personal->LetraNombramientoTemporal ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="CargaNombramientoTemporal">Carga Nombramiento Temporal</label>
                                    <input class="form-control" id="CargaNombramientoTemporal" name="CargaNombramientoTemporal" type="text" value="{{$personal->CargaNombramientoTemporal ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NombramientoTemporalInicio"> Nombramiento Temporal Inicio </label>
                                    <input class="form-control" id="NombramientoTemporalInicio" name="NombramientoTemporalInicio" type="text" value="{{$personal->NombramientoTemporalInicio ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NombramientoTemporalFin">Nombramiento Temporal Fin</label>
                                    <input class="form-control" id="NombramientoTemporalFin" name="NombramientoTemporalFin" type="text" value="{{$personal->NombramientoTemporalFin ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Antiguedad"> Antiguedad</label>
                                    <input class="form-control" id="Antiguedad" name="Antiguedad" type="text" value="{{$personal->Antiguedad ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="FechaAntiguedad">Fecha de antiguedad</label>
                                    <input class="form-control" id="FechaAntiguedad" name="FechaAntiguedad" type="text" value="{{$personal->FechaAntiguedad ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="OBSERVACIONES_1"> OBSERVACIONES 1 </label>
                                    <input class="form-control" id="OBSERVACIONES_1" name="OBSERVACIONES_1" type="text" value="{{$personal->OBSERVACIONES_1 ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NombramientoDirectivoTemporal">Nombramiento Directivo Temporal</label>
                                    <input class="form-control" id="NombramientoDirectivoTemporal" name="NombramientoDirectivoTemporal" type="text" value="{{$personal->NombramientoDirectivoTemporal ?? ''}}">
                                </div>

                        </div>


                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="FechaInicioNombramientoDir"> Fecha Inicio Nombramiento Dir</label>
                                    <input class="form-control" id="FechaInicioNombramientoDir" name="FechaInicioNombramientoDir" type="text" value="{{$personal->FechaInicioNombramientoDir ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="FechaTerminoNombramientoDir">Fecha Termino Nombramiento Dir</label>
                                    <input class="form-control" id="FechaTerminoNombramientoDir" name="FechaTerminoNombramientoDir" type="text" value="{{$personal->FechaTerminoNombramientoDir ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NombramientoTemporalInicio"> OBSERVACIONES_2 </label>
                                    <input class="form-control" id="NombramientoTemporalInicio" name="NombramientoTemporalInicio" type="text" value="{{$personal->NombramientoTemporalInicio ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NombramientoContratoLaboral">Nombramiento Contrato Laboral</label>
                                    <input class="form-control" id="NombramientoContratoLaboral" name="NombramientoContratoLaboral" type="text" value="{{$personal->NombramientoContratoLaboral ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="LetraContratoLaboral"> Letra Contrato Laboral</label>
                                    <input class="form-control" id="LetraContratoLaboral" name="LetraContratoLaboral" type="text" value="{{$personal->LetraContratoLaboral ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="CargaContratoLaboral">Carga Contrato Laboral</label>
                                    <input class="form-control" id="CargaContratoLaboral" name="CargaContratoLaboral" type="text" value="{{$personal->CargaContratoLaboral ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="FechaInicioContratoLaboral"> Fecha Inicio Contrato Laboral </label>
                                    <input class="form-control" id="FechaInicioContratoLaboral" name="FechaInicioContratoLaboral" type="text" value="{{$personal->FechaInicioContratoLaboral ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="FechaFinContratoLaboral">Fecha Fin Contrato Laboral</label>
                                    <input class="form-control" id="FechaFinContratoLaboral" name="FechaFinContratoLaboral" type="text" value="{{$personal->FechaFinContratoLaboral ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="INGRESO_MENSUAL_CONTRATO_CIVIL_1"> Ingreso Mens. Cont. Civil 1 </label>
                                    <input class="form-control" id="INGRESO_MENSUAL_CONTRATO_CIVIL_1" name="INGRESO_MENSUAL_CONTRATO_CIVIL_1" type="text" value="{{$personal->INGRESO_MENSUAL_CONTRATO_CIVIL_1 ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="FECHA_INGRESO_CONTRATO_CIVIL_1"> Fecha ING. CONT. CIVIL 1 </label>
                                    <input class="form-control" id="FECHA_INGRESO_CONTRATO_CIVIL_1" name="FECHA_INGRESO_CONTRATO_CIVIL_1" type="text" value="{{$personal->FECHA_INGRESO_CONTRATO_CIVIL_1 ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="FECHA_FIN_CONTRATO_CIVIL_1"> FECHA FIN CONT. CIVIL 1 </label>
                                    <input class="form-control" id="FECHA_FIN_CONTRATO_CIVIL_1" name="FECHA_FIN_CONTRATO_CIVIL_1" type="text" value="{{$personal->FECHA_FIN_CONTRATO_CIVIL_1 ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Domicilio"> Domicilio </label>
                                    <input class="form-control" id="Domicilio" name="Domicilio" type="text" value="{{$personal->Domicilio ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="Telefono"> Teléfono </label>
                                    <input class="form-control" id="Telefono" name="Telefono" type="text" value="{{$personal->Telefono ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="TelefonoCelular"> Teléfono Celular </label>
                                    <input class="form-control" id="TelefonoCelular" name="TelefonoCelular" type="text" value="{{$personal->TelefonoCelular ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="CodigoPostal"> Código postal </label>
                                    <input class="form-control" id="CodigoPostal" name="CodigoPostal" type="text" value="{{$personal->CodigoPostal ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="CorreoE">  Correo electrónico </label>
                                    <input class="form-control" id="CorreoE" name="CorreoE" type="text" value="{{$personal->CorreoE ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="SueldoBaseNombramientoDef"> SueldoBaseNombramientoDef </label>
                                    <input class="form-control" id="SueldoBaseNombramientoDef" name="SueldoBaseNombramientoDef" type="text" value="{{$personal->SueldoBaseNombramientoDef ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="LicenciaConSueldoInicio"> LicenciaConSueldoInicio </label>
                                    <input class="form-control" id="LicenciaConSueldoInicio" name="LicenciaConSueldoInicio" type="text" value="{{$personal->LicenciaConSueldoInicio ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="LicenciaConSueldoFin"> LicenciaConSueldoFin </label>
                                    <input class="form-control" id="LicenciaConSueldoFin" name="LicenciaConSueldoFin" type="text" value="{{$personal->LicenciaConSueldoFin ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="LicenciaSinSueldoInicio"> LicenciaSinSueldoInicio </label>
                                    <input class="form-control" id="LicenciaSinSueldoInicio" name="LicenciaSinSueldoInicio" type="text" value="{{$personal->LicenciaSinSueldoInicio ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="LicenciaSinSueldoFin"> LicenciaSinSueldoFin </label>
                                    <input class="form-control" id="LicenciaSinSueldoFin" name="LicenciaSinSueldoFin" type="text" value="{{$personal->LicenciaSinSueldoFin ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="AnioSabaticoInicio"> Año Sabático Inicio </label>
                                    <input class="form-control" id="AnioSabaticoInicio" name="AnioSabaticoInicio" type="text" value="{{$personal->AnioSabaticoInicio ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="AnioSabaticoFin"> Año Sabático Fin </label>
                                    <input class="form-control" id="AnioSabaticoFin" name="AnioSabaticoFin" type="text" value="{{$personal->AnioSabaticoFin ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="PensionInvalidezTemporalInicio"> PensionInvalidezTemporalInicio </label>
                                    <input class="form-control" id="PensionInvalidezTemporalInicio" name="PensionInvalidezTemporalInicio" type="text" value="{{$personal->PensionInvalidezTemporalInicio ?? ''}}">
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="PensionInvalidezTemporalFin"> PensionInvalidezTemporalFin </label>
                                    <input class="form-control" id="PensionInvalidezTemporalFin" name="PensionInvalidezTemporalFin" type="text" value="{{$personal->PensionInvalidezTemporalFin ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="ClaveDeEscalafon"> ClaveDeEscalafon </label>
                                    <input class="form-control" id="ClaveDeEscalafon" name="ClaveDeEscalafon" type="text" value="{{$personal->ClaveDeEscalafon ?? ''}}">
                                </div>


                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="LugarDeEscalafon"> Lugar De Escalafon </label>
                                    <input class="form-control" id="LugarDeEscalafon" name="LugarDeEscalafon" type="text" value="{{$personal->LugarDeEscalafon ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        {{-- pending --}}
                                        <label for="SeguroDeVida"><p class="font-weight-bold mb-0">Tiene seguro de vida</p>
                                        </label>
                                        <div class="input-group">
                                          <select class="custom-select" name="SeguroDeVida" id="SeguroDeVida">
                                            <option value="1" {{ old('SeguroDeVida', ($personal->SeguroDeVida ?? '') == '1' ? 'selected' : '') ?? '' }}> Sí </option>
                                            <option value="0" {{ old('SeguroDeVida', ($personal->SeguroDeVida ?? '') == '0' ? 'selected' : '') ?? '' }}> No </option>
                                          </select>
                                        </div>
                                      </div>
                                </div>

                        </div>

                        <div class="row g-3 align-items-center mb-3">
                                <div class="col-md-3">
                                    <label class="font-weight-bold" for="NivelSNI"> NivelSNI </label>
                                    <input class="form-control" id="NivelSNI" name="NivelSNI" type="text" value="{{$personal->NivelSNI ?? ''}}">
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label for="Baja"><p class="font-weight-bold mb-0">Dado de baja</p>
                                        </label>
                                        <div class="input-group">
                                          <select class="custom-select" name="Baja" id="Baja">
                                            <option value="1" {{ old('Baja', ($personal->Baja ?? '') == '1' ? 'selected' : '') ?? '' }}> Sí </option>
                                            <option value="0" {{ old('Baja', ($personal->Baja ?? '') == '0' ? 'selected' : '') ?? '' }}> No </option>
                                          </select>
                                        </div>
                                      </div>
                                </div>
                                <div class="col-md-3">
                                    {{-- <label class="font-weight-bold" for="SeguroDeVida"> - </label>
                                    <input class="form-control" id="SeguroDeVida" name="SeguroDeVida" type="text"> --}}
                                </div>

                        </div>




                        <br>

			            <div class="row g-3 align-items-center">
                        	<div class="col-md-12">
                            		<a href="{{ route('home') }}" class="btn btn-danger">Cancelar</a>
                            		<button type="submit" class="btn btn-success">Guardar datos</button>
                        	</div>
                    	</div>
                    </div>
                    <br>

                </div>
            </form>
            <br>
            <div class="row g-3 align-items-center">

                <br>
                <h5>En caso de inconsistencias, favor de reportarlas.</h5>
                <hr>

            </div>
    </div>
    @endcan

@else
    Acceso No válido
@endif
@endsection
