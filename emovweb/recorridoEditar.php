<?php 
    include 'header.php';
    include 'codigophp/sesion.php';
	$menu=Sesiones("EMPRESADETRANSPORTE");
 ?>

<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
<script src="leaflet-routing-machine-3.2.12/dist/leaflet-routing-machine.js"></script>
<script src="leaflet-routing-machine-3.2.12/src/Control.Geocoder.js"></script>

<div class="container-fluid mt-2" >
	<div class="row ">
		<div class="col-md-5 m-0  card" ">
			<div class="container-fluid m-0 p-0">
				<div class="row">
					<div class="col-md-12">
						
						<form class="needs-validation text-left mt-1">	
						<h3 class="card-header cyan white-text font-weight-bold text-center  p-1" >Recorrido</h3>
						<div class="form-group row mt-1">
								<label class="col-md-3 col-form-label">Hora inicio:<span style="color:red" >*</span></label>
								<div class="col-md-3">
									<input type='time' id= "inicioRuta" name="inicioRuta" class="form-control" required/>
								</div>
								<label class="col-md-3 col-form-label">Hora fin: <span style="color:red" >*</span></label>
								<div class="col-md-3">
									<input type='time' id= "finRuta" name="finRuta"  class="form-control" required/>
								</div>
							</div>
							
							<div class="form-group row">
								<label class="col-md-3 col-form-label">Sentido<span style="color:red" >*</span></label>
								<div class="col-md-3">
									<SELECT id="listaSentido"  class="browser-default custom-select"> 
									</SELECT> 
								</div>
								<label class="col-md-3 col-form-label">Estado:<span style="color:red" >*</span></label>
								<div class="col-md-3">
									<SELECT id="estado"  class="browser-default custom-select"> 
										<OPTION VALUE="1" selected >ACTIVO</OPTION>
										<OPTION VALUE="0">INACTIVO</OPTION>
									</SELECT> 
								</div>
							</div>						
						</form>
					</div>		
				</div>
				
				<div class='table-responsive-sm my-custom-scrollbar mt-5'>
						<table id='dt-select' class='table-sm table table-hover text-center' cellspacing='0' width='100%'>
						<thead class='cyan white-text'>
							<tr>
								<th scope="col">ORDEN</th>
								<th scope="col">NOMBRE</th>
								<th scope="col">UBICACI&Oacute;N</th>
                                <th scope="col">IDENTIFICACIÓN</th>
							</tr>
						</thead>
						<tbody  id="listaParadas" >
							<!-- AQUI SE CARGA LA TABLA CON LOS REGISTROS -->
						</tbody>
						</table>
					</div> 	

				<div class="row justify-content-end mt-3 mr-5">
					<input value="Guardar" class="btn cyan text-white" onclick="IngMod(this)" type="submit" value="" id="metodo" name="metodo"/>
                    <input type="button" value="Cancelar" class="btn cyan text-white" onclick="location.href = 'preruta.php';"/><br/>
				</div>
			</div>
			
		</div>
		<div class="col-md-7 p-3">
			<div id="map" style="width: 100%; height: 550px;"></div>
		</div>
	</div>	
</div>

