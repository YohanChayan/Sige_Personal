<?php
include_once 'conexion.php';

class horarioCumplido{

    private $IdHorarioCumplido;
    private $IdEmpleado;
    private $fecha;
    private $regulacion;
    private $horaEntrada;
    private $horaSalida;
    private $diferencia;
    private $IdPermiso;
    private $semana;
    private $mes;

    function __construct(){
        gc_enable(); // Forzando el garbage collector.
        date_default_timezone_set('America/Mexico_City');
        set_time_limit(60);
    }

    function getIdHorarioCumplir(){
        return $this->IdHorarioCumplido;
    }

    function getIdEmpleado(){
        return $this->IdEmpleado;
    }

    function getFecha(){
        return $this->fecha;
    }

    function getRegulacion(){
        return $this->regulacion;
    }

    function getHoraEntrada(){
        return $this->horaEntrada;
    }

    function getHoraSalida(){
        return $this->horaSalida;
    }

    function getDiferencia(){
        return $this->diferencia;
    }

    function getIdPermiso(){
        return $this->IdPermiso;
    }

    function getSemana(){
        return $this->semana;
    }

    function getMes(){
        return $this->mes;
    }

    function setIdHorarioCumplido($IdHorarioCumplido) {
        $this->IdHorarioCumplido = $IdHorarioCumplido;
    }

    function setIdEmpleado($IdEmpleado) {
        $this->IdEmpleado = $IdEmpleado;
    }

    function setFecha($fecha) {
        $this->fecha = $fecha;
    }

    function setRegulacion($regulacion) {
        $this->regulacion = $regulacion;
    }

    function setHoraEntrada($horaEntrada) {
        $this->horaEntrada = $horaEntrada;
    }

    function setHoraSalida($horaSalida) {
        $this->horaSalida = $horaSalida;
    }

    function setDiferencia($diferencia) {
        $this->diferencia = $diferencia;
    }

    function setIdPermiso($IdPermiso) {
        $this->IdPermiso = $IdPermiso;
    }

    function setSemana($semana) {
        $this->semana = $semana;
    }

    function setMes($mes) {
        $this->mes = $mes;
    }

    function consultaEmpleados() {
        $pdo = new Conexion();
        $query = $pdo->prepare('SELECT idEmpleado, nombre FROM empleado WHERE idEmpleado != 0 ORDER BY nombre ASC;');
        $query->execute();

        $resultado = $query->fetchAll();
        foreach ($resultado as $value) {
            echo '<option value="'. $value['idEmpleado'] .'">'. $value['nombre'] .'</option>';
        }
    }

    function consultaNombreEmpleado(){
        $datos = array();
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT nombre, codigoUDG, idEmpleado from empleado WHERE idEmpleado=".$this ->getIdEmpleado().";");
        $query->execute();

        $resultado = $query->fetchAll();

        $datos = $resultado[0];
        return $datos;
    }

    function horarioCumplidoConsulaSemana(){
        $pdo = new Conexion();
        $query = $pdo->prepare("SELECT IdHorarioCumplido, fecha, horaEntrada, horaSalida, diferencia, IdPermiso FROM horariocumplido WHERE idEmpleado=".$this ->getIdEmpleado()." AND weekofyear(fecha)=weekofyear('".$this ->getSemana()."');");
        $query->execute();
        $resultado = $query->fetchAll();

        $idEmpleado = $this ->getIdEmpleado();
        $fechas = $this ->getSemana();

        foreach ($resultado as $key => $value) {

            $capturaEntrada="<a href='capturarEntrada.php?id=".$value['IdHorarioCumplido']."' class='btn btn-default'>Capturar</a>";
            $capturaSalida="<a href='capturarSalida.php?id=".$value['IdHorarioCumplido']."' class='btn btn-default'>Capturar</a>";
            $descargar="<a href='permisoPDF.php?id=".$value['IdPermiso']."' class='btn btn-success' target='_blank'>Descargar PDF</a>";

            $cuentas[$key] = array(
                $value['IdHorarioCumplido'],
                $value['fecha'],
                $value['horaEntrada'],
                $value['horaSalida'],
                $value['diferencia'],
                $value['IdPermiso'],
            );


            if($cuentas[$key][2]==null || $cuentas[$key][2]=='00:00:00'){
                $cuentas[$key][2]=$capturaEntrada;
            }

            if($cuentas[$key][3]==null || $cuentas[$key][3]=='00:00:00'){
                $cuentas[$key][3]=$capturaSalida;
            }

            if($cuentas[$key][4]==null || $cuentas[$key][4]=='00:00:00'){
                $cuentas[$key][4]='Sin Diferencia';
            }

            if($cuentas[$key][5]==null || $cuentas[$key][5]=='0'){
                $cuentas[$key][5]='Sin Permiso';
            }else{
                $cuentas[$key][5]=$descargar;
            }
        }
        return $cuentas;
    }

