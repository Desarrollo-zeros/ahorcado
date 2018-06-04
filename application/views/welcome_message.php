<?php
defined('BASEPATH') OR exit('No direct script access allowed');
echo '<script>localStorage.url = "'.base_url("Juego").'"</script>';
?>


<!DOCTYPE html>
<html lang="en">
<head>
	<title>Proyecto Juego</title>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script>



	<link href="<?=base_url("files")?>/css/fileinput.min.css" media="all" rel="stylesheet" type="text/css" />
	<script src="<?=base_url("files")?>/js/plugins/piexif.min.js" type="text/javascript"></script>
	<script src="<?=base_url("files")?>/js/plugins/sortable.min.js" type="text/javascript"></script>
	<script src="<?=base_url("files")?>/js/plugins/purify.min.js" type="text/javascript"></script>
	<!--<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script> -->
	<script src="<?=base_url("files")?>/js/fileinput.min.js"></script>
	<script src="<?=base_url("files")?>/themes/fa/theme.js"></script>
	<script src="<?=base_url("files")?>/js/locales/es.js"></script>

	<style>


		body {
			background-image: url("uploads/fondo.jpg");

		}

		.panel{
			background-color: rgba(151, 146, 149, 0.56)!important;
		}

		.well{
			background-color: rgba(151, 146, 149, 0.56)!important;
		}


		/* Set black background color, white text and some padding */
		footer {
			background-color: #555;
			color: white;
			padding: 15px;
			position: absolute;
			bottom: 0;
			width: 100%;
			height: 70px;
		}
		html {
			min-height: 100%;
			position: relative;
		}
		body {
			margin: 0;
			margin-bottom: 40px;
		}


	</style>
</head>
<body>

<nav class="navbar navbar-inverse">
	<div class="container-fluid">
		<div class="navbar-header">
			<button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
				<span class="icon-bar"></span>
			</button>
			<a class="navbar-brand" href=""><img width="40"  style="position: relative; bottom: 7px;" class="img-reponsive img-circle" src="uploads/fondo.jpg"></a>
		</div>
		<div class="collapse navbar-collapse" id="myNavbar">
			<ul class="nav navbar-nav">
				<li class="active"><a href="">Inicio</a></li>
			</ul>
			<ul class="nav navbar-nav navbar-right">
				<?php
					if(isset($this->session->idUsuario)){
						echo '<li><a href="#" id="cerrar"><span class="glyphicon glyphicon-user"></span>cerrar session</a></li>';
					}
					else{
						echo '<li><a href="#" data-toggle="modal" data-target="#myModal"><span class="glyphicon glyphicon-user"></span>Iniciar Session</a></li>';
					}
				?>
			</ul>
		</div>
	</div>
</nav>

<div class="container text-center">
	<div class="row">

		<div class="col-sm-3 well"  id="n1" <?=isset($this->session->idUsuario) ? 'style="display: block"' : 'style="display: none"'?>>
			<div class="well">
				<p><a  ondblclick="mostrarInputFoto()" href="#">Hola <?=$this->session->usuario;?></a></p>
				<img ondblclick="mostrarInputFoto()" src=" <?= isset($persona->imagen) ? base_url('uploads/').$persona->imagen : '' ;?>" class="img-circle" height="65" width="65" alt="Avatar">
			</div>
			<div class="alert alert-success fade in">
				<a href="#" class="close" data-dismiss="alert" aria-label="close">×</a>
				<p><strong>Ey!</strong></p>
				No se te olvide responder todas las preguntas :p
			</div>
			<div class="well">
				<button id="jugar" type="button" class="btn btn-default btn-sm btn-info">
					<span class="glyphicon glyphicon-play-circle"></span> Jugar
				</button>
				<button id="estados" type="button" class="btn btn-default btn-sm btn-info">
						<span class="glyphicon glyphicon-play-circle"></span> Ver estados
				</button>
				<br><br><button data-toggle="modal" data-target="#myModal1" id="crearPregunta" type="button" class="btn btn-default btn-sm btn-info">
					<span class="glyphicon glyphicon-play-circle"></span> Crear Preguntas
				</button>
			</div>
		</div>

		<div class=" <?=isset($this->session->idUsuario) ? 'col-sm-9' : 'col-sm-11'?>">
			<div class="row">
				<div class="col-sm-12">
					<div class="panel panel-default text-left">
						<div class="panel-body">
							<p>Bienvenido:
								<?=isset($persona->primerNombre) ? strtoupper($persona->primerNombre): '';?>
								<?=isset($persona->segundoNombre) ? strtoupper($persona->segundoNombre): '';?>
								<?=isset($persona->primerApellido) ? strtoupper($persona->primerApellido): '';?>
								<?=isset($persona->segundoApellido) ? strtoupper($persona->segundoApellido): '';?>
							</p>
							<button type="button" class="btn btn-default btn-sm">
								<span class="glyphicon glyphicon-thumbs-up"></span> Like
							</button>
						</div>
					</div>
				</div>
			</div>

			<div class="row" id="juego" style="display: none; height: 101%;" >
				<div class="col-sm-12">
					<div class="panel panel-default text-left">
						<div class="panel-body">
							<div class="col-sm-4">
								<h3 style="color: white">Tiempo : <i id="tiempo"></i>s</h3>
							</div>


							<div class="col-sm-5">
								<h3 style="color: white">intenetos : <label id="intentos"></label></h3>
							</div>


							<div class="col-md-5">
								<br>
								<h2><b>Pregunta:</b></h2>
								<hr>
								<h5 style="color: #000000" id="escribirPregunta"></h5>
								<hr>
								<div class="panel panel-default text-left">
									<input  type="hidden" id="repuesta" class="form-control" value="" placeholder="" disabled="disabled">
									<div class="table-responsive">
										<table class="table table-bordered">
										<tr class="success" style="height: 40px;" id="trTable">
										</tr>
									</table>
									</div>

									<div class="panel-body" id="abcd">
									</div>
								</div>

							</div>

							<div class="col-md-3">
								<img id="imagen" src="uploads/juego/punt1.png" width="478" align="left">
							</div>

							<button style="position: relative; top: 10px;" id="nuevoJuego" class="btn btn-warning btn-small">Nuevo juego</button><br>
						</div>
					</div>
				</div>

			</div>

			<div id="verEstados" style="display: block">

			</div>





		</div>
	</div>
