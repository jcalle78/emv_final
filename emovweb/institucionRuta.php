<?php include 'header.php'; 
    include 'codigophp/sesion.php';	 
    $menu=Sesiones("EMPRESADETRANSPORTE"); 
?>
<div class="container-fluid grey pr-0 pl-0">
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
                <option value="ins_nombre" selected>NOMBRE</option>
                <option value="ins_ruc">RUC</option>
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
                        <th scope="col">ID</th>
                        <th scope="col">RUC</th>
                        <th scope="col">NOMBRE</th>
                        <th scope="col">DIRECCIÓN</th> 
                        <th scope="col">TELÉFONO</th>  
                        <th scope="col">ESTADO</th>  
                        <th></th> 
                    </tr>
                </thead>
                <tbody  id="lista" >
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
	const lista=document.querySelector('#lista');	

	async function Buscar(){	
		event.preventDefault();
			try{
				let response = await fetch(`${raizServidor}/institucionRuta?est`);
				let data = await response.json();   
				console.log(data);
			}catch(e){
					toastr.error('Error al Cargar algunos datos'); 	
			}
			
	}
	boton.addEventListener('click',Buscar);
</script>


<?php include 'footer.php'; ?>