<?php

/**
 * Función que establece una conexión con la base de datos 
 * @return \mysqli
 */
function conexion() {
    $mysqli = new mysqli("localhost", "root", "", "libros");
    if ($mysqli->connect_error) {
        echo "Error de conexión: " . $mysqli->connect_error;
        die("Pruebe de nuevo más tarde");
    } else {
        if (!$mysqli->set_charset("utf8")) {
            printf("Error cargando el conjunto de caracteres utf8: %s\n", $mysqli->error);
            exit();
        }
    }
    return $mysqli;
}

/**
 * Función que mediante la función conexión establece la conexioón y 
 * hace una consulta a la base de datos y en caso correcto devuleve un array con
 * con todos los autores guardados 
 * @return array
 */
function getListaAutores() {
    $resultado = array();
    $resultadoAux = array();
    $mysqli = conexion();
    $sql = "SELECT * FROM autor;";
    $res = $mysqli->query($sql);
    if ($res) {
        $i = 0;
        while ($fila = $res->fetch_array()) {
            $resultadoAux[0] = $fila["id"];
            $resultadoAux[1] = $fila["nombre"];
            $resultadoAux[2] = $fila["apellidos"];
            $resultadoAux[3] = $fila["nacionalidad"];
            $resultado[$i] = $resultadoAux;
            $i++;
        }
    } else {
        $resultado [0] = "Error en la consulta";
    }
    $mysqli->close();
    return $resultado;
}

/**
 * Función que mediante la función conexión establece la conexión y 
 * hace una consulta a la base de datos y en caso correcto devuleve un array con
 * con todos los libros guardados 
 * @return array
 */
function getListaLibros() {
    $resultado = array();
    $resultadoAux = array();
    $mysqli = conexion();
    $sql = "SELECT * FROM libro ;";
    $res = $mysqli->query($sql);
    if ($res) {
        $i = 0;
        while ($fila = $res->fetch_array()) {
            $resultadoAux[0] = $fila["id"];
            $resultadoAux[1] = $fila["titulo"];
            $resultadoAux[2] = $fila["f_publicacion"];
            $resultado[$i] = $resultadoAux;
            $i++;
        }
    } else {
        $resultado [0] = "Error en le consulta";
    }

    $mysqli->close();
    return $resultado;
}

/**
 * Función que acepta como argumento un id de libro, hace una consulta 
 * y devuelve un array con los datos del libro especificado
 * @param type $id
 * @return array
 */
function getDatosLibro($id) {
    $salida = array();
    $mysqli = conexion();
    $sql = "SELECT titulo, f_publicacion, id_autor FROM libro WHERE id=' $id ' ";
    $res = $mysqli->query($sql);
    if ($res) {
        $fila = $res->fetch_array();
        $salida["datos"][0] = $fila["titulo"];
        $salida["datos"][1] = $fila["f_publicacion"];
        $salida["datos"][2] = $fila["id_autor"];
    } else {
        $salida["datos"] [0] = "No encontré al autor";
    }
    $mysqli->close();
    return $salida;
}

/**
 * Función que acepta como argumento un id de autor, hace una consulta 
 * y devuelve un array con los datos del autor especificado
 * @param type $id
 * @return array
 */
function getDatosAutor($id) {
    $salida = array();
    $mysqli = conexion();
    $sql = "SELECT id, nombre, apellidos, nacionalidad FROM autor WHERE id=" . $id . "; ";
    $res = $mysqli->query($sql);
    if ($res) {
        $fila = $res->fetch_array();
        $salida["datos"][0] = $fila["nombre"];
        $salida["datos"][1] = $fila["apellidos"];
        $salida["datos"][2] = $fila["nacionalidad"];
        $id_autor = $fila["id"];
        $res->free();
        $sql2 = "SELECT titulo, id FROM libro WHERE id_autor=' $id_autor '";
        $res = $mysqli->query($sql2);
        $i = 0;
        while ($fila2 = $res->fetch_array()) {
            $salidaAux [0] = $fila2[0];
            $salidaAux [1] = $fila2[1];

            $salida["libros"][$i] = $salidaAux;
            $i++;
        }
    } else {
        $salida["libros"] = "No encontré al autor";
    }
    $mysqli->close();
    return $salida;
}
/*
 * 
 */
