<?php
include_once("conexion.php");

$sql = "SELECT
tbl_mesas.id_mesa AS mesa,
tbl_salas.ubicacion_sala AS sala,
CASE
    WHEN CURRENT_TIMESTAMP BETWEEN MAX(tbl_registros_mesas.fecha_hora_entrada) AND IFNULL(MAX(tbl_registros_mesas.fecha_hora_salida), CURRENT_TIMESTAMP)
        OR (MAX(tbl_registros_mesas.fecha_hora_entrada) IS NOT NULL AND MAX(tbl_registros_mesas.fecha_hora_salida) IS NULL)
    THEN 'OCUPADO'
    ELSE 'DISPONIBLE'
END AS disponibilidad,
COUNT(DISTINCT tbl_sillas.id_silla) AS numero_sillas,
DATE_FORMAT(MAX(tbl_registros_mesas.fecha_hora_entrada), '%d/%m/%Y %H:%i:%s') AS entrada,
CASE
    WHEN SUM(tbl_registros_mesas.fecha_hora_salida IS NULL) > 0 THEN NULL
    ELSE DATE_FORMAT(MAX(tbl_registros_mesas.fecha_hora_salida), '%d/%m/%Y %H:%i:%s')
END AS salida
FROM
tbl_mesas
INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala
INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa
LEFT JOIN tbl_registros_mesas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa
GROUP BY
tbl_mesas.id_mesa,
tbl_salas.ubicacion_sala;
";
$stmt = $conn->prepare($sql);
$stmt->execute();
$mesas = $stmt->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($mesas);