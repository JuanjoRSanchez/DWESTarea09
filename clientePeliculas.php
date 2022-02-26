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
            $IDImdb = ["La Comunidad del Anillo"=>"tt0120737",
                        "Las dos torres"=>"tt0167261",
                        "El retorno del Rey"=>"tt0167260",
                        "El Hobbit"=>"tt0903624",
                        "Yo, robot"=>"tt0343818",
                        "Mortadelo y Filemon"=>"tt0314121"
                ];
            
// Si se ha hecho una peticion que busca informacion de un autor "get_datos_autor" a traves de su "id"...
            if (isset($_GET["action"]) && isset($_GET["titulo"])) {
                $tit = $_GET["titulo"];
                $id;
                foreach ($IDImdb as $clave=>$valor){
                    if($tit === $clave){
                        $id = $valor;
                        break;
                    }
                }
                //Se realiza la peticion a la api IMDB que nos devuelve el JSON con la información de la película
                $app_info = file_get_contents('https://api.themoviedb.org/3/movie/' .$id .'?api_key=8a2b1ab4eb3eb709fc1caa1f7168c3c0&language=ES');
                // Se decodifica el fichero JSON y se convierte a array
                $app_info = json_decode($app_info, true);
                foreach ($app_info as $clave => $valor) {
                    if ($clave !== 'Resumen' || $clave !== 'Título' || $clave !== 'Fecha' || $clave !== 'Puntuación IMDB') {
                        $pos = array_search($clave, $app_info);
                        echo $pos;
                        if ($pos) {
                            unset($app_info[$pos]);
                        }
                    }
                }
                ?>
                <div id="cajatabla">
                    <h1>Datos de la Película</h1>
                    <?php 
                    $arraySalida = [];
                    $i = 0;
                    foreach ($app_info as $clave => $valor):
                        switch ($clave) {
                            case 'overview':
                                $clave = 'Resumen';
                                break;
                            case 'title':
                                $clave = 'Título';
                                break;
                            case 'release_date':
                                $clave = 'Fecha';
                                break;
                            case 'vote_average':
                                $clave = 'Puntuación IMDB';
                                break;
                        }
                        if ($clave === 'Resumen' || $clave === 'Título' || $clave === 'Fecha' || $clave === 'Puntuación IMDB') {
                            $arraySalida [$clave] = $valor;
                        }
                    endforeach; ?> 
                    <table>
                        <?php foreach ($arraySalida as $clave => $valor): ?>
                            <tr> 
                                <th><?=$clave ?></th>
                                <td><?=$valor ?></td>
                            </tr>
                        <?php endforeach; ?> 
                </table>
            </div>               
            <br />
            <!-- Enlace para volver a la lista de autores -->
            <a class="btnRetorno" href="http://localhost/T09/clienteAutores.php?action=getListaAutores" alt="Lista de autores">Volver a la lista de autores</a>
        </div>
    </body>
            <?php } ?> 
</html>
