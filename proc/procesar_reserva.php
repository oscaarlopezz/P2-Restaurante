<?php
// procesar_reserva.php
session_start();
include_once("conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php?sesion=nosesion');
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

        // Puedes hacer otras validaciones o manipulaciones con $fecha si es necesario

        // Muestra los datos recibidos
        echo "Fecha recibida: " . $fecha;
    } else {
        // Si no es una solicitud POST, muestra un mensaje de error
        echo "Error: Esta página solo acepta solicitudes POST.";
    }
}