    function permisosMes(){
        $conn = new Conexion();
        $data = array();
        $idEmpleado = $this->getIdEmpleado();
        $mes = $this ->getMes();

        $consultaPermisos = $conn->prepare("SELECT f.fechaPermiso, p.IdPermiso, p.motivo, p.periodoLargo, p.estatus
            FROM fechapermiso f INNER JOIN permiso p ON p.IdPermiso = f.IdPermiso
            INNER JOIN empleado e ON p.IdEmpleado = e.idEmpleado
            WHERE p.IdEmpleado = 107 AND p.activo = 'si'
            AND month(f.fechaPermiso) = month('2018-11-01')
            AND year(f.fechaPermiso) = year('2018-11-01')"
        );
        $consultaPermisos->execute();
        $rs = $consultaPermisos->fetchAll();
        // No se pueden combinar los dos tipos de permiso (periodo largo y unitario).
        // Hay que complementar esta aprte.
        if (sizeof($rs) > 0) {

            $indexPeriodo = array();
            for ($i=0; $i < sizeof($rs); $i++) {
                $actual = $rs[$i];
                if ($actual['periodoLargo'] == "si") {
                    array_push($indexPeriodo, $i);
                }
            }

            if (sizeof($indexPeriodo) > 0) {

                if (sizeof($rs) > 2) {
                    $permisoUnitario = array();
                    $permisoLargo = array();

                    while (sizeof($rs) > 0) {
                        $permiso = array_shift($rs);
                        if ($permiso['periodoLargo'] == "no") {
                            array_push($permisoUnitario, $permiso);
                        }else {
                            array_push($permisoLargo, $permiso);
                        }
                    }

                    foreach($permisoUnitario as $p){
                        $i = $p['fechaPermiso'];
                        $m = $p['motivo'];
                        $str = "<td>Permiso para el dia $i - $m</td>";
                        array_push($data, $str);
                    }

                    if (sizeof($permisoLargo) > 0) {
                        $idPermiso = $permisoLargo[0]['IdPermiso'];
                        $obtenerPeriodo = $conn->prepare("SELECT * FROM fechapermiso WHERE IdPermiso = $idPermiso ORDER BY fechaPermiso ASC");
                        $obtenerPeriodo->execute();
                        $periodo = $obtenerPeriodo->fetchAll();

                        $inicioPeriodo = new DateTime($periodo[0]['fechaPermiso']);
                        $finPeriodo = new DateTime($periodo[1]['fechaPermiso']);
                        $i = $inicioPeriodo->format('Y/m/d');
                        $f = $finPeriodo->format('Y/m/d');
                        $m = $permisoLargo[0]['motivo'];

                        $str = "<td>Permiso del $i al $f - $m</td>";
                        array_push($data, $str);
                    }

                }else{
                    $idPermiso = $rs[0]['IdPermiso'];
                    $obtenerPeriodo = $conn->prepare("SELECT * FROM fechapermiso WHERE IdPermiso = $idPermiso ORDER BY fechaPermiso ASC");
                    $obtenerPeriodo->execute();
                    $periodo = $obtenerPeriodo->fetchAll();

                    $inicioPeriodo = new DateTime($periodo[0]['fechaPermiso']);
                    $finPeriodo = new DateTime($periodo[1]['fechaPermiso']);
                    $i = $inicioPeriodo->format('Y/m/d');
                    $f = $finPeriodo->format('Y/m/d');
                    $m = $rs[0]['motivo'];

                    $str = "<td>Permiso del $i al $f - $m</td>";
                    array_push($data, $str);
                }

            }else{
                foreach ($rs as $p) {
                    $i = $p['fechaPermiso'];
                    $m = $p['motivo'];
                    $str = "<td>Permiso para el dia $i - $m</td>";
                    array_push($data, $str);
                }
            }
        }else{
            array_push($data, "Sin permisos");
        }

        return $data;
    }

