<?php
session_start();
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php'); // Redirige a la página de inicio de sesión
    exit();
}
include 'conexion.php';
// Realizar la consulta SQL
$sala = intval($_GET['sala']);
if (isset($sala)){
    if ($sala === 0){
        $sql = "SELECT tbl_registros_sillas.id_registro_silla as id, tbl_sillas.id_silla as silla, tbl_camareros.nombre as camarero, tbl_registros_sillas.fecha_hora_entrada as entrada, tbl_registros_sillas.fecha_hora_salida as salida, TIMEDIFF(fecha_hora_salida, fecha_hora_entrada) AS diferencia, tbl_salas.id_sala as id_sala, tbl_salas.ubicacion_sala as sala FROM `tbl_registros_sillas` INNER JOIN tbl_sillas INNER JOIN tbl_camareros INNER JOIN tbl_salas INNER JOIN tbl_mesas ON tbl_sillas.id_silla = tbl_registros_sillas.id_silla and tbl_registros_sillas.id_user = tbl_camareros.id_user and tbl_salas.id_sala = tbl_mesas.id_sala and tbl_sillas.id_mesa = tbl_mesas.id_mesa;";
        $stmt = mysqli_prepare($conn, $sql);
    }else {
        $sql = "SELECT tbl_registros_sillas.id_registro_silla as id, tbl_sillas.id_silla as silla, tbl_camareros.nombre as camarero, tbl_registros_sillas.fecha_hora_entrada as entrada, tbl_registros_sillas.fecha_hora_salida as salida, TIMEDIFF(fecha_hora_salida, fecha_hora_entrada) AS diferencia, tbl_salas.id_sala as id_sala, tbl_salas.ubicacion_sala as sala FROM `tbl_registros_sillas` INNER JOIN tbl_sillas INNER JOIN tbl_camareros INNER JOIN tbl_salas INNER JOIN tbl_mesas ON tbl_sillas.id_silla = tbl_registros_sillas.id_silla and tbl_registros_sillas.id_user = tbl_camareros.id_user and tbl_salas.id_sala = tbl_mesas.id_sala and tbl_sillas.id_mesa = tbl_mesas.id_mesa WHERE tbl_salas.id_sala = ?;";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $sala);
    }
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);
// Verificar si hay resultados
if (mysqli_num_rows($resultado) > 0) {
    // Definir el nombre del archivo CSV
    $nombreArchivo = 'export_registros_sillas.csv';

    // Crear un puntero al archivo temporal
    $archivo = fopen($nombreArchivo, 'w');

    // Escribir la fila de encabezado en el archivo CSV
    $encabezados = array('id', 'silla', 'camarero', 'entrada', 'salida', 'diferencia', 'ubicacion');
    fputcsv($archivo, $encabezados);

    // Recorrer los resultados y escribir cada fila en el archivo CSV
    while ($fila = mysqli_fetch_assoc($resultado)) {
        fputcsv($archivo, $fila);
    }

    // Cerrar el puntero al archivo
    fclose($archivo);

    // Configurar las cabeceras para descargar el archivo
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $nombreArchivo . '"');
    header('Pragma: no-cache');
    readfile($nombreArchivo);

    // Eliminar el archivo temporal
    unlink($nombreArchivo);

} else {
    echo 'No hay datos para exportar.';
}

// Cerrar la conexión a la base de datos
mysqli_close($conn);
}
?>