<?php
// procesar_reserva.php
session_start();
include_once("conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ../index.php?sesion=nosesion');
    exit();
} else {
    $id = $_SESSION['id_user'];
    // $mesa2 = $_GET['mesa'];
    // $mesa = intval($mesa2);
    $sqlMesa = "SELECT nombre FROM tbl_camareros WHERE id_user = :id";
    $stmt1 = $conn->prepare($sqlMesa);
    $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt1->execute();
    $nom = $stmt1->fetchColumn();

    // Verifica si se ha recibido la información esperada
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        // Obtiene la entrada JSON y la decodifica
        $data = json_decode(file_get_contents("php://input"), true);

        // Obtiene la fecha directamente del array sin intentar convertirla
        $fecha = $data['fecha'];
        $mesa = $data['mesa'];

        // Puedes hacer otras validaciones o manipulaciones con $fecha si es necesario

        // Muestra los datos recibidos
        echo "Fecha recibida: " . $fecha . " en la mesa: " . $mesa;
        $sql = "INSERT INTO tbl_registros_mesas (id_mesa, fecha_hora_entrada) VALUES (:id_mesa, :fecha_entrada)";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        // Asociar parámetros
        $stmt->bindParam(':id_mesa', $mesa, PDO::PARAM_INT);
        $stmt->bindParam(':fecha_entrada', $fecha, PDO::PARAM_STR);

        // Ejecutar la consulta
        try {
            $stmt->execute();
            echo "Nuevo registro de mesa insertado con éxito.";
        } catch (PDOException $e) {
            die("Error al insertar el registro de mesa: " . $e->getMessage());
        }
    } else {
        // Si no es una solicitud POST, muestra un mensaje de error
        echo "Error: Esta página solo acepta solicitudes POST.";
    }
}

