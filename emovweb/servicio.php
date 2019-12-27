<?php 
    include 'header.php';
?>

<script src="https://unpkg.com/leaflet@1.0.2/dist/leaflet.js"></script>
<script src="leaflet-routing-machine-3.2.12/dist/leaflet-routing-machine.js"></script>
<script src="leaflet-routing-machine-3.2.12/src/Control.Geocoder.js"></script>


<div class="container mt-2">
    <div class="row justify-content-center ">
        <div class="col-md-10 ">
            <form action="">
                <h3 class="card-header cyan white-text font-weight-bold text-center p-0 m-0" >Solicitud de servicio</h3>
                
                <div class="row">
                    <label class="col-md-3 col-form-label  align-self-center">Fecha Registro:</label>
                    <div class="col-md-3 align-self-center">
                        <input type="date" id= "fregistro" class="form-control text-uppercase form-control-sm" readonly disabled/>
                    </div>

                    <label class="col-md-3 col-form-label  align-self-center">Fecha Finalizaci&oacute;n:</label>
                    <div class="col-md-3 align-self-center">
                        <input type="date" id="ffin" class="form-control text-uppercase form-control-sm"/>
                    </div>
                </div>
                
                <!-- SELECCIONAR INSTITUCION-->
                <div class="row ">
                    <label class="col-md-3 col-form-label  align-self-center">Institución Educativa:</label>
                    <div class="col-md-3 align-self-center">
                        <input type="text" id= "nomInst" class="form-control text-uppercase form-control-sm" readonly disabled />
                    </div>
                    <label class="col-md-3 col-form-label  align-self-center">Estado:</label>
                    <div class="col-md-3 align-self-center">
                        <SELECT id="estado"  class="browser-default custom-select"> 
                            <OPTION VALUE="1" selected >ACTIVO</OPTION>
                            <OPTION VALUE="0">INACTIVO</OPTION>
                        </SELECT> 
                    </div>	
                            
                </div>
                 <!-- FIN SELECCIONAR INSTITUCION-->

                <div class="row mt-2">
                    <label class="col-md-3 col-form-label  align-self-center">Observaci&oacute;n:</label>
                    <textarea class="form-control col-md-8 ml-3" id="observacion" rows="2"></textarea>
                </div>

                <div class="row mt-2 mb-1">
                    <label class="col-md-3 col-form-label  align-self-center">Tipo de Servicio:</label>
                    <div class="col-md-3 align-self-center" id="tservicio">
                    </div>
                    <label class="col-md-3 col-form-label  align-self-center">Periodo Lectivo:</label>
                    <div class="col-md-3 align-self-center" id="plectivo">
                    </div>	
				</div>


                <div class="row mt-2 mb-1">
                    <label class="col-md-3 col-form-label  align-self-center">Seleccione Estudiante:</label>
                    <div class="col-md-5 align-self-center" id="estudiante">
                    </div>
				</div>

                 <!-- SELECCIONAR CONDUCTOR -->
                <h5 class="text-center" id="tituloRuta"><strong>Lista de Rutas Disponibles</strong></h5>
				<div class=" row" id="divRuta">
                    <div class=' col-md-12 justify-content-center table-responsive-sm my-custom-scrollbar'>
                        <table id="tablaRutas" class='table-sm table table-hover text-center' cellspacing='0' width='100%'>
                            <thead class='cyan white-text'>
                            <tr>
                                <th scope='col'>NRO</th>
								<th scope='col'>NOMBRE</th>
								<th scope='col'>ID</th>
							</tr>
                        </thead>
                        <tbody  id="listaRutas" class='dt-select' >
                            <!-- AQUI SE CARGA LA TABLA CON LOS REGISTROS -->
                        </tbody>
                        </table>
                    </div>
                </div>
                <!-- FIN SELECCIONAR CONDUCTOR-->

                <!-- SELECCIONAR CONDUCTOR -->
                <h5 class="text-center"><strong>Datos del Conductor y Vehículo </strong></h5>
                <div class="row ">
                    <label class="col-md-3 col-form-label  align-self-center">Nombres:</label>
                    <div class="col-md-4 align-self-center">
                        <input type="text" id= "nomC" class="form-control text-uppercase form-control-sm" readonly disabled />
                    </div>
                    <label class="col-md-2 col-form-label  align-self-center">Placa:</label>
                    <div class="col-md-3 align-self-center">
                        <input type="text" id= "plc" class="form-control text-uppercase form-control-sm" readonly disabled />
                    </div>	
                </div>
                <!-- FIN SELECCIONAR CONDUCTOR-->

                <div class="row ">
                    <label class="col-md-12 col-form-label  align-self-center blue-grey-text text-center" id="textoElegirServicio"></label>
				</div>


                <div class="row my-2">
                    <div id="map" style="width: 100%; height: 400px;"></div>
				</div>

                <div class="row justify-content-center mt-3 mr-5">
					<input value="Guardar" class="btn cyan text-white" onclick="IngMod(this)"  value="GUARDAR"/>
		
				</div>
            </form>
        </div>
    </div>