</div>





<div id="myModal" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Gestion de Usuario</h4>
			</div>
			<div class="modal-body">
				<div id="error" style="display: none;">

				</div>
				<form name="iniciarSession" id="iniciarSession">
					<h4 class="modal-title">Iniciar Session</h4>
					<div class="form-group" align="center">
						<input class="form-control" value="" id="usuario" placeholder="Usuario">
					</div>
					<div class="form-group" align="center">
						<input class="form-control" id="contraseña" value="" placeholder="Contraseña">
					</div>
					<div class="form-group align-center">
						<input type="submit" class="btn btn-success" value="Iniciar Session" id="submitLogin">
						<a href="#" class="align-center" id="btnRegistrar"> ¿No tienes Cuenta?, ¡Registrate!</a>
					</div>
				</form>
				<form name="registar" id="registar" style="display: none;">
					<h4 class="modal-title">Registro</h4>


					<div class="form-group" align="center">
						<input class="form-control" value="" id="pNombre" placeholder="Primer Nombre" required="required">
					</div>

					<div class="form-group" align="center">
						<input class="form-control" value="" id="sNombre" placeholder="Segundo Nombre" >
					</div>

					<div class="form-group" align="center">
						<input class="form-control" value="" id="pApellido" placeholder="Primer Apellido" required="required">
					</div>

					<div class="form-group" align="center">
						<input class="form-control" value="" id="sApellido" placeholder="Segundo Apellido" required="required">
					</div>

					<div class="form-group" align="center">
						<input class="form-control" value="" pattern="[0-9]" id="semestre" placeholder="Semestre entre (1-10)" required="required">
					</div>

					<div class="form-group" align="center">
						<input class="form-control" value="" id="usuario1" placeholder="Usuario" required="required">
					</div>
					<div class="form-group" align="center">
						<input class="form-control" id="contraseña1" value="" placeholder="Contraseña" required="required">
					</div>

					<div class="form-group align-center">
						<input type="submit" class="btn btn-info" value="Registrarme" id="submitLogin">
						<a href="#" class="align-center" id="btnIniciarSession"> ¿Iniciar Session!</a>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>


<div id="myModal1" class="modal fade" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal">&times;</button>
				<h4 class="modal-title">Gestion de Pregunta</h4>
			</div>
			<div class="modal-body">
				<div id="error" style="display: none;">

				</div>
				<form name="fromPregunta" id="fromPregunta">
					<h4 class="modal-title">Registrar Pregunta</h4>
					<div class="form-group" align="center">
						<textarea class="form-control"  id="textPregunta" placeholder="Pregunta" style="height: 20%"></textarea>
						<br><input class="form-control" value="" id="textRepuesta" placeholder="Repuesta">
						<br><input type="submit" class="btn btn-success form-control" value="Registrar Pregunta">
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal -->
<div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel">Modal title</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<form id="formInputFile">
				<div class="modal-body">
						<div class="">
							<input id="input-b2" name="foto" type="file" class="file" data-show-preview="false">
						</div>
					<div id="kartik-file-errors"></div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
					<button type="submit" class="btn btn-primary" title="Your custom upload logic">Guardar Imagen</button>
				</div>
			</form>
		</div>
	</div>
