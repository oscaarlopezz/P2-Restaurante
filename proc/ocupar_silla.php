<?php
session_start();
include_once("./conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ../index.php'); // Redirige a la página de inicio de sesión
    exit();
}

function ocuparSilla($id_silla, $conn) {
    // Consultar el estado actual de la silla
    $sql_select_silla = "SELECT silla_ocupada, fecha_entrada FROM tbl_sillas WHERE id_silla = ?";
    $stmt_select_silla = $conn->prepare($sql_select_silla);
    $stmt_select_silla->bindParam(1, $id_silla, PDO::PARAM_INT);
    $stmt_select_silla->execute();

    $result = $stmt_select_silla->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $silla_ocupada = $result['silla_ocupada'];
        $fecha_entrada = $result['fecha_entrada'];

        // Actualizar la tabla tbl_sillas
        if ($silla_ocupada) {
            // Obtener el ID de usuario actual
            $id_usuario_actual = $_SESSION['id_user'];

            // Obtener la fecha_hora_entrada actual de la silla
            $fecha_entrada_actual = $fecha_entrada;

            // Obtener la fecha y hora actual para fecha_hora_salida
            $fecha_salida_actual = date("Y-m-d H:i:s");

            // Utilizar sentencia preparada para la inserción
            $sql_insert_registro = "INSERT INTO tbl_registros_sillas (id_silla, id_user, fecha_hora_entrada, fecha_hora_salida) VALUES (?, ?, ?, ?)";
            $stmt_insert_registro = $conn->prepare($sql_insert_registro);
            $stmt_insert_registro->bindParam(1, $id_silla, PDO::PARAM_INT);
            $stmt_insert_registro->bindParam(2, $id_usuario_actual, PDO::PARAM_INT);
            $stmt_insert_registro->bindParam(3, $fecha_entrada_actual, PDO::PARAM_STR);
            $stmt_insert_registro->bindParam(4, $fecha_salida_actual, PDO::PARAM_STR);

            if ($stmt_insert_registro->execute()) {
                echo "Registro de salida insertado correctamente.";

                // Actualizar la tabla tbl_sillas
                $sql_update_silla = "UPDATE tbl_sillas SET silla_ocupada = FALSE, fecha_entrada = NULL WHERE id_silla = ?";
                $stmt_update = $conn->prepare($sql_update_silla);
                $stmt_update->bindParam(1, $id_silla, PDO::PARAM_INT);

                if ($stmt_update->execute()) {
                    echo "Silla liberada correctamente.";
                } else {
                    echo "Error al actualizar la silla: " . $stmt_update->errorInfo()[2];
                }
            } else {
                echo "Error al insertar el registro de salida: " . $stmt_insert_registro->errorInfo()[2];
            }
        } else {
            // Si la silla no está ocupada, ocuparla y establecer la fecha de entrada
            $sql_update_silla = "UPDATE tbl_sillas SET silla_ocupada = TRUE, fecha_entrada = CURRENT_TIMESTAMP WHERE id_silla = ?";
            $stmt_update = $conn->prepare($sql_update_silla);
            $stmt_update->bindParam(1, $id_silla, PDO::PARAM_INT);

            if ($stmt_update->execute()) {
                echo "Silla ocupada correctamente.";
            } else {
                echo "Error al ocupar la silla: " . $stmt_update->errorInfo()[2];
            }
        }
    } else {
        echo "Error al obtener el estado de la silla.";
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtener el ID de la silla desde el botón
    $id_silla = substr(key($_POST), 6); // Extraer el número de silla del nombre del botón

    // Llamar a la función ocuparSilla
    ocuparSilla($id_silla, $conn);
}

echo "</br>";
echo '<a href="../home.php">volver</a>';
