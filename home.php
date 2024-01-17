<?php
session_start();
include_once("./proc/conexion.php");

// Comprobar si el usuario ha iniciado sesión
if (!isset($_SESSION['id_user'])) {
    header('Location: ./index.php?sesion=nosesion');
    exit();
} else {
    $id = $_SESSION['id_user'];
    $sqlMesa = "SELECT nombre FROM tbl_camareros WHERE id_user = :id";
    $stmt1 = $conn->prepare($sqlMesa);
    $stmt1->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt1->execute();
    $nom = $stmt1->fetchColumn();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./css/style.css">
    <title>Home</title>
</head>

<body id="login">
    <h2 id="userTitulo">Hola <?php echo $nom; ?> <span class="csvBtn"><a href="./registros.php"
                class="regBtn">Historico</a></span></h2>
    <div class="InfoContainer">
        <h1 id="infoTitulo">Pasa el ratón por la mesa para saber su información</h1>
        <!-- Disponibilidad -->
        <p id="disp"></p>
        <!-- Sala -->
        <p id="info" class="text-Center"></p>
        <!-- sillas disponibles -->
        <p id="sillasDisp" class="text-Center"></p>

    </div>
    <div id="reservasContainer">

    </div>
        <!-- <form method="post" action="./proc/ocupar_silla.php"> -->
            <!-- Botones de Silla -->
            <!-- <button type="submit" name="silla_1" value="Silla 1"
                class="silla-btn"><img src="./img/sillaIcon.png" alt="" srcset=""></button>
        </form> -->
    <a href="./proc/logout.php" class="logout">Cerrar sesión</a>
    <script src="./js/getInfo.js"></script>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var xhr = new XMLHttpRequest();
            var mapa = document.getElementById("reservasContainer");
            
            xhr.onreadystatechange = function () {
                if (xhr.readyState == 4 && xhr.status == 200) {
                    var mesas = JSON.parse(xhr.responseText);
                    console.log(mesas);

                    // Limpiar el contenido actual del mapa
                    mapa.innerHTML = "";

                    // Iterar sobre las mesas y agregarlas al mapa
                    for (var i = 0; i < mesas.length; i++) {
                        var mesa = mesas[i];

                        // Crear un elemento div para representar la mesa
                        var divMesa = document.createElement("div");
                        divMesa.id = mesa.mesa;
                        divMesa.classList.add("mesaContainer");
                        divMesa.addEventListener('mouseover', function() {
                            Informacion(this);
                        });
                        divMesa.addEventListener('mouseleave', function() {
                            Ocultar(this);
                        });

                        // Crear un elemento button dentro del div
                        var button = document.createElement("button");
                        button.type = "submit";
                        button.name = "mesa_" + mesa.mesa;
                        button.value = "Mesa " + mesa.mesa;
                        button.classList.add("mesa-btn");

                        // Crear un elemento img dentro del button
                        var img = document.createElement("img");
                        img.classList.add("mesa" + mesa.mesa);
                        img.src = "./img/mesaIcon/mesa" + mesa.numero_sillas + ".png";
                        img.alt = "";
                        img.srcset = "";

                        // Agregar el elemento img al button
                        button.appendChild(img);

                        // Crear un elemento p dentro del div
                        var p = document.createElement("p");
                        p.style.display = "none";
                        if (mesa.salida === null) {
                            p.textContent = mesa.sala + "-" + mesa.numero_sillas + "-" + 1;
                        }else{
                            p.textContent = mesa.sala + "-" + mesa.numero_sillas + "-" + 0;
                        }

                        // Agregar los elementos al div
                        divMesa.appendChild(button);
                        divMesa.appendChild(p);

                        // Agregar el elemento div al mapa
                        mapa.appendChild(divMesa);
                    }
                }
            };

            // Abre la solicitud antes de agregar encabezados
            xhr.open('GET', './proc/get_mesas.php', true);

            // Agrega un encabezado después de abrir la solicitud
            xhr.setRequestHeader('X-Requested-With', 'XMLHttpRequest');
            
            xhr.send();
        });
    </script>
</body>

</html>
