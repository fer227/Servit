function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

var alerta_correo = document.getElementById("alerta_correo");
var alerta_user = document.getElementById("alerta_user");
var enviar = document.getElementById("enviar");
var correo = document.getElementById("email");
var usernames = document.getElementById("usernames");
var user_intro = document.getElementById("username_intro");
var usernames_list = usernames.value;
var usernames_array = usernames_list.split(",");

correo.onkeyup = function(){
    if(!validateEmail(correo.value)) {
        alerta_correo.style.visibility = "visible";
        alerta_correo.style.display = "block";
        enviar.disabled = true;
    }
    else {
        alerta_correo.style.visibility = "hidden";
        alerta_correo.style.display = "none";
        enviar.disabled = false;
    }
}

user_intro.onkeyup = function(){
    if(usernames_array.includes(user_intro.value)) {
        alerta_user.style.visibility = "visible";
        alerta_user.style.display = "block";
        enviar.disabled = true;
    }
    else{
        alerta_user.style.visibility = "hidden";
        alerta_user.style.display = "none";
        enviar.disabled = false;
    }
}