    function horarioCumplidoConsulaMes(){
        $salidasFaltantes = 0;
        $pdo = new Conexion();
        $cuentas = array();
        $query = $pdo->prepare("SELECT IdHorarioCumplido, fecha, horaEntrada, horaSalida, diferencia, IdPermiso
            FROM horariocumplido WHERE idEmpleado=".$this->getIdEmpleado()."
            AND month(fecha)=month('".$this ->getMes()."') AND year(fecha) = year('".$this->getMes()."')");

        $query->execute();
        $horario = $this->getHorarioCumplir($this->getIdEmpleado());
        for ($i=0; $i < sizeof($horario); $i++) {
            $horario[$i]['dia'] = substr($horario[$i]['dia'], 0, 2);
        }

        $resultado = $query->fetchAll();
        foreach ($resultado as $key => $value) {

            $capturaEntrada="<a href='capturarEntrada.php?id=".$value['IdHorarioCumplido']."' class='btn btn-default'>Capturar</a>";
            $capturaSalida="<a href='capturarSalida.php?id=".$value['IdHorarioCumplido']."' class='btn btn-default'>Capturar</a>";
            $descargar="<a href='permisoPDF.php?id=".$value['IdPermiso']."' class='btn btn-success' target='_blank'>Descargar PDF</a>";

            // Formato de la informacion a mostrar
            $unix = strtotime($value['fecha']);
            $diaSemana = date("l", $unix);
            switch($diaSemana){
                case "Monday":
                    $diaSemana = "Lu";
                    break;
                case "Tuesday":
                    $diaSemana = "Ma";
                    break;
                case "Wednesday":
                    $diaSemana = "Mi";
                    break;
                case "Thursday":
                    $diaSemana = "Ju";
                    break;
                case "Friday":
                    $diaSemana = "Vi";
                    break;
                case "Saturday":
                    $diaSemana = "Sa";
                    break;
                case "Sunday":
                    $diaSemana = "Do";
                    break;
            }
            $formateado = $this->getDateFormat($diaSemana, $horario, $value);

            //<font color="red"></font>
            $fechaFormato = '(<b>'.$diaSemana.'</b>) '.$value['fecha'];

            //--------------------------------------------------------

            $cuentas[$key] = array(
                $value['IdHorarioCumplido'],
                $fechaFormato,
                $formateado['horaEntrada'],
                $value['horaSalida'],
                $value['diferencia'],
                $value['IdPermiso']
            );

            if($cuentas[$key][2]==null || $cuentas[$key][2]=='00:00:00'){
                $cuentas[$key][2]=$capturaEntrada;
            }

            if($cuentas[$key][3]==null || $cuentas[$key][3]=='00:00:00'){
                //$cuentas[$key][3]=$capturaSalida;
                $salidasFaltantes++;
                $cuentas[$key][3] = $this->actualizarHorario(
                    $value['IdHorarioCumplido'],
                    $value['horaEntrada'],
                    $value['horaSalida'],
                    $fechaFormato
                );
                $cuentas[$key][4] = "00:00:00";
            }

            if($cuentas[$key][4]==null || $cuentas[$key][4]=='00:00:00'){
                $cuentas[$key][4]='Sin Diferencia';
            }

            if($cuentas[$key][5]==null || $cuentas[$key][5]=='0'){
                $cuentas[$key][5]='-';
            }else{
                $cuentas[$key][5]=$descargar;
            }
        }
        return $cuentas;
    }

    // Obtener la carga horaria de los empleados
    function getHorarioCumplir($empleado){
        $conn = new Conexion();
        $horario = array();
        $dias = array("Lunes","Martes","Miercoles","Jueves","Viernes","Sabado","Domingo","Vacacional");
        $sql = "SELECT * FROM horariocumplir WHERE idEmpleado = $empleado";
        $rs = $conn->query($sql);

        // Si existen registros
        if ($rs->rowCount() > 0) {
            // Quitar los acentos de los registros
            while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
                if (substr($row['dia'],0,1) == "S") {
                    $row['dia'] = "Sabado";
                }
                if (substr($row['dia'],0,2) == "Mi") {
                    $row['dia'] = "Miercoles";
                }
                array_push($horario, $row);
            }
        }else{
            foreach ($dias as $dia) {
                $row = array();
                $row['dia'] = $dia;
                $row['horaEntrada'] = "00:00:00";
                $row['horaSalida'] = "00:00:00";
                array_push($horario, $row);
            }
        }
        return $horario;
    }
    // Formatear el texto de los reistros de la tabla del reporte mensual
    function getDateFormat($diaSemana, $horario, $datos){
        $formato = array();

        foreach ($horario as $dia) {
            if ($diaSemana == $dia['dia']) {
                if ($dia['horaEntrada'] == "00:00:00") {
                    $formato['horaEntrada'] = $datos['horaEntrada'];
                }else{
                    $horaCumplir = new DateTime($dia['horaEntrada']);
                    $aux = new DateTime($dia['horaEntrada']);

                    $horaCumplida = new DateTime($datos['horaEntrada']);
                    $tolerancia = $horaCumplir->modify('+20 minute');
                    if ($horaCumplida > $tolerancia) {
                        $formato['horaEntrada'] = '<font color="red">'.$horaCumplida->format('H:i:s').'</font>';
                    }else {
                        $formato['horaEntrada'] = $datos['horaEntrada'];
                    }
                }
            }
        }
        return $formato;
    }

