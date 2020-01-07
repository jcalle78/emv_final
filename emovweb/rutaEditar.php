<?php 
    include 'header.php';
    include 'codigophp/sesion.php';
	$menu=Sesiones("EMPRESADETRANSPORTE");
 ?>


<div class="container text-left mt-2">
	<div class="row">
    	<div class="col-md-6 offset-md-3">
			<div class="card">
      			<h3 class="card-header cyan white-text font-weight-bold text-center" id="titulo">RUTA</h3>
      			<div class="card-body">

					<form>
						<div class=" row">
							<label class="col-md-4 col-form-label">Nombre:<span style="color:red" >*</span></label>
							<div class="col-md-8">
								<input type='text' id= "nom" class="form-control form-control-sm text-uppercase"  maxlength="100"/>
							</div>
						</div>
						<div class="row">
							<label class="col-md-4 col-form-label">Descripcion:<span style="color:red" >*</span></label>
							<div class="col-md-8">
								<input type='text' id= "desc" class="form-control form-control-sm text-uppercase"  maxlength="50" />
							</div>
						</div>
                        
						<div class="row">
							<label class="col-md-4 col-form-label">Cupo Maximo:<span style="color:red" >*</span></label>
							<div class="col-md-5">
								<input type='number'id= "cupo" class="form-control form-control-sm" maxlength="10"/>
							</div>
						</div>	

						<div class="row">
							<label class="col-md-4 col-form-label">Color:<span style="color:red" >*</span></label>
							<div class="col-md-1">
								<input type="color" id="colorRuta" name="colorRuta" value="#ff0000">
							</div>
						</div>

						<div class="row">
							<label class="col-md-4 col-form-label">Estado:</label>
							<div class="col-md-5">
								<SELECT id="est" class="browser-default custom-select"> 
									<OPTION VALUE="1">ACTIVO</OPTION>
									<OPTION VALUE="0">INACTIVO</OPTION>
								</SELECT> 
							</div>
						</div>
					
						<div class="text-white row justify-content-center mt-3">
							<input class="btn cyan" onclick="IngMod(this)" type="submit" value="" id="metodo" name="metodo"/>		
							<input type="button" value="Cancelar" class="btn cyan" onclick="location.href = 'preruta.php';"/><br/>
						</div>						
					</form>					
				</div>
			</div>
      	</div>
	</div>
</div>


<script type="text/javascript">
	
	let parametro = new URLSearchParams(location.search);
	var metodo = parametro.get('metodo');		
	document.getElementById('metodo').value =metodo;
	var id;
	if(metodo=='Guardar'){				
		document.getElementById("est").disabled=true;	
	}if(metodo=='Modificar'){
		id= parametro.get('id');	
		(async () => {
			try{
				let response = await fetch(`${raizServidor}/rutas/${id}`)
				let data = await response.json();
				document.getElementById('nom').value = (data['nombre']);
				document.getElementById('desc').value = (data['descripcion']);
				document.getElementById('cupo').value = (data['cupoMaximo']);
				document.getElementById('colorRuta').value= (data['color']);
			}catch(e){
				toastr.error('Error al cargar algunos datos'); 	
			}
		})();			
	}	


	function IngMod(v) {	
		var nom = document.getElementById('nom');
		var desc = document.getElementById('desc');
		var cupo = document.getElementById('cupo');
		var est = document.getElementById('est');
		var colorRuta = document.getElementById('colorRuta');
		
		event.preventDefault();			

		if(nom.value == "")
		{
				toastr.error('Error en el nombre');
				nom.style.borderColor="red";
		}
		else
		{
			nom.style.borderColor="green";
			if(desc.value == "")
			{
					toastr.error('Error en la descripción');
					desc.style.borderColor="red";
			}
			else
			{
				desc.style.borderColor="green";
				if(cupo.value == "")
				{
						toastr.error('Error en el cupo asignado');
						cupo.style.borderColor="red";
				}
				else
				{
					cupo.style.borderColor="green";
					var parametros={'id':0,'nombre':nom.value.toUpperCase(),'descripcion':desc.value.toUpperCase(),'estado':est.value,'cupoMaximo':cupo.value,'color':colorRuta.value,'insId':0};		
					var url=`${raizServidor}/rutas`;
					if(v.value=="Guardar")
					{	
						Ingresar(parametros,url);
					}	
					if(v.value=="Modificar")
					{
						let param = new URLSearchParams(location.search);
						var id =param.get('id');
						let redirigir="preruta.php";
						Modificar(parametros,`${url}/${id}`,redirigir);
					}
				}
			}
		}	
	}

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
			BusInstituion(valor);
		}
	});
	</script>


 

<?php include 'footer.php'; ?>