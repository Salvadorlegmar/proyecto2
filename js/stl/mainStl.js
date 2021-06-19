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

var id_caso = getUrlVars()["caso"]; id_caso = (typeof id_caso === 'undefined') ? 1 : id_caso;
var id_modelo = getUrlVars()["modelo"]; id_modelo = (typeof id_modelo === 'undefined') ? 1 : id_modelo;

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
        //data: {IDCase : id_caso, IDModel : id_modelo}
	})
    .done(function(response){
        //console.log("PRIMERO:"+response);
	    $.each(response, function(i, item) {
            //console.log("SALIDA:"+item.ID_stl);
			/*if(item.ID_caso == id_caso){*/

			element="<tr><td width='10px'>"+item.ID_stl+"</td>";
			element+="<td>"+item.Nombre+"</td>";
            element+="<td>"+item.Color+"</td>";

           //element+="<td> <input id='inputcolor"+item.ID_stl+" value="+item.Color+" data-jscolor='{}'></td>";

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

//var idStl=1;

//Editar un STL

function openModalSTL(id_stl){
	//idStl=ID_stl;

    var datos = new FormData();
    datos.append('IDSTL', id_stl);

    $.ajax({
        url: 'php/getOneSTL.php',
        type: 'POST',
        data: datos,
        processData: false,
        contentType: false,
        dataType: 'json'
        //data: {IDCase : id_caso, IDModel : id_modelo}
	})
    .done(function(response){
        console.log("recupero:"+response);
	    $.each(response, function(i, item) {
            console.log("SALIDA:"+item);
			/*if(item.ID_caso == id_caso){*/
            
            $("#idstl").val(id_stl);

            $("#inputName").val(item.Nombre);
            $("#inputModalcolor").val(item.Color);
            $("#visible_id").val(item.Visible);
            $("#inputTrans").val(item.Transp);
            $("#inputOrden").val(item.Orden);
            
		});
	});


	$("#formEditSTL").modal();
    //loadDatosStl(id_stl)
}

function hideModalUpdateTL(){
    id_stl=$("#idstl").val();

	updateSTL(id_stl);
	$("#formEditSTL").modal('hide');
	lisSTLs();
}

function updateSTL(id_stl){
	
	//$("#formAddModel").modal();

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
		console.log("Salida:"+jsonData);
		toastr.success('Nueva Elemento STL actualizado con éxito');

	})
	.fail(function(response){
		var jsonData = JSON.stringify(response);
		//console.log(jsonData);
		toastr.error('Fallo. No se ha podido actualizar el elemento.');

	});
}




//Elimina un STL
function deleteSTL(id_stl){
    removeSTL(id_stl);
    lisSTLs();
}

function removeSTL(id_stl){
	//alert("ELIMINAR "+id_stl);

    const datos = new FormData();
    datos.append('IDStl', id_stl);


	$.ajax({
        url: 'php/deleteStl.php',
        type: 'POST',
        data: {IDStl:id_stl},
		dataType: 'json'
    })
	.done(function(response){
        console.log("PRIMERA:"+response)
		toastr.success('El Elemento STL ha sido eliminado con éxito');

	});

}
//Fin Elimina un STL




function returnToModels(){
    window.location="indexModelo.html?caso="+id_caso;
}