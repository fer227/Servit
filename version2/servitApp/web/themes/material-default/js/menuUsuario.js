function propina() {
    var input = document.getElementById("propina_input");
    var consejo = document.getElementById("consejo");
    var boton = document.getElementById("solicitar_cuenta");
    var form_propina = document.getElementById("form_propina");
    if(input.disabled == true){
        input.disabled = false;
        input.placeholder = "Por ejemplo: 1.50";
        consejo.style.visibility = "visible";
        consejo.style.display = "block";
        validateDecimal();
    }
    else{
        input.disabled = true;
        input.placeholder = "";
        consejo.style.visibility = "hidden";
        consejo.style.display = "none";
        boton.disabled = false;
        input.value = "";
        form_propina.value = 0;
    }
}

function validateDecimal() {
    var input = document.getElementById("propina_input");
    var boton = document.getElementById("solicitar_cuenta");
    var form_propina = document.getElementById("form_propina");
    var valor_puro = input.value;
    var valor = parseFloat(input.value);
    var puntocoma = /^[0-9]{1,4}([.][0-9]{1,2})?$/;
    var RE = /[0-9]+(\.[0-9][0-9]?)?/;
    if(puntocoma.test(valor_puro)){
        if (RE.test(valor)) {
            if(valor != 0){
                boton.disabled = false;
                form_propina.value = valor;
            }
            else
                boton.disabled = true;
        } else {
            boton.disabled = true;
        }
    }
    else{
        boton.disabled = true;
    }

}

function sumar(id) {
    var cantidad_form = document.getElementById("cantidad_form_".concat(id));
    var cantidad = document.getElementById("cantidad_".concat(id));
    var enviar = document.getElementById("enviar_".concat(id));
    cantidad.innerHTML = parseInt(cantidad.innerHTML) + 1;
    enviar.disabled = false;
    cantidad_form.value = parseInt(cantidad.innerHTML);
}

function restar(id) {
    var cantidad_form = document.getElementById("cantidad_form_".concat(id));
    var cantidad = document.getElementById("cantidad_".concat(id));
    var enviar = document.getElementById("enviar_".concat(id));
    cant = parseInt(cantidad.innerHTML);
    if(cant != 0){
        cantidad.innerHTML = parseInt(cantidad.innerHTML) - 1;
        cantidad_form.value = parseInt(cantidad.innerHTML);
        if(cant == 1){
            enviar.disabled = true;
        }
    }
}