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
        $sala = intval($_POST['sala']);
        $sqlSala = "SELECT * FROM `tbl_salas` WHERE id_sala = :ubicacion";
        $stmt2 = $conn->prepare($sqlSala);
        $stmt2->bindParam(':ubicacion', $sala, PDO::PARAM_INT);
        $stmt2->execute();
        $sql2 = $stmt2->fetchColumn();
        if (!empty($sql2)) {
            try {
                $sqlSala2 = "UPDATE `tbl_mesas` SET `id_sala` = :ubicacion WHERE `tbl_mesas`.`id_mesa` = :id";
                $stmt3 = $conn->prepare($sqlSala2);
                $stmt3->bindParam(':ubicacion', $sala, PDO::PARAM_INT);
                $stmt3->bindParam(':id', $mesa, PDO::PARAM_INT);
                $stmt3->execute();
                $sql3 = $stmt3->fetchColumn();
            }catch(PDOException $e) {
                echo $e->getMessage();
                echo "Fallo al cambiar la ubicacion";
            }
            // FECHAS
            // $entrada = strtotime($_POST['entrada']);
            // $salida = strtotime($_POST['salida']);
            // $sqlFecha = "SELECT tbl_mesas.id_mesa AS mesa, tbl_salas.ubicacion_sala AS sala, DATE_FORMAT(MAX(tbl_registros_mesas.fecha_hora_entrada), '%d/%m/%Y %H:%i:%s') AS entrada, CASE WHEN SUM(tbl_registros_mesas.fecha_hora_salida IS NULL) > 0 THEN NULL ELSE DATE_FORMAT(MAX(tbl_registros_mesas.fecha_hora_salida), '%d/%m/%Y %H:%i:%s') END AS salida FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa LEFT JOIN tbl_registros_mesas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa WHERE tbl_mesas.id_mesa = :id GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala;";
            // $stmt4 = $conn->prepare($sqlFecha);
            // $stmt4->bindParam(':id', $mesa, PDO::PARAM_INT);
            // $stmt4->execute();
            // $sql4 = $stmt4->fetchAll(PDO::FETCH_ASSOC);
            // $FechaE1 = "";
            // $FechaS1 = "";

            // foreach ($sql4 as $row) {
            //     $FechaE1 = $row['entrada'];
            //     $FechaS1 = $row['salida'];
            // }
            // $FechaE = strtotime($FechaE1);
            // $FechaS = strtotime($FechaS1);
            // echo "hola " . $FechaE;
            // echo "hola2 " . $FechaS;

            // $sqlFecha2 = "UPDATE `tbl_registros_mesas` SET `fecha_hora_entrada` = :entrada, `fecha_hora_salida` = :salida WHERE `tbl_registros_mesas`.`id_mesa` = :id and fecha_hora_entrada = :fechae and fecha_hora_salida = :fechas;";
            // $stmt6 = $conn->prepare($sqlFecha2);
            // $stmt6->bindParam(':entrada', $entrada, PDO::PARAM_STR);
            // $stmt6->bindParam(':salida', $salida, PDO::PARAM_STR);
            // $stmt6->bindParam(':id', $mesa, PDO::PARAM_STR);
            // $stmt6->bindParam(':fechae', $FechaE, PDO::PARAM_STR);
            // $stmt6->bindParam(':fechas', $FechaS, PDO::PARAM_STR);
            // $stmt6->execute();
            // $sql6 = $stmt6->fetchColumn();
            // SELECT tbl_mesas.id_mesa AS mesa, tbl_salas.ubicacion_sala AS sala, DATE_FORMAT(MAX(tbl_registros_mesas.fecha_hora_entrada), '%d/%m/%Y %H:%i:%s') AS entrada, CASE WHEN SUM(tbl_registros_mesas.fecha_hora_salida IS NULL) > 0 THEN NULL ELSE DATE_FORMAT(MAX(tbl_registros_mesas.fecha_hora_salida), '%d/%m/%Y %H:%i:%s') END AS salida FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa LEFT JOIN tbl_registros_mesas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala;
            $sillas = intval($_POST['sillas']);
            echo $sillas;

            // Obtener el número actual de sillas en la mesa
            $sqlSillas = "SELECT tbl_mesas.id_mesa AS mesa, tbl_salas.ubicacion_sala AS sala, COUNT(DISTINCT tbl_sillas.id_silla) AS numero_sillas FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa LEFT JOIN tbl_registros_mesas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa WHERE tbl_mesas.id_mesa = :id GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala;";
            $stmt5 = $conn->prepare($sqlSillas);
            $stmt5->bindParam(':id', $mesa, PDO::PARAM_INT);
            $stmt5->execute();
            $sql5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);

            $numeroSillas2 = "";
            foreach ($sql5 as $row) {
                $numeroSillas2 = $row['numero_sillas'];
            }

            $numeroSillas = intval($numeroSillas2);
            echo $numeroSillas;

            // Comparar y ajustar el número de sillas
            if ($numeroSillas === $sillas) {
                // El número de sillas es el mismo, no es necesario hacer nada
                exit("El número de sillas es el mismo: $numeroSillas");
            } elseif ($numeroSillas < $sillas) {
                // El usuario quiere agregar más sillas, ejecutar la lógica correspondiente aquí
                $sillasPorAgregar = $sillas - $numeroSillas;

                // Puedes ejecutar aquí la lógica para agregar las sillas necesarias a la mesa
                // Por ejemplo, podrías insertar nuevas filas en la tabla de sillas
                for ($i = 0; $i < $sillasPorAgregar; $i++) {
                    // Insertar una nueva silla en la base de datos asociada a la mesa
                    $sqlInsertSilla = "INSERT INTO `tbl_sillas` (`id_silla`, `silla_ocupada`, `id_mesa`, `fecha_entrada`) VALUES (NULL, '0', :id_mesa, NULL);";
                    $stmtInsertSilla = $conn->prepare($sqlInsertSilla);
                    $stmtInsertSilla->bindParam(':id_mesa', $mesa, PDO::PARAM_INT);
                    $stmtInsertSilla->execute();
                }

                exit("Agregando $sillasPorAgregar sillas a la mesa");
            } else {
                // El usuario quiere reducir el número de sillas, ejecutar la lógica correspondiente aquí
                $sillasPorQuitar = $numeroSillas - $sillas;

                // Puedes ejecutar aquí la lógica para quitar las sillas necesarias de la mesa
                // Por ejemplo, podrías eliminar filas de la tabla de sillas
                for ($i = 0; $i < $sillasPorQuitar; $i++) {
                    // Obtener la ID de una silla asociada a la mesa
                    $sqlSillaParaEliminar = "SELECT id_silla FROM tbl_sillas WHERE id_mesa = :id_mesa LIMIT 1";
                    $stmtSillaParaEliminar = $conn->prepare($sqlSillaParaEliminar);
                    $stmtSillaParaEliminar->bindParam(':id_mesa', $mesa, PDO::PARAM_INT);
                    $stmtSillaParaEliminar->execute();
                    $sillaParaEliminar = $stmtSillaParaEliminar->fetch(PDO::FETCH_ASSOC);

                    // Eliminar la silla de la base de datos
                    $sqlEliminarSilla = "DELETE FROM tbl_sillas WHERE id_silla = :id_silla";
                    $stmtEliminarSilla = $conn->prepare($sqlEliminarSilla);
                    $stmtEliminarSilla->bindParam(':id_silla', $sillaParaEliminar['id_silla'], PDO::PARAM_INT);
                    $stmtEliminarSilla->execute();
                }

                exit("Quitando $sillasPorQuitar sillas de la mesa");
            }
        }else{
            echo "selecciona una sala por favor de la lista";
        }
    }else {
        echo "selecciona una mesa por favor de la lista";
    }
}