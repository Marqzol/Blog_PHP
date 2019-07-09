<?php

class GestorSQL_PDO {

    private $db_host, $db_nombre ,$db_usuario, $db_pass, $conexion, $tablas;

    public function __construct($db_host, $db_usuario, $db_pass, $db_nombre){

            $this->db_host = $db_host;
            $this->db_usuario = $db_usuario;
            $this->db_pass = $db_pass;
            $this->db_nombre = $db_nombre;
            $this->tablas = [];
            $this->conexion = "";

            //Lanza el método privado para crear la BBDD.
            $this->ConectarBBDD(); 

    }

    //CONECTA CON LA BASE DE DATOS CON LOS DATOS DEL CONSTRUCTOR.
    public function conectarBBDD(){
        try {
            $this->conexion = new PDO("mysql:host=$this->db_host;dbname=$this->db_nombre;charset=utf8mb4", $this->db_usuario, $this->db_pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOExceptio $e) {
            echo "Connection failed: ". $e->getMessage();
        }

    }

    //CREA LA BASE DE DATOS CON LOS DATOS DEL CONSTRUCTOR.
    public function crearBBDD($BBDD){
        try {
            $this->conexion = new PDO("mysql:host=$this->db_host;dbname=$this->db_nombre;charset=utf8", $this->db_usuario, $this->db_pass);
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query ="CREATE DATABASE $BBDD";
            $this->conexion->exec($sql);
        } catch (PDOException $e) {
            echo $query ."<br>". $e->getMessage();
        }
        $this->conexion = null;
    }

    //CREA UNA TABLA VACÍA, SOLAMENTE CON UN ID AUTO INCREMENTAL
    public function crearTabla($nombreTabla){
        try {
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $query = "CREATE TABLE $nombreTabla (ID INTEGER NOT NULL AUTO_INCREMENT PRIMARY KEY)";
            $this->conexion->exec($query);
        } catch (PDOException $e) {
            echo $query ."<br>". $e->getMessage();
        }
    }

    //DEVUELVE EL NOMBRE DE UNA TABLA PASADA POR PARÁMETRO, SI EXISTE.
    public function getTabla($nombre_tabla){
        try {
            $query = "SHOW TABLES FROM $this->db_nombre LIKE '$nombre_tabla'";
            $check = $this->conexion->query($query);
            if ($check == false) {
                return false;
            }else{
                if ($check->rowCount() > 0) {
                    return true;
                }else{
                    throw new Exception("Conexión establecida correctamente pero no existe ninguna tabla con el nombre: $nombre_tabla");
                    return false;
                }		
            }
        } catch (PDOException $e) {
            echo $query ."<br>". $e->getMessage();
        } catch(Exception $ex) {
            echo 'Excepción capturada: ',  $ex->getMessage(), "\n";
        }
    }

    //CREA LAS COLUMNAS (NOMBRE => TIPO) QUE SE QUIERA PARA UN NOMBRE DE TABLA CONCRETO.
    public function crearColumnas($nombre_tabla, $columnas){
        try {
            $this->conexion->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            if ($this->getTabla($nombre_tabla)) {
                foreach ($columnas as $nombre_col => $tipo_col) {
                    $query = "ALTER TABLE $nombre_tabla ADD COLUMN $nombre_col $tipo_col";
                    $check = $this->conexion->query($query);
                    if ($check->rowCount() < 0){
                        throw new Exception("No se ha modificado ninguna columna con el nombre: $nombre_col y el tipo: $tipo_col");
                    }
                }
            }
        } catch (PDOException $e) {
            echo $query ."<br>". $e->getMessage();
        } catch(Exception $ex) {
            echo 'Excepción capturada: ',  $ex->getMessage(), "\n";
        }
    }

    //INSERTA LOS DATOS QUE SE QUIERA (ARRAY DE DATOS) PARA UNA TABLA CONCRETA.
    public function Insert($nombre_tabla, $columnas = "", $datos){
        if ($this->getTabla($nombre_tabla)) {
            try {
                $datos = $this->arrayToString($datos, true);
                switch ($columnas){
                    case "":
                        $columnas = $this->getColumnsName_NO_ID($nombre_tabla);
                        $query = "INSERT INTO $nombre_tabla ($columnas) VALUES ($datos)";
                        break;
                    default:
                        $query = "INSERT INTO $nombre_tabla ($columnas) VALUES ($datos)";
                }
                $check = $this->conexion->query($query);
                return $check;
            } catch (PDOException $e) {
                echo $query ."<br>". $e->getMessage();
            }
        }
    }

    //SELECT CON CAMPOS ESPECÍFICOS
    public function selectBy($nombre_tabla, $datos_obtener, $INNER = "", $datos_seleccion = ""){
        if ($this->getTabla($nombre_tabla)) {
            try {
                $datos_obtener_filtrados = $this->arrayToString($datos_obtener);
                switch ($INNER){
                    case "":
                        if(empty($datos_seleccion)){
                            $query = "SELECT $datos_obtener_filtrados FROM $nombre_tabla";
                        }else{
                            $query = "SELECT $datos_obtener_filtrados FROM $nombre_tabla $datos_seleccion";
                        }
                        break;
                    default:
                        if(empty($datos_seleccion)){
                            $query = "SELECT $datos_obtener_filtrados FROM $nombre_tabla " . $INNER;
                        }else{ // Tuve que cambiar la línea de abajo y borrarle el WHERE (que lo escriba el programador)
                            $query = "SELECT $datos_obtener_filtrados FROM $nombre_tabla $INNER $datos_seleccion";
                        }
                        break;
                }
                $resultado = $this->conexion->prepare($query);
                $resultado->execute();
                if($resultado->rowCount() == 0){
                    return false; //No se ha encontrado ningún registro con esos datos
                }else{
                    return $resultado; //Se ha encontrado la coincidencia
                }
            } catch (PDOException $e) {
                echo $query ."<br>". $e->getMessage();
            }
        }
    }

    //SELECT CON TODOS LOS CAMPOS.
    public function selectAll($nombre_tabla, $INNER = "" ,$datos_seleccion = "") {
        if ($this->getTabla($nombre_tabla)) {
            try {
                switch ($INNER){
                    case "":
                        if (empty($datos_seleccion)) {
                            $query = "SELECT * FROM $nombre_tabla";
                        }else{
                            $query = "SELECT * FROM $nombre_tabla WHERE $datos_seleccion";
                        }
                        break;
                    default:
                        if (empty($datos_seleccion)) {
                            $query = "SELECT * FROM $nombre_tabla " . $INNER;
                        }else{
                            $query = "SELECT * FROM $nombre_tabla " . $INNER . " WHERE $datos_seleccion";
                        }
                        break;
                }
                $resultado = $this->conexion->prepare($query);
                $resultado->execute();
                if($resultado->rowCount() == 0){
                    return false; //No se ha encontrado ningún registro con esos datos
                }else{
                    return $resultado; //Se ha encontrado la coincidencia
                }
            } catch (PDOException $e) {
                echo $query ."<br>". $e->getMessage();
            }				
        }
    }
    
    //SELECT CON CAMPOS ESPECÍFICOS
    public function selectCount($nombre_tabla, $dato_obtener, $INNER = "", $datos_seleccion = ""){
        if ($this->getTabla($nombre_tabla)) {
            try {
                switch ($INNER){
                    case "":
                        if(empty($datos_seleccion)){
                            $query = "SELECT COUNT($dato_obtener) FROM $nombre_tabla";
                        }else{
                            $query = "SELECT COUNT($dato_obtener) FROM $nombre_tabla WHERE $datos_seleccion";
                        }
                        break;
                    /*default:
                        if(empty($datos_seleccion)){
                            $query = "SELECT $datos_obtener_filtrados FROM $nombre_tabla " . $INNER;
                        }else{ // Tuve que cambiar la línea de abajo y borrarle el WHERE (que lo escriba el prog)
                            $query = "SELECT $datos_obtener_filtrados FROM $nombre_tabla $INNER $datos_seleccion";
                        }
                        break;*/
                }
                $resultado = $this->conexion->prepare($query);
                $resultado->execute();
                if($resultado->rowCount() == 0){
                    return false; //No se ha encontrado ningún registro con esos datos
                }else{
                    return $resultado; //Se ha encontrado la coincidencia
                }
            } catch (PDOException $e) {
                echo $query ."<br>". $e->getMessage();
            }
        }
    }

    //DELETE CON DATOS DE SELECCIÓN
    public function Delete ($nombre_tabla, $datos_seleccion){
        if ($this->getTabla($nombre_tabla)) {
            try {
                $query = "DELETE FROM $nombre_tabla WHERE $datos_seleccion";
                $resultado = $this->conexion->prepare($query);
                $resultado->execute();
                if($resultado->rowCount() == 0){
                    return false; //No se ha borrado ningún registro con esos datos
                }else{
                    return $resultado; //Se ha borrado la coincidencia
                }
            } catch (PDOException $e) {
                echo $query ."<br>". $e->getMessage();
            }
        }
    }

    //UPDATE CON DATOS DE SELECCIÓN
    public function Update($nombre_tabla, $datos_modificar ,$datos_seleccion){
        if ($this->getTabla($nombre_tabla)) {
            try {
                $query = "UPDATE $nombre_tabla SET $datos_modificar WHERE $datos_seleccion";
                $resultado = $this->conexion->prepare($query);
                $resultado->execute();
                if($resultado->rowCount() == 0){
                    return false; //No se ha actualizado ningún registro con esos datos
                }else{
                    return $resultado; //Se ha actualizado la coincidencia
                }
            } catch (PDOException $e) {
                echo $query ."<br>". $e->getMessage();
            }
        }
    }

    //DEVUELVE EL NOMBRE DE CADA COLUMNA DE UNA TABLA (SIN APARECER LA COLUMNA "ID"). FORMATO ADAPTADO PARA INSERT, DELETE, UPDATE.
    private function getColumnsName_NO_ID($nombre_tabla){
        $query = "SHOW COLUMNS FROM $nombre_tabla";
        try {
            $check = $this->conexion->query($query);
            if ($check->rowCount() < 0){
                throw new Exception("No se ha encontrado ninguna columna para la tabla: $nombre_tabla");	
            }else{
                $array = array();
                foreach ($check as $value) {
                    if ($value[0] != "ID" && $value[0] != "id") {
                        array_push($array, $value[0]);
                    }
                }
                return $this->arrayToString($array);
            }
        } catch (PDOException $e) {
            echo $query ."<br>". $e->getMessage();
        }
    }

    //TRANSFORMA UN ARRAY EN UN STRING (CONCATENADOS DE STRINGS). FORMATO ADAPTADO PARA INSERT, DELETE Y UPDATE.
    //Si $checkComillas = false no concatena los strings con comillas (para devolver el nombre de las columnas, por ejemplo)
    //Si $checkComillas = true concatena los strings con comillas (para devolver los datos de un insert a hacer, por ejemplo)
    private function arrayToString($array, $checkComillas = false){
        $strings_name = "";
        switch ($checkComillas) {
            case true:
                for ($i=0; $i < count($array); $i++) {
                    if ($i==0) {
                        $strings_name = "'" . $array[$i] . "'";
                    }else{
                        $strings_name = $strings_name . ", '" . $array[$i] . "'";
                    }	
                }
                break;
            case false:
                for ($i=0; $i < count($array); $i++) {
                    if ($i==0) {
                        $strings_name = $array[$i];
                    }else{
                        $strings_name = $strings_name . ", " . $array[$i];
                    }	
                }
                break;
        }
        return $strings_name;
    }
    
    //FUNCIÓN QUE DEVUELVE LA CONEXIÓN PARA PODER USARSE EN OTROS ARCHIVOS
    public function getConexion(){
        return $this->conexion;
    }
}

?>

