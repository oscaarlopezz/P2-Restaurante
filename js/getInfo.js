// ------------------------------------------
container = document.querySelector(".InfoContainer");
// console.log(container);
function Ocultar(){
    for (let i = 0; i < container.children.length; i++) {
        container.children[i].innerText ="";
        
    }
    container.children[0].innerText = "Pasa el ratón por la mesa para saber su información";
}
function Informacion(mesa){
    // var info = info.split('-');
    var info = mesa.children[1].innerText.split('-');
    console.log(info[4]);
    var numMesa = mesa.children[0].value;
    // 3 entrada 
    // 4 salida 
    // 5 actual
    container.children[0].innerText = numMesa;
    // Convertir las cadenas de fechas a objetos Date
    // Cadena con fecha y hora en formato "Y/m/d H:i:s"
    function fechaHora(fecha) {
        // console.log(fecha);
        if (fecha === "null") {
            return "Actualmente";
        } else {
            // Reemplazar '/' por '-' para asegurar compatibilidad en algunos navegadores
            fecha = fecha.replace(/\//g, '-');
    
            var partes = fecha.split(/[\/ :-]/);
    
            // Intentar parsear con el formato "dd-mm-yyyy"
            var fechaHora = new Date(partes[2], partes[1] - 1, partes[0], partes[3] || 0, partes[4] || 0, partes[5] || 0);
    
            // Verificar si la conversión fue exitosa
            if (isNaN(fechaHora.getTime())) {
                // Intentar parsear con el formato "yyyy-mm-dd"
                fechaHora = new Date(partes[0], partes[1] - 1, partes[2], partes[3] || 0, partes[4] || 0, partes[5] || 0);
            }
    
            // Si sigue siendo inválido, asumimos que el formato es "yyyy-mm-ddTHH:mm:ss"
            if (isNaN(fechaHora.getTime())) {
                fechaHora = new Date(fecha);
            }
    
            if (isNaN(fechaHora.getTime())) {
                console.log("La cadena no es válida para la conversión a fecha. " + fecha);
            } else {
                // console.log(fechaHora);
                return fechaHora;
            }
        }
    }
    var fechaEntrada = fechaHora(info[3]);
    var fechaSalida = fechaHora(info[4]);
    // var fechaActual = fechaHora(info[5]);
    var formatoFecha = new Date();
    var fechaActual = formatoFecha;
    console.log("Entrada: " + fechaEntrada);
    console.log("Salida: " + fechaSalida);
    console.log("Actual: " + fechaActual);
    var reserva = document.getElementById("reservar");
    // Verificar si la fechaActual es más reciente que fechaEntrada y más antigua que fechaSalida
    if (fechaActual > fechaEntrada && fechaSalida === "Actualmente") {
        // Tu código aquí si se cumple la condición
        console.log("Condición 1 cumplida");
        container.children[1].innerText = "OCUPADO";
        container.children[1].style.color = "red";
        // reserva.href += "&ocu=1"
    } else {
        if (fechaActual > fechaEntrada && fechaActual < fechaSalida) {
            // Tu código aquí si se cumple la condición
            console.log("Condición 2 cumplida");
            container.children[1].innerText = "OCUPADO";
            container.children[1].style.color = "red";
            // reserva.href += "&ocu=1"
        } else {
            // Tu código aquí si la condición no se cumple
            console.log("Condición no cumplida");
            container.children[1].innerText = "DISPONIBLE";
            container.children[1].style.color = "green";
            // reserva.href += "&ocu=0"
        }
    }
    // if(info[2]==1){
    //     container.children[1].innerText = "OCUPADO";
    //     container.children[1].style.color="red";
    // }else{
    //     container.children[1].innerText = "DISPONIBLE";
    //     container.children[1].style.color="green";
    // }
    container.children[2].innerHTML = `<p id="info"class="text-Center">Ubicación: </br> <span class="infoMesa">${info[1]}</span></p>`;
    container.children[3].innerHTML = `<p id="sillasDisp"class="text-Center">Numero de sillas: </br> <span class="infoMesa">${info[2]} sillas</span></p>`;
}



