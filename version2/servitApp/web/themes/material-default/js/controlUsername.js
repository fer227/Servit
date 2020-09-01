var alerta_user = document.getElementById("alerta_user");
var enviar = document.getElementById("enviar");
var usernames = document.getElementById("usernames");
var user_intro = document.getElementById("username_intro");
var usernames_list = usernames.value;
var usernames_array = usernames_list.split(",");

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