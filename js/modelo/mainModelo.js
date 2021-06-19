// Obtiene parametros de la URL
function getUrlVars(){

    var vars = [], hash;

    var hashes = window.location.href.slice(window.location.href.indexOf('?') + 1).split('&');
    for(var i = 0; i < hashes.length; i++) {
        hash = hashes[i].split('=');
        vars.push(hash[0]);
        vars[hash[0]] = hash[1];
    }
    return vars;
}

//Establecemos el valor del Caso
var id_caso = getUrlVars()["caso"]; id_caso = (typeof id_caso === 'undefined') ? 1 : id_caso;

//Listamos los modelos
function listModels(){
	$("#table > tbody > tr").remove();

    $("#nameCaso").text("Caso "+id_caso);

	const datos = new FormData();
    datos.append('IDCase', id_caso);

   
    $.ajax({
        url: 'php/getModelos.php',
        type: 'POST',
        processData: false,
        contentType: false,
		dataType: 'json',
		data: datos
	})
    .done(function(response){
	        $.each(response, function(i, item) {
			    element="<tr><td width='5px'>"+item.ID_modelo+"</td>";
			    element+="<td>"+item.Nombre+"</td>";
                element+="<td>"+item.Tipo+"</td>";
			    element+="<td>"+item.Fecha+"</td>";
			    element+="<td width='10px'><a href='#' class='btn btn-info' onclick='loadSTLs("+item.ID_modelo+")'>Listar</a></td>";
				element+="<td><div class='form-group row justify-content-center'>";
                element+="<div class='col-sm-6'><button id='newSTL' class='btn btn-primary' onclick='openModalSTL("+item.ID_modelo+")'>Nuevo STL</button></div>";
			    element+="<div class='col-sm-6'><button id='delcase' class='btn btn-danger' onclick='deleteModel("+item.ID_modelo+")'>Eliminar</button></div>";
			    element+="</div></td></tr>"


			    $("#table > tbody").append(element);
            
			});
	});

}



//Elimina un modelo
function deleteModel(id_model){
	var datos = new FormData();
    datos.append('IDModelo', id_model);


	$.ajax({
        url: 'php/deleteModelo.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
		dataType: 'json'
    })
	.done(function(response){
		var jsonData = JSON.stringify(response);
		console.log("Salida:"+jsonData);
		toastr.success('El Modelo ha sido eliminado con éxito');

	})
	.fail(function(response){
		var jsonData = JSON.stringify(response);
		toastr.error('Fallo. No se ha podido eliminar el Modelo.');

	});

	listModels();

}
//Fin Elimina un modelo



//Accedemos a la pagina de los Elementos STLs asociados al Caso y al Modelo
function loadSTLs(id_model){
	window.location="indexStl.html?caso="+id_caso+"&modelo="+id_model;

}
//Fin Accedemos a la pagina de los Elementos STLs asociados al Caso y al Modelo

var idModelo=1;

//Añadimos un nuevo STL
function openModalSTL(id_model){
	idModelo=id_model;
	$("#formAddSTL").modal();
}

function hideModalSTL(){
	newSTL();
	$("#formAddSTL").modal('hide');
}

function newSTL(){


	var name=$("#inputName").val();
	var colour=$("#inputcolor").val();
	var visible=$("#visible_id").val();
	var trans=$("#inputTrans").val();
	var order=$("#inputOrder").val();
	

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
		toastr.error('Fallo. No se ha podido añadir el elemento.');

	});
}
//Fin Añadimos un nuevo STL



//Volvemos a la pagina de los Casos
function returnToCases(){
    window.location="indexCaso.html";
}
//Fin Volvemos a la pagina de los Casos



////////////// API /////////////////
function listaModelosByCasos(id_caso){
	const datos = new FormData();
    datos.append('ID', id_caso);

	$.ajax({
        url: 'API/getApiModelosByCasos.php',
        type: 'POST',
        processData: false,
		contentType: false,
		dataType: 'json',
		data: datos
	})
    .done(function(response){
		return "modelos:"+response;
	});
}