<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Recursos</title>

    <!-- Enlaces CDN de Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../css/crud.css">
</head>
<body>
    <a href="crud_user.php">Usuarios</a>
    <div class="crud" id="crud">
        <div id="container">
        <form id="formularioModificar_r" onsubmit="event.preventDefault(); enviarDatos();">
        </form>
        </div>
        <div class="tabla" id="tabla">
            <table class="table">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">Mesa Núm.</th>
                        <th scope="col">Sala</th>
                        <th scope="col">Disponibilidad</th>
                        <th scope="col">Núm. Sillas</th>
                        <th scope="col">Últ. Entrada</th>
                        <th scope="col">Últ. Salida</th>
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
                cargarDatosUsuarios();
                console.log(xhr.responseText);
            }
        };

        // Los datos que deseas enviar
        var datos = "id=" + id;

        // Enviar la solicitud al servidor
        xhr.send(datos);
    }
    function alerta(id)
        {
        var opcion = confirm("Deseas eliminar el usuario con el id " + id + "?");
        if (opcion == true) {
            eliminar(id);
        } else {
            return false;
        }
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
                    usuarios.forEach(function (mesa) {
                        var fila = "<tr>";
                        fila += "<th scope='row'>" + mesa.mesa + "</th>";
                        fila += "<td>" + mesa.sala + "</td>";
                        if (mesa.salida === null){
                            fila += "<td>OCUPADO</td>";
                        }else{
                            fila += "<td>" + mesa.disponibilidad + "</td>";
                        }
                        // fila += "<td>" + mesa.disponibilidad + "</td>";
                        fila += "<td>" + mesa.numero_sillas + "</td>";
                        fila += "<td>" + mesa.entrada + "</td>";
                        if (mesa.salida === null){
                            fila += "<td>OCUPADO</td>";
                        }else{
                            fila += "<td>" + mesa.salida + "</td>";
                        }
                        fila += "<td><button onclick=modificar(" + mesa.mesa + ") style='text-decoration: none; color: red;'>✎</button></td>";
                        fila += "<td><button onclick=alerta(" + mesa.mesa + ") style='text-decoration: none; color: red;'>⌧</button></td>";
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
        xhr.open("GET", "get_mesas.php", true);
        xhr.send();
    }

    // Llamar a la función al cargar la página
    cargarDatosUsuarios();
    function modificar(id) {
        // Crear un elemento button dentro del div
        var button = document.createElement("div");
        button.id = "container";
        crud = document.getElementById("crud");
        crud.appendChild(button);
        var cont = document.getElementById("container");
        var tabla = document.getElementById("tabla");
        var form = document.getElementById("formularioModificar_r");
        // Añadir estilos al contenedor
        if (id == "close") {
            cont.style.width = "0";
            cont.style.height = "0";
            tabla.style.height = "100vh";
            cont.style.float = "none";
        }else{
            cont.style.width = "100%";
            cont.style.height = "30vh";
            cont.style.float = "left";
            tabla.style.height = "70vh";
        }
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "f_mod_r.php", true);
        xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        xhr.onreadystatechange = function () {
            if (xhr.readyState === 4) {
                if (xhr.status === 200) {
                    // Parsear la respuesta JSON
                    form.innerHTML = xhr.responseText;
                    console.log(xhr.responseText);
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
        
    // Limpiar el contenido existente en el contenedor
    form.innerHTML = "";

    // Agregar el botón al contenedor
    form.appendChild(button);
    }

    function cerrar() {
        modificar("close");
    }
    function enviarDatos() {
    // Obtener los valores de los campos
    var mesa = document.getElementById("mesa").value;
    var sala = document.getElementById("sala").value;
    var sillas = document.getElementById("sillas").value;
    // var entrada = document.getElementById("entrada").value;
    // var salida = document.getElementById("salida").value;

    // Crear un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append("mesa", mesa);
    formData.append("sala", sala);
    formData.append("sillas", sillas);
    // formData.append("entrada", entrada);
    // formData.append("salida", salida);

    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "modificar_r.php", true);

    // Configurar el manejo de eventos para la respuesta
    xhr.onreadystatechange = function () {
        if (xhr.readyState === 4) {
            if (xhr.status === 200) {
                // La solicitud se completó exitosamente
                cerrar();
                cargarDatosUsuarios();
                console.log(xhr.responseText);
                // Aquí puedes manejar la respuesta del servidor si es necesario
            } else {
                // La solicitud no se completó correctamente
                console.error('Error al modificar datos:', xhr.statusText);
            }
        }
    };

    // Enviar la solicitud con los datos del formulario
    xhr.send(formData);
}
document.getElementById("formularioModificar_r").addEventListener("submit", function (event) {
    event.preventDefault(); // Evitar el envío convencional del formulario
    enviarDatos();
});

</script>


<!-- Contenido de tu página -->

<!-- Enlaces CDN de Bootstrap JS y Popper.js (necesario para algunas funciones de Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
