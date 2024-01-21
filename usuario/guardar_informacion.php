<?php
// Obtener valores directamente del array $_POST
$nombreHermano = $_POST['nombreHermano'];
$idTerritorio = $_POST['idTerritorio'];
$fechaEntrega = $_POST['fechaEntrega'];

try {
    // Configura las credenciales de conexión a tu base de datos PostgreSQL
    $conn = new PDO('pgsql:host=localhost port=5432 dbname=postgres user=postgres password=#!bin/bashA1');
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Insertar en la tabla territorios_hermanos
    $stmt = $conn->prepare('INSERT INTO territorios_hermanos (territorio_id, hermano_id, fecha_entrega) VALUES (?, (SELECT id FROM hermanos WHERE n_hermano = ?), ?)');
    $stmt->execute([$idTerritorio, $nombreHermano, $fechaEntrega]);

    $respuesta = ['success' => true, 'message' => 'Información guardada exitosamente.'];
    echo json_encode($respuesta);
} catch (PDOException $e) {
    $respuesta = ['success' => false, 'message' => 'Error al guardar la información: ' . $e->getMessage()];
    echo json_encode($respuesta);
}
?>