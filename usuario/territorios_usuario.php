<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="territorios_usuario.css">
    <script src="territorios_usuario.js" type="text/javascript"></script>
    <title>mis_territorios</title>
</head>
<body>

<!-- CSS -->
<style>
    * {
        box-sizing: border-box;
    }
    body {
        font-family:Arial, Helvetica, sans-serif; 
        text-align: center;}
    h2 {
        background-color: chartreuse;
    }
    a {
        color: black;
        text-decoration: none;
    }
    #boton_volver_oculto {
        display: none;
    }
    #principal > div {
        display: block;
    }
    #volver {
        display: block;
        text-align: left;
    }
    #volver_oculto {
        display: none;
    }
    #mostrar_territorios {
        display: none;
    }
    .territorios {
        float: left;
        width: 50%;
        padding: 15px;
        background-color: greenyellow;
    }
    .apartados::after {
        content: "";
        display: table;
        clear: both; 
    }
    #apartados {
        display: block;
    }
    #boton{
        border: none;
        text-decoration: none;
        background-color: greenyellow;
        font-size: 34px;
        font-weight: bold;
    }
    @media screen and (max-width:600px) {
        .territorios {
            width: 100%;
        }
    }
    #mis_territorios {
        display: none;
    }
</style>

<!-- Apartado para responsable -->
<div id="mostrar_ocultar_id">
    <div id="apartado_responsables">
        <h1 id="responsable">
            
            <?php

            // Probamos conexion con postgres

            $conexion = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=#!bin/bashA1");
            $nombre = $_POST['nombre_usuario'];
            $consulta = "SELECT * FROM hermanos WHERE nombre_hermano = '$nombre'";
            $query = pg_query($conexion,$consulta);

            while ($data = pg_fetch_object($query)) {
                $responsable = $data->responsable; 
                echo $responsable;
            }
            ?>

        </h1>
        <h2><a href="registro_territorios/registro_territorios.php">Tabla territorios</a></h2>
    </div>

    <script>
        function mostrar_apartado() {
        // Reemplaza con la lógica real para determinar si el usuario es responsable
        if (document.getElementById('responsable').innerText == "si") {
            document.getElementById('apartado_responsables').style.display = 'block';
            document.getElementById('responsable').style.display = 'none';
        }
        else {
            document.getElementById('apartado_responsables').style.display = 'none';
        }

    }

    // Llama a la función al cargar la página (puedes ajustar según tu necesidad)
    window.onload = function() {
        mostrar_apartado();
    };
    </script>

    <!-- botones para volver atras -->
    
</div>

<!-- Botón cerrar sesión -->
<div id="volver">
    <button type="button"><a href="http://localhost/Territorios/territorios_principal.html">Cerrar sesión</a></button>
</div>

<!-- Otro territorio (Mostrar) -->
<div id="mostrar_territorios">
    <button type="button"><a href="http://localhost/Territorios/usuario/territorios_usuario.php">volver</a></button>
    <form action="" method="post">
        <input type="hidden" name="fecha" id="fecha">
        <p id="fecha"></p>
        <p id="territorio"></p>
        <input type="hidden" name="contenido" id="contenido_oculto">
        <img id="imagen_mostrada" style="width:300px"> 
        <br>
        <label for="nombre_hermano">Introduzca nombre:</label>
        <input type="text" id="nombre_hermano" name="nombre_hermano">
        <br>
        <button type="submit">Me lo quedo!</button>
    </form>
</div>

<!-- Apartados (Mis territorios / Otro territorio) -->
<div id="apartados" class="apartados">
    <div class="territorios">
        <h1><button id="boton" onclick="mis_territorios()">Mis territorios</button></h1>
    </div>
    <div class="territorios">
        <h1><button id="boton" onclick="mostrar_territorio()">Otro territorio</button></h1>
    </div>
</div>

