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
        $sql = "SELECT * FROM tbl_camareros WHERE id_user = :id";

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
<input type="text" class="form-control" id="id_camarero" value="<?php echo $id; ?>" style="width: 0; display: none;">
<div class="row">
    <div class="col">
            <label for="Nombre">Nombre</label>
            <input type="text" class="form-control" id="nombre" placeholder="Nombre" value="<?php echo $resultados['nombre']; ?>">
        </div>
        <div class="col">
            <label for="Apellido">Apellido</label>
            <input type="text" class="form-control" id="apellido" placeholder="Apellidos" value="<?php echo $resultados['apellido']; ?>">
        </div>
        </div>
        <div class="row">
            <div class="col">
                <label for="Correo">Correo</label>
                <input type="text" class="form-control" id="correo" placeholder="Email" value="<?php echo $resultados['correo']; ?>">
            </div>
            <div class="col">
                <label for="Contraseña">Contraseña</label>
                <input type="text" class="form-control" id="contrasena" placeholder="Contraseña" value="<?php echo $resultados['contrasena']; ?>">
            </div>
        </div>
        <button onclick="cerrar()" class="btn btn-danger">Cerrar Formulario</button>
        <button type="submit" class="btn btn-primary">Modificar</button>