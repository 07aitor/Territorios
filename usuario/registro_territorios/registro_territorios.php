<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="otro_territorio.js"></script>
    <title>registro territorios</title>
    <style>
        table {
            font-family:'Gill Sans', 'Gill Sans MT', Calibri, 'Trebuchet MS', sans-serif;
            border-collapse: collapse;
            width: 50%;
        }
        th, td {
            border: 1px solid #dddddd;
            text-align: left;
            padding: 8px;
        }
        th {
            background-color: #f2f2f2;
        }
        #titulo {
            font-weight: bold;
            font-size: 50px;
            text-align: center;
        }
        #apartados {
            font-weight: bold;
        }
    </style>
</head>
<body>
<?php
$conexion = pg_connect("host=localhost port=5432 dbname=postgres user=postgres password=#!bin/bashA1");
$consulta_hermanos = "SELECT * FROM territorios_hermanos p JOIN hermanos u ON p.hermano_id = u.id ORDER BY fecha_entrega ASC";
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
    echo '<td> <div id="apartados">Fecha devolución</div> </td>';
    echo '<td> <div id="apartados">PEDIR</div> </td>';
    echo '<td> <div id="apartados">Meses sin predicar</div> </td>';
    echo '<tr>';
    echo '<td>' . $territorio_id . '</td>';
    echo '<td>' . $hermano_nombre . ' ' . $hermano_apellido . '</td>';
    echo '<td>' . $fecha_entrega . '</td>';
    echo '<td>' . $fecha_fin . '</td>';
     // Muestra "PEDIR" si han pasado más de 4 meses, de lo contrario, muestra nada
     echo '<td>';
    if ($diferencia_meses > 4) {
        echo 'PEDIR';
    }
    echo '<td>' . $meses_sin_predicar . '</td>';
    echo '<tr>';
    echo '</table>';
}

?>
<a href="http://localhost/Territorios/usuario/territorios_usuario.php">volver</a>
</body>
</html>