<div id="mis_territorios">
    <?php
    $conexion = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=#!bin/bashA1");
    $nombre = $_POST['nombre_usuario'];
    $consulta_hermanos = "SELECT * FROM territorios_hermanos p JOIN hermanos u ON p.hermano_id = u.id WHERE nombre_hermano = '$nombre' AND fecha_fin IS NULL ORDER BY fecha_entrega ASC";
    $query = pg_query($conexion,$consulta_hermanos);

    while ($data = pg_fetch_object($query)) {
        $territorio_id = $data->territorio_id; 
        $hermano_nombre = $data->nombre_hermano; 
        $hermano_apellido = $data->apellido_hermano;
        $fecha_entrega = $data->fecha_entrega; 
        $fecha_fin = $data->fecha_fin;

        // Obtiene la fecha de entrega de la fila actual
        $fechaEntrega = new DateTime($data->fecha_entrega);
        
        // Calcula la diferencia en meses
        $hoy = new DateTime();
        $diferencia = $hoy->diff($fechaEntrega);
        $diferencia_meses = $diferencia->y * 12 + $diferencia->m;

        // Obtiene la fecha de devolución de la fila actual
        $fechaFin = new DateTime($data->fecha_fin);

        // Calcula meses sin predicar
        $diferencia_meses_sin_predicar = $hoy->diff($fechaFin);
        $meses_sin_predicar = $diferencia->y * 12 + $diferencia->m;

        echo '<table>';    
        echo '<tr>';
        echo '<td> <div id="apartados">Nº territorio</div> </td>';
        echo '<td> <div id="apartados">Nombre hermano</div> </td>';
        echo '<td> <div id="apartados">Fecha entrega</div> </td>';
        echo '<tr>';
        echo '<td>' . $territorio_id . '</td>';
        echo '<td>' . $hermano_nombre . ' ' . $hermano_apellido . '</td>';
        echo '<td>' . $fecha_entrega . '</td>';
        echo '<td>';
        echo '</table>';
    }

    ?>
</div>

<!-- JS mis territorios -->
<script>
    function mis_territorios() {
        const mis_territorios = document.getElementById("mis_territorios");
        if (mis_territorios.style.display === "none") {
            mis_territorios.style.display = "block";
        }
        else {
            mis_territorios.style.display = "none";
        }
    }
</script>

<!-- JS mostrar territorio-->
<script>
    // Obtener la fecha actual
    var fechaActual = new Date();

    // Formatear la fecha 
    var fechaFormateada = fechaActual.getFullYear() + '/' + (fechaActual.getMonth() + 1).toString().padStart(2, '0') + '/' + fechaActual.getDate().toString().padStart(2, '0');
    // Mostrar la fecha 
    document.getElementById('fecha').innerText = fechaFormateada;

    function mostrar_territorio() {
        const element = document.getElementById("mostrar_territorios");
        if (element.style.display === "none") {
            element.style.display = "block"; 
        } else {
            element.style.display = "none";
        }
        const apartados = document.getElementById("apartados");
        if (apartados.style.display === "block") {
            apartados.style.display = "none";
        } else {
            apartados.style.display = "block";
        }
    // Array de nombres de archivos de imágenes 
    var imagenes = ["1"];

    // Obtiene una imagen al azar del array
    var territorio = imagenes[Math.floor(Math.random() * imagenes.length)];

    // Construye la ruta completa de la imagen
    var ruta_completa = "http://localhost/Territorios/usuario/" + imagenes + ".jpg";

    // Actualiza la fuente de la imagen en la página
    document.getElementById("imagen_mostrada").src = ruta_completa;
    document.getElementById('territorio').innerText = territorio;

    document.getElementById('contenido_oculto').value = document.getElementById('territorio').innerText;
    }
</script>

<!-- PHP -->
<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Verifica si la clave 'territorio' está presente en el array $_POST
        if (isset($_POST['contenido'])) {
            // Conecta a la base de datos
            $conexion = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=#!bin/bashA1");

            // Obtiene el territorio del formulario
            $territorio = $_POST['contenido'];
            $hermano = $_POST['nombre_hermano'];
            // $fecha = $_POST['fecha'];
            $fecha_actual = date('Y-m-d');
            // Consulta para obtener información sobre el territorio, hermano y fecha
            $consulta_territorio = "SELECT * FROM territorios WHERE n_territorio = '$territorio'";
            $consulta_hermano = "SELECT * FROM hermanos WHERE nombre_hermano = '$hermano'";
            
            $query_territorio = pg_query($conexion, $consulta_territorio);
            $query_hermano = pg_query($conexion, $consulta_hermano);

            while ($data = pg_fetch_object($query_territorio)) {
                $n_territorio = $data->n_territorio; 
            }
            while ($data = pg_fetch_object($query_hermano)) {
                $nombre_hermano = $data->id;
                $enviar_datos = "INSERT INTO territorios_hermanos (territorio_id, hermano_id, fecha_entrega) VALUES ('$n_territorio', '$nombre_hermano', '$fecha_actual')";
                pg_query($conexion, $enviar_datos);  
            }

            
        }
    }
?>  

</body>
</html>