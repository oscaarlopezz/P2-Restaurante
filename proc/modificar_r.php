<?php
session_start();
include_once("./conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php?sesion=nosesion');
    exit();
} else {
    $mesa = intval($_POST['mesa']);
    $sqlMesa = "SELECT id_mesa FROM tbl_mesas WHERE id_mesa = :id";
    $stmt1 = $conn->prepare($sqlMesa);
    $stmt1->bindParam(':id', $mesa, PDO::PARAM_INT);
    $stmt1->execute();
    $sql = $stmt1->fetchColumn();
    if (!empty($sql)) {
        $sala = $_POST['sala'];
        $sqlSala = "SELECT * FROM `tbl_salas` WHERE id_sala = :ubicacion";
        $stmt2 = $conn->prepare($sqlSala);
        $stmt2->bindParam(':ubicacion', $sala, PDO::PARAM_INT);
        $stmt2->execute();
        $sql2 = $stmt2->fetchColumn();
        if (!empty($sql2)) {
            $sqlSala2 = "UPDATE `tbl_mesas` SET `id_sala` = :ubicacion WHERE `tbl_mesas`.`id_mesa` = :id";
            $stmt3 = $conn->prepare($sqlSala2);
            $stmt3->bindParam(':ubicacion', $sala, PDO::PARAM_INT);
            $stmt3->bindParam(':id', $mesa, PDO::PARAM_INT);
            $stmt3->execute();
            $sql3 = $stmt3->fetchColumn();
            $entrada = $_POST['entrada'];
            // SELECT tbl_mesas.id_mesa AS mesa, tbl_salas.ubicacion_sala AS sala, DATE_FORMAT(MAX(tbl_registros_mesas.fecha_hora_entrada), '%d/%m/%Y %H:%i:%s') AS entrada, CASE WHEN SUM(tbl_registros_mesas.fecha_hora_salida IS NULL) > 0 THEN NULL ELSE DATE_FORMAT(MAX(tbl_registros_mesas.fecha_hora_salida), '%d/%m/%Y %H:%i:%s') END AS salida FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa LEFT JOIN tbl_registros_mesas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala;
            $sillas = intval($_POST['sillas']);
            echo $sillas;
            // SILLAS
            $sqlSillas = "SELECT tbl_mesas.id_mesa AS mesa, tbl_salas.ubicacion_sala AS sala, COUNT(DISTINCT tbl_sillas.id_silla) AS numero_sillas FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa LEFT JOIN tbl_registros_mesas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa WHERE tbl_mesas.id_mesa = :id GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala;";
            $stmt4 = $conn->prepare($sqlSillas);
            $stmt4->bindParam(':id', $mesa, PDO::PARAM_INT);
            $stmt4->execute();
            $sql4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);

            $numeroSillas2 = "";

            foreach ($sql4 as $row) {
                $numeroSillas2 = $row['numero_sillas'];
            }
            $numeroSillas = intval($numeroSillas2);
            echo $numeroSillas;
            if ($numeroSillas = $sillas){

            }

        }else{
            echo "selecciona una sala por favor de la lista";
        }
    }else {
        echo "selecciona una mesa por favor de la lista";
    }
}