    function secondsToHours($seconds) {
      $t = round($seconds);
      return sprintf('%02d:%02d', ($t/3600),($t/60%60));
    }

    function getTable($semana, $tipoReporte){
        /*
        Arreglo con los dias de la seman en ingles para
        poder dar dormato a la tabla. Si es posible, hay
        que ponerlo en otro archivo como constante ya que
        se utiliza varias veces en esta clase.
        */
        $dias = array("Monday","Tuesday","Wednesday","Thursday","Friday","Saturday","Sunday");

        $conn = new Conexion();
        // Inicializar arreglo de retorno
        $table = array();

        // Obtener el primer y utlimo dia de la semana
        $inicio = date('Y/m/d', strtotime($semana."1"));
        $fin = date('Y/m/d', strtotime($semana."7"));
        // Obtener los empleados que apareceran en la tabla
        $empleados = array();
        $sql = "SELECT idEmpleado FROM empleado WHERE tipoReporte = '$tipoReporte' AND generarReporte = '1'";
        $rs = $conn->query($sql);
        // Guardar los registros en una pila
        while ($row = $rs->fetch(PDO::FETCH_ASSOC)) {
            array_push($empleados, $row['idEmpleado']);
        }

        while (sizeof($empleados) > 0){
            /*
            Obtener cada uno de los registros de la pila para
            obtener los registros de los empleados que apareceran
            en la tabla.
            */
            $idEmpleado = array_shift($empleados);
            $sql = "SELECT fecha, horaEntrada, horaSalida, diferencia, cargaHoraria, e.nombre, a.edificio
            FROM horariocumplido d INNER JOIN empleado e ON e.idEmpleado = d.idEmpleado
            INNER JOIN area a ON e.idArea = a.idArea
            WHERE d.idEmpleado = $idEmpleado AND
            fecha BETWEEN '$inicio' AND '$fin' ORDER BY fecha, nombre ASC";

            $rs = $conn->query($sql);
            // Si hay registros que corresponden a la semana
            if ($rs->rowCount() > 0) {
                $emp = array();
                $emp['idEmpleado'] = $idEmpleado;
                $emp['inicio'] = $inicio;
                $emp['fin'] = $fin;

                // Inicializar el conteo de horas a la semana
                $emp['horasSemana'] = "0:00";
                // Formatear los registros para imprimirlos en la tabla
                while ($row = $rs->fetch(PDO::FETCH_ASSOC)){
                    $emp['nombre'] = $row['nombre'];
                    if ($row['edificio'] != null) {
                        $emp['edificio'] = $row['edificio'];
                    }else{
                        $emp['edificio'] = "-";
                    }

                    $emp['cargaHoraria'] = $row['cargaHoraria'];
                    $horaEntrada = new DateTime($row['horaEntrada']);
                    $horaSalida = new DateTime($row['horaSalida']);
                    $diferencia = new DateTime($row['diferencia']);
                    $horaEntrada = $horaEntrada->format('H:i');
                    $horaSalida = $horaSalida->format('H:i');
                    if ($row['horaSalida'] == "00:00:00") {
                        $diferencia = "00:00";
                    }else{
                        $diferencia = $diferencia->format('G:i');
                    }

                    // Calcular la suma total de las horas a la semana
                    $partes = explode(':',$diferencia);
                    $partes[1] = intval($partes[1]);

                    $cuentaActual = explode(':',$emp['horasSemana']);
                    $cuentaActual = ($cuentaActual[0] * 3600) + ($cuentaActual[1] * 60);
                    $diferenciaSegundos = explode(':',$diferencia);
                    $diferenciaSegundos = ($diferenciaSegundos[0] * 3600) + ($diferenciaSegundos[1] * 60);

                    $suma = $diferenciaSegundos + $cuentaActual;

                    // La siguiente funcion convierte las horas en decimales:
                    //$absoluto = round(($partes[0] + floor(($partes[1]/60)*100) / 100),1);
                    //$emp['horasSemana'] = $emp['horasSemana'] + $absoluto;

                    $emp['horasSemana'] = $this->secondsToHours($suma);

                    $formato = "<b>$partes[0]h $partes[1]m</b>"."<br>$horaEntrada - $horaSalida";
                    // Obtener en que dia de la semana cae la fecha del registro
                    $unix = strtotime($row['fecha']);
                    $diaSemana = date("l", $unix);

                    switch($diaSemana){
                        case "Monday":
                            $emp['Monday'] = $formato;
                            break;
                        case "Tuesday":
                            $emp['Tuesday'] = $formato;
                            break;
                        case "Wednesday":
                            $emp['Wednesday'] = $formato;
                            break;
                        case "Thursday":
                            $emp['Thursday'] = $formato;
                            break;
                        case "Friday":
                            $emp['Friday'] = $formato;
                            break;
                        case "Saturday":
                            $emp['Saturday'] = $formato;
                            break;
                        case "Sunday":
                            $emp['Sunday'] = $formato;
                            break;
                    }

                    array_push($table, $emp);
                }
                // Si no, guarda un registr vacio
            }else{
                $auxSql = "SELECT nombre, cargaHoraria, edificio FROM empleado e
                INNER JOIN area a ON a.idArea = e.idArea WHERE idEmpleado = $idEmpleado";
                $auxRs = $conn->query($auxSql);
                $auxRow = $auxRs->fetch(PDO::FETCH_ASSOC);
                $emp = array();
                $emp['idEmpleado'] = $idEmpleado;
                if ($row['edificio'] != null) {
                    $emp['edificio'] = $row['edificio'];
                }else{
                    $emp['edificio'] = "-";
                }

                $emp['cargaHoraria'] = $auxRow['cargaHoraria'];
                $emp['horasSemana'] = 0.0;
                $emp['nombre'] = $auxRow['nombre'];
                $emp['Monday'] = "-";
                $emp['Tuesday'] = "-";
                $emp['Wednesday'] = "-";
                $emp['Thursday'] = "-";
                $emp['Friday'] = "-";
                $emp['Saturday'] = "-";
                $emp['Sunday'] = "-";
                $emp['inicio'] = $inicio;
                $emp['fin'] = $fin;
                array_push($table, $emp);
            }
        }
        $filterTable = array();
        $i = 0;
        /*
        El proceso anterior arroja como resultado
        7 registros por cada empleado, el siguiete
        proceso los mete todos en uno solo.
        */
        while(sizeof($table) > 0){
            $row = array_shift($table);

            if (sizeof($filterTable) > 0) {
                if ($filterTable[$i-1]['nombre'] == $row['nombre'] && sizeof($row) > sizeof($filterTable[$i-1])) {
                    $filterTable[$i-1] = $row;
                }else{
                    array_push($filterTable, $row);
                    $i++;
                }

            }else{
                array_push($filterTable, $row);
                $i++;
            }
        }

        $res = array();
        while (sizeof($filterTable) > 0){
            $emp = array_shift($filterTable);

            foreach ($dias as $dia) {
                if (!isset($emp[$dia])) {
                    $emp[$dia] = "-";
                }
            }
            /*
            Ordenar los datos de los registros de acuerdo
            al formato de la tabla y pasarlo a un tipo de
            arreglo indexado para que el datatable lo
            pueda leer.
            */
            $byIndex = array(
                $emp['nombre'],
                $emp['cargaHoraria'],
                $emp['horasSemana'],
                $emp['Monday'],
                $emp['Tuesday'],
                $emp['Wednesday'],
                $emp['Thursday'],
                $emp['Friday'],
                $emp['Saturday'],
                $emp['Sunday'],
                $emp['idEmpleado'],
                $emp['inicio'],
                $emp['fin'],
                $emp['edificio']
            );
            array_push($res, $byIndex);
        }

        return $this->compararAsistencias($res);
    }

