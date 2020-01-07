<?php include 'header.php'; 
    include 'codigophp/sesion.php';	 
    $menu=Sesiones("EMOV"); 
?>
<div class="container-fluid grey">
		<?php 
		echo $menu 
		?>
</div>

<div class="container">
    <div class="row mt-3 ">
        <div class="h3 text-left font-weight-bold">INSTITUCION EDUCATIVA - RUTA</div>
    </div>

    <div class="form-group row mt-3">
    <div class="col-md-3">
            <label>Campo:</label>
            <select id="campo" class="browser-default custom-select">
                <option value="ins_nombre" selected>NOMBRE INSTITUCIÓN</option>
                <option value="rut_nombre">NOMBRE RUTA</option>
            </select>
        </div>

        <div class="col-md-3">
            <label>Buscar:</label>
            <input type="text" id="textBuscar" name="textBuscar" class="form-control text-uppercase">     
        </div>

        <div class="col-sm-2 align-self-center">
        	<label>Estado:</label>
			<SELECT id="estBusqueda"  class="browser-default custom-select"> 
				<OPTION VALUE="" selected >TODOS</OPTION>
				<OPTION VALUE="1">ACTIVO</OPTION>
				<OPTION VALUE="0">INACTIVO</OPTION>					
			</SELECT> 
		</div>

        <div class="col-md-2 mt-3" id="buscar">
                <a href="" class="btn grey"><i class="fas fa fa-search "></i></a>
        </div>
    </div>

    <div class="row mt-2">
         <div class="container">                    
            <div class='table-responsive-sm my-custom-scrollbar'>
                <table id='dt-select' class='table-sm table table-hover text-center' cellspacing='0' width='100%'>
                <thead class='cyan white-text'>
                    <tr>
                        <th scope="col">INS ID</th>
                        <th scope="col">RUTA ID</th>
                        <th scope="col">INSTITUCIÓN</th> 
                        <th scope="col">RUTA</th>  
                        <th scope="col">CUPO MÁXIMO</th>  
                        <th scope="col">ESTADO</th>  
                        <th></th> 
                    </tr>
                </thead>
                <tbody  id="listaInsRuta" >
                    <!-- AQUI SE CARGA LA TABLA CON LOS REGISTROS -->
                </tbody>
                </table>
            </div>                           
        </div>
    </div>
</div>         
    <div class="cyan circulo">
		<a href="institucionRutaEditar.php?metodo=Guardar" class="circulo-mas"><i class="fa fa-plus" ></i></a>
	</div>	   


<script type="text/javascript">
	const boton=document.querySelector('#buscar');		
	const lista=document.querySelector('#listaInsRuta');	
   

	async function Buscar(){	
		event.preventDefault();
        var campo = document.getElementById('campo').value;
        var textBuscar=document.getElementById('textBuscar').value;
        textBuscar=textBuscar.toUpperCase();	
        var estado=document.getElementById("estBusqueda").value;
        lista.innerHTML=`<div class="text-center"><div class="spinner-border text-info" role="status"><span class="sr-only">Loading...</span></div></div>`;	
		
        // try{
            let response = await fetch(`${raizServidor}/institucionRuta?campo=${campo}&bus=${textBuscar}&est=${estado}`);
            let data = await response.json(); 
            // console.log(data);  
            let result="";		
            est="";
			for(let prod of data){						
				result +=
				`<tr> 
					<td> ${prod.insId}</td>
					<td> ${prod.rutaId}</td>
                    <td> ${prod.insNombre}</td>
                    <td> ${prod.rutaNombre}</td>
                    <td class="text-center"> ${prod.rutaCupo}</td>
					<td> ${prod.estado==1?"ACTIVO":"INACTIVO"} </td>
					<td>
						<?php echo "<a href="?>institucionRutaEditar.php?metodo=Modificar&insId=${prod.insId}&rutaId=${prod.rutaId}
						<?php echo "class='fas fa-edit'>Editar</a>"?>
					</td>
				</tr>`;										
			}
			result += `</table> `;
			lista.innerHTML=result;	
        // }catch(e){
        //         toastr.error('Error al Cargar algunos datos'); 	
        // }
			
	}
	boton.addEventListener('click',Buscar);
</script>


<?php include 'footer.php'; ?>