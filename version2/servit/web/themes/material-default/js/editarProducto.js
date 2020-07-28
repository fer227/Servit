$(document).ready(function(){
    var tagsMeta = [];
    //alert(tagsMeta);
    var tagsString = document.getElementById('chip_input').value;
    //alert(tagsString);
    if(tagsString != "null"){
        var tagsArray = tagsString.split(',');
        for(i=0; i < tagsArray.length; i++) {
            tagsMeta.push({tag: tagsArray[i]});
        }

        $('.chips-initial').chips({
            data: tagsMeta
        });
    }
});

var enviar = document.getElementById("enviar");
enviar.onclick = function () {
    var chips = M.Chips.getInstance(document.getElementById('chips1'));
    var ingredientes = chips.chipsData;
    var myForm = document.getElementById('chip_input');
    myForm.value = JSON.stringify(ingredientes);
}