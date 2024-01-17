<?php
session_start();

if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php');
    exit();
}

include_once("./conexion.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_mesa = substr(key($_POST), 5);

    if (!empty($id_mesa)) {
        ocuparMesa($id_mesa, $conn);
    } else {
        echo "Error: El ID de la mesa está vacío.";
    }
}

function ocuparMesa($id_mesa, $conn) {
    $sql_select_mesa = "SELECT mesa_ocupada, fecha_entrada FROM tbl_mesas WHERE id_mesa = ?";
    $stmt_select_mesa = $conn->prepare($sql_select_mesa);
    $stmt_select_mesa->bindParam(1, $id_mesa, PDO::PARAM_STR);
    $stmt_select_mesa->execute();

    $result = $stmt_select_mesa->fetch(PDO::FETCH_ASSOC);

    if ($result) {
        $mesa_ocupada = $result["mesa_ocupada"];

        if ($mesa_ocupada) {
            $id_usuario_actual = $_SESSION['id_user'];
            $fecha_entrada_actual = $result["fecha_entrada"];
            $fecha_salida_actual = date("Y-m-d H:i:s");

            $sql_desocupar_sillas = "UPDATE tbl_sillas SET silla_ocupada = FALSE WHERE id_mesa = ?";
            $stmt_desocupar_sillas = $conn->prepare($sql_desocupar_sillas);
            $stmt_desocupar_sillas->bindParam(1, $id_mesa, PDO::PARAM_STR);

            if ($stmt_desocupar_sillas->execute()) {
                echo "Sillas desocupadas correctamente.";
            } else {
                echo "Error al desocupar las sillas: " . $stmt_desocupar_sillas->errorInfo()[2];
            }

            $sql_insert_registro = "INSERT INTO tbl_registros_mesas (id_mesa, id_user, fecha_hora_entrada, fecha_hora_salida) VALUES (?, ?, ?, ?)";
            $stmt_insert_registro = $conn->prepare($sql_insert_registro);
            $stmt_insert_registro->bindParam(1, $id_mesa, PDO::PARAM_STR);
            $stmt_insert_registro->bindParam(2, $id_usuario_actual, PDO::PARAM_INT);
            $stmt_insert_registro->bindParam(3, $fecha_entrada_actual, PDO::PARAM_STR);
            $stmt_insert_registro->bindParam(4, $fecha_salida_actual, PDO::PARAM_STR);

            if ($stmt_insert_registro->execute()) {
                echo "Registro de salida mesa insertado correctamente.";

                $sql_update_mesa = "UPDATE tbl_mesas SET mesa_ocupada = FALSE, fecha_entrada = NULL WHERE id_mesa = ?";
                $stmt_update_mesa = $conn->prepare($sql_update_mesa);
                $stmt_update_mesa->bindParam(1, $id_mesa, PDO::PARAM_STR);

                if ($stmt_update_mesa->execute()) {
                    echo "Mesa liberada correctamente.";
                    header('Location: ../home.php');
                    exit();
                } else {
                    echo "Error al actualizar la mesa: " . $stmt_update_mesa->errorInfo()[2];
                }
            } else {
                echo "Error al insertar el registro de salida: " . $stmt_insert_registro->errorInfo()[2];
            }
        } else {
            $sql_update_mesa = "UPDATE tbl_mesas SET mesa_ocupada = TRUE, fecha_entrada = CURRENT_TIMESTAMP WHERE id_mesa = ?";
            $stmt_update_mesa = $conn->prepare($sql_update_mesa);
            $stmt_update_mesa->bindParam(1, $id_mesa, PDO::PARAM_STR);

            if ($stmt_update_mesa->execute()) {
                $sql_ocupar_sillas = "UPDATE tbl_sillas SET silla_ocupada = TRUE WHERE id_mesa = ?";
                $stmt_ocupar_sillas = $conn->prepare($sql_ocupar_sillas);
                $stmt_ocupar_sillas->bindParam(1, $id_mesa, PDO::PARAM_STR);

                if ($stmt_ocupar_sillas->execute()) {
                    echo "Mesa ocupada y sillas ocupadas correctamente.";
                    header('Location: ../home.php');
                    exit();
                } else {
                    echo "Error al ocupar las sillas: " . $stmt_ocupar_sillas->errorInfo()[2];
                }
            } else {
                echo "Error al ocupar la mesa: " . $stmt_update_mesa->errorInfo()[2];
            }
        }
    } else {
        echo "Error al obtener el estado de la mesa: " . $stmt_select_mesa->errorInfo()[2];
    }
}
