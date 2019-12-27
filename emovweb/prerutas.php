<?php include 'header.php'; include 'codigophp/sesion.php'; 
    $menu=Sesiones("EMPRESADETRANSPORTE"); 
?>


<div class="container-fluid grey">
		<?php
		echo $menu
		?>
</div>


<div class="container pt-3">
	<div class="row">
		<div class="h3 text-left font-weight-bold">PreRutas</div>
	</div>


	<div class="form-group row mt-3 align-middle">
		<div class="col-md-3">
			<label>Campo:</label>
			<SELECT id="campo"  class="browser-default custom-select">
				<option value="rut_nombre">NOMBRE</option>
			</SELECT>
		</div>

		<div class="col-md-3">
            <label>Buscar:</label>
            <input type="text" id="textBuscar" name="textBuscar" class="form-control text-uppercase">
        </div>

		<div class="col-sm-2">
			<label>Estado:</label>
			<SELECT id="estado"  class="browser-default custom-select">
				<OPTION VALUE="" selected >TODOS</OPTION>
                <OPTION VALUE="1">ACTIVO</OPTION>
                <OPTION VALUE="0">INACTIVO</OPTION>
			</SELECT>
		</div>


		<div class="col-sm-2 align-self-center mt-3" id="buscar">
			<a href="" class="btn grey"><i class="fas fa fa-search "></i></a>
		</div>
	</div>


	<div class="row mt-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
				
					<div class="row justify-content-end text-white mr-1">
						<a href="RutaEditar.php?metodo=Guardar" class="btn btn-info p-1"  ><i class="far fa-plus-square pr-2" aria-hidden="true"></i>Ruta</a> 
					</div>

                            
                    <div class='table-responsive-sm my-custom-scrollbar'>
                        <table  class='table-sm table table-hover text-center' cellspacing='0' width='100%'>
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
                        <tbody  id="lista" class='dt-select' >
                           <!-- AQUI SE CARGA LA TABLA CON LOS REGISTROS  -->
                        </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row mt-3">
        <div class="col-md-6 justify-content-start">
            <div class="h5 text-left font-weight-bold">Recorrido</div>
        </div>
        <div class="col-md-6 justify-content-start">
            <div class="h5 text-left font-weight-bold">Paradas</div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6">
            <div class='table-responsive-sm my-custom-scrollbar'>
                <table id='dt-select' class='table-sm table table-hover text-center' cellspacing='0' width='100%'>
                    <thead class='cyan white-text'>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>INICIO</th>
                        <th scope='col'>FIN</th>
                        <th scope='col'>ESTADO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody  id="listaR" class='dt-select' >
                    <!-- AQUI SE CARGA LA TABLA CON LOS REGISTROS -->
                </tbody>
                </table>
            </div>
        </div>

        <div class="col-md-6">
            <div class='table-responsive-sm my-custom-scrollbar'>
                <table id='dt-select' class='table-sm table table-hover text-center' cellspacing='0' width='100%'>
                    <thead class='cyan white-text'>
                    <tr>
                        <th scope='col'>ID</th>
                        <th scope='col'>NOMBRE</th>
                        <th scope='col'>ESTADO</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody  id="listaP" class='dt-select' >
                    <!-- AQUI SE CARGA LA TABLA CON LOS REGISTROS -->
                </tbody>
                </table>
            </div>
        </div>
    </div>
</div>