</div>


<script>
let parametro = new URLSearchParams(location.search);
var idRepresentante = parametro.get('id');	
var idInstitucionEducativa=parametro.get('edu');
var idInstitucionTransporte=parametro.get('inst');
var idConductor=parametro.get('cond');
var rut_id=0;
var institutoMonitoreo=false;
var servicioEntrada=true;
var cooperativa=0;
var tipoVehiculo=``;
var lati=0;
var long=0;
var lati2=0;
var long2=0;
CargarFechaActual();
cargarEducativa(idInstitucionEducativa)

if(idConductor != 0)
{
    comprobarTipo(idConductor);
    cargarFuncionario(idConductor);
    cargarVehiculoFun(idConductor);
}


function cargarRutas()
{
	
	var result=`<td></td>
			<td class=" text-center"><div class="spinner-border text-center" role="status">
			<span class="sr-only">Loading...</span>
			</div></td>`;
	document.getElementById('listaRutas').innerHTML =result;
	var url=`http://localhost:8888/rutas?opcion=3&id=`+idInstitucionEducativa+`&id2=2&campo=0&bus=0&est=0`;
	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
        result=``;
        var cont=1;
		if(produ.length > 0)
		{
			for(let prod of produ){						
			result += `<tr> 
                        <td class="boton">${cont}</td>
                        <td class="boton">${prod.nombre}</td>
                        <td class="boton">${prod.id}</td>
                        </tr>`;	
            cont++;							
								
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

		for(let i=0;i<elementos.length;i++)
		{
			elementos[i].addEventListener('click',obtenerValores);
        } 
        
		$(".dt-select tr ").click(function(){
			$(this).addClass('filaSeleccionada').siblings().removeClass('filaSeleccionada');		
		});

		return produ;				
		})		
		.catch(error => { console.log("error",error); return error; });
}

function obtenerValores(e)
{
    
    var elementosTD=e.srcElement.parentElement.getElementsByTagName("td");
    cargarParadas(elementosTD[2].innerHTML);
    cargarVehiculos(elementosTD[2].innerHTML);
    rut_id=elementosTD[2].innerHTML;
}

function CargarFechaActual()
{
    n =  new Date();
    y = n.getFullYear();
    m = n.getMonth() + 1;
    d = n.getDate();
    document.getElementById("fregistro").value = `${y}-${m}-${d}`;
    document.getElementById("ffin").value = `${y}-${m}-${d}`;


    var divContenedor=document.querySelector('#tservicio');
	var urlservicio=`${raizServidor}/tipoServicio?campo=tse_nombre&bus=&est=1`;			
    cargarCombo(urlservicio,"tipoServicio",divContenedor,"");
    

    var contenedor=document.querySelector('#plectivo');
	var urlperiodo=`${raizServidor}/periodo?campo=ple_nombre&bus=&est=1`;			
    cargarCombo(urlperiodo,"tipoPeriodo",contenedor,"");
    
    document.getElementById("estado").disabled=true;



    
    var contenedor1=document.querySelector('#estudiante');
	var urlperiodo1=`${raizServidor}/estudianteRepresentante?id=${idRepresentante}`;			
    cargarComboEstudiante(urlperiodo1,"tipoEstudiante",contenedor1,"");
    
    document.getElementById("estado").disabled=true;
    cargarRutas();	
}


