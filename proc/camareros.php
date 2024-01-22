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
        $sql = "SELECT * FROM tbl_camareros";

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