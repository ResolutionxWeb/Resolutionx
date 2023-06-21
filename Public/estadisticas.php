<?php
session_start();
require 'controllers/sql.php';

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarGoleadores') {

    $sql = new sql();
    $resultado = $sql->goleadoresEquipo($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarEstadisticasPiePorteros') {

    $sql = new sql();
    $resultado = $sql->estadisticasPorteroPieEquipo($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarEstadisticas') {

    $sql = new sql();
    $resultado = $sql->estadisticasBaseEquipo($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarEstadisticasPorteros') {

    $sql = new sql();
    $resultado = $sql->estadisticasBasePorteros($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'cargarJugadores') {

    $sql = new sql();
    $resultado = $sql->cargarJugadores($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'cargarPartidos') {

    $sql = new sql();
    $resultado = $sql->cargarPartidos($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'posicionJugador') {

    $sql = new sql();
    $resultado = $sql->posicionJugador($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'comprobarPartidoJugador') {

    $sql = new sql();
    $resultado = $sql->comprobarPartidoJugador($_POST['idJugador'],$_POST['idPartido']);
    
    echo $resultado;
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'crearEstadistica') {
    
    $sql = new sql();
    $id = $sql->maxIdEstadisticas();

    $result = $sql->crearEstadistica($id+1,$_POST['idJugador'],$_POST['idPartido'],$_POST['lanzamientos'],$_POST['goles'],$_POST['perdidas'],$_POST['recuperaciones'],$_POST['lanzamientosP'],$_POST['paradas'],$_POST['golesRecibidos']);

    return $result;

}


if($_SESSION['Usuario'] && $_SESSION['idEquipo'])  {

    $html = file_get_contents('estadisticas.html');
    $dom = new DOMDocument();
    $dom->loadHTML($html);

    $nombre = $dom->getElementById('nombreEquipo');

    $nombre->nodeValue = $_SESSION['nombreEquipo'];

    $html_modificado = $dom->saveHTML();
    file_put_contents('estadisticas.html', $html_modificado);

    require 'estadisticas.html';

} else if($_SESSION['Usuario'] && !$_SESSION['Equipo']) {
    header("Location: equipos.php");
    exit;
} else {
    header("Location: login.html");
    exit;
}



?>