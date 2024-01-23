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
        <form id="formularioModificar" onsubmit="event.preventDefault(); enviarDatos();">
        </form>
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
                    usuarios.forEach(function (usuario) {
                        var fila = "<tr>";
                        fila += "<th scope='row'>" + usuario.id_user + "</th>";
                        fila += "<td>" + usuario.nombre + "</td>";
                        fila += "<td>" + usuario.apellido + "</td>";
                        fila += "<td>" + usuario.correo + "</td>";
                        fila += "<td><button onclick=modificar(" + usuario.id_user + ") style='text-decoration: none; color: red;'>✎</button></td>";
                        fila += "<td><button onclick=alerta(" + usuario.id_user + ") style='text-decoration: none; color: red;'>⌧</button></td>";
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
    function modificar(id) {
        // Crear un elemento button dentro del div
        var button = document.createElement("div");
        button.id = "container";
        crud = document.getElementById("crud");
        crud.appendChild(button);
        var cont = document.getElementById("container");
        var form = document.getElementById("formularioModificar");
        // Añadir estilos al contenedor
        if (id == "close") {
            cont.style.width = "0";
            cont.style.height = "0";
            cont.style.float = "none";
        }else{
            cont.style.width = "100%";
            cont.style.height = "30vh";
            cont.style.float = "left";
        }
        var xhr = new XMLHttpRequest();
        xhr.open("POST", "f_mod.php", true);
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
    var id = document.getElementById("id_camarero").value;
    var nombre = document.getElementById("nombre").value;
    var apellido = document.getElementById("apellido").value;
    var correo = document.getElementById("correo").value;
    var contrasena = document.getElementById("contrasena").value;

    // Crear un objeto FormData para enviar los datos
    var formData = new FormData();
    formData.append("id", id);
    formData.append("nombre", nombre);
    formData.append("apellido", apellido);
    formData.append("correo", correo);
    formData.append("contrasena", contrasena);

    // Crear una instancia de XMLHttpRequest
    var xhr = new XMLHttpRequest();
    xhr.open("POST", "modificar.php", true);

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
document.getElementById("formularioModificar").addEventListener("submit", function (event) {
    event.preventDefault(); // Evitar el envío convencional del formulario
    enviarDatos();
});

</script>


<!-- Contenido de tu página -->

<!-- Enlaces CDN de Bootstrap JS y Popper.js (necesario para algunas funciones de Bootstrap) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
