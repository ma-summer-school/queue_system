<?php
/*session_start();
$_SESSION["lastserved"]=isset($_SESSION["lastserved"]) ? $_SESSION["lastserved"] : 0 ;
$_SESSION["lastticket"]=isset($_SESSION["lastticket"]) ? $_SESSION["lastticket"] : 0 ; 
*/
include "PhpSerial.php";
session_start();

?>
		<div id="lastserved">

		<?php 
		include "PhpSerial.php";
		$_SESSION['serial']->sendMessage("c\n");
		preg_match('/\d+/', $_SESSION['serial']->readPort(), $read);
		
//    	echo '<h3>Αριθμός που εξυπηρετείται:</h2><h1>'.$_SESSION["lastserved"].'</br></h1>';
		if ($read)
    		echo '<h3>Αριθμός που εξυπηρετείται:</h2><h1>'.$read[0].'</br></h1>';
		?>

		</div>
		<div id="lastticket" >
	
		<?php 
		include "PhpSerial.php";
		$_SESSION['serial']->sendMessage("t\n");
		preg_match('/\d+/', $_SESSION['serial']->readPort(), $read);
//    	echo '<h3>Τελευταίος αριθμός στην ουρά:</h2><h1>'.$_SESSION["lastticket"].'</h1>';
		if ($read)
    		echo '<h3>Τελευταίος αριθμός στην ουρά:</h2><h1>'.$read[0].'</h1>';
		?>

		</div>

