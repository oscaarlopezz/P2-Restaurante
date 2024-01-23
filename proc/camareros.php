<?php
session_start();
include_once("conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ../index.php?sesion=nosesion');
    exit();
}else {
    try{
        // Sentencia SQL
        $sql = "SELECT c.id_user, c.nombre, c.apellido, c.correo, c.contrasena, t.tipo FROM tbl_camareros c JOIN tbl_tipo t ON c.tipo_id = t.id ORDER BY id_user ASC;";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener los resultados como un array asociativo
        $resultados = $stmt->fetchAll(PDO::FETCH_ASSOC);

        // Devolver los resultados como JSON
        header('Content-Type: application/json');
        echo json_encode($resultados);

    } catch (PDOException $e) {
        echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
    }
}