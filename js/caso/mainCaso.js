//Inicio
function init(){
	listCasos();
	
}

//Añade un caso
function openModalCase(){
	$("#formAddCase").modal();
}

function hideModalCase(){
	newCaso();
	$("#formAddCase").modal('hide');
	//window.location="indexCaso.html";
	listCasos();
}


function newCaso(){
	var traza=$("#inputTraza").val();
	var m=new Date();
	var dateString = m.getUTCFullYear() +"/"+ (m.getUTCMonth()+1) +"/"+ m.getUTCDate() + " " + 
	(m.getUTCHours()+2) + ":" + m.getUTCMinutes() + ":" + m.getUTCSeconds();


	$.ajax({
        url: 'php/addCaso.php',
        type: 'post',
		dataType: 'json',
        data: {Traza : traza, Fecha : dateString}
    })
	.done(function(response){
		var jsonData = JSON.stringify(response);
		console.log("Salida:"+jsonData);
		toastr.success('Nueva Caso creada con éxito');

	})
	.fail(function(response){
		var jsonData = JSON.stringify(response);
		//console.log(jsonData);
		toastr.error('Fallo. No se ha podido añadir el Caso.');

	});


}
//Fin Añade un caso

//List los casos
function listCasos(){
	$("#table > tbody > tr").remove();

	$.ajax({
        url: 'php/getCasos.php',
        type: 'get',
        processData: false,
		contentType: false,
		dataType: 'json'
	})
    .done(function(response){
		$.each(response, function(i, item) {
			console.log(item.Id);

			element="<tr><td width='10px'>"+item.Id+"</td>";
			element+="<td>"+item.Traza+"</td>";
			element+="<td>"+item.Fecha+"</td>";
			element+="<td width='10px'><a href='#' class='btn btn-info' onclick='loadModels("+item.Id+")'>Listar</a></td>";
			element+="<td><div class='form-group row justify-content-center'>";
			element+="<div class='col-sm-6'><button id='newModel' class='btn btn-primary' onclick='openModalModel("+item.Id+")'>Nuevo Modelo</button></div>";
			element+="<div class='col-sm-6'><button id='delcase' class='btn btn-danger' onclick='deleteCase("+item.Id+")'>Eliminar</button></div>";
			element+="</div></td></tr>"


			$("#table > tbody").append(element);
		});
	});
		
}
// Fin Lista los casos


//Eliminia un caso
function deleteCase(id_case){
	alert("ELIMINAR "+id_case);

	var datos = new FormData();
    datos.append('IDCaso', id_case);


	$.ajax({
        url: 'php/deleteCaso.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
		dataType: 'json'
    })
	.done(function(response){
		var jsonData = JSON.stringify(response);
		console.log("Salida:"+jsonData);
		toastr.success('El Caso ha sido eliminado con éxito');

	})
	.fail(function(response){
		var jsonData = JSON.stringify(response);
		//console.log(jsonData);
		toastr.error('Fallo. No se ha podido eliminar el caso.');

	});

	listCasos();




}
//Fin Elimina un caso

function loadModels(id_case){
	window.location="indexModelo.html?caso="+id_case;

}

var idCaso=1;

//Añade un Modelo al caso indicado
function openModalModel(id_case){
	idCaso=id_case;
	$("#formAddModel").modal();
}

function hideModalModel(){
	newModel();
	$("#formAddModel").modal('hide');
	loadModels(idCaso);
}

function newModel(){
	$("#formAddModel").modal();

	var name=$("#inputName").val();
	var tipe=$("#tipo_id").val();
	var m=new Date();
	var dateString = m.getUTCFullYear() +"/"+ (m.getUTCMonth()+1) +"/"+ m.getUTCDate() + " " + 
	(m.getUTCHours()+2) + ":" + m.getUTCMinutes() + ":" + m.getUTCSeconds();

	console.log("IDCASO:"+idCaso+", Nombre:"+name+", tipo:"+tipe+", fecha:"+dateString);

	


	$.ajax({
        url: 'php/addModelo.php',
        type: 'post',
		dataType: 'json',
        data: {IdCaso:idCaso ,Nombre: name,Tipo: tipe, Fecha : dateString}
    })
	.done(function(response){
		var jsonData = JSON.stringify(response);
		console.log("Salida:"+jsonData);
		toastr.success('Nueva Modelo creada con éxito');

	})
	.fail(function(response){
		var jsonData = JSON.stringify(response);
		//console.log(jsonData);
		toastr.error('Fallo. No se ha podido añadir el Modelo.');

	});
}
//Fin Añade un modelos a caso seleccionado

////////////// API /////////////////
function listaCasos(){
	$.ajax({
        url: 'API/getApiCasos.php',
        type: 'get',
        processData: false,
		contentType: false,
		dataType: 'json'
	})
    .done(function(response){
		return response;
	});
}