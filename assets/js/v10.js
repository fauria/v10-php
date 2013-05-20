var probar = function(){
	$.ajax({
		url: 'ajax/test',
		method: "get",
		async: false,
		dataType: "json",
		success: function(data){
		   $("#resultado").html("La petición ha sido correcta!");
		   $("#array").html(JSON.stringify(data));
		},
		error: function(){
			$("#resultado").html("La petición ha fallado!");
		}
	});
}

$(document).ready(function(){
	probar();
	$("#probar").click(function(){
		probar();
	})
});