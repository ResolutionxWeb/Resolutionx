<?php

class sql {

    // Configuración de la conexión a la base de datos
    private $servername = "resolutionxweb.cxz64uegjq0k.eu-south-2.rds.amazonaws.com";
    private $username = "AdminResolutionX";
    private $password = "VeDxNoItUlOsEr";
    private $dbname = "ResolutionXDEV";

    public function verificarUsuario($user, $passw) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $passwCod = md5($passw);
    
        $sql = "SELECT * FROM Users WHERE Usuario = '$user' AND Contraseña = '$passwCod'";
        $result = $conn->query($sql);
        
        $row = $result->fetch_assoc();

        if ($row != null) {
            session_start();

            $_SESSION['Usuario'] = $row['Usuario'];
            $_SESSION['IDuser'] = $row['ID'];

            return true;
        } else {
            return false;
        }
    }

    public function desplegarEquipos($user) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Equipos WHERE ID_User = '$user'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $equipos = array();
            while ($row = $result->fetch_assoc()) {
              $equipos[] = $row;
            }

            return $equipos;

        } else {
            return false;
        }
    }

    public function buscarEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT Nombre FROM Equipos WHERE ID = '$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            
            $row = $result->fetch_assoc();      

            return $row["Nombre"];

        } else {
            return false;
        }
    }

    public function goleadoresEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT j.Nombre, sum(e.Goles) as Goles FROM Jugadores j INNER JOIN Estadisticas e ON e.ID_Jugador = j.ID INNER JOIN Equipos eq ON eq.ID = j.ID_Equipo WHERE eq.ID LIKE '$id' AND j.Posicion NOT LIKE 'Portero' group by j.ID";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadisticas = array();
            while ($row = $result->fetch_assoc()) {
              $estadisticas[] = $row;
            }

            return $estadisticas;
        } else {
            return false;
        }
    }

    public function estadisticasBaseEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT j.Dorsal, j.Nombre, sum(e.Goles) as Goles, sum(e.Lanzamientos) as Lanzamientos, sum(e.Perdidas) as Perdidas, sum(e.Recuperaciones) as Recuperaciones, 
        COUNT(e.ID_Jugador) as 'Partidos Jugados' , j.Posicion FROM Jugadores j INNER JOIN Estadisticas e ON e.ID_Jugador = j.ID 
        INNER JOIN Equipos eq ON eq.ID = j.ID_Equipo WHERE eq.ID LIKE '$id' AND j.Posicion NOT LIKE 'Portero' group by j.ID";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadisticas = array();
            while ($row = $result->fetch_assoc()) {
              $estadisticas[] = $row;
            }

            return $estadisticas;
        } else {
            return false;
        }
    }

    public function estadisticasBasePorteros($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT j.Dorsal, j.Nombre, sum(e.LanzamientosP) as 'Lanzamientos Recibidos', sum(e.Paradas) as Paradas, sum(e.GolesRecibidos) as 'Goles Recibidos',
        COUNT(e.ID_Jugador) as 'Partidos Jugados' , j.Posicion FROM Jugadores j INNER JOIN Estadisticas e ON e.ID_Jugador = j.ID 
        INNER JOIN Equipos eq ON eq.ID = j.ID_Equipo WHERE eq.ID LIKE '$id' AND j.Posicion LIKE 'Portero' group by j.ID";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadisticas = array();
            while ($row = $result->fetch_assoc()) {
              $estadisticas[] = $row;
            }

            return $estadisticas;
        } else {
            return false;
        }
    }

    public function estadisticasPorteroBaseEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT j.Dorsal, j.Nombre,sum(e.Paradas) as Paradas, sum(e.GolesRecibidos) as 'Goles Recibidos', sum(e.LanzamientosP) as 'Lanzamientos Recibidos',
        COUNT(e.ID_Jugador) as 'Partidos Jugados' , j.Posicion FROM Jugadores j INNER JOIN Estadisticas e ON e.ID_Jugador = j.ID INNER JOIN Equipos eq ON eq.ID = j.ID_Equipo
        WHERE eq.ID LIKE '$id' AND j.Posicion LIKE 'Portero' group by j.ID";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadisticas = array();
            while ($row = $result->fetch_assoc()) {
              $estadisticas[] = $row;
            }

            return $estadisticas;
        } else {
            return false;
        }
    }

    public function estadisticasPorteroPieEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT sum(e.Paradas) as Paradas, sum(e.GolesRecibidos) as 'Goles Recibidos' FROM Jugadores j 
        INNER JOIN Estadisticas e ON e.ID_Jugador = j.ID INNER JOIN Equipos eq ON eq.ID = j.ID_Equipo WHERE eq.ID LIKE '$id' AND j.Posicion LIKE 'Portero';";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadisticas = array();
            while ($row = $result->fetch_assoc()) {
              $estadisticas[] = $row;
            }

            return $estadisticas;
        } else {
            return false;
        }
    }
    
    public function partidosEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Partidos p where ID_Equipo LIKE '$id' ORDER BY Fecha ASC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $partidos = array();
            while ($row = $result->fetch_assoc()) {
              $partidos[] = $row;
            }

            return $partidos;
        } else {
            return false;
        }
    }

    public function jugadoresEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Jugadores where ID_Equipo LIKE '$id' ORDER BY Dorsal ASC;";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $jugadores = array();
            while ($row = $result->fetch_assoc()) {
              $jugadores[] = $row;
            }

            return $jugadores;
        } else {
            return false;
        }
    }

    public function estadisticasPartidoJugadores($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT e.ID, e.ID_Partido, j.Nombre, p.Rival, p.Campeonato, p.Jornada, e.Lanzamientos, e.Goles, e.Perdidas, e.Recuperaciones, j.Dorsal, j.Posicion FROM Estadisticas e INNER JOIN Partidos p ON p.ID = e.ID_Partido INNER JOIN Jugadores j ON j.ID = e.ID_Jugador WHERE p.ID_Equipo = '$id' AND j.Posicion NOT LIKE 'Portero' order by p.Fecha ASC, j.Dorsal ASC;";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadisticas = array();
            while ($row = $result->fetch_assoc()) {
              $estadisticas[] = $row;
            }

            return $estadisticas;
        } else {
            return false;
        }
    }

    public function estadisticasPartidoPorteros($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT e.ID, e.ID_Partido, j.Nombre, p.Rival, p.Campeonato, p.Jornada, e.LanzamientosP, e.Paradas, e.GolesRecibidos, j.Dorsal, j.Posicion FROM Estadisticas e INNER JOIN Partidos p ON p.ID = e.ID_Partido INNER JOIN Jugadores j ON j.ID = e.ID_Jugador WHERE p.ID_Equipo = '$id' AND j.Posicion LIKE 'Portero' order by p.Fecha ASC, j.Dorsal ASC;";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadisticas = array();
            while ($row = $result->fetch_assoc()) {
              $estadisticas[] = $row;
            }

            return $estadisticas;
        } else {
            return false;
        }
    }

    public function crearEquipo($idEquipo, $idUser, $nombre, $lugar, $categoria, $temporada){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "INSERT INTO Equipos (ID, ID_User, Nombre, Lugar, Categoria, Temporada) VALUES ('$idEquipo', '$idUser', '$nombre', '$lugar', '$categoria', '$temporada')";
        if ($conn->query($sql) === TRUE) {
            return "Nuevo registro insertado correctamente.";
        } else {
            return "Error al insertar el registro: " . $conn->error;
        }
    }

    public function maxIdEquipos(){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT Max(ID) as max_id from Equipos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $maxId = $fila['max_id'];
            
            return $maxId;
        } else {
            return "No se encontraron resultados.";
        }

    }

    public function crearJugador($idJugador, $idEquipo, $dni, $nombre, $apellidos, $posicion, $dorsal){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "INSERT INTO Jugadores (ID, ID_Equipo, DNI, Nombre, Apellidos, Posicion, Dorsal) VALUES($idJugador, $idEquipo, '$dni', '$nombre', '$apellidos', '$posicion', $dorsal)";
        if ($conn->query($sql) === TRUE) {
            return "Nuevo registro insertado correctamente.";
        } else {
            return "Error al insertar el registro: " . $conn->error;
        }
    }

    public function maxIdJugadores(){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT Max(ID) as max_id from Jugadores";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $maxId = $fila['max_id'];
            
            return $maxId;
        } else {
            return "No se encontraron resultados.";
        }

    }

    public function crearPartido($idPartido, $idEquipo, $rival, $resultado, $campeonato, $jornada, $fechaJS){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }

        $fecha = date('Y-m-d', strtotime($fechaJS));
    
        $sql = "INSERT INTO Partidos (ID, ID_Equipo, Rival, Resultado, Campeonato, Jornada, Fecha) VALUES($idPartido, $idEquipo, '$rival', '$resultado', '$campeonato', '$jornada', '$fecha')";
        if ($conn->query($sql) === TRUE) {
            return "Nuevo registro insertado correctamente.";
        } else {
            return "Error al insertar el registro: " . $conn->error;
        }
    }

    public function maxIdEstadisticas(){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT Max(ID) as max_id from Estadisticas";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $maxId = $row['max_id'];
            
            return $maxId;
        } else {
            return "No se encontraron resultados.";
        }

    }

    public function crearEstadistica($idEstadistica, $idJugador, $idPartido, $lanzamientos, $goles, $perdidas, $recuperaciones, $lanzamientosP, $paradas, $golesRecibidos){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "INSERT INTO Estadisticas (ID, ID_Jugador, ID_Partido, Lanzamientos, Goles, Perdidas, Recuperaciones, LanzamientosP, Paradas, GolesRecibidos) VALUES($idEstadistica, $idJugador, $idPartido, $lanzamientos, $goles, $perdidas, $recuperaciones, $lanzamientosP, $paradas, $golesRecibidos)";
        if ($conn->query($sql) === TRUE) {
            return "Nuevo registro insertado correctamente.";
        } else {
            return "Error al insertar el registro: " . $conn->error;
        }
    }

    public function maxIdPartidos(){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT Max(ID) as max_id from Partidos";
        $result = $conn->query($sql);

        if ($result->num_rows > 0) {
            $fila = $result->fetch_assoc();
            $maxId = $fila['max_id'];
            
            return $maxId;
        } else {
            return "No se encontraron resultados.";
        }

    }

    public function comprobarDorsal($dorsal, $idEquipo){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Jugadores where Dorsal like '$dorsal' AND ID_Equipo like '$idEquipo'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            
            return true;
        } else {
            return false;
        }

    }

    public function comprobarDNI($dni){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Jugadores where DNI like '$dni' AND ID_Equipo like '$idEquipo'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            
            return true;
        } else {
            return false;
        }
    }

    public function comprobarCampeonatoJornada($campeonato, $jornada, $idEquipo){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Partidos where Campeonato like '$campeonato' and Jornada like '$jornada' AND ID_Equipo like '$idEquipo'";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            
            return true;
        } else {
            return false;
        }
    }

    public function cargarJugadores($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT ID, Nombre, Apellidos FROM Jugadores where ID_Equipo LIKE '$id' ORDER BY Dorsal ASC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $jugadores = array();
            while ($row = $result->fetch_assoc()) {
              $jugadores[] = $row;
            }

            return $jugadores;
        } else {
            return false;
        }
    }

    public function cargarPartidos($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT ID, Campeonato, Jornada, Rival FROM Partidos where ID_Equipo LIKE '$id' ORDER BY Fecha ASC";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $jugadores = array();
            while ($row = $result->fetch_assoc()) {
              $jugadores[] = $row;
            }

            return $jugadores;
        } else {
            return false;
        }
    }

    public function posicionJugador($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT Posicion FROM Jugadores where ID LIKE '$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $jugadores = array();
            while ($row = $result->fetch_assoc()) {
              $jugadores[] = $row;
            }

            return $jugadores;
        } else {
            return false;
        }
    }
    
    public function comprobarPartidoJugador($idJugador, $idPartido){
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Estadisticas where ID_Jugador like $idJugador and ID_Partido like $idPartido";
        $result = $conn->query($sql);

        if ($result->num_rows == 0) {
            
            return true;
        } else {
            return false;
        }
    }

    public function elegirEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Equipos where ID LIKE '$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $equipo = array();
            while ($row = $result->fetch_assoc()) {
              $equipo[] = $row;
            }

            return $equipo;
        } else {
            return false;
        }
    }

    public function elegirJugador($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Jugadores where ID LIKE '$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $jugador = array();
            while ($row = $result->fetch_assoc()) {
              $jugador[] = $row;
            }

            return $jugador;
        } else {
            return false;
        }
    }

    public function elegirPartido($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Partidos where ID LIKE '$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $partido = array();
            while ($row = $result->fetch_assoc()) {
              $partido[] = $row;
            }

            return $partido;
        } else {
            return false;
        }
    }

    public function elegirEstadistica($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT * FROM Estadisticas where ID LIKE '$id'";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadistica = array();
            while ($row = $result->fetch_assoc()) {
              $estadistica[] = $row;
            }

            return $estadistica;
        } else {
            return false;
        }
    }

    public function numeroJugadoresEquipos($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT COUNT(j.ID) AS numeroJugadores FROM Equipos e INNER JOIN Jugadores j ON j.ID_Equipo = e.ID WHERE e.ID = '$id' GROUP by e.ID";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row['numeroJugadores'];
        } else {
            return false;
        }
    }

    public function numeroPartidosEquipos($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT COUNT(p.ID) AS numeroPartidos FROM Equipos e INNER JOIN Partidos p ON p.ID_Equipo = e.ID WHERE e.ID = '$id' GROUP by e.ID";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row['numeroPartidos'];
        } else {
            return false;
        }
    }

    public function numeroPartidosJugador($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT COUNT(e.ID_Jugador) as partidosJugados from Estadisticas e WHERE e.ID_Jugador = '$id' GROUP BY e.ID_Jugador";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row['partidosJugados'];
        } else {
            return false;
        }
    }

    public function numeroEstadisticasEquipos($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT COUNT(e2.ID) AS numeroEstadisticas FROM Equipos e INNER JOIN Partidos p ON p.ID_Equipo = e.ID INNER JOIN Estadisticas e2 ON e2.ID_Partido = p.ID WHERE e.ID = '$id' GROUP by e.ID;";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row['numeroEstadisticas'];
        } else {
            return false;
        }
    }

    public function numeroEstadisticasPartidos($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT COUNT(e.ID_Partido) as estadisticasPartidos from Estadisticas e WHERE e.ID_Partido = '$id' GROUP BY e.ID_Partido";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();

            return $row['estadisticasPartidos'];
        } else {
            return false;
        }
    }

    public function estadisticasEquipo($id) {
        
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);
        
        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
    
        $sql = "SELECT e.ID, j.Nombre, j.Apellidos, p.Rival, p.Campeonato, p.Jornada  FROM Estadisticas e INNER JOIN Partidos p ON p.ID = e.ID_Partido INNER JOIN Jugadores j ON j.ID = e.ID_Jugador WHERE j.ID_Equipo = '$id' ORDER BY e.ID";
        $result = $conn->query($sql);
        
        if ($result->num_rows > 0) {
            $estadisticas = array();
            while ($row = $result->fetch_assoc()) {
              $estadisticas[] = $row;
            }

            return $estadisticas;
        } else {
            return false;
        }
    }

    public function borrarEstadisticasEquipo($idEquipo) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $subquery = "SELECT e.ID FROM Estadisticas e
                     INNER JOIN Partidos p ON p.ID = e.ID_Partido
                     INNER JOIN Equipos e2 ON p.ID_Equipo = e2.ID
                     WHERE e2.ID = '$idEquipo'
                     ORDER BY e.ID";
        
        $result = $conn->query($subquery);

        if ($result->num_rows > 0) {

            while ($row = $result->fetch_assoc()) {
                $id = $row['ID'];
                $sql = "DELETE FROM Estadisticas WHERE ID LIKE $id";

                $conn->query($sql);    
            }
            
        }
    }

    public function borrarPartidosEquipo($idEquipo) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "DELETE FROM Partidos WHERE ID_Equipo = $idEquipo";

        $conn->query($sql);
        
    }

    public function borrarJugadoresEquipo($idEquipo) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "DELETE FROM Jugadores WHERE ID_Equipo = $idEquipo";

        $conn->query($sql);
        
    }

    public function borrarEquipo($idEquipo) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "DELETE FROM Equipos WHERE ID = $idEquipo";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function borrarEstadisticasJugador($idJugador) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "DELETE FROM Estadisticas WHERE ID_Jugador = $idJugador";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function borrarJugador($idJugador) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "DELETE FROM Jugadores WHERE ID = $idJugador";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function borrarEstadisticasPartido($idPartido) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "DELETE FROM Estadisticas WHERE ID_Partido = $idPartido";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function borrarPartido($idPartido) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "DELETE FROM Partidos WHERE ID = $idPartido";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

    public function borrarEstadistica($idPartido) {
        $conn = new mysqli($this->servername, $this->username, $this->password, $this->dbname);

        if ($conn->connect_error) {
            die("Conexión fallida: " . $conn->connect_error);
        }
        
        $sql = "DELETE FROM Estadisticas WHERE ID = $idPartido";

        if ($conn->query($sql) === TRUE) {
            return true;
        } else {
            return false;
        }
    }

}
session_start();

if (isset($_POST['accion']) && $_POST['accion'] === 'verificarUsuario') {
    $user = $_POST['parametro1'];
    $pass = $_POST['parametro2'];

    $sql = new sql();
    $resultado = $sql->verificarUsuario($user, $pass);
    if($resultado == 1){
        echo true;
    } else {
        echo false;
    }
}

if (isset($_POST['accion']) && $_POST['accion'] === 'cerrarSesion') {
    session_destroy();
    header("Location: ../login.html");
    exit;
}

?>
