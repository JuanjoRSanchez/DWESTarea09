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
            <h2 id="title">Introduzca un título de libro</h2> 
            <form   name="formulario"  id="formTesteo">
                <input id="texto" type="text"  name='action1&titulo' size="45"/>
                <h5>Sugerencias: <br></h5>
                <div id="salida"></div>
            </form>
            <br/>
            <!--<input id="btnSubmit" type="submit" value="Buscar">-->     
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
                xhr.open("GET", "apis.php?action=getTitulo&titulo=" + $("#texto").val(), true);
                xhr.send();
                xhr.onreadystatechange = devuelta;
                var aux = "";
                function devuelta() {
                    if (xhr.readyState === 4 && xhr.status === 200) {
                        var respuesta = JSON.parse(xhr.responseText);
                        var tit;
                        for (var i = 0; i < respuesta.length; i++) {
                            tit = respuesta[i]['titulo'];
                            aux += tit + "<br>";
                        }
                    }
                    salida.innerHTML = aux;
                }
            }
        });
    });
</script>

</html>
