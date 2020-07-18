var enviar = document.getElementById("enviar");

enviar.onclick = function () {
    var chips = M.Chips.getInstance(document.getElementById('chips1'));
    var ingredientes = chips.chipsData;
    var myForm = document.getElementById('my-form');
    var hiddenInput = document.createElement('input');
    hiddenInput.type = 'hidden';
    hiddenInput.name = 'formProducto[chips]';
    hiddenInput.value = JSON.stringify(ingredientes);
    myForm.appendChild(hiddenInput);
}