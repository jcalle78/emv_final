
<?php include 'header.php'; 
    include 'codigophp/sesion.php';
	$menu=Sesiones("EMPRESADETRANSPORTE"); 
	include 'funcionario_modal_selec_institucion.php'; 
?>

<script type="text/javascript">
function desactivar()
	{
		var x = document.getElementById("myCheck").checked;
	document.getElementById("des").value = x;
	}
$(document).ready(function(){
  $("#bte").click(function(){
	$("#formr").hide();
	$("#forme").show();
  });
  $("#btr").click(function(){
	$("#forme").hide();
	$("#formr").show();
  });
});
</script>
<body >
	<!-- JQuery y toastr -->
	<script type="text/javascript" src="js/jquery-3.4.1.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
	<?php
		include 'funcionario_modal_selec_institucion.php';
	?>

<div class="container text-left mt-2 text-uppercase">
	<div class="row">
    	<div class="col-md-6 offset-md-3">
			<div class="card">
      			<h3 class="card-header cyan white-text text-uppercase font-weight-bold text-center py-5" id="titulo">IMPORTAR</h3>
      			<div class="card-body">

						<div class="container">

	<div class="row mt-3 pt-3">
    <div class="col">
	<input type="button" value="Estudiantes" class="btn btn-cyan"  id="bte" >
                <input type="button" value="Representantes" class="btn btn-cyan" id=btr><br/>
	<form action="control.php?id=e" method='post' enctype="multipart/form-data" id="forme" style="display: none;">

		<h5 class="container text-center mt-2 text-uppercase"><strong >Datos de la Institucion </strong></h5>
			Desactivar  periodos anteriores: <input type="checkbox" id="myCheck" class="case" >
			<input type='hidden' id= "des" value="false" name="des" >
			<script>$("input.case").click(desactivar);</script>
				<div class=" row">
						<label class="col-md-3  col-form-label align-self-center">Código:</label>
						<div class="col-md-3 align-self-center">
							<input type='text' id= "idInst" class="form-control form-control-sm " />
						</div>

	<!-- BOTON MODAL.... en la cabecera importo el modal -->
						<div class="col-sm-0 align-self-center" id="buscar">
								<a class="btn grey" href="#" role="button" data-toggle="modal" data-target="#centralModalSm"><i class="fas fa fa-search "></i></a>

							</div>

					</div>

						<div class="row ">
					<label class="col-md-3 col-form-label  align-self-center">Nombre:</label>
					<div class="col-md-9 align-self-center">
						<input type="text" id= "nomInst" class="form-control text-uppercase form-control-sm" readonly disabled />

					</div>
					Importar Archivo : <input type='file' name='sel_file' size='20'>
					<input type='hidden' id="inst" name="inst" size='20'>
				</div>
		<input type='submit' name='submit' value='guardar'class="btn btn-cyan">
		<input type="button" value="Cancelar" class="btn btn-cyan" onclick="location.href = 'fun_listarM.php';"/><br/>
	</form>

	<form action='control.php?id=r' method='post' enctype="multipart/form-data" id="formr" style="display: none;">

			<h5 class="container text-center mt-2 text-uppercase"><strong >Datos de la Institucion </strong></h5>

			<input type='hidden' id= "des" value="false" name="des" >
			<input type='hidden' id="inst" name="inst" size='20'>
							<div class="row ">
						Importar Archivo : <input type='file' name='sel_file' size='20'>
					</div>
			<input type='submit' name='submit' value='submit'class="btn btn-cyan">
			<input type="button" value="Cancelar" class="btn btn-cyan" onclick="location.href = 'fun_listarM.php';"/><br/>
	</form>
	<div class="mt-5" id="alerta"></div>
	</div></div></div>




				</div>
			</div>
      	</div>
	</div>
</div>





	<script type="text/javascript">




	function BusInstituion(insid){
		fetch(`http://localhost:8888/institucion/${insid}`)
			.then(response => response.json())
			.then(data => {
				var dato=`${data.nombre}`;
				document.getElementById('nomInst').value = dato;
		})
		.catch(error => {
			toastr.error('No  existe la institucion'); console.log(error);
			document.getElementById('nomInst').value = "";
		})
	}
	$('#idInst').keypress(function (e) {
		if (e.which == 13) {
			event.preventDefault();
			var valor=e.target.value;
			document.getElementById('inst').value=valor;
			BusInstituion(valor);

		}
	});
	</script>
<?php include 'footer.php'; ?>
