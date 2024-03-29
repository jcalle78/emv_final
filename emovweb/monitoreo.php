<?php include 'header.php';?>
<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
<script src="leaflet-routing-machine-3.2.12/dist/leaflet-routing-machine.js"></script>
<script src="leaflet-routing-machine-3.2.12/src/Control.Geocoder.js"></script>

 <?php
	 session_start();
	 if (isset($_SESSION['id']) && isset($_SESSION['rol'])) {
			 
			 $id = $_SESSION['id'];
			 $rol = $_SESSION['rol'];               
			 $menu=$_SESSION['menu'];   
			 $institutoId=$_SESSION['institutoId'];
			 $nombreUser=$_SESSION['nombreUser'];

			 echo " <script> 
					 var IntitucionPrincipal=0;
					 window.onload = function()
					 { 
						 IntitucionPrincipal=$institutoId;
						 document.getElementById('name').innerHTML='$nombreUser';
						 document.getElementById('rol').innerHTML ='ROL: $rol';
						 document.getElementById('btncerrar').style.display = 'block';
					 };                      
					 </script>" ;
	 }else 
		 header('Location: ./');

  include 'funcionario_modal_selec_institucion.php';
  
  ?>


<div class="container-fluid grey pr-0 pl-0">
		<?php 
		echo $menu 
		?>
</div>


<div class="container-fluid my-2">
	<div class="row ml-2">
		<div class="col-md-4 m-0  card">
      	
			<div class="h3 text-left font-weight-bold">Filtros</div>

			<div class=" row">
					<label class="col-md-3  col-form-label align-self-center">Instituci&oacute;n:<span style="color:red" >*</span></label>
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
			
			<div class="row mt-3">
				<div class="h4 text-left font-weight-bold col-md-6">Rutas</div>
			</div>
			<div class="row border">
				<div class="col-md-12">
					<div class='table-responsive-sm my-custom-scrollbar'>
                        <table id="tablaRutas" class='table-sm table table-hover text-center' cellspacing='0' width='100%'>
                            <thead class='cyan white-text'>
                            <tr>
								<th scope='col'>ID</th>
								<th scope='col'>RUTA</th>
								<th scope='col'>SELECCIONAR</th>
							</tr>
                        </thead>
                        <tbody  id="listaRutas" class='dt-select' >
                            <!-- AQUI SE CARGA LA TABLA CON LOS REGISTROS -->
                        </tbody>
                        </table>
                    </div>

				</div>
			</div>

			<div class="row mt-3">
				<div class="h5 text-left font-weight-bold col-md-6">Fechas</div>
			</div>
			<div class="row border-bottom">
				<label class="col-md-2 col-form-label  align-self-center">Desde:</label>
				<div class="col-md-4 align-self-center">
					<input type="date" id= "fdesde" class="form-control text-uppercase form-control-sm"/>
				</div>
				<label class="col-md-2 col-form-label  align-self-center">Hasta:</label>
				<div class="col-md-4 align-self-center">
					<input type="date" id= "fhasta" class="form-control text-uppercase form-control-sm"/>
				</div>
			</div>

			<div class="row mt-3">
				<div class="h5 text-left font-weight-bold col-md-12">Datos del Conductor y Vehículo</div>
			</div>

			<div class="row ">
				<label class="col-md-3 col-form-label  align-self-center">Nombre:</label>
				<div class="col-md-8 align-self-center">
					<input type="text" id= "nomC" class="form-control text-uppercase form-control-sm" readonly disabled />
				</div>
			</div>
			<div class="row ">
				<label class="col-md-3 col-form-label  align-self-center">Placa:</label>
				<div class="col-md-8 align-self-center">
					<input type="text" id="plc" class="form-control text-uppercase form-control-sm" readonly disabled />
				</div>
			</div>

		</div>


		<div class="col-md-8 p-2">
			<div class="container">
				<div class="row">
					<div class="col-md-1 text-right">
						<div class="circuloAzul"></div>
					</div>
					<div class="col-md-3 text-left">
						<div class="">Paradas visitadas</div>
					</div>
				</div>
				<div class="row mt-1">
					<div class="col-md-1">
						<div class="circuloRojo"></div>
					</div>
					<div class="col-md-3">
						<div >Paradas no visitadas</div>
					</div>
				</div>
				<div class="row mt-2">
					<div id="map" style="width: 100%; height: 550px;"></div>
				</div>
			</div>
			
		</div>
	</div>
