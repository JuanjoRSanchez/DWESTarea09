<!DOCTYPE html>
<html>
    <head>
        <title>Tarea 08 Base de datos</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <style>
            @import 'estilos.css' ;
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
            if (isset($_GET["action"]) && isset($_GET["id"]) && $_GET["action"] == "getDatosAutor") {
                //Se realiza la peticion a la api que nos devuelve el JSON con la información de los autores
                $app_info = file_get_contents('http://localhost/T09/apis.php?action=getDatosAutor&id=' . $_GET["id"]);
                // Se decodifica el fichero JSON y se convierte a array
                $app_info = json_decode($app_info, true);
                ?>
                <div id="cajatabla">
                    <h1>Datos del Autor</h1>
                    <table> 
                        <tr><th>Id: </th><td> <?php echo $app_info["datos"][0] ?></td></tr>
                        <tr><th>Nombre: </th><td> <?php echo $app_info["datos"][0] ?></td></tr>
                        <tr><th>Apellidos: </th><td> <?php echo $app_info["datos"][1] ?></td></tr>
                        <tr><th>Nacionalidad: </th><td> <?php echo $app_info["datos"][2] ?></td></tr>
                    </table>
                </div>
                <div id="cajatabla">
                    <h1>Libros del Autor</h1>
                    <table>
                        <tr> <th>Título</th><th>Id</th><th>Películas</th></tr>
                        <?php foreach ($app_info["libros"] as $libro): ?>                        
                            <tr>
                                <td><?php echo $libro[0] ?></td>
                                <td>
                                    <a href="<?php echo "http://localhost/T09/clienteLibros.php?action=getDatosLibro&id=" . $libro[1] ?>"><?= $libro[1]; ?> </a>
                                </td>
                                <td>
                                    <a  href="<?php
                                    $valido = false;
                                    $salida;
                                    foreach ($IDImdb as $clave => $valor) {
                                        if ($libro[0] === $clave) {
                                            $valido = true;
                                        }
                                    }
                                    if($valido){
                                        echo "http://localhost/T09/clientePeliculas.php?action=1&titulo=" . $libro[0];
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
                <br />
                <!-- Enlace para volver a la lista de autores -->
                <a class="btnRetorno" href="http://localhost/T09/clienteAutores.php?action=getListaAutores" alt="Lista de autores">Volver a la lista de autores</a>
                <?php
            } else { //sino muestra la lista de autores
                // Pedimos al la api que nos devuelva una lista de autores. La respuesta se da en formato JSON
                $lista_autores = file_get_contents('http://localhost/T09/apis.php?action=getListaAutores');
                // Convertimos el fichero JSON en array

                $lista_autores = json_decode($lista_autores, true);
                ?>
                <div id="cajatabla">
                    <table >
                        <tr><th>Lista de autores</th>
                            <!-- Mostramos una entrada por cada autor -->
                            <?php foreach ($lista_autores as $autores): ?>
                            <tr>
                                <td>
                                    <!-- Enlazamos cada nombre de autor con su informacion (primer if) -->
                                    <a href= "<?php echo "http://localhost/T09/clienteAutores.php?action=getDatosAutor&id=" . $autores[0] ?>"><?php echo $autores[1] . $autores[2] ?></a>
                                </td>
                            <tr>
                            <?php endforeach; ?>

                    </table>
                </div>
            <?php }
            ?>
        </div>

    </body>
</html>
