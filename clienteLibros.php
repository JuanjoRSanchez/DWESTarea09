<!DOCTYPE html>
<html>
    <head>
        <title>Tarea 08 Base de datos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            @import 'estilos.css';

        </style>
    </head>
    <body>
        <header>
            <a id="" href="index.php"><div><p>Trabajo con Servicios</p></div></a> 
        </header>
        <div id="caja">
            <?php
            $IDImdb = ["La Comunidad del Anillo" => "tt0120737",
                "Las dos torres" => "tt0167261",
                "El retorno del Rey" => "tt0167260",
                "El Hobbit" => "tt0903624",
                "Yo, robot" => "tt0343818",
                "Mortadelo y Filemon" => "tt0314121"
            ];
// Si se ha hecho una peticion que busca informacion de un autor "get_datos_autor" a traves de su "id"...
            if ((isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "getDatosLibro")) {
                //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
                $app_infoLibro = file_get_contents('http://localhost/T09/apis.php?action=getDatosLibro&id=' . $_GET["id"]);
                // Se decodifica el fichero JSON y se convierte a array
                $app_infoLibro = json_decode($app_infoLibro, true);
                $app_infoAutor = file_get_contents('http://localhost/T09/apis.php?action=getDatosAutor&id=' . $app_infoLibro["datos"][2]);
                // Se decodifica el fichero JSON y se convierte a array
                $app_infoAutor = json_decode($app_infoAutor, true);
                ?>
                <div id="cajatabla">
                    <h1>Datos del libro</h1>
                    <table>
                        <tr><th>Título: </th><td> <?php echo $app_infoLibro["datos"][0] ?></td></tr>
                        <tr><th>Fecha de publicación:</th><td> <?php echo $app_infoLibro["datos"][1] ?></td></tr>
                        <tr><th>Nombre de autor: </th><td> <a href="<?php echo "http://localhost/T09/clienteAutores.php?action=getDatosAutor&id=" . $app_infoLibro["datos"][2] ?>"><?php echo $app_infoAutor["datos"][0] ?></a></td></tr>
                        <tr><th>Apellidos de autor: </th><td> <?php echo $app_infoAutor["datos"][1] ?></td></tr>
                        <tr><th>ID del autor: </th><td> <?php echo $app_infoLibro["datos"][2] ?></td></tr>
                    </table>
                </div>      
                <br />              
                <br /><br /><br /><br />
                <!-- Enlace para volver a la lista de autores -->
                <a class="btnRetorno" href="http://localhost/T09/clienteLibros.php?action=getListaLibros" alt="Lista de libros">Volver a la lista de libros</a>
                <?php
            } elseif ((isset($_GET["action"]) && isset($_GET["titulo"]) && $_GET["action"] == "getDatosLibroPorTitulo")) {
                $app_infoLibro = file_get_contents('http://localhost/T08/apis.php?action=getDatosLibro&id=' . $_GET["titulo"]);
                $app_infoLibro = json_decode($app_infoLibro, true);
                $app_infoAutor = file_get_contents('http://localhost/T09/apis.php?action=getDatosAutor&id=' . $app_infoLibro["datos"][2]);
            } else { //sino muestra la lista de autores
                // Pedimos al la api que nos devuelva una lista de autores. La respuesta se da en formato JSON
                $lista_libros = file_get_contents('http://localhost/T09/apis.php?action=getListaLibros');
                // Convertimos el fichero JSON en array   
                $lista_libros = json_decode($lista_libros, true);
                ?>
                <div id="cajatabla">
                    <table>
                        <tr><th>Id</th><th>Título</th><th>Películas</th></tr>
                        <!-- Mostramos una entrada por cada autor -->
                        <?php foreach ($lista_libros as $libro): ?>
                            <tr>
                                <td>
                                    <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->                  
                                    <?php echo $libro[0] ?>                       
                                </td>
                                <td>
                                    <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
                                    <a  href="<?php echo "http://localhost/T09/clienteLibros.php?action=getDatosLibro&id=" . $libro[0] ?>">
                                        <?php echo $libro[1] ?>
                                    </a>
                                </td>
                                <td>
                                    <a  href="<?php
                                    $valido = false;
                                    $salida;
                                    foreach ($IDImdb as $clave => $valor) {
                                        if ($libro[1] === $clave) {
                                            $valido = true;
                                        }
                                    }
                                    if($valido){
                                        echo "http://localhost/T09/clientePeliculas.php?action=1&titulo=" . $libro[1];
                                        $salida = "Info película";
                                    } else{
                                        $salida =  "x";
                                    }
                                    ?>"><?=$salida  ?></a>
                                </td>

                            </tr>
                <?php endforeach; ?>
                    </table>
                </div>
<?php }
?>
        </div>
    </body>
    <script>
        var json;
        var respuesta = [];
        json = new XMLHttpRequest();
        json.open("GET", "", true);
        json.send();
        json.onreadystatechange = gestionarPeticion;

        function gestionarPeticion() {
            if (json.readyState === 4 && json.status === 200) {
                respuesta = json.responseText;


            }
        }
    </script>
</html>