<script type="text/javascript">

    const boton=document.querySelector('#buscar');
    const lista=document.querySelector('#lista');

    function Buscar(){
        event.preventDefault();
        var campo = document.getElementById('campo').value;
        var textBuscar=document.getElementById('textBuscar').value;
        textBuscar=textBuscar.toUpperCase();
        var estado=document.getElementById("estado").value;
        
        let url=`http://localhost:8888/rutas?opcion=4&id=${IntitucionPrincipal}&id2=0&campo=${campo}&bus=${textBuscar}&est=${estado}`;
      
        
        fetch(url)
        .then((res) => {return res.json(); })
        .then(produ => {
            var cont=0;
            lista.innerHTML='';
            let result = ``;

            for(let prod of produ){
                if(cont==0)
                {
                    result +=
                    `<tr>
                        <td class ="first boton"> ${prod.id}</td>
                        <td class ="boton"> ${prod.nombre} </td>
                        <td class ="boton"> ${prod.descripcion}</td>
                        <td class ="boton"> ${prod.cupoMaximo}</td>
                        <td class ="boton"> ${prod.estado==1?"Activo":"Inactivo"} </td>
                        <td>
                            <?php echo "<a href="?>RutaEditar.php?id=${prod.id}
                            <?php echo "class='fas fa-edit'>Editar</a>" ?>
                        </td>
                    </tr>`;
                    cont++;
                }
                else{
                    result +=
                    `<tr>
                        <td class ="boton"> ${prod.id}</td>
                        <td class ="boton"> ${prod.nombre} </td>
                        <td class ="boton"> ${prod.descripcion}</td>
                        <td class ="boton"> ${prod.cupoMaximo}</td>
                        <td class ="boton"> ${prod.estado==1?"Activo":"Inactivo"} </td>
                        <td>
                            <?php echo "<a href="?>RutaEditar.php?id=${prod.id}
                            <?php echo "class='fas fa-edit'>Editar</a>" ?>
                        </td>
                    </tr>`;
                }
               

            }
            lista.innerHTML=result;
            
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
            .catch(error => { lista.innerHTML =`<div>No se encuentras coincidencias</div>`;	 console.log("error",error); return error; })
    }

    boton.addEventListener('click',Buscar);


    function obtenerValores(e) 
    {
        var valores="";
  
        var elementosTD=e.srcElement.parentElement.getElementsByTagName("td");
        document.getElementById('listaP').innerHTML=valores;
        document.getElementById('listaR').innerHTML=valores;
        cargarOpciones(elementosTD[0].innerHTML);
        function cargarOpciones(id)
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
                    result +=
                    `<tr>
                        <td class ="boton1"> ${prod.id}</td>
                        <td class ="boton1"> ${prod.horaInicio} </td>
                        <td class ="boton1"> ${prod.horaFin}</td>
                        <td class ="boton1"> ${prod.estado==1?"Activo":"Inactivo"} </td>
                        <td>
                            <?php echo "<a href="?>RecorridoEditar.php?id=${prod.id}
                            <?php echo "class='fas fa-edit'>Editar</a>" ?>
                        </td>
                    </tr>`;

                }
                document.getElementById('listaR').innerHTML=result;
                let elementos=document.getElementsByClassName('boton1');
                    for(let i=0;i<elementos.length;i++)
                    {
                            elementos[i].addEventListener('click',obtenerParadas);
                    }

                    $(".dt-select tr ").click(function(){
                        $(this).addClass('filaSeleccionada').siblings().removeClass('filaSeleccionada');
                });
            }
            else{
                document.getElementById('listaR').innerHTML =`<div>No se encuentras coincidencias</div>`;
            }
            
            return produ;
            })
            .catch(error => {  document.getElementById('listaR').innerHTML =`<div>No se encuentras coincidencias</div>`;	 console.log("error",error); return error; })
        }
    }

    function obtenerParadas(e) 
    {
        var valores="";
  
        var elementosTD=e.srcElement.parentElement.getElementsByTagName("td");

        document.getElementById('listaP').innerHTML=valores;
        cargarP(elementosTD[0].innerHTML);
        function cargarP(id)
        {
        

            var result=``;
            let url=`http://localhost:8888/parada?opcion=3&dato=`+id;
            fetch(url)
            .then((res) => {return res.json(); })
            .then(produ => {

            let result = ``;
            if(produ.length>0)
            {
                for(let prod of produ){
                    result +=
                    `<tr>
                        <td class ="boton1"> ${prod.id}</td>
                        <td class ="boton1"> ${prod.nombre} </td>
                        <td class ="boton1"> ${prod.estado==1?"Activo":"Inactivo"} </td>
                    </tr>`;

                }
                document.getElementById('listaP').innerHTML=result;
            }
            else{
                document.getElementById('listaP').innerHTML =`<div>No se encuentras coincidencias</div>`;
            }
            return produ;
            })
            .catch(error => {  document.getElementById('listaP').innerHTML =`<div>No se encuentras coincidencias</div>`;	 console.log("error",error); return error; })
        }
    } 

    jQuery(document).ready(function($)
{
	$('#thetable').tableScroll({height:150});

	$('#thetable2').tableScroll();
});

</script>



 <?php include 'footer.php'; ?>
