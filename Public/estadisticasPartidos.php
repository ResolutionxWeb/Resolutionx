<?php
session_start();
require 'controllers/sql.php';

if (isset($_POST['accion']) && $_POST['accion'] === 'estadisticasPartidoJugadores') {

    $sql = new sql();
    $resultado = $sql->estadisticasPartidoJugadores($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'estadisticasPartidoPorteros') {

    $sql = new sql();
    $resultado = $sql->estadisticasPartidoPorteros($_SESSION['idEquipo']);
    
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

    $html = file_get_contents('estadisticasPartidos.html');
    $dom = new DOMDocument();
    $dom->loadHTML($html);

    $nombre = $dom->getElementById('nombreEquipo');

    $nombre->nodeValue = "Estadisticas de los partidos ".$_SESSION['nombreEquipo'];

    $html_modificado = $dom->saveHTML();
    file_put_contents('estadisticasPartidos.html', $html_modificado);

    require 'estadisticasPartidos.html';

} else if($_SESSION['Usuario'] && !$_SESSION['Equipo']) {
    header("Location: equipos.php");
    exit;
} else {
    header("Location: login.html");
    exit;
}



?>