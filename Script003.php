<!DOCTYPE html>
<html>
    <head>
        <title>Script DWES Tarea 09</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.1/jquery.min.js"></script>
        <style>
            @import 'estilos.css';
        </style>
    </head>
    <body>
        <header>
            <a  href="index.php"><div><p>Trabajo con Servicios</p></div></a> 
        </header>
        <div id="caja">
            <h2 id="title">Introduzca un nombre de autor</h2> 
            <form   name="formulario"  id="formTesteo">
                <input id="texto" type="text"  name='action1&titulo' size="45"/>           
            </form>
            <h2>Sugerencias: <br></h2>
            <div id="salida"></div>
            <br/>
        </div>
    </div>
</body>
<script>
    $(document).ready(function () {
        var input = $("#texto").val();
        var xhr = new XMLHttpRequest();
        var salida = document.getElementById("salida");
        $("#texto").keyup(function () {
            if (input.length !== "") {
                xhr.open("GET", "apis.php?action=getAutorLibros&autor=" + $("#texto").val(), true);
                xhr.send();
                xhr.onreadystatechange = devuelta;
                var aux = [];
                var autor;
                function devuelta() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var respuesta = JSON.parse(xhr.responseText);
                        console.log(respuesta);
                        for (var i = 0; i < respuesta.length; i++) {
                            if (i === 0) {
                                autor = respuesta[i]['nombre'];
                            } else {
                                aux [i] = respuesta[i]['titulo'] + "<br>";
                            }
                        }
                    }
                    if (autor !== "" && aux !== "") {
                        salida.innerHTML = "Autor<hr>" + autor + "<hr>Libros del Autor<br>" + "<hr>" + aux;
                    } else {
                        salida.innerHTML = "";
                    }
                }
            }
        });
    });
</script>

</html>
