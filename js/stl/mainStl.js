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

//Establecemos las variables del Caso y el Modelo
var id_caso = getUrlVars()["caso"]; id_caso = (typeof id_caso === 'undefined') ? 1 : id_caso;
var id_modelo = getUrlVars()["modelo"]; id_modelo = (typeof id_modelo === 'undefined') ? 1 : id_modelo;

//Listamos los STLs
function lisSTLs(){
    $("#table > tbody > tr").remove();

    $("#nameCaso").html("Caso "+id_caso+"  &nbsp; Modelo "+id_modelo);

    var datos = new FormData();
    datos.append('IDCase', id_caso);
    datos.append('IDModel', id_modelo);

    $.ajax({
        url: 'php/getSTLs.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        dataType: 'json'
	})
    .done(function(response){
	    $.each(response, function(i, item) {

			element="<tr><td width='10px'>"+item.ID_stl+"</td>";
			element+="<td>"+item.Nombre+"</td>";
            element+="<td>"+item.Color+"</td>";
			element+="<td>"+item.Visible+"</td>";
            element+="<td>"+item.Transp+"</td>";
            element+="<td>"+item.Orden+"</td>";
			element+="<td><div class='form-group row justify-content-center'>";
            element+="<div class='col-sm-6'><button id='newSTL' class='btn btn-primary' onclick='openModalSTL("+item.ID_stl+")'>Editar STL</button></div>";
			element+="<div class='col-sm-6'><button id='delcase' class='btn btn-danger' onclick='deleteSTL("+item.ID_stl+")'>Eliminar</button></div>";
			element+="</div></td></tr>"


			$("#table > tbody").append(element);
            
		});
	});

}
//Fin Listamos los STLs


//Editar y actualizar un STL
function openModalSTL(id_stl){

    var datos = new FormData();
    datos.append('IDSTL', id_stl);

    $.ajax({
        url: 'php/getOneSTL.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        dataType: 'json'
	})
    .done(function(response){
	    $.each(response, function(i, item) {
       
            $("#idstl").val(id_stl);

            $("#inputName").val(item.Nombre);
            $("#inputModalcolor").val(item.Color);
            $("#visible_id").val(item.Visible);
            $("#inputTrans").val(item.Transp);
            $("#inputOrden").val(item.Orden);
            
		});
	});


	$("#formEditSTL").modal();
}

function hideModalUpdateTL(){
    id_stl=$("#idstl").val();

	updateSTL(id_stl);
	$("#formEditSTL").modal('hide');
	lisSTLs();
}

function updateSTL(id_stl){

	var name=$("#inputName").val();
	var colour=$("#inputModalcolor").val();
    colour=colour.split("#")[1];

	var visible=$("#visible_id").val();
    if(visible == "si"){
        visible=1;
    }else{
        visible=0;
    }
	var trans=$("#inputTrans").val();
	var order=$("#inputOrden").val();
	

	var datos = new FormData();
    datos.append('IDStl', id_stl);
    datos.append('Nombre', name);
    datos.append('Color', colour);
    datos.append('Visible',visible);
    datos.append('Transp', trans);
    datos.append('Orden', order);


	$.ajax({
        url: 'php/updateSTL.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
		dataType: 'json'
    })
	.done(function(response){
		var jsonData = JSON.stringify(response);
		toastr.success('Nueva Elemento STL actualizado con éxito');

	})
	.fail(function(response){
		var jsonData = JSON.stringify(response);
		toastr.error('Fallo. No se ha podido actualizar el elemento.');

	});
}
//Fin Editar y actualizar un STL



//Elimina un STL
function deleteSTL(id_stl){

    var datos = new FormData();
    datos.append('IDSTL', id_stl);

	$.ajax({
        url: 'php/deleteStl.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
		dataType: 'json'
    })
	.done(function(response){
		var jsonData = JSON.stringify(response);
		toastr.success('El STL ha sido eliminado con éxito');

	})
	.fail(function(response){
		var jsonData = JSON.stringify(response);
		toastr.error('Fallo. No se ha podido eliminar el STL.');

	});

    lisSTLs();

}
//Fin Elimina un STL



//Volvemos a la pagina de los Modelos
function returnToModels(){
    window.location="indexModelo.html?caso="+id_caso;
}
//Fin Volvemos a la pagina de los Modelos