    function compararAsistencias($registros){
        $conn = new Conexion();
        // Comparar con su horario
        $crudo = $registros;
        $filtrados = array();
        while(sizeof($crudo) > 0){

            $reg = array_shift($crudo);
            $horario = $this->getHorarioCumplir($reg[10]);

            $consultaPermisos = $conn->prepare("SELECT f.fechaPermiso, p.IdPermiso, p.motivo, p.periodoLargo, p.estatus
                FROM fechapermiso f INNER JOIN permiso p ON p.IdPermiso = f.IdPermiso INNER JOIN empleado e ON p.IdEmpleado = e.idEmpleado
                WHERE p.IdEmpleado = $reg[10] AND p.activo = 'si' AND
                f.fechaPermiso BETWEEN '$reg[11]' AND '$reg[12]'"
            );
            $consultaPermisos->execute();
            $rs = $consultaPermisos->fetchAll();

            if(sizeof($rs) > 0){
                if ($rs[0]['periodoLargo'] == "si") {
                    $idPermiso = $rs[0]['IdPermiso'];
                    $obtenerPeriodo = $conn->prepare("SELECT * FROM fechapermiso WHERE IdPermiso = $idPermiso ORDER BY fechaPermiso ASC");
                    $obtenerPeriodo->execute();
                    $periodo = $obtenerPeriodo->fetchAll();

                    $inicioPeriodo = new DateTime($periodo[0]['fechaPermiso']);
                    $finPeriodo = new DateTime($periodo[1]['fechaPermiso']);
                    $inicioSemana = new DateTime($reg[11]);
                    $finSemana = new DateTime($reg[12]);
                    $contadorDias = 3;
                    while($inicioSemana <= $finSemana){
                        if ($inicioSemana >= $inicioPeriodo && $inicioSemana <= $finPeriodo) {
                            if ($reg[$contadorDias] == "-" && $rs[0]['estatus'] == "Aprobado") {
                                $reg[$contadorDias] = $rs[0]['motivo'];
                            }
                        }

                        $contadorDias++;
                        $inicioSemana->modify('+1 day');
                    }
                }else{
                    $estatus = $rs[0]['estatus'];
                    $inicioSemana = new DateTime($reg[11]);
                    $finSemana = new DateTime($reg[12]);
                    $contadorDias = 3;
                    while($inicioSemana <= $finSemana){
                        foreach($rs as $permisoUnitario){
                            $diaPermiso = new DateTime($permisoUnitario['fechaPermiso']);
                            if ($diaPermiso == $inicioSemana) {
                                if ($reg[$contadorDias] == "-" && $estatus == "Aprobado") {
                                    $reg[$contadorDias] = $permisoUnitario['motivo'];
                                }
                            }
                        }
                        $contadorDias++;
                        $inicioSemana->modify('+1 day');
                    }
                }
            }
            $x = 3;
            while (sizeof($horario) > 0) {
                $dia = array_shift($horario);
                if ($reg[$x] == "-") {
                    if($dia['horaEntrada'] != "00:00:00" && $reg[13] == "Agua Azul"){
                        $reg[$x] = "Agua Azul";
                    }
                }
                $x++;
            }

            array_push($filtrados, $reg);
        }
        return $filtrados;
    }

    function actualizarHorario($idRegistro, $horaEntrada, $horaSalida, $fecha){
        $datos = array();
        $pdo = new Conexion();
        /*
        En esta clase ya existe una funcion que hace el siguiente proceso
        pero tuve que ponerla aqui otra vez por la forma en la que esta
        estructurado el sistema de clases.
        Sirve para obtener el nombre del empleado.
        */
        $query = $pdo->prepare("SELECT nombre, e.idEmpleado FROM empleado e
        INNER JOIN horariocumplido h ON e.idEmpleado = h.idEmpleado WHERE
        IdHorarioCumplido = :idRegistro");
        $query->bindparam(':idRegistro', $idRegistro, PDO::PARAM_STR, 8);
        $query->execute();
        $resultado = $query->fetchAll();
        $datos = $resultado[0];

        /*
        Crea un formulario html con todos los datos necesarios
        para actualizar las horas. Todos los inputs estan ocultos
        menos el boton porque es el que se imprime en la.
        */
        $html = '
        <form action="actualizarHoras.php" method="post">
            <input type="hidden" name="nombre" value="'.$datos[0].'"/>
            <input type="hidden" name="idEmpleado" value="'.$datos[1].'"/>
            <input type="hidden" name="idRegistro" value="'.$idRegistro.'"/>
            <input type="hidden" name="horaEntrada" value="'.$horaEntrada.'"/>
            <input type="hidden" name="horaSalida" value="'.$horaSalida.'"/>
            <input type="hidden" name="fecha" value="'.$fecha.'"/>
            <button type="submit" class="btn" name="actualizarHora">
                Capturar salida
            </button>
        </form>
        ';
        return $html;

    }


    // Funcion para actualizar los registros faltantes en los reportes
    function actualizarHorarioBD($idRegistro, $horaEntrada, $horaSalida){
        // Calcula la diferencia de la hora insertada
        $entrada = new DateTime($horaEntrada);
        $salida = new DateTime($horaSalida);
        $diff = date_diff($entrada, $salida);
        $diferencia = $diff->format('%H:%I:%S');

        // Actualiza la informacion
        $conn = new Conexion();
        $st = $conn->prepare("UPDATE horariocumplido
        SET horaEntrada = :horaEntrada, horaSalida = :horaSalida, diferencia = :diferencia
        WHERE IdHorarioCumplido = :idHorario");

        $st->bindparam(':idHorario', $idRegistro, PDO::PARAM_INT);
        $st->bindparam(':horaEntrada', $horaEntrada, PDO::PARAM_STR, 8);
        $st->bindparam(':horaSalida', $horaSalida, PDO::PARAM_STR, 8);
        $st->bindparam(':diferencia', $diferencia, PDO::PARAM_STR, 8);
        $st->execute();
    }

}
?>
