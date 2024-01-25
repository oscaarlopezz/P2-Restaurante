<?php 
session_start();
include_once("conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ../index.php?sesion=nosesion');
    exit();
}else {
    try {
        $mesa2 = $_GET['mesa'];
        $entrada3 = $_GET['entrada'];
        $entrada2 = DateTime::createFromFormat('d/m/Y H:i:s', $entrada3)->format('Y-m-d H:i:s');
        $entrada = strtotime($entrada2);
        echo $entrada;

        $mesa = intval($mesa2);
        $sql = "UPDATE tbl_registros_mesas SET fecha_hora_salida = CURRENT_TIMESTAMP WHERE id_mesa = :id_mesa AND fecha_hora_entrada = FROM_UNIXTIME(:entrada)";

        
        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Vincular el parámetro
        $stmt->bindParam(':id_mesa', $mesa, PDO::PARAM_INT);
        $stmt->bindParam(':entrada', $entrada, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Obtener el número de filas afectadas
        $rowsAffected = $stmt->rowCount();

        // Verificar si se actualizó al menos una fila
        if ($rowsAffected > 0) {
            echo "Actualización exitosa. Se actualizaron $rowsAffected fila(s).";
            header('Location: ../home.php');
        } else {
            echo "No se realizaron actualizaciones. Puede que no haya coincidencias con los criterios de la consulta.";
        }
    }catch(PDOException $e) {
        echo $e->getMessage();
    }

}