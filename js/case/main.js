function newCaso(){
	var traza=$("#inputTraza").val();
	var m=new Date();
	var dateString = m.getUTCFullYear() +"/"+ (m.getUTCMonth()+1) +"/"+ m.getUTCDate() + " " + 
	(m.getUTCHours()+2) + ":" + m.getUTCMinutes() + ":" + m.getUTCSeconds();

	$.ajax({
        url: '/php/addCaso.php',
        type: 'GET',
		data: {"Traza" : traza, "Fecha" : dateString},
        processData: false,
		contentType: false,
		dataType: 'json',
        success: function(data) {


		}
    });



}

function listCasos(){
	$.ajax({
        url: '/php/getCasos.php',
        type: 'GET',
        processData: false,
		contentType: false,
		dataType: 'json',
        success: function(data) {
			$.each(data, function(i, item) {
			element="<tr><td width='10px'>"+item.Id+"</td>";
			element+="<td>"+item.Traza+"</td>";
			element+="<td>"+item.Fecha+"</td>";
			element+="<td width='10px'><a href='#' class='btn btn-info' onclick='loadModels()'>Listar</a></td>";
			element+="<td width='10px'><a href='#' class='btn btn-danger btn-sm' onclick='deleteCase()'>Eliminar</a></td><tr>";

			$("#table > tbody").append(element);

		}
    });
}


/*$.ajax({
        url: '/php/addCaso.php',
        type: 'GET',
        processData: false,
		contentType: false,
		dataType: 'json',
        success: function(data) {
			$.each(data.images, function(i, item) {
				//console.log(item.url);

				//Create HTML element
				element="<div class='carousel-item";

				//Adding active class if slide is the first
				if(curIndex==1) element+=" active";
				element+="'>"

				element+="<img id='img"+curIndex+"' class='d-block w-100 img-fluid' src='' alt='Slide"+curIndex+"'>";
				element+="<div id='txt"+curIndex+"' class='carousel-caption d-none d-md-block'>";
				element+="<h5></h5></div></div>";

				//Adding element to HTML body
				$(".carousel-inner").append(element); 

				urlImage = item.url.toString();
				if(item.text===null){
					urlText='';
				}else{
					urlText = item.text.toString();
				}
				
				$('#img'+(curIndex)).attr("src",urlImage);
				$('#txt'+(curIndex)+'> h5').text(urlText);

				curIndex+=1;
			});
        }
    });*/