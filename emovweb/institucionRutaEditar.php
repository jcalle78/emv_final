<?php include 'header.php'; 
	include 'codigophp/sesion.php';
    $menu=Sesiones("EMOV");
    include 'funcionario_modal_selec_institucion.php';
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
						<div class="text-white row justify-content-center mt-3">
							<input class="btn cyan" onclick="IngMod(this)" type="submit" value="" id="metodo" name="metodo"/>		
							<input type="button" value="Cancelar" class="btn cyan" onclick="location.href = 'funcionario.php';"/><br/>
						</div>						
					</form>		

                </div>
			</div>
      	</div>
	</div>
</div>

<?php include 'footer.php'; ?>