<<<<<<< HEAD
<script type="text/javascript" src="js/jspdf/js/jquery/jquery-1.7.1.min.js"></script>
	<script type="text/javascript" src="js/jspdf/js/jquery/jquery-ui-1.8.17.custom.min.js"></script>
	<script type="text/javascript" src="js/jspdf/jspdf.js"></script>

	<script type="text/javascript" src="js/jspdf/jspdf.plugin.addimage.js"></script>

	<script type="text/javascript" src="js/jspdf/jspdf.plugin.standard_fonts_metrics.js"></script>
	<script type="text/javascript" src="js/jspdf/jspdf.plugin.split_text_to_size.js"></script>
	<script type="text/javascript" src="js/jspdf/jspdf.plugin.from_html.js"></script>

=======
>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
<script>
function Ceros(idi) {
    
		fetch(`http://localhost:8888/estudianteRepresentante/${idi}`, {
				method: 'DELETE',
				//body:JSON.stringify(parametros),
				headers:{
					'Content-Type': 'application/json'
				}
			}).then(res => res.json())
			.catch(error => {
			//	toastr.error('Error al Guardar');
			})
			.then(respuesta => {
			//	toastr.success('Guardado correctamente');
				//setTimeout("location.href='funcionario.php?metodo=Ingresar'",1000);
			})
	}
function IngresarR(parametros) {
		fetch('http://localhost:8888/representante', {
				method: 'POST',
				body:JSON.stringify(parametros),
				headers:{
					'Content-Type': 'application/json'
				}
			}).then(res => res.json())
			.catch(error => {
			//	toastr.error('Error al Guardar');
			})
			.then(respuesta => {
			//	toastr.success('Guardado correctamente');
				//setTimeout("location.href='funcionario.php?metodo=Ingresar'",1000);
			})
	}

    function IngresarRE(parametros) {
		fetch('http://localhost:8888/estudianteRepresentante', {
				method: 'POST',
				body:JSON.stringify(parametros),
				headers:{
					'Content-Type': 'application/json'
				}
			}).then(res => res.json())
			.catch(error => {
			//	toastr.error('Error al Guardar');
			})
			.then(respuesta => {
			//	toastr.success('Guardado correctamente');
				//setTimeout("location.href='funcionario.php?metodo=Ingresar'",1000);
			})
	}
    function IngresarE(parametros) {
		fetch('http://localhost:8888/estudiante', {
				method: 'POST',
				body:JSON.stringify(parametros),
				headers:{
					'Content-Type': 'application/json'
				}
			}).then(res => res.json())
			.catch(error => {
			//	toastr.error('Error al Guardar');
			})
			.then(respuesta => {
			//	toastr.success('Guardado correctamente');
				//setTimeout("location.href='funcionario.php?metodo=Ingresar'",1000);
			})
	}

    function BusRepresentante(ced){
<<<<<<< HEAD
       
=======

>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
		fetch(`http://localhost:8888/representante?campo=rep_cedula&valor=${ced}&estado=1`)
			.then(response => response.json())
			.then(data => {
				if(data==null || data=="")
                {

                    document.getElementById('repId').value =0;
                }
                else{
<<<<<<< HEAD
                var dato=`${data[0].id}`;
=======

                var dato=`${data[0].id}`;

>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
				document.getElementById('repId').value = dato;
                }
		})
		.catch(error => {
			//toastr.error('No  existe el representante'); console.log(error);
			//document.getElementById('repId').value = 0;
		})
	}

    function BusEstudiante(ced){

    fetch(`http://localhost:8888/estudiante?campo=est_cedula&valor=${ced}&estado=1`)
    .then(response => response.json())
    .then(data => {

        if(data==null)
        {
            document.getElementById('estId').value =0;
        }
        else{

        var dato=`${data[0].id}`;

        document.getElementById('estId').value = dato;
        }
})
.catch(error => {
    //toastr.error('No  existe el representante'); console.log(error);
    //document.getElementById('repId').value = 0;
})
}