<div class="modal fade" id="modalNombres" tabindex="-1" role="dialog" aria-labelledby="tittle"
  aria-hidden="true">

  <!-- Change class .modal-sm to change the size of the modal -->
  <div class="modal-dialog modal-md" role="document">

    <div class="modal-content">
        <div class="modal-header text-center m-0 p-0 cyan">
            <h4 class="modal-title w-100 text-white text-center" id="title">Asignar nombre de parada</h4>
            </button>
        </div>
        <div class="modal-body" id="cuerpoModal">
			<div class="row">
				<label class="col-md-4 col-form-label">Nombre:</label>
				<div class="col-md-8"><input type="text" id="txtNombreParada" name="textBuscar" class="form-control text-uppercase"></div>
			</div>
			<div class="row mt-2">
				<label class="col-md-4 col-form-label">Orden:</label>
				<div class="col-md-4"><input type="number" id="txtOrden" name="textBuscar" class="form-control text-uppercase"></div>
			</div>
            <div class="row justify-content-center mt-3">
                <div class=""><input type="button" value="Guardar" class="btn white" onclick="agregarNombreParada();"  /></div>
                <div class=""><input type="button" value="Cancelar" class="btn white" data-dismiss="modal"/><br/></div>
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
    cargarComboSentido();

	if(metodo=='Modificar'){
		id= parametro.get('id');	
		(async () => {
			try{
				let response = await fetch(`${raizServidor}/recorrido/${id}`)
				let data = await response.json();
				document.getElementById('inicioRuta').value = (data['horaInicio']);
				document.getElementById('finRuta').value = (data['horaFin']);
                document.getElementById('listaSentido').value = (data['senId']);
                document.getElementById('estado').value = (data['estado']);
                cargarListaParadas(id);
			}catch(e){
				toastr.error('Error al cargar algunos datos'); 	
			}
		})();			
	}	

    async function cargarComboSentido(){
		const listaSentido=document.querySelector('#listaSentido');
		listaSentido.innerHTML=``;
		try {
			var url=`http://localhost:8888/sentido?campo=sen_nombre&bus=&est=1`;			
			let response = await fetch(url)
			let data = await response.json();					
			var result = ``;						
			for(let pro of data){
				result +='<OPTION VALUE=' + pro.id + '>' + pro.nombre + '</OPTION>';		
			}			
			listaSentido.innerHTML = result;	
		}catch(e)
		{
			listaSentido.innerHTML =`<div>No se encuentran resultados</div>`; 	
		}
	}

	function IngMod(v) {	
        var inicio=document.getElementById('inicioRuta').value;
        var fin=document.getElementById('finRuta').value;
        var sentido=document.getElementById('listaSentido').value;
        var estado=document.getElementById('estado').value;
		
		event.preventDefault();			
        var datos=control.getWaypoints();
        for(let pro of datos)
        {
            console.log(pro.latLng.lat);
            console.log(pro.latLng.lng);		
		}
		// if(nom.value == "")
		// {
		// 		toastr.error('Error en el nombre');
		// 		nom.style.borderColor="red";
		// }
		// else
		// {
		// 	nom.style.borderColor="green";
		// 	if(desc.value == "")
		// 	{
		// 			toastr.error('Error en la descripción');
		// 			desc.style.borderColor="red";
		// 	}
		// 	else
		// 	{
		// 		desc.style.borderColor="green";
		// 		if(cupo.value == "")
		// 		{
		// 				toastr.error('Error en el cupo asignado');
		// 				cupo.style.borderColor="red";
		// 		}
		// 		else
		// 		{
		// 			cupo.style.borderColor="green";
		// 			var parametros={'id':0,'nombre':nom.value.toUpperCase(),'descripcion':desc.value.toUpperCase(),'estado':est.value,'cupoMaximo':cupo.value,'color':colorRuta.value,'insId':0};		
		// 			var url=`${raizServidor}/rutas`;
		// 			if(v.value=="Guardar")
		// 			{	
		// 				Ingresar(parametros,url);
		// 			}	
		// 			if(v.value=="Modificar")
		// 			{
		// 				let param = new URLSearchParams(location.search);
		// 				var id =param.get('id');
		// 				let redirigir="preruta.php";
		// 				Modificar(parametros,`${url}/${id}`,redirigir);
		// 			}
		// 		}
		// 	}
		// }	
	}

    var cords=[];
    function cargarListaParadas(id)
    {
        var valores=``;
        let url= `http://localhost:8888/parada?opcion=3&dato=${id}`;

        fetch(url)
        .then((res) => {return res.json(); })
        .then(produ => {
            
        if(produ.length > 0)
        {
            for(let prod of produ)
            {   
                valores+=` <tr>
                        <td>${prod.orden}</td>
					    <td>${prod.nombre}</td>
                        <td>${prod.latitud},${prod.longuitud}</td>
                        <td>${prod.id}</td>
                    </tr>`;

                agregarMarcadorAzul(prod.latitud,prod.longuitud,prod.nombre,layerGroup);
                // cords.push(L.latLng(prod.latitud,prod.longuitud));	
            }
            
            
        }
        else
        {
            valores+='No se han encontrado coincidencias';
        }
        control.setWaypoints(cords);
        document.getElementById('listaParadas').innerHTML=valores;
        return produ;	
        })		
        .catch(error => { console.log("error",error); return error; });
    }

    var vecNombre=[];
    var vecOrden=[];
    function agregarNombreParada()
	{
		
		var n=document.getElementById("txtNombreParada").value;
		var o=document.getElementById("txtOrden").value;
		var listanombres="";
		if(n == "")
		{
			toastr.error('Datos de nombre');
			document.getElementById("txtNombreParada").style.borderColor="red";
		}
		else
		{
			if(o == "")
			{
				toastr.error('Datos de nombre');
				document.getElementById("txtOrden").style.borderColor="red";
			}
			else
			{
				vecNombres.push(n);
				vecOrden.push(o);
				document.getElementById("txtNombreParada").value="";
				document.getElementById("txtOrden").value="";
				$('#modalNombres').modal('hide');
				vec.push(e.latlng.toString());
				actualizarLista();
			}
			
		}
	}

