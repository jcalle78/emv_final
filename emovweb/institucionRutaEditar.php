<?php include 'header.php'; 
	include 'codigophp/sesion.php';
	$menu=Sesiones("EMOV");
	
	include 'funcionario_modal_selec_institucion.php';
	include 'modal_ruta.php';
?>

<div class="container text-align-left mt-2 ">
	<div class="row">
    	<div class="col-md-6 offset-md-2">
			<div class="card">
				<h3 class="card-header cyan white-text text-uppercase font-weight-bold text-center" id="titulo">INSTITUCION EDUCATIVA - RUTA</h3>
      			<div class="card-body">
						<!--AQUI VA EL FORMULARIO DE INGRESO Y EDICION -->
                    <form>	
                        <h5 class="container text-center mt-3 text-uppercase"><strong >Datos de la Institución </strong></h5>
						<div class=" row">
								<label class="col-md-3  col-form-label align-self-center">Código:<span style="color:red" >*</span></label>
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
								<div class="col-md-8 align-self-center">
									<input type="text" id= "nomInst" class="form-control text-uppercase form-control-sm" readonly disabled />
								</div>										
							</div>


						<h5 class="container text-center mt-3 text-uppercase"><strong >Datos de la Ruta </strong></h5>
						<div class=" row">
							<label class="col-md-3  col-form-label align-self-center">Código:<span style="color:red" >*</span></label>
							<div class="col-md-3 align-self-center">
								<input type='text' id= "idRuta" class="form-control form-control-sm " />
							</div>
				<!-- BOTON MODAL.... en la cabecera importo el modal -->
							<div class="col-sm-0 align-self-center" id="buscar">
								<a class="btn grey" href="#" role="button" data-toggle="modal" data-target="#modalRutas"><i class="fas fa fa-search "></i></a>
							</div>	
						</div>
							
						<div class="row ">
							<label class="col-md-3 col-form-label  align-self-center">Nombre:</label>
							<div class="col-md-8 align-self-center">
								<input type="text" id= "nomRuta" class="form-control text-uppercase form-control-sm" readonly disabled />
							</div>
									
						</div>

						<div class="row">
                            <label class="col-md-3 col-form-label">Estado: <span class="text-danger">* </span></label>
                            <div class="col-md-6">
                                <SELECT id="estado"  class="browser-default custom-select"> 
                                    <OPTION VALUE="1" selected >ACTIVO</OPTION>
                                    <OPTION VALUE="0">INAACTIVO</OPTION>
                                </SELECT> 
                            </div>
                        </div>		
						
						<div class="text-white row justify-content-center mt-3">
							<input class="btn cyan" onclick="IngMod(this)" type="submit" value="" id="metodo" name="metodo"/>		
							<input type="button" value="Cancelar" class="btn cyan" onclick="location.href = 'institucionRuta.php';"/><br/>
						</div>

										
					</form>		

                </div>
			</div>
      	</div>
	</div>
</div>

<?php include 'footer.php'; ?>

<script type="text/javascript">
	var institutoMonitoreo =false;

	let parametro = new URLSearchParams(location.search);
	var metodo = parametro.get('metodo');		
	document.getElementById('metodo').value =metodo;
	var insId, rutaId;
	if(metodo=='Guardar'){				
		document.getElementById("estado").disabled=true;	
	}if(metodo=='Modificar'){
		insId = parametro.get('insId');
		rutaId = parametro.get('rutaId');	
		document.getElementById('idInst').value = insId;
		document.getElementById('idRuta').value = rutaId;				
		BusInstitucion(insId);
		BusRuta(rutaId);				
	}	


function IngMod(v) {						
	event.preventDefault();	

	if((idInst.value=="")||(nomInst.value=="") ){
		toastr["error"]("Seleccione una Institución", "Dato Incorrecto!");
		idInst.style.borderColor="red";
		nomInst.style.borderColor="red";
	}else{
		idInst.style.borderColor='green';
		nomInst.style.borderColor="green";	
		if((idRuta.value=="")||(nomRuta.value=="") ){
			toastr["error"]("Seleccione una Ruta", "Dato Incorrecto!");
			idRuta.style.borderColor="red";
			nomRuta.style.borderColor="red";
		}else{
			idRuta.style.borderColor='green';
			nomRuta.style.borderColor="green";	

			var parametros={"insId": idInst.value,"rutaId":idInst.value,"insNombre":"","rutaNombre":"","rutaCupo":0,"estado": document.getElementById("estado").value};							
			console.log("ty",parametros);
			var urlRutaIns=`${raizServidor}/institucionRuta`;
			if(v.value=="Guardar"){	
				Ingresar(parametros,urlRutaIns);
			}	
			if(v.value=="Modificar"){
				// let para = new URLSearchParams(location.search);				
				// var id=para.get('id');
				// let redirigir="tipoSentido.php";
				// Modificar(parametros,`${url}/${id}`,redirigir);
			}
		}
	}
}

function BusInstitucion(insid){		
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
		BusInstitucion(valor);
	}
});

	function BusRuta(ruta){		
		fetch(`http://localhost:8888/rutas/${ruta}`)
			.then(response => response.json())
			.then(data => {		  	
				var dato=`${data.nombre}`;
				document.getElementById('nomRuta').value = dato;										
		})  
		.catch(error => { 
			toastr.error('No  existe la Ruta'); console.log(error);
			document.getElementById('nomRuta').value = "";	
		})	
	}
	$('#idRuta').keypress(function (e) {	
		if (e.which == 13) {
			event.preventDefault();	
			var valor=e.target.value;
			BusRuta(valor);
		}
	});
	</script>