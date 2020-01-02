<div class="modal fade" id="modalRutas" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">

  <!-- Change class .modal-sm to change the size of the modal -->
  <div class="modal-dialog modal-lg" role="document">

    <div class="modal-content">
      	<div class="modal-header">
			<h4 class="modal-title w-100" id="myModalLabel">Seleccionar ruta</h4>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			<span aria-hidden="true">&times;</span> 
			</button>
      	</div>
      	<div class="modal-body"> 

			<div class="container">
				<div class="form-group row">
					<div class="col-md-3  align-self-center">		
						<label>Campo:</label>							
						<SELECT id="campo"  class="browser-default custom-select">
                            <option value="rut_nombre">NOMBRE</option>
                        </SELECT>
					</div>

					<div class="col-md-3">
						<label for="txtuser">Buscar:</label>
						<input type="text" id="textBuscarRuta" name="textBuscarRuta" class="form-control text-uppercase">     
					</div>

					<div class="col-md-3">
						<label>Estado:</label>
						<SELECT id="estadol"  class="browser-default custom-select"> 
							<OPTION VALUE="" selected >TODOS</OPTION>
							<OPTION VALUE="1">ACTIVO</OPTION>
							<OPTION VALUE="0">INACTIVO</OPTION>             
						</SELECT> 
					</div>		

					<div class="col-md-2  align-self-center" id="buscarRuta">
						<a href="" class="btn grey"><i class="fas fa fa-search "></i></a>
					</div>
				</div>
				<div class="row">
					<div class="container">
						<div class="row">
							<div class="col">                    
								<div class='table-responsive-sm my-custom-scrollbar'>
									<table id='dt-select' class='table-sm table table-hover text-center' cellspacing='0' width='100%'>
										<thead class='cyan white-text'>
											<tr>
                                                <th scope='col'>ID</th>
                                                <th scope='col'>NOMBRE</th>
                                                <th scope='col'>DESCRIPCIÓN</th>
                                                <th scope='col'>CUPO MAXIMO</th>
                                                <th scope='col'>ESTADO</th>
                                                <th></th>
											</tr>
										</thead>
										<tbody  id="listaRuta" >
											<!-- AQUI SE CARGA LA TABLA CON LOS REGISTROS -->
										</tbody>
									</table>
								</div>
							</div>
						</div>                
					</div>
				</div>			
			</div>			
	    </div>
    </div>
  </div>
</div>

<script type="text/javascript">	
		const botonBuscarLista=document.querySelector('#buscarRuta');		
		const listaRuta=document.querySelector('#listaRuta');
		var idFun;		
	
		function Buscar(){	
			event.preventDefault();

			var campo = document.getElementById('campo').value;			
			var textBuscar=document.getElementById('textBuscarRuta').value;
			textBuscar=textBuscar.toUpperCase();			
			var estado=document.getElementById("estadol").value;
			
			let url=`http://localhost:8888/rutas?opcion=4&id=${IntitucionPrincipal}&id2=0&campo=${campo}&bus=${textBuscar}&est=${estado}`;
            
			listaRuta.innerHTML=`<div class="text-center"><div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div></div>`;	
			fetch(url)
		 	.then((res) => {return res.json(); })
			.then(produ => {
				let result = "";					
				est="";
				for(let prod of produ){						
					result +=
					`<tr> 
                            <td class ="first boton"> ${prod.id}</td>
							<td class ="boton"> ${prod.nombre} </td>
                            <td class ="boton"> ${prod.descripcion}</td>
                            <td class ="boton"> ${prod.cupoMaximo}</td>
                            <td class ="boton"> ${prod.estado==1?"Activo":"Inactivo"} </td>																			
                            <td><a class='bot fas fa-check-circle' data-dismiss='modal'>Seleccionar</a>
                            </td> 
					</tr>`;											
				}
				result += `</tabla> `;
				listaRuta.innerHTML=result;
				return produ;				
			})		
				.catch(error => { listaRuta.innerHTML =`<div>No se encuentras coincidencias</div>`;	 console.log("error",error); return error; })					
		}		
			
		botonBuscarLista.addEventListener('click',Buscar);
		
		// la clase bot es del boton de seleccionar. 
		//  la lista es el div contenedor del resultado de la busqueda
		$("#listaRuta").on('click', '.bot', function(e) {
			// CAPTURA LOS DATOS DE LAS POSICIONES DE LA TABLA DE BUSQUEDA.
			var cod = $(this).parents("tr").find("td")[0].innerHTML;
			var nom = $(this).parents("tr").find("td")[1].innerHTML;
			// ENVIO EL RESULTADO A LOS INPUT DE LA VENTANA PRINCIPAL
			document.getElementById('nomRuta').value = (`${nom}`);
			document.getElementById('idRuta').value = cod.trim();
			
		});		 
	</script>