async function cargarComboEstudiante(
  url,
  nombreCombo,
  divContenedor,
  SeleccionarElemento
) {
  divContenedor.innerHTML = `<div class='text-center'><div class='spinner-border text-info' role='status'><span class='sr-only'>Loading...</span></div></div>`;
  var result = `<select id='${nombreCombo}' class='browser-default custom-select'>`;
  try {
    let response = await fetch(url);
    let data = await response.json();
    for (let pro of data) {
      if (SeleccionarElemento == pro.id)
        result +=
          "<OPTION VALUE=" + pro.id + " selected>" + pro.nombre + "</OPTION>";
      else result += "<OPTION VALUE=" + pro.id + ">" + pro.nombre + " "+ pro.apellido + "</OPTION>";
    }
    result += "</SELECT>";
    divContenedor.innerHTML = result;
  } catch (e) {
    result +=
      '<option value="-1" selected>No existe elementos</option> </SELECT>';
    divContenedor.innerHTML = result;
  }
}


async function comprobarTipo(cod)
{
    try {
    layerGroup.clearLayers();
    let response = await fetch(`http://localhost:8888/servicio?opcion=1&id=${cod}`);
    let data = await response.json();
    var cont=0;
    for (let pro of data) {
      if (cont==0)
        tipoVehiculo=pro.nombre;
    }
    if(tipoVehiculo == "BUS")
    {
        $('#tituloRuta').show(); 
        $('#divRuta').show(); 
        cargarParadas(cod.trim());
        document.getElementById('textoElegirServicio').innerHTML=`**Para seleccionar la parada solamente es necesario dar click sobre la misma, Si el servicio es mixto debera elegir dos paradas diferentes**`;
    }
    if(tipoVehiculo == "BUSETA")
    {
        $('#tituloRuta').hide(); 
        $('#divRuta').hide(); 
        agregarUbicacion();
        document.getElementById('textoElegirServicio').innerHTML=`**Para agregar la parada pulsar doble click y agregar la parada donde necesite el servicio, Si el servicio es mixto debera elegir dos paradas diferentes**`;
    }
        
   
  } catch (e) {
    console.log(e);
  }



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
        comprobarTipo(funid);
	return produ;				
	})		
	.catch(error => { console.log("error",error); return error; });
}	

function cargarVehiculoFun(id)
{
	var cont=0;
	var funid=0;
	var result=``;
	let url= `${raizServidor}/vehiculo/${id}?opcion=2`;
	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
		
		document.getElementById('plc').value=produ.placa;
			
		
	return produ;				
	})				
	.catch(error => { console.log("error",error); return error; });
}	


function cargarEducativa(id)
{
	var result=``;
	let url= `http://localhost:8888/institucion/${id}`;

	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
		
		document.getElementById('nomInst').value=produ.nombre;
			
		
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
		idConductor=produ.id;	
		
	return produ;				
	})		
	.catch(error => { console.log("error",error); return error; });
}	


function agregarUbicacion()
{
    marker.addTo(map);
    map.locate({setView: true, maxZoom: 16});
    map.on('locationfound', onLocationFound);
    map.on('dblclick', function(e) 
    {
        var container = L.DomUtil.create('div'),
            ida = createButton('Agregar Parada', container);

    
        L.popup()
            .setContent(container)
            .setLatLng(e.latlng)
            .openOn(map);
            
       
        L.DomEvent.on(ida, 'click', function() 
        {
            lati=e.latlng.lat;
            long=e.latlng.lng;
            marker.setLatLng(e.latlng).update();
            map.closePopup();
        });

        
    });
    
}