</script>

<script>


    var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
        osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
        osm = L.tileLayer(osmUrl, {maxZoom: 16, attribution: osmAttrib});

    var cont=1;
    var map = L.map('map').setView([-2.901866, -79.006055], 14).addLayer(osm);
    map.doubleClickZoom.disable();
    var control = L.Routing.control({

        routeWhileDragging: true,
        reverseWaypoints: true,
        showAlternatives: true,
        altLineOptions: {
            styles: [
                {color: 'black', opacity: 0.15, weight: 9},
                {color: 'white', opacity: 0.8, weight: 6},
                {color: 'blue', opacity: 0.5, weight: 2}
            ]
        }
        //geocoder: L.Control.Geocoder.nominatim()
    }).addTo(map);
    

    var layerGroup = L.layerGroup().addTo(map);
    //Marcador en la Ciudad de Cuenca				
    /*L.marker([-2.901866, -79.006055],{title: '1'})
        .addTo(map)
        .bindPopup('Ciudad de Cuenca.')
        .openPopup();*/
    

    function createButton(label, container) {
    var btn = L.DomUtil.create('button', '', container);
    btn.setAttribute('type', 'button');
    btn.setAttribute('class', 'boton_personalizado');
    btn.innerHTML = label;
    return btn;
    }

    map.on('dblclick', function(e) 
    {
        var container = L.DomUtil.create('div'),
            startBtn = createButton('Comenzar ruta aquí', container),
            interBtn = createButton('Realizar parada aquí', container),
            destBtn = createButton('Finalizar ruta aquí', container),
            delBtn = createButton('Eliminar última parada', container);

    
        L.popup()
            .setContent(container)
            .setLatLng(e.latlng)
            .openOn(map);
            
              
        L.DomEvent.on(interBtn, 'click', function() 
        {
            $('#modalNombres').modal('show');
            agregarMarcadorAzul(e.latlng.lat,e.latlng.lng,"",layerGroup);
            map.closePopup();
        });
        
    });
    
    
    // function onLocationFound(e) 
    // {
    // 	var radius = e.accuracy / 2;

    // 	L.marker(e.latlng).addTo(map)
    // 		.bindPopup("You are within " + radius + " meters from this point").openPopup();

    // 	L.circle(e.latlng, radius).addTo(map);
    // }

    function agregarMarcadorAzul(lat,lng,num,grupo)
    {
        L.marker([lat, lng],{draggable:'true'}).addTo(grupo)
        .bindPopup(`${num}`)
        .openPopup();
    }

    function onLocationError(e)
    {
        alert(e.message);
    }

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