function BusEstudiante2(ced){
<<<<<<< HEAD
    
=======
    alert("estre");
>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
fetch(`http://localhost:8888/estudiante?campo=est_cedula&valor=${ced}&estado=0`)
.then(response => response.json())
.then(data => {

    if(data==null)
    {
        return 0;
    }
    else{

    var dato=`${data[0].nombre}`;   
   return dato;
    }
})
.catch(error => {
//toastr.error('No  existe el representante'); console.log(error);
//document.getElementById('repId').value = 0;
})
}
    </script>
    <input type='hidden' name='repId' id='repId' value="0">
    <input type='hidden' name='estId' id='estId' value="0" >
    <iframe frameborder="0" width="500" height="400"></iframe>
<?php
    if(isset($_POST['submit']))
    {
        $id= $_GET['id'];
        $des=$_POST["des"];
        $inst= $_POST['inst'];
        //Aqui es donde seleccionamos nuestro csv
         $fname = $_FILES['sel_file']['name'];
         echo 'Cargando nombre del archivo: '.$fname.' <br>';
         $chk_ext = explode(".",$fname);
         if($des=='true')
         {
         echo"<script>Ceros($inst);</script>";
         if(strtolower(end($chk_ext)) == "csv")
         {
             //si es correcto, entonces damos permisos de lectura para subir
             $filename = $_FILES['sel_file']['tmp_name'];
             $handle = fopen($filename, "r");
             while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
             {    
                            echo"<script>
                            var noIngresado = [];
                            var i=0;
                            var ced='$data[6]';
                            var cedE='$data[0]';
                            var error='';
                            var cont=BusEstudiante2(cedE);
<<<<<<< HEAD
                           // alert(cont);
                            if()
                            {
                            // alert('entre if ');
=======
                            alert(cont);
                            if()
                            {
                             alert('entre if ');
>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
                            }//fin if(BusEstudiante2(cedE)>0)
                            else {
                                            BusRepresentante(ced); 
                                            setTimeout(function(){ var repId=document.getElementById('repId').value;
                                                if(repId!=0){
                                                var parametros={'id':0,'cedula':'$data[0]','nombre':'$data[1]','apellido':'$data[2]','direccion':'$data[3]','telefono':'$data[4]','correo':'$data[5]','estado':1,'insId':$inst};
                                                IngresarE(parametros);
                                                BusEstudiante(cedE);
                                                setTimeout(function(){ var rI=document.getElementById('repId').value;
                                                var eI=document.getElementById('estId').value;
                                                var parametros2={'estId':eI,repId:rI};
                                            IngresarRE(parametros2);})
                                            }//fin If
                                                else{
                                                noIngresado[i]= 'Estudiante con la cedula ->$data[0] no se ingreso';
                                                i++;
                                                error+='$data[0]';

                                                }//fin else
                                ; }, 500);//fin setTimeout
                            }
                            </script>";

                     


                
             }
             //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
             fclose($handle);
             //generamos el archivo de error 
             echo"<script>
             setTimeout(function(){

                var y = 10, lengthOfPage = 500;
                var doc = new jsPDF();
                //looping thru each text item
                for(var i = 0, textlength = noIngresado.length ; i < textlength ; i++) {

                    var splitTitle = doc.splitTextToSize(noIngresado[i], lengthOfPage);

                    //loop thru each line and output while increasing the vertical space
                    for(var c = 0, stlength = splitTitle.length ; c < stlength ; c++){
                        if(y<300){

                        doc.text(20, y, splitTitle[c]);
                        y = y + 10;}
                        else{
                            doc.addPage();
                            y=10;
                            doc.text(20, 10, splitTitle[c]);
                            y = y + 10;
                        }

                    }

                }
                var string = doc.output('datauristring');

                        $('iframe').attr('src', string);
            }, 2000);
             </script>";
             //fin creacion mensaje error 
         }
         else
         {
            //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para
//ver si esta separado por " ;"
             echo "Archivo invalido!";
         }
            
        }//fin if(des=true)
         else
         {
<<<<<<< HEAD
             
=======
>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
            if(strtolower(end($chk_ext)) == "csv")
            {
                //si es correcto, entonces damos permisos de lectura para subir
                $filename = $_FILES['sel_file']['tmp_name'];
                $handle = fopen($filename, "r");
                while (($data = fgetcsv($handle, 1000, ";")) !== FALSE)
                {
                   if ($id=='r') {
                       echo"<script>
                       var parametros={'id':0,'cedula':'$data[0]','nombre':'$data[1]','apellido':'$data[2]','direccion':'$data[3]','telefono':'$data[4]','celular':'$data[5]','correo':'$data[6]','estado':1};
                       IngresarR(parametros);
                       </script>";
                   }
                   else
                   {
<<<<<<< HEAD
                               $inst= $_POST['inst'];
                               echo"<script>
=======
                       
                       
                               $inst= $_POST['inst'];
                               echo"<script>
   
>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
                               var noIngresado = [];
                               var i=0;
                               var ced='$data[6]';
                               var error='';
                               BusRepresentante(ced);
                               setTimeout(function(){ var repId=document.getElementById('repId').value;
                                   if(repId!=0){
                                   var parametros={'id':0,'cedula':'$data[0]','nombre':'$data[1]','apellido':'$data[2]','direccion':'$data[3]','telefono':'$data[4]','correo':'$data[5]','estado':1,'insId':$inst};
                                   IngresarE(parametros);
                                   var cedE='$data[0]';
                                   BusEstudiante(cedE);
                                   setTimeout(function(){ var rI=document.getElementById('repId').value;
                                   var eI=document.getElementById('estId').value;
                                   var parametros2={'estId':eI,repId:rI};
                               IngresarRE(parametros2);})
                               }//fin If
<<<<<<< HEAD
                                   else{    
                                   noIngresado[i]= 'Estudiante con la cedula ->$data[0] no se ingreso';
                                   i++;
=======
                                   else{
   
                                   noIngresado[i]= 'Estudiante con la cedula ->$data[0] no se ingreso';
                                   i++;
                                   error+='$data[0]';
   
>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
                                   }//fin else
                                   ; }, 500);//fin setTimeout
                               </script>";
   
                        
   
   
                   }
                }
                //cerramos la lectura del archivo "abrir archivo" con un "cerrar archivo"
                fclose($handle);
                //generamos el archivo de error 
                echo"<script>
                setTimeout(function(){
   
                   var y = 10, lengthOfPage = 500;
                   var doc = new jsPDF();
                   //looping thru each text item
                   for(var i = 0, textlength = noIngresado.length ; i < textlength ; i++) {
   
                       var splitTitle = doc.splitTextToSize(noIngresado[i], lengthOfPage);
<<<<<<< HEAD
                       
=======
   
>>>>>>> 2254ff942b1937741162f548542c2e5b879c1572
                       //loop thru each line and output while increasing the vertical space
                       for(var c = 0, stlength = splitTitle.length ; c < stlength ; c++){
                           if(y<300){
   
                           doc.text(20, y, splitTitle[c]);
                           y = y + 10;}
                           else{
                               doc.addPage();
                               y=10;
                               doc.text(20, 10, splitTitle[c]);
                               y = y + 10;
                           }
   
                       }
   
                   }
                   var string = doc.output('datauristring');
   
                           $('iframe').attr('src', string);
               }, 2000);
                </script>";
                //fin creacion mensaje error 
            }
            else
            {
               //si aparece esto es posible que el archivo no tenga el formato adecuado, inclusive cuando es cvs, revisarlo para
   //ver si esta separado por " ;"
                echo "Archivo invalido!";
            }
         }//fin else (if des==true)
    }

?>