function cargarParadas(id)
{
    marker.remove();
	// let url= `http://localhost:8888/parada?opcion=2&dato=${id}`;
    let url= `http://localhost:8888/parada?opcion=1&dato=${id}`;
    var cords=[];
    
	fetch(url)
	.then((res) => {return res.json(); })
	.then(produ => {
		cords=[];
		if(produ.length > 0)
		{
            var cont=0;
			for(let prod of produ){	
				cords.push(L.latLng(prod.latitud,prod.longuitud));	
			}
            control.setWaypoints(cords);

            for(let prod of produ){
                var text="id:"+prod.id+",<br>nombre:"+prod.nombre;
                agregarMarcadorAzul(prod.latitud,prod.longuitud,text,layerGroup);	
            }
			marker.addTo(map);
		}
		return produ;	
		})		
		.catch(error => { console.log("error",error); return error; });
}

function IngMod(v) 
{	
    var fregistro = document.getElementById('fregistro').value;
    var ffin = document.getElementById('ffin').value;
    var observacion = document.getElementById('observacion').value;
    var tservicio = document.getElementById('tipoServicio').value; 
    var plectivo = document.getElementById('tipoPeriodo').value; 
    var estudiante = document.getElementById('tipoEstudiante').value;
    var estado = document.getElementById('estado').value; 
    
    event.preventDefault();		

    if(valSololetras(observacion)==false)
    {
        toastr.error('Ingrese solo letras');
        document.getElementById("observacion").style.borderColor="red";
    }
    else
    {
        document.getElementById("observacion").style.borderColor='#ced4da';
        if(tservicio < 1)
        {
            toastr.error('Debe elegir un tipo de servicio');
            document.getElementById("tipoServicio").style.borderColor="red";
        }
        else
        { 
            document.getElementById("tipoServicio").style.borderColor='#ced4da';
            if(plectivo < 1)
            {
                toastr.error('Debe elegir un periodo léctivo');
                document.getElementById("tipoPeriodo").style.borderColor="red";
            }
            else
            { 
                document.getElementById("tipoPeriodo").style.borderColor='#ced4da';
                if(estudiante<1)
                {
                    toastr.error('Debe elegir un estudiante');
                    document.getElementById("tipoEstudiante").style.borderColor="red";
                }
                else
                { 
                    document.getElementById("tipoEstudiante").style.borderColor='#ced4da';
                    if(idInstitucionTransporte == 0 )
                    {
                        toastr.error('Error en cooperativa');
                    }
                    else
                    {
                        if(lati == 0 || long == 0)
                        {
                            toastr.error('Error en latitud y longitud ');
                        }
                        else
                        {
                            var p1;
                            var p2;
                            var parametros= {'id': 0,'fechaRegistro':fregistro,'fechaFin':ffin,'observacion':observacion,'estado':estado,'latitud':lati,'longitud':long,'periodo':plectivo,'cooperativa':idInstitucionTransporte,'educativa':idInstitucionEducativa,'estudiante':estudiante,'funcionario':idConductor,'tipoServicio':tservicio};							
                            console.log(parametros);
                            var url=`${raizServidor}/servicio`;
                            var url2=`${raizServidor}/recorridoServicio`;
                            Ingresar(parametros,url);

                            (async () => {
                                try{												
                                    let response = await fetch(`${raizServidor}/contadores?opcion=5&id=0`);
                                    let data = await response.json();
                                    // alert(data.numero);
                                    if(tservicio==1 || tservicio==2)
                                    {
                                            p1= {'servicio': data.numero,'recorrido':recorridos[0],'parada':par[0]};
                                            Ingresar(p1,url2);	
                                    }
                                    else
                                    {
                                            p1= {'servicio': data.numero,'recorrido':recorridos[0],'parada':par[0]};
                                            p2= {'servicio': data.numero,'recorrido':recorridos[1],'parada':par[1]};
                                            Ingresar(p1,url2);
                                            Ingresar(p2,url2);

                                    }
                                    											
                                }catch(e){
                                    toastr.error('Error al Cargar algunos datos'); 	
                                }
                            })();	
                        }
                    }
                }
            }	
        }
    }
}