</div>


<script>

n =  new Date();
y = n.getFullYear();
m = n.getMonth() + 1;
d = n.getDate();

if(m<10)
	m="0"+m;
if(d<10)
	d="0"+d;


//Lo ordenas a gusto.
document.getElementById("fhasta").value = `${y}-${m}-${d}`;
document.getElementById("fdesde").value = `${y}-${m}-${d}`;

var institutoMonitoreo=true;
var idRutas=[];

function cargarRutas(id)
{
	
	var result=`<td></td>
			<td class=" text-center"><div class="spinner-border text-center" role="status">
			<span class="sr-only">Loading...</span>
			</div></td>`;
	document.getElementById('listaRutas').innerHTML =result;
	var url=`http://localhost:8888/rutas?opcion=2&id=`+id+`&id2=0&campo=0&bus=0&est=0`;
	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
		result=``;
		if(produ.length > 0)
		{
			for(let prod of produ){						
			result += `<tr> 
						<td class="boton">${prod.id}</td>
						<td class="boton">${prod.nombre}</td> 
						<td><input type="checkbox" name="check" class="case" /></td>
						</tr>`;								
								
			}
			
		}
		else{
			result= `<tr> 
						<td></td>
						<td>No se encuentran coincidencias</td> 
						</tr>`;	
		}
		document.getElementById('listaRutas').innerHTML =result;
		let elementos=document.getElementsByClassName('boton');

		$(".dt-select tr ").click(function(){
			$(this).addClass('filaSeleccionada').siblings().removeClass('filaSeleccionada'); 
			
			
		});

		
		$("input.case").click(myfunc);

		return produ;				
		})		
		.catch(error => { console.log("error",error); return error; });
}

var layers=[];
var layers2=[];
var intervalos=[];
var conductores=[];

function myfunc(ele) {

	var values = new Array();
	var cont=true;
	  $.each($("input[name='check']:checked").closest("td").siblings("td"),
			 function () {
				 if(cont)
				 {
					values.push($(this).text());
					cont=false;
				 }
				 else{
					 cont=true;
				 }
				 
			 });
			 control.setWaypoints(null);
   	if(intervalos.length > 0 )
	{
		for(var i=0;i<intervalos.length;i++)
		{
			
			clearInterval(intervalos[i]);
		}
	}
	if(layers2.length > 0 )
	{
		for(var i=0;i<layers2.length;i++)
		{
			layers2[i].clearLayers();
		}
	}
	if(layers.length > 0 )
	{
		for(var i=0;i<layers.length;i++)
		{
			layers[i].clearLayers();
		}
	}

	if(values.length>0)
	{
		intervalos=[];
		for(var i=0;i<values.length;i++)
		{
			cargarListaParadas(values[i]);
			cargar(values[i]);
		}
	}
	
	
}

function cargarListaParadas(id)
{
	let url= `http://localhost:8888/parada?opcion=1&dato=${id}`;

	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
		
		if(produ.length > 0)
		{
			var layerGroup2 = L.layerGroup().addTo(map)
			layers.push(layerGroup2);
			var cords=[];
			for(let prod of produ){	
				cords.push(L.latLng(prod.latitud,prod.longuitud));	
			}
			
			control.setWaypoints(cords);
			for(let prod of produ){	

				agregarMarcadorRojo(prod.latitud,prod.longuitud,prod.nombre,layerGroup2);							
								
			}
			
		}
		return produ;	
		})		
		.catch(error => { console.log("error",error); return error; });
}

