// Obtiene parametros de la URL
function getUrlVars(){

    var vars = [], hash;

    //var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

var id_caso = getUrlVars()["caso"]; caso = (typeof caso === 'undefined') ? 1 : caso;

function listModels(){
    $("#nameCaso").text("Caso "+id_caso);

    //alert("EL ID CASO="+id_caso);

    $.ajax({
        url: 'php/getModelos.php',
        type: 'post',
        processData: false,
		dataType: 'json',
        data: {IDCase : id_caso}
	})
    .done(function(response){
        /*console.log("PRIMERO:"+response);
        var jsonData = JSON.stringify(response);
        console.log("SEGUNDO:"+jsonData);*/
		$.each(response, function(i, item) {
			console.log(item.Id);

			element="<tr><td width='10px'>"+item.Id+"</td>";
			element+="<td>"+item.Nombre+"</td>";
            element+="<td>"+item.Tipo+"</td>";
			element+="<td>"+item.Fecha+"</td>";
			element+="<td><div class='form-group row justify-content-center'>";
			element+="<div class='col-sm-12'><button id='delcase' class='btn btn-danger' onclick='deleteCase("+item.Id+")'>Eliminar</button></div>";
			element+="</div></td></tr>"


			$("#table > tbody").append(element);
		});
	});


    /*$.ajax({
        url: 'php/getModelos.php',
        type: 'post',
        processData: false,
		contentType: false,
		dataType: 'json',
        data: {IDCase : id_caso}
	})*/

}


function returnToCases(){
    window.location="indexCaso.html";
}