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

   
    $.ajax({
        url: 'php/getModelos.php',
        type: 'get',
        processData: false,
        contentType: false,
		dataType: 'json'
        //data: {IDCase : id_caso}
	})
    .done(function(response){
	        $.each(response, function(i, item) {
			if(item.ID_caso == id_caso){

			    element="<tr><td width='10px'>"+item.ID_modelo+"</td>";
			    element+="<td>"+item.Nombre+"</td>";
                element+="<td>"+item.Tipo+"</td>";
			    element+="<td>"+item.Fecha+"</td>";
			    element+="<td><div class='form-group row justify-content-center'>";
                element+="<div class='col-sm-6'><button id='newSTL' class='btn btn-primary' onclick='openModalSTL("+item.ID_modelo+")'>Nuevo STL</button></div>";
			    element+="<div class='col-sm-6'><button id='delcase' class='btn btn-danger' onclick='deleteCase("+item.ID_modelo+")'>Eliminar</button></div>";
			    element+="</div></td></tr>"


			    $("#table > tbody").append(element);
            }
		});
	});

}


var idModelo=1;

function openModalSTL(id_model){
	idModelo=id_model;
	$("#formAddSTL").modal();
}

function hideModalSTL(){
	newSTL();
	$("#formAddSTL").modal('hide');
	//loadSTLs();
}

function newSTL(){
	
	//$("#formAddModel").modal();

	var name=$("#inputName").val();
	var colour=$("#inputcolor").val();
	var visible=$("#visible_id").val();
	var trans=$("#inputTrans").val();
	var order=$("#inputOrder").val();
	
	console.log("IDC:"+id_caso+", IDM:"+idModelo+", NAME:"+name+", COLOR:"+colour+", VISIBLE:"+visible+", TRANS:"+trans+", ORDER:"+order);

	


	$.ajax({
        url: 'php/addSTL.php',
        type: 'get',
		dataType: 'json',
        data: {IdCaso:id_caso, IdModelo:idModelo ,Nombre: name, Color: colour, Visible :visible, Transp: trans, Orden: order}
    })
	.done(function(response){
		var jsonData = JSON.stringify(response);
		console.log("Salida:"+jsonData);
		toastr.success('Nueva Elemento STL creada con éxito');

	})
	.fail(function(response){
		var jsonData = JSON.stringify(response);
		//console.log(jsonData);
		toastr.error('Fallo. No se ha podido añadir el elemento.');

	});
}




function returnToCases(){
    window.location="indexCaso.html";
}




////////////// API /////////////////
function listaModelosByCasos(id_caso){
	$.ajax({
        url: 'API/getApiModelosByCasos.php',
        type: 'get',
        processData: false,
		contentType: false,
		dataType: 'json',
		data: {ID:id_caso}
	})
    .done(function(response){
		return response;
	});
}