</div>


<script>
	$(document).on('ready', function() {
		$("#input-b9").fileinput({
			showPreview: false,
			showUpload: false,
			elErrorContainer: '#kartik-file-errors',
			allowedFileExtensions: ["jpg", "png", "gif"]
			//uploadUrl: '/site/file-upload-single'
		});
	});
</script>


<script>

	var tiempo = 60;
	var abcd = ["A","B","C","D","E","F","H","I","J","k","L","M","N","Ñ","O","P","Q","R","S","T","U","W","V","X","Y","Z"," ","Á","É","Í","Ó","Ú"];
	var letra = "";
	var contador = 1;
	var repuesta1 = "";
	var obj = new Object();
	var vec = [];
	var $t = "";

	$("#btnRegistrar").click(function () {
		abrirRegistrar();
	});

	function abrirRegistrar(){
		$("#iniciarSession").css("display","none");
		$("#registar").css("display","block");
	}
	function abrirLogin(){
		$("#registar").css("display","none");
		$("#iniciarSession").css("display","block");
	}

	$("#btnIniciarSession").click(function () {
		abrirLogin();
	});

	$("#registar").on("submit",function (form) {
		form.preventDefault();
		$obj = new Object();
		$obj.pNombre = $("#pNombre").val();
		$obj.pApellido = $("#pApellido").val();
		$obj.sNombre = $("#sNombre").val();
		$obj.sApellido = $("#sApellido").val();
		$obj.semestre = $("#semestre").val();
		$obj.usuario = $("#usuario1").val();
		$obj.pass = $("#contraseña1").val();

		console.log($obj.contraseña);

		$.ajax({
			url : localStorage.url+'/registro',
			dataType : 'JSON',
			type : 'POST',
			data : { usuario : $obj},
			success: function (data) {
				if(data == true){
					$("#myModal").modal('toggle');
					abrirLogin();
				}
			}
		});
	});


	$("#iniciarSession").on("submit",function (form) {
		form.preventDefault();
		$obj = new Object();
		$obj.usuario = $("#usuario").val();
		$obj.pass = $("#contraseña").val();

		$.ajax({
			url : localStorage.url+'/iniciarSession',
			dataType : 'JSON',
			type : 'POST',
			data : { usuario : $obj},
			success: function (data) {
				if(data == true){
					window.location.reload();
				}
				else{
					$("#error").css("display","block");
					$("#error").html("<h4 align='center' style='color: red;'>usuario y/o contraseña incorrecta</h4>");
				}
			}
		});

	});

	$("#cerrar").click(function () {
		window.location.href = localStorage.url+'/cerrarSession';
	});


	$("#jugar").click(function () {
		$("#verEstados").css("display","none");
		$("#juego").css("display","block");
	});

	function cargarEstados(){
		$.ajax({
			url : localStorage.url +"/verEstados",
			dataType : 'JSON',
			type : 'POST',
			success : function (data) {
				var string = '';
				for(var i in data){
					var estado = data[i].estado == 1 ? '<label style="color: #00ff60;">Winner</label>' : '<label style="color: red">Loser</label>';
					string += '<div class="row"">' +
						'<div class="col-sm-3">' +
						'<div class="well">' +
						'<h5 style="color:white;">'+data[i].usuario+'</h5>' +
						'<img src="<?=base_url()?>uploads/'+data[i].imagen+'" class="img-reponsive img-circle" height="67" width="55" alt="Avatar">' +
						'</div>' +
						'</div>' +
						'<div class="col-sm-9">' +
						'<div class="well">' +
						'<b style="color:white;"><h4>Pregunta</h4></b>' +
						'<p style="color:white;">'+data[i].pregunta+'</p>' +
						'<p style="color:white;">Estado: '+estado+'</p>' +
						'</div>' +
						'</div>' +
						'</div>'
				}
				$("#verEstados").html(string);
			}
		});
	}

	$("#estados").click(function () {
		$("#verEstados").css("display","block");
		$("#juego").css("display","none");
		reload();
		cargarPreguntas();
		cargarEstados();
	});

	$(document).ready(function () {
		cargarEstados();
	});


	function restarTiempo() {
		tiempo--;
		if(tiempo == 0){
			clearInterval($t);
			$('#imagen').attr("src","uploads/juego/murio.png");
			alert("Perdiste");
		}
		$("#tiempo").html(tiempo);
	}

	function escribirLetra(posicion) {
		var img = '';
		var bool = false;
		for (var i = 0; i < obj.repuesta.length; i++) {
			if (abcd[posicion].toUpperCase() == obj.repuesta[i].toUpperCase()) {
				letra += obj.repuesta[i];
				$("#x" + i + "").html(abcd[posicion].toUpperCase());
				bool = true;
			}
		}
		if (!bool) {
			if (contador >= 2 && contador <= 6) {
				img = 'punt' + contador + '.png';
				$("#intentos").html(contador);
			} else if (contador > 6) {
				clearInterval($t);
				img = 'murio.png';
				alert("Perdiste");
				registrarProgreso(0);
			}
			else {
				img = 'punt1.png';
			}
			console.log(img);
			$('#imagen').attr("src", "uploads/juego/" + img + " ");
			contador++;
		}

		for(var i=0;i<obj.repuesta1.length;i++){
			for(var j=0;j<letra.length;j++){
				if(obj.repuesta1[i] == letra[j]){
					vec[i] = obj.repuesta1[i];
				}
			}
		}
		var r  = vec.toString().toUpperCase().replace(/,/g,"");
		if( r.length == obj.repuesta1.length && r.toString().toUpperCase() == obj.repuesta1.toUpperCase()){
				clearInterval($t);
				$('#imagen').attr("src","uploads/juego/vivio.png");
				/*var str = "";
				for(var i in obj.repuesta1){
					str += "<td id='x"+i+"'>"+obj.repuesta[i]+"</td>";
				}
				$("#trTable").html(str);
				*/
				alert("ganaste");
				registrarProgreso(1);
		}
	}



	function reload(){
		$('#imagen').attr("src","uploads/juego/punt1.png");
		var string = '';
		for(var i = 0; i<abcd.length; i++){
			var l = abcd[i] == " " ? "ESPACIO" :  abcd[i] ;
			string += '<button onclick="escribirLetra('+i+')" style="background-color:#f2ffa0;">'+l+'</button>\n\n';
		}
		$("#abcd").html(string);
		vec = [];
		tiempo = 60;
		contador = 1;
		letra = "";
		$("#intentos").html("");
		clearInterval($t);
	}

	$("#nuevoJuego").click(function () {
		reload();
		vec = [];
		$("#escribirPregunta").html();
		cargarPreguntas();
		$t = setInterval(restarTiempo,1000);
	});


	function  cargarPreguntas() {
		$.ajax({
			url : localStorage.url+"/obtenerPreguntas",
			dataType : 'JSON',
			type : 'POST',
			success : function (data) {
				obj.pregunta = data.pregunta.toUpperCase();
				$("#escribirPregunta").html(obj.pregunta);
				obj.repuesta = data.repuesta.toUpperCase();
				obj.repuesta1 = data.repuesta.toUpperCase();
				$("#escribirPregunta").html(obj.pregunta);
				obj.idPregunta = data.idPregunta;
				var str  = "";
				for(var i in obj.repuesta){
					str += "<td id='x"+i+"'></td>";
				}
				$("#trTable").html(str);
			}
		});
	}

	function registrarProgreso(bool) {
		$.ajax({
			url : localStorage.url + "/registrarProgreso",
			dataType : 'JSON',
			type : 'POST',
			data:{
				idPregunta : obj.idPregunta,
				estado : bool
			},
			success : function (data) {
				console.log(data);
			}
		});
	}

	$("#fromPregunta").on("submit",function (form){
		form.preventDefault();
		if(confirm("desea Registrar esta pregunta")){
			$.ajax({
				url : localStorage.url + "/registrarPregunta",
				dataType : 'JSON',
				type : 'POST',
				data: {
					pregunta : $("#textPregunta").val(),
					repuesta : $("#textRepuesta").val()
				},
				success : function (data) {
					if(data == true){
						alert("pregunta guardada");
					}
				}
			});
		}
	});

	function mostrarInputFoto() {
		$("#exampleModal").modal("show");
	}
	$("#formInputFile").on("submit",function (form) {
		form.preventDefault();
		var formData = new FormData($(this)[0]);
		$.ajax({
			url: localStorage.url+"/guardarFoto",
			type: 'POST',
			dataType : 'JSON',
			data: formData,
			async: false,
			cache: false,
			contentType: false,
			processData: false,
			success: function (data) {
				if(data == true){
					alert("Foto actualizada, recarga la pagina");
				}
			}
		});
	});

</script>

</body>
</html>
