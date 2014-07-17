<html>
<?php
session_start();
$_SESSION["lastserved"]=isset($_SESSION["lastserved"]) ? $_SESSION["lastserved"] : 0 ;
$_SESSION["lastticket"]=isset($_SESSION["lastticket"]) ? $_SESSION["lastticket"] : 0 ; 


if(isset($_POST['submit'])
{

   ++$_SESSION['lastticket'];
}
?>

<div id="content" >
	<div id="refresh" >
		<div id="lastserved">
		<?php 
				echo '<h2>Last Served:</h2><h1>'.$_SESSION["lastserved"].'</br></h1>';

		?>
		</div>
		<div id="lastticket" >
		<?php 
				echo '<h2>Last ticket:</h2><h1>'.$_SESSION["lastticket"].'</h1>';
		?>
		</div>
	</div>
	<div id="form" >
	<form id="get_a_ticket" action="" method="POST">
		<div id="Greek_Form" style="">
		Επίθετο:</br>
		<input type="text" name="Surname_Gr" >
		</br>
		Όνομα:</br>
		<input type="text" name="Name_Gr" >
		</br>
		Όνομα Πατέρα:</br>
		<input type="text" name="FName_Gr" >
		</br>
		Όνομα Μητέρας:</br>
		<input type="text" name="MName_Gr" >
		</br>
		Ημ/νία Γέννησης:(Ημ/Μη/Χρ)</br>
		<input type="text" size="2" maxlength="2" name="DBirth"  >/
		<input type="text" size="2" maxlength="2" name="MBirth"  >/
		<input type="text" size="2" maxlength="2" name="YBirth"  >
		<input type="text" value="submit" name="submit">
 		</div>
 	<input type="text" value="submit" name="submit">
	</form>
	</div>
</div>
</html>
