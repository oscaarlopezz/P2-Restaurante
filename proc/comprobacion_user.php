<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="style.css">
</head>

<body>
    <?php
    session_start(); // Inicia la sesión

    if (!filter_has_var(INPUT_POST, 'enviar')) {
        header('Location: ./index.php');
        exit();
    }
    
    // Conexión a la base de datos (asegúrate de tener una conexión configurada en conexion.php)
    include_once("./conexion.php");

    $correo = isset($_POST['correo']) ? $_POST['correo'] : "";
    $correo = trim(htmlspecialchars($correo, ENT_QUOTES, 'UTF-8'));
    $contrasena = isset($_POST['contrasena']) ? $_POST['contrasena'] : "";
    $contrasena = trim(htmlspecialchars($contrasena, ENT_QUOTES, 'UTF-8'));

    // Validación de campos
    if (empty($correo)) {
        header("Location: ../index.php?correoVacio=true");
        exit();
    } else {
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            header("Location: ../index.php?mailMal=true");
            exit();
        }
    }

    if (empty($contrasena)) {
        header("Location: ../index.php?contrasenaVacio=true");
        exit();
    }

    try {
        // Consulta SQL para verificar el correo
        $sql = "SELECT correo, contrasena, id_user FROM tbl_camareros WHERE correo = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(1, $correo, PDO::PARAM_STR);
        $stmt->execute();
        
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($result && password_verify($contrasena, $result['contrasena'])) {
            $_SESSION['correo'] = $result['correo'];
            $_SESSION['id_user'] = $result['id_user'];
            header("Location: ../home.php");
            exit();
        } else {
            // Las credenciales no son válidas
            header("Location: ../index.php?loginError=true");
            exit();
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
    ?>

</body>

</html>
