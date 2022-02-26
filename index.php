<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Tarea 09 DWES</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
        <link href="https://fonts.googleapis.com/css2?family=Dongle:wght@300&display=swap" rel="stylesheet">
            <style>
                @import 'estilos.css';
            </style>
    </head>
    <body>
        <header>
            <a  href="index.php"><div><p>Trabajo con Servicios</p></div></a> 
        </header>
        <div id="cajaIndex">
            <a class="botonesInicio" href="clienteAutores.php">Gestión de autores</a>
            <a class="botonesInicio" href="clienteLibros.php">Gestión de libros</a>
        </div>
        <br/>
        <div style="text-align: center;">
            <a  class="botonesInicio" onclick="abrirBuscador()" >Ir al buscador de títulos</a>
        </div>
        <br/>
        <br/>
        <br/>
        <br/>
        <div style="text-align: center;">
            <a  class="botonesInicio" onclick="abrirVentana()" >Prueba Script de advertencia</a>
        </div>
        <br/>
        <br/>
        <br/>
        <br/>
        <div style="text-align: center;">
            <a  class="botonesInicio" onclick="abrirBuscadorAutor()" >Ir al buscador de autores</a>
        </div>
        <footer>
            <div>Tarea09 Juanjo Rubio Sánchez</div>
        </footer>
    </body>
    <script>
        var btn = document.getElementById("btnAdver");
        function abrirVentana() {
            window.open("http://localhost/T09/Script002.html", "", "width=600, height=700, scrollbars=yes,status=yes, menubar=yes, toolbar=yes, top=0, left=300");
        }
        function abrirBuscador() {
            window.open("http://localhost/T09/Script001.php", "", "width=600, height=700, scrollbars=yes,status=yes, menubar=yes, toolbar=yes, top=0, left=300");
        }
         function abrirBuscadorAutor() {
            window.open("http://localhost/T09/Script003.php", "", "width=600, height=700, scrollbars=yes,status=yes, menubar=yes, toolbar=yes, top=0, left=300");
        }
    </script>
</html>
