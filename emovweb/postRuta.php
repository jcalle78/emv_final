<?php include 'header.php'; 
    include 'codigophp/sesion.php';	 
    $menu=Sesiones("EMOV"); 
?>
<div class="container-fluid grey">
		<?php 
		echo $menu 
		?>
</div>








<?php include 'footer.php'; ?>