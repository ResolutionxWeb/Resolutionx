<?php
session_start();
require 'controllers/sql.php';

$_SESSION['idEquipo'] = "";
$_SESSION['nombreEquipo'] = "";

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarEquipos') {

    $sql = new sql();
    $resultado = $sql->desplegarEquipos($_SESSION['IDuser']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'seleccionarEquipo') {
    
    $_SESSION['idEquipo'] = $_POST['idEquipo'];
    
    $sql = new sql();
    $resultado = $sql->buscarEquipo($_POST['idEquipo']);

    $_SESSION['nombreEquipo'] = $resultado;
    exit;

}

if (isset($_POST['accion']) && $_POST['accion'] === 'crearEquipo') {
    
    $sql = new sql();
    $id = $sql->maxIdEquipos();

    $result = $sql->crearEquipo($id+1,$_SESSION['IDuser'],$_POST['nombre'],$_POST['lugar'],$_POST['categoria'],$_POST['temporada']);
    
    return $result;

}




if($_SESSION['Usuario']){

    require 'equipos.html';

} else {
    header("Location: login.html");
    exit;
}



?>