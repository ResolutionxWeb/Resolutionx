<?php
session_start();
require 'controllers/sql.php';

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarGoleadores') {

    $sql = new sql();
    $resultado = $sql->goleadoresEquipo($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarPartidos') {

    $sql = new sql();
    $resultado = $sql->partidosEquipo($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarJugadores') {

    $sql = new sql();
    $resultado = $sql->jugadoresEquipo($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}






if($_SESSION['Usuario'] && $_SESSION['idEquipo'])  {

    $html = file_get_contents('equipo.html');
    $dom = new DOMDocument();
    $dom->loadHTML($html);

    $nombre = $dom->getElementById('nombreEquipo');

    $nombre->nodeValue = $_SESSION['nombreEquipo'];

    $html_modificado = $dom->saveHTML();
    file_put_contents('equipo.html', $html_modificado);

    require 'equipo.html';

} else if($_SESSION['Usuario'] && !$_SESSION['Equipo']) {
    header("Location: equipos.php");
    exit;
} else {
    header("Location: login.html");
    exit;
}



?>