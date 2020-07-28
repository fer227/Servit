function restar(id_producto, id_pedido) {
    var code_p1 = id_producto.toString().concat('_');
    var code_p2 = id_pedido.toString();
    var code = code_p1.concat(code_p2);
    var id = id_producto.toString();
    var cantidad = document.getElementById("cant_".concat(code));
    if(parseInt(cantidad.innerHTML) != 0){
        cantidad.innerHTML = parseInt(cantidad.innerHTML) - 1;
        if(parseInt(cantidad.innerHTML) == 0){
            var boton = document.getElementById("boton_".concat(code));
            boton.classList.add('disabled');
        }

        var json = document.getElementById('json');
        if(json.value == ''){
            jsondata = {};
            jsondata[code] = 1;
            var str = JSON.stringify(jsondata);
            json.value = str;
        }
        else{
            var json_obj = JSON.parse(json.value);
            if(json_obj.hasOwnProperty(code)){
                json_obj[code] = json_obj[code] + 1;
                var str = JSON.stringify(json_obj);
                json.value = str;
            }
            else{
                json_obj[code] = 1;
                var str = JSON.stringify(json_obj);
                json.value = str;
            }
        }
    }
}