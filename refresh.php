<?php
session_start();
$_SESSION["lastserved"]=isset($_SESSION["lastserved"]) ? $_SESSION["lastserved"] : 0 ;
$_SESSION["lastticket"]=isset($_SESSION["lastticket"]) ? $_SESSION["lastticket"] : 0 ; 


?>

		<div id="lastserved">

		<?php 
    	echo '<h3>Αριθμός που εξυπηρετείται:</h2><h1>'.$_SESSION["lastserved"].'</br></h1>';
		?>

		</div>
		<div id="lastticket" >
	
		<?php 
    	echo '<h3>Τελευταίος αριθμός στην ουρά:</h2><h1>'.$_SESSION["lastticket"].'</h1>';
		?>

		</div>
