/*$(document).ready(function() {
	$("#btn_new").on("click", function(){
		$("#formAddCase").modal();
	});

	$("#addCase").on("click", function(){
		newCaso();
	});


});*/

function init(){
	$("#btn_new").on("click", function(){
		$("#formAddCase").modal();
	});

	$("#addCase").on("click", function(){
		//newCaso();
		$("#formAddCase").modal('hide');
		listCasos();
	});
}


function newCaso(){
	var traza=$("#inputTraza").val();
	var m=new Date();
	var dateString = m.getUTCFullYear() +"/"+ (m.getUTCMonth()+1) +"/"+ m.getUTCDate() + " " + 
	(m.getUTCHours()+2) + ":" + m.getUTCMinutes() + ":" + m.getUTCSeconds();

	console.log("TRAZA:"+traza+", fecha:"+dateString);

	

	/*$.ajax({
        url: 'php/addCaso.php',
        type: 'GET',
		data: {Traza : traza, Fecha : dateString},
        success: function(response){
            var jsonData = JSON.stringify(response);
			console.log(jsonData);

		}
    });*/
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


function listCasos(){
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
			element+="<td width='10px'><a href='#' class='btn btn-info' onclick='loadModels()'>Listar</a></td>";
			element+="<td><div class='form-group row justify-content-center'>";
			element+="<div class='col-sm-6'><button id='newModel' class='btn btn-primary' onclick='addModelo("+item.Id+")'>Nuevo Modelo</button></div>";
			element+="<div class='col-sm-6'><button id='delcase' class='btn btn-danger' onclick='deleteCase("+item.Id+")'>Eliminar</button></div>";
			element+="</div></td></tr>"


			$("#table > tbody").append(element);
		});
	});
		

}

function deleteCase(id_case){
	alert("ELIMINAR "+id_case);

}

function loadModels(){
	window.location="indexModelo.html";

}

function addModelo(id_case){
	/*alert("AÑADIR MODELO PARA:"+id_case);*/
	$("#formAddModel").modal();
}
