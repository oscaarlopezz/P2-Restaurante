<?php
include_once("conexion.php");

try {
    // Asegúrate de que 'id' esté definida y sea un entero
    if ($_POST['id'] == "close") {
        exit();
    }else {
        $id = intval($_POST['id']);
    }
    if ($id > 0) {
        // Sentencia SQL
        $sql = "SELECT tbl_mesas.id_mesa AS mesa, tbl_salas.ubicacion_sala AS sala, CASE WHEN CURRENT_TIMESTAMP BETWEEN MAX(tbl_registros_mesas.fecha_hora_entrada) AND IFNULL(MAX(tbl_registros_mesas.fecha_hora_salida), CURRENT_TIMESTAMP) OR (MAX(tbl_registros_mesas.fecha_hora_entrada) IS NOT NULL AND MAX(tbl_registros_mesas.fecha_hora_salida) IS NULL) THEN 'OCUPADO' ELSE 'DISPONIBLE' END AS disponibilidad, COUNT(DISTINCT tbl_sillas.id_silla) AS numero_sillas, MAX(tbl_registros_mesas.fecha_hora_entrada) AS entrada, CASE WHEN SUM(tbl_registros_mesas.fecha_hora_salida IS NULL) > 0 THEN NULL ELSE MAX(tbl_registros_mesas.fecha_hora_salida) END AS salida FROM tbl_mesas INNER JOIN tbl_salas ON tbl_mesas.id_sala = tbl_salas.id_sala INNER JOIN tbl_sillas ON tbl_mesas.id_mesa = tbl_sillas.id_mesa LEFT JOIN tbl_registros_mesas ON tbl_mesas.id_mesa = tbl_registros_mesas.id_mesa  WHERE tbl_mesas.id_mesa = :id GROUP BY tbl_mesas.id_mesa, tbl_salas.ubicacion_sala;";

        // Preparar la consulta
        $stmt = $conn->prepare($sql);

        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        // Ejecutar la consulta
        $stmt->execute();

        // Obtener el resultado como un array asociativo
        $resultados = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // Mostrar un mensaje de error si 'id' no es válido
        echo "ID no válido" . $id;
        exit();
    }
} catch (PDOException $e) {
    echo json_encode(['error' => 'Error: ' . $e->getMessage()]);
}
?>

<!-- Formulario HTML -->
<input type="text" class="form-control" id="mesa" value="<?php echo $id; ?>" style="width: 0; display: none;">
<div class="row">
    <div class="col">
            <label for="Sala">Sala</label>
            <select class="form-control" id="sala">
                    <?php 
                    // Sentencia SQL
                    $sql2 = "SELECT id_sala as sala, ubicacion_sala as ubicacion FROM `tbl_salas`";

                    // Preparar la consulta
                    $stmt2 = $conn->prepare($sql2);

                    // Ejecutar la consulta
                    $stmt2->execute();

                    // Obtener todos los resultados como un array asociativo
                    $resultados2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

                    // Iterar sobre los resultados e imprimir las opciones
                    foreach ($resultados2 as $tipo) {
                        $tipoSeleccionado = $resultados['sala'];
                        if ($tipo['ubicacion'] == $tipoSeleccionado) {
                            echo "<option value='" . $tipo['sala'] . "' selected>" . $tipo['ubicacion'] . "</option>";
                        }else{
                            echo "<option value='" . $tipo['sala'] . "'>" . $tipo['ubicacion'] . "</option>";
                        }
                    }

                    ?>
                </select>
    </div>
    <div class="col">
        <label for="Sillas">Núm Sillas</label>
        <br>
        <select class="form-control" name="sillas" id="sillas">
            <?php 
            if ($resultados['numero_sillas'] == 2){
                echo "<option value='2' selected>2</option>
                <option value='4'>4</option>
                <option value='6'>6</option>";
            }
            if ($resultados['numero_sillas'] == 4){
                echo "<option value='2'>2</option>
                <option value='4' selected>4</option>
                <option value='6'>6</option>";
            }if ($resultados['numero_sillas'] == 6){
                echo "<option value='2'>2</option>
                <option value='4'>4</option>
                <option value='6' selected>6</option>";
            }?>
        </select>
    </div>
</div>
<!-- <div class="row">
    <div class="col">
        <label for="Entrada">Últ. Entrada</label>
        <input type="datetime-local" class="form-control" id="entrada" value="<?php echo $resultados['entrada']; ?>">
    </div>
    <div class="col">
        <label for="Salida">Últ. Salida <?php $fecha_hoy = date('Y-m-d H:i:s'); echo $fecha_hoy; ?></label>
        <input type="datetime-local" class="form-control" id="salida" value="<?php echo $resultados['salida']; ?>">
    </div>
</div> -->
<button onclick="cerrar()" class="btn btn-danger">Cerrar</button>
<button type="submit" class="btn btn-primary">Modificar</button>