function getDatosLibroPorTitulo($titulo) {
    $titulos = strtolower($titulo);
    $salida = "";
    $misql = conexion();
    $sql = "SELECT * FROM libro WHERE titulo LIKE '" . $titulos . "' ";
    $res = $misql->query($sql);
    $i = 0;
    while ($campo = $res->fetch_array()) {
        $salida = $salida . "<br>" . $campo['titulo'];
        $i++;
    }
    $res->free();
    $misql->close();
    return $salida;
}
/*
 * Función que acepta como argumento un título de libro, hace una consulta 
 * y devuelve un array con los libros que tenga conincidencias con el título
 * introducido.
 * @param type $titulo
 * @return array
 */
function cotejaLibro($titulo) {
    $titulos = strtolower($titulo);
    $salida = [];
    $misql = conexion();
    if ($titulo !== "") {
        $sql = "SELECT titulo FROM libro WHERE titulo LIKE '" . $titulos . "%'  ";
        $res = $misql->query($sql);
        $i = 0;
        while ($campo = $res->fetch_assoc()) {
            $salida [$i] = $campo;
            $i++;
        }
        json_encode($salida);
        $res->free();
        $misql->close();
        return $salida;
    }
}
/*
 * Función que acepta como argumento un nombre de autor, hace una consulta 
 * y devuelve un array con los autores que tenga conincidencias con el nombre
 * introducido.
 * @param type $autor
 * @return array
 */
function cotejaAutor($autor) {
    $autores = strtolower($autor);
    $salida = [];
    $misql = conexion();
    if ($autores !== "") {
        $sql = "SELECT nombre,id FROM autor WHERE nombre LIKE '" . $autores . "%'  ";
        $res = $misql->query($sql);
        $i = 0;
        while ($campo = $res->fetch_assoc()) {
            $salida [$i] = $campo;
            $i++;
        }
        json_encode($salida);
        $res->free();
        $misql->close();
        return $salida;
    }
}
/*
 * Función que acepta como argumento un nombre de autor, hace una consulta 
 * y devuelve un array con los autores que tenga conincidencias con el nombre
 * introducido y sus libros del catálogo.
 * @param type $autor
 * @return array
 */
function cotejaAutorLibro($autor) {
    $autores = strtolower($autor);
    $salida = [];
    $misql = conexion();
    if ($autores !== "") {
        $sql = "SELECT autor.nombre, autor.ID, libro.id_autor, libro.titulo FROM autor INNER JOIN libro ON autor.id=libro.id_autor WHERE autor.nombre LIKE '$autor%'; ";
        $res = $misql->query($sql);
        
        $i = 0;
        while ($fila = $res->fetch_assoc()) {
            $salida [$i] = $fila;
            $i++;
        }
        json_encode($salida);
        $res->free();
        $misql->close();
        return $salida;
    }
}

/**
 * Mediante un condicional que evalua la URL de llamada a la api y en función 
 * de esta llamará a la funcioón corerspondiente 
 */
$posibles_URL = array("getListaAutores", "getDatosAutor", "getListaLibros", "getDatosLibro", "getTitulo", "getDatosLibroPorTitulo", "getAutor", "getAutorLibros");
$valor = "Ha ocurrido un error";
if (isset($_GET["action"]) && in_array($_GET["action"], $posibles_URL)) {
    switch ($_GET["action"]) {
        case "getListaAutores":
            $valor = getListaAutores();
            break;
        case "getDatosAutor":
            if (isset($_GET["id"]))
                $valor = getDatosAutor($_GET["id"]);
            else
                $valor = "Argumento no encontrado";
            break;
        case "getListaLibros":
            $valor = getListaLibros();
            break;
        case "getDatosLibro":
            if (isset($_GET["id"]))
                $valor = getDatosLibro($_GET["id"]);
            else
                $valor = "Argumento no encontrado";
            break;
        case "getTitulo":
            if (isset($_GET["titulo"]))
                $valor = cotejaLibro($_GET["titulo"]);
            else
                $valor = "Título no encontrado";
            break;
        case "getDatosLibroPorTitulo":
            if (isset($_GET["titulo"]))
                $valor = getDatosLibroPorTitulo($_GET["titulo"]);
            else
                $valor = "Título no encontrado";
            break;
        case "getAutor":
            if (isset($_GET["autor"]))
                $valor = cotejaAutor($_GET["autor"]);
            else
                $valor = "Nombre no encontrado";
            break;
        case "getAutorLibros":
            if (isset($_GET["autor"]))
                $valor = cotejaAutorLibro($_GET["autor"]);
            else
                $valor = "Nombre no encontrado";
            break;
    }
}
//devolvemos los datos serializados en JSON
exit(json_encode($valor));
?>