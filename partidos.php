<?php
session_start();
require 'controllers/sql.php';

if (isset($_POST['accion']) && $_POST['accion'] === 'desplegarPartidos') {

    $sql = new sql();
    $resultado = $sql->partidosEquipo($_SESSION['idEquipo']);
    
    echo json_encode($resultado);
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'comprobarCampeonatoJornada') {

    $sql = new sql();
    $resultado = $sql->comprobarCampeonatoJornada($_POST['campeonato'],$_POST['jornada'],$_SESSION['idEquipo']);
    
    echo $resultado;
    exit();

}

if (isset($_POST['accion']) && $_POST['accion'] === 'crearPartido') {
    
    $sql = new sql();
    $id = $sql->maxIdPartidos();

    $result = $sql->crearPartido($id+1,$_SESSION['idEquipo'],$_POST['rival'],$_POST['resultado'],$_POST['campeonato'],$_POST['jornada'],$_POST['fecha']);

    return $result;

}

if($_SESSION['Usuario'] && $_SESSION['idEquipo'])  {

    $html = file_get_contents('partidos.html');
    $dom = new DOMDocument();
    $dom->loadHTML($html);

    $nombre = $dom->getElementById('nombreEquipo');

    $nombre->nodeValue = $_SESSION['nombreEquipo'];

    $html_modificado = $dom->saveHTML();
    file_put_contents('partidos.html', $html_modificado);

    require 'partidos.html';

} else if($_SESSION['Usuario'] && !$_SESSION['Equipo']) {
    header("Location: equipos.php");
    exit;
} else {
    header("Location: login.html");
    exit;
}



?>