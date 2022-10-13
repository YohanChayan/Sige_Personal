<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Personal extends Model
{
    use HasFactory, HasRoles;
    protected $table ='archivo_personal';

    protected $fillable = [
        'Codigo',
        'NombreYApellidos',
        'AfiliacionIMSS',
        'FechaNacimiento',
        'Sexo',
        'Turno',
        'Horario',
        'RFC',
        'CURP',
        'Nacionalidad',
        'Escolaridad',
        'Division',
        'DepartamentoAdscripcion',
        'DepartamentoLabora',
        'Categoria',
        'NombramientoDefinitivo',
        'LetraNombramientoDef',
        'CargaNombramientoDef',
        'FECHA_DE_EMISION_NOMBRAMIENTO_DEF',
        'NombramientoTemporal',
        'LetraNombramientoTemporal',
        'CargaNombramientoTemporal',
        'NombramientoTemporalInicio',
        'NombramientoTemporalFin',
        'Antiguedad',
        'FechaAntiguedad',
        'OBSERVACIONES_1',
        'NombramientoDirectivoTemporal',
        'FechaInicioNombramientoDir',
        'FechaTerminoNombramientoDir',
        'NombramientoTemporalInicio',
        'NombramientoContratoLaboral',
        'LetraContratoLaboral',
        'CargaContratoLaboral',
        'FechaInicioContratoLaboral',
        'FechaFinContratoLaboral',
        'INGRESO_MENSUAL_CONTRATO_CIVIL_1',
        'FECHA_INGRESO_CONTRATO_CIVIL_1',
        'FECHA_FIN_CONTRATO_CIVIL_1',
        'Domicilio',
        'Telefono',
        'TelefonoCelular',
        'CodigoPostal',
        'CorreoE',
        'SueldoBaseNombramientoDef',
        'LicenciaConSueldoInicio',
        'LicenciaConSueldoFin',
        'LicenciaSinSueldoInicio',
        'LicenciaSinSueldoFin',
        'AnioSabaticoInicio',
        'AnioSabaticoFin',
        'PensionInvalidezTemporalInicio',
        'PensionInvalidezTemporalFin',
        'ClaveDeEscalafon',
        'LugarDeEscalafon',
        'SeguroDeVida',
        'NivelSNI',
        'Baja',
    ];
}
