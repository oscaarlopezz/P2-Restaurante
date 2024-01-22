<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Tu Página con Bootstrap</title>

    <!-- Enlaces CDN de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>
    <div class="crud" id="crud">
        <div id="container">
        </div>
        <div class="tabla">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Nombre</th>
                        <th scope="col">Apellido</th>
                        <th scope="col">Correo</th>
                        <th scope="col">Modificar</th>
                        <th scope="col">Eliminar</th>
                    </tr>
                </thead>
                <tbody id="usuarios"></tbody>
            </table>
        </div>
    </div>

<script>

    function eliminar(id) {
        // Código para la función de eliminar

        // Ejemplo de envío de datos por AJAX
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "eliminar.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4 && xhr.status === 200) {
                // Manejar la respuesta del servidor si es necesario
                console.log(xhr.responseText);
            }
        };

        // Los datos que deseas enviar
        var datos = "id=" + id;

        // Enviar la solicitud al servidor
        xhr.send(datos);
    }
    function modificar(id) {
        // Crear un elemento button dentro del div
        var button = document.createElement("div");
        button.id = "container";
        crud = 
        button.appendChild(crud);
        var cont = document.getElementById("container");
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "f_mod.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Parsear la respuesta JSON
                    cont.innerHTML = xhr.responseText;

                } else {
                    // Manejar errores de la solicitud AJAX
                    console.error('Error al cargar datos de usuarios:', xhr.statusText);
                }
            }
        };
        var datos = "id=" + id;
        // Configurar y enviar la solicitud AJAX

        // Enviar la solicitud al servidor
        xhr.send(datos);
    }

    // Función para cargar y mostrar datos de usuarios por AJAX
    function cargarDatosUsuarios() {
        var xhr = new XMLHttpRequest();

        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Parsear la respuesta JSON
                    var usuarios = JSON.parse(xhr.responseText);

                    // Limpiar la tabla
                    document.getElementById("usuarios").innerHTML = "";

                    // Iterar sobre los usuarios y agregar filas a la tabla
                    usuarios.forEach(function (usuario) {
                        var fila = "<tr>";
                        fila += "<th scope='row'>" + usuario.id_user + "</th>";
                        fila += "<td>" + usuario.nombre + "</td>";
                        fila += "<td>" + usuario.apellido + "</td>";
                        fila += "<td>" + usuario.correo + "</td>";
                        fila += "<td><button onclick=modificar(" + usuario.id_user + ") style='text-decoration: none; color: red;'>✎</button></td>";
                        fila += "<td><button onclick=eliminar(" + usuario.id_user + ") style='text-decoration: none; color: red;'>⌧</button></td>";
                        fila += "</tr>";

                        document.getElementById("usuarios").innerHTML += fila;
                    });
                } else {
                    // Manejar errores de la solicitud AJAX
                    console.error('Error al cargar datos de usuarios:', xhr.statusText);
                }
            }
        };

        // Configurar y enviar la solicitud AJAX
        xhr.open("GET", "camareros.php", true);
        xhr.send();
    }

    // Llamar a la función al cargar la página
    cargarDatosUsuarios();
</script>


<!-- Contenido de tu página -->

<!-- Enlaces CDN de Bootstrap JS y Popper.js (necesario para algunas funciones de Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
