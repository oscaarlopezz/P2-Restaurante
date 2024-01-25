<?php
session_start();
include_once("conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php?sesion=nosesion');
    exit();
}else {
    $id = $_SESSION['id_user'];
    $mesa2 = $_GET['mesa'];
    $entrada = $_GET['entrada'];
    $mesa = intval($mesa2);
    $sqlMesa = "SELECT nombre FROM tbl_camareros WHERE id_user = :id";
    $stmt1 = $conn->prepare($sqlMesa);
    $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt1->execute();
    $nom = $stmt1->fetchColumn();

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Reservar</title>
</head>
<body>
    <h1>Mesa <?php echo $mesa; ?></h1>
    <div>
        <label>
            <input type="radio" name="opcionReserva" value="reservarAhora" onchange="mostrarFormulario()">
            Reservar Ahora
        </label>
</br>
        <label>
            <input type="radio" name="opcionReserva" value="reservarFechaEspecifica" onchange="mostrarFormulario()">
            Reservar en una Fecha Específica
        </label>
    </div>

    <div id="reservaAhoraForm" style="display: none;">
        <button onclick="reservarAhora()">Reservar Ahora</button>
    </div>

    <div id="reservaFechaForm" style="display: none;">
        <label for="fechaReserva">Fecha de Reserva:</label>
        <input type="datetime-local" id="fechaReserva" name="fechaReserva">
        <button onclick="reservarEnFechaEspecifica()">Reservar</button>
    </div>

    <script>
        function alerta()
            {
            var opcion = confirm("Deseas desocupar el recurso número <?php echo $mesa; ?>?");
            if (opcion == true) {
                window.location.href = "./desocupar.php?mesa=<?php echo $mesa; ?>&entrada=<?php echo $entrada; ?>";
            } else {
                window.location.href = "../home.php";
            }
        }
        function reservarAhora() {
            // Obtener la fecha actual
            var fechaActual = new Date();
            console.log("Fecha Actual: " + fechaActual);

            // Aquí puedes enviar la fechaActual por AJAX
            enviarDatosPorAjax({ fecha: fechaActual, mesa: <?php echo $mesa; ?> });
        }

        function reservarEnFechaEspecifica() {
            // Obtener la fecha seleccionada
            var fechaReserva = document.getElementById("fechaReserva").value;

            // Aquí puedes enviar la fechaReserva por AJAX
            enviarDatosPorAjax({ fecha: fechaReserva, mesa: <?php echo $mesa; ?> });
        }

        function enviarDatosPorAjax(data) {
            var xhr = new XMLHttpRequest();

            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                        // Redirigir a otra página
                        window.location.href = "../home.php";

                        // Aquí puedes manejar la respuesta del servidor
                    } else {
                        console.error("Error en la solicitud AJAX");
                    }
                }
            };

            xhr.open("POST", "procesar_reserva.php", true);
            xhr.setRequestHeader("Content-Type", "application/json");
            xhr.send(JSON.stringify(data));
        }

        // Mostrar el formulario correspondiente según la opción seleccionada
        function mostrarFormulario() {
            var opcionReserva = document.querySelector('input[name="opcionReserva"]:checked').value;

            if (opcionReserva === "reservarAhora") {
                document.getElementById("reservaAhoraForm").style.display = "block";
                document.getElementById("reservaFechaForm").style.display = "none";
            } else if (opcionReserva === "reservarFechaEspecifica") {
                document.getElementById("reservaFechaForm").style.display = "block";
                document.getElementById("reservaAhoraForm").style.display = "none";
            }
        }
    </script>
    <?php 
    if ($_GET['disp'] == 'OCUPADO') {
            echo "<script>alerta();</script>";
        }
    }
?>
</body>
</html>