function cargar(id)
{
	cargarUbicaciones(id);
	cargarVehiculos(id);
	var pasos = setInterval(function(){
        cargarUbicaciones(id);
	}, 3000); 

	intervalos.push(pasos);
	
}

		 
function cargarVehiculos(id)
{
	var cont=0;
	var funid=0;
	var result=``;
	let url= `http://localhost:8888/rutaVehiculo?id=${id}`;

	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
		
		if(produ.length > 0)
		{
			for(let prod of produ)
			{
				if(cont==0)
				{
					document.getElementById('plc').value=prod.placa;
					funid=prod.fun_id;
					cont++;
				}
								
			}
			
		}
		cargarFuncionario(funid);
	return produ;				
	})		
	.catch(error => { console.log("error",error); return error; });
}




function cargarFuncionario(id)
{
	var cont=0;
	var result=``;
	let url= `http://localhost:8888/funcionario/${id}`;

	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
		
		document.getElementById('nomC').value=produ.nombre+" "+produ.apellido;
			
		
	return produ;				
	})		
	.catch(error => { console.log("error",error); return error; });
}	



function cargarUbicaciones(id)
{
	
	var fechaActual=document.getElementById('fdesde').value;
	var url=`http://localhost:8888/monitoreo?id=${id}&fecha=${fechaActual}`;
	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
		var layerGroup = L.layerGroup().addTo(map);
		layers2.push(layerGroup);
		for(let prod of produ){			
			agregarMarcadorAzul(prod.latitud,prod.longuitud,prod.nombre,layerGroup);	
			cont++;									
		}
		return produ;				
		})		
		.catch(error => { console.log("error",error); return error; });

}


</script>



<script>


			var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
				osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
				osm = L.tileLayer(osmUrl, {maxZoom: 16, attribution: osmAttrib});

			var cont=1;
			var map = L.map('map').setView([-2.901866, -79.006055], 14).addLayer(osm);
			map.doubleClickZoom.disable();

			var control = L.Routing.control(L.extend( {
				waypoints: [null],
				routeWhileDragging: true,
				reverseWaypoints: true,
				showAlternatives: true,
				altLineOptions: {
					styles: [
						{color: 'black', opacity: 0.15, weight: 9},
						{color: 'white', opacity: 0.8, weight: 6},
						{color: 'red', opacity: 0.5, weight: 2}
					]
				}
			})).addTo(map);
			
			//Marcador en la Ciudad de Cuenca				
			/*L.marker([-2.901866, -79.006055],{title: '1'})
				.addTo(map)
				.bindPopup('Ciudad de Cuenca.')
				.openPopup();*/
			
				var redIcon = new L.Icon({
					iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-red.png',
					shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
					iconSize: [25, 41],
					iconAnchor: [12, 41],
					popupAnchor: [1, -34],
					shadowSize: [41, 41]
					});


			

			function agregarMarcadorRojo(lat,lng,num,grupo)
			{
				L.marker([lat, lng], {icon: redIcon}).addTo(grupo)
				.bindPopup(`${num}`)
				.openPopup();
			}

			function agregarMarcadorAzul(lat,lng,num,grupo)
			{
				L.marker([lat, lng]).addTo(grupo)
				.bindPopup(`${num}`)
				.openPopup();
			}
			
			function createButton(label, container) 
			{
				var btn = L.DomUtil.create('button', '', container);
				btn.setAttribute('type', 'button');
				btn.innerHTML = label;
				return btn;
			}

			
			
			// function onLocationFound(e) 
			// {
			// 	var radius = e.accuracy / 2;

			// 	L.marker(e.latlng).addTo(map)
			// 		.bindPopup("You are within " + radius + " meters from this point").openPopup();

			// 	L.circle(e.latlng, radius).addTo(map);
			// }

			map.on('locationfound', onLocationFound);
			map.on('locationerror', onLocationError);

			map.locate({setView: true, maxZoom: 16});
			
			L.Routing.errorControl(control).addTo(map);

			L.Routing.Formatter = L.Class.extend({
				options: {
					language: 'sp'
				}
			});
</script>


<?php include 'footer.php'; ?>
