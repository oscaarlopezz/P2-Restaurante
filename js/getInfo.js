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
    function fechaHora(fecha){
        console.log(fecha);
        if(fecha === "null"){
            return "Actualmente el recurso esta ocupado";
        }else {
            var partes = fecha.split(/[\/ :]/);

            // Crear un objeto Date con las partes extraídas
            // Nota: El mes se resta en 1 porque en JavaScript los meses van de 0 a 11
            var fechaHora = new Date(partes[0], partes[1] - 1, partes[2], partes[3] || 0, partes[4] || 0, partes[5] || 0);
    
            // Verificar si la conversión fue exitosa
            if (isNaN(fechaHora.getTime())) {
                console.log("La cadena no es válida para la conversión a fecha." + fechaHora);
            } else {
                console.log(fechaHora);
                return fechaHora;
            }
        }
    }
    var fechaEntrada = fechaHora(info[3]);
    var fechaSalida = fechaHora(info[4]);
    var fechaActual = fechaHora(info[5]);
    console.log(fechaSalida);
    // Verificar si la fechaActual es más reciente que fechaEntrada y más antigua que fechaSalida
    if (fechaActual > fechaEntrada && fechaActual < fechaSalida) {
        // Tu código aquí si se cumple la condición
        container.children[1].innerText = "OCUPADO";
        container.children[1].style.color="red";
    } else {
        if (fechaActual > fechaEntrada && fechaSalida === "Actualmente el recurso esta ocupado") {
            // Tu código aquí si se cumple la condición
            container.children[1].innerText = "OCUPADO";
            container.children[1].style.color="red";
        } else {
            // Tu código aquí si la condición no se cumple
            container.children[1].innerText = "DISPONIBLE";
            container.children[1].style.color="green";
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