var recorridos=[];
function obtenerRecorrido(id)
{


    var result=``;
    let url=`http://localhost:8888/recorrido?id=${id}`;

    fetch(url)
    .then((res) => {return res.json(); })
    .then(produ => {

    let result = ``;
    if(produ.length>0)
    {
        for(let prod of produ){
           recorridos.push(prod.id);
        }
    }
    return produ;
    })
    .catch(error => {  console.log("error",error); return error; })
}

</script>


<script>
var greenIcon = new L.Icon({
        iconUrl: 'https://cdn.rawgit.com/pointhi/leaflet-color-markers/master/img/marker-icon-2x-green.png',
        shadowUrl: 'https://cdnjs.cloudflare.com/ajax/libs/leaflet/0.7.7/images/marker-shadow.png',
        iconSize: [25, 41],
        iconAnchor: [12, 41],
        popupAnchor: [1, -34],
        shadowSize: [41, 41]
        });

var osmUrl = 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
    osmAttrib = '&copy; <a href="http://openstreetmap.org/copyright">OpenStreetMap</a> contributors',
    osm = L.tileLayer(osmUrl, {maxZoom: 16, attribution: osmAttrib});

var cont=1;
var map = L.map('map').setView([-2.901866, -79.006055], 14).addLayer(osm);
map.doubleClickZoom.disable();

var layerGroup = L.layerGroup().addTo(map);
var marker=L.marker([0,0], {icon: greenIcon})
    .bindPopup(`Parada Seleccionada`)
    .on('mouseover', onClick);



var control = L.Routing.control(L.extend( {
    waypoints: [null],
    routeWhileDragging: false,
    reverseWaypoints: false,
    showAlternatives: false,
    altLineOptions: {
        styles: [
            {color: 'black', opacity: 0.15, weight: 9},
            {color: 'white', opacity: 0.8, weight: 6},
            {color: 'red', opacity: 0.5, weight: 2}
        ]
    }
})).addTo(map);

L.Routing.errorControl(control).addTo(map);

L.Routing.Formatter = L.Class.extend({
    options: {
        language: 'sp'
    }
});


function agregarMarcadorAzul(lat,lng,num,grupo)
{
    L.marker([lat, lng]).addTo(grupo)
    .bindPopup(`${num}`)
    .on('mouseover', onClick)
    .on('click',obtenerDatosParada);
}

function agregarMarcadorVerde(posicion,grupo)
{
    L.marker(posicion, {icon: greenIcon}).addTo(grupo)
    .bindPopup(`Parada Seleccionada`)
    .on('mouseover', onClick);
}

function createButton(label, container) 
{
    var btn = L.DomUtil.create('button', '', container);
    btn.setAttribute('type', 'button');
    btn.setAttribute('class', 'btn');
    btn.innerHTML = label;
    return btn;
}

function onClick(e) {
    this.openPopup();
}

var par=[];
function obtenerDatosParada(e) {
    
    obtenerRecorrido(rut_id);
    var datos=this._popup.getContent().split(",");
    var datos1=datos[0].split(":");
    par.push(datos1[1]);
    marker.setLatLng(this.getLatLng()).update();
    marker.openPopup();
    lati=e.latlng.lat;
    long=e.latlng.lng;
}

    
map.on('locationerror', onLocationError);

function onLocationFound(e) 
{
    var radius = e.accuracy / 2;
    // lati=e.latlng.lat;
    // long=e.latlng.lng;
    L.marker(e.latlng).addTo(map)
    .bindPopup("Tu estas aqui, con " + radius + " metros de aproximacion").openPopup();
        
    L.circle(e.latlng, radius).addTo(map);
}


</script>

<?php include 'footer.php'; ?>
