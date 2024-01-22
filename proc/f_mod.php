<?php
include_once("conexion.php");

try {
    // Asegúrate de que 'id' esté definida y sea un entero
    $id = intval($_POST['id']);

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

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tu Página con Bootstrap</title>

    <!-- Enlaces CDN de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>
        <form>
        <div class="row">
            <div class="col">
            <label for="Nombre">Nombre</label>
            <input type="text" class="form-control" placeholder="Nombre" value="<?php echo $resultados['nombre']; ?>">
            </div>
            <div class="col">
            <label for="Apellido">Apellido</label>
            <input type="text" class="form-control" placeholder="Apellidos" value="<?php echo $resultados['apellido']; ?>">
            </div>
        </div>
        <div class="row">
            <div class="col">
            <label for="Correo">Correo</label>
            <input type="text" class="form-control" placeholder="Email" value="<?php echo $resultados['correo']; ?>">
            </div>
            <div class="col">
            <label for="Contraseña">Contraseña</label>
            <input type="text" class="form-control" placeholder="Contraseña" value="<?php echo $resultados['contrasena']; ?>">
            </div>
        </div>
        <button type="submit">Modificar</button>
        </form>
    
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
<?php

    ?>