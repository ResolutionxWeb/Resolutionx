<?php
session_start();
require 'controllers/sql.php';

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarJugadores') {

    $sql = new sql();
    $resultado = $sql->jugadoresEquipo($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'comprobarDorsal') {

    $sql = new sql();
    $resultado = $sql->comprobarDorsal($_POST['id'],$_SESSION['idEquipo']);
    
    echo $resultado;
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'comprobarDNI') {

    $sql = new sql();
    $resultado = $sql->comprobarDNI($_POST['dni'],$_SESSION['idEquipo']);
    
    echo $resultado;
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'crearJugador') {
    
    $sql = new sql();
    $id = $sql->maxIdJugadores();

    $result = $sql->crearJugador($id+1,$_SESSION['idEquipo'],$_POST['dni'],$_POST['nombre'],$_POST['apellidos'],$_POST['posicion'],$_POST['dorsal']);
    
    return $result;

}

if($_SESSION['Usuario'] && $_SESSION['idEquipo'])  {

    $html = file_get_contents('jugadores.html');
    $dom = new DOMDocument();
    $dom->loadHTML($html);

    $nombre = $dom->getElementById('nombreEquipo');

    $nombre->nodeValue = $_SESSION['nombreEquipo'];

    $html_modificado = $dom->saveHTML();
    file_put_contents('jugadores.html', $html_modificado);

    require 'jugadores.html';

} else if($_SESSION['Usuario'] && !$_SESSION['Equipo']) {
    header("Location: equipos.php");
    exit;
} else {
    header("Location: login.html");
    exit;
}



?>