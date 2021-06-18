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
		dataType: 'json',
        //data: {IDCase : id_caso}
	})
    .done(function(response){
        $.each(response, function(i, item) {
			console.log(item.Id);
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

function openModalModel(id_model){
	idCaso=id_model;
	$("#formAddModel").modal();
}

function hideModalModel(){
	newSTL();
	$("#formAddModel").modal('hide');
	loadModels(idCaso);
}

function newSTL(){
	/*alert("AÑADIR MODELO PARA:"+id_case);*/
	$("#formAddModel").modal();

	var name=$("#inputName").val();
	var tipe=$("#tipo_id").val();
	var m=new Date();
	var dateString = m.getUTCFullYear() +"/"+ (m.getUTCMonth()+1) +"/"+ m.getUTCDate() + " " + 
	(m.getUTCHours()+2) + ":" + m.getUTCMinutes() + ":" + m.getUTCSeconds();

	console.log("IDCASO:"+idCaso+", Nombre:"+name+", tipo:"+tipe+", fecha:"+dateString);

	


	$.ajax({
        url: 'php/addSTL.php',
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




function returnToCases(){
    window.location="indexCaso.html";
}