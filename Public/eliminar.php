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

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarJugadores') {

    $sql = new sql();
    $resultado = $sql->jugadoresEquipo($_POST['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarPartidos') {

    $sql = new sql();
    $resultado = $sql->partidosEquipo($_POST['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarEstadisticas') {

    $sql = new sql();
    $resultado = $sql->estadisticasEquipo($_POST['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'elegirEquipo') {

    $sql = new sql();
    $resultado = $sql->elegirEquipo($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'elegirJugador') {

    $sql = new sql();
    $resultado = $sql->elegirJugador($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'elegirPartido') {

    $sql = new sql();
    $resultado = $sql->elegirPartido($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'elegirEstadistica') {

    $sql = new sql();
    $resultado = $sql->elegirEstadistica($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'numeroJugadoresEquipos') {

    $sql = new sql();
    $resultado = $sql->numeroJugadoresEquipos($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'numeroPartidosEquipos') {

    $sql = new sql();
    $resultado = $sql->numeroPartidosEquipos($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'numeroEstadisticasEquipos') {

    $sql = new sql();
    $resultado = $sql->numeroEstadisticasEquipos($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'numeroEstadisticasPartidos') {

    $sql = new sql();
    $resultado = $sql->numeroEstadisticasPartidos($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'numeroPartidosJugador') {

    $sql = new sql();
    $resultado = $sql->numeroPartidosJugador($_POST['id']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'borrarEquipo') {

    $sql = new sql();
    $sql->borrarEstadisticasEquipo($_POST['id']);
    $sql->borrarPartidosEquipo($_POST['id']);
    $sql->borrarJugadoresEquipo($_POST['id']);
    $resultado = $sql->borrarEquipo($_POST['id']);
    
    return $resultado;
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'borrarJugador') {

    $sql = new sql();
    $sql->borrarEstadisticasJugador($_POST['id']);
    $resultado = $sql->borrarJugador($_POST['id']);
    
    return $resultado;
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'borrarPartido') {

    $sql = new sql();
    $sql->borrarEstadisticasPartido($_POST['id']);
    $resultado = $sql->borrarPartido($_POST['id']);
    
    return $resultado;
    exit();
}

if (isset($_POST['accion']) && $_POST['accion'] === 'borrarEstadistica') {

    $sql = new sql();
    $resultado = $sql->borrarEstadistica($_POST['id']);
    
    return $resultado;
    exit();
}

if($_SESSION['Usuario']){

    $html = file_get_contents('eliminar.html');
    $dom = new DOMDocument();
    $dom->loadHTML($html);

    $nombre = $dom->getElementById('nombreEquipo');

    $nombre->nodeValue = "Eliminar registros de ".$_SESSION['Usuario'];

    $html_modificado = $dom->saveHTML();
    file_put_contents('eliminar.html', $html_modificado);

    require 'eliminar.html';

} else {
    header("Location: login.html");
    exit;
}



?>