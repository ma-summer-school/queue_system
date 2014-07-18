<?php
include 'PhpSerial.php';

session_start();
$_SESSION["serial"]= new PhpSerial;
$_SESSION["serial"]->deviceSet("/dev/ttyUSB0");
//$_SESSION["serial"]->deviceSet("/tmp/ttyeqemu");
$_SESSION["serial"]->confBaudRate(38400);
$_SESSION["serial"]->confParity("none");
$_SESSION["serial"]->confCharacterLength(8);
$_SESSION["serial"]->confStopBits(1);
$_SESSION["serial"]->confFlowControl("none");
$_SESSION["serial"]->deviceOpen('r+');

?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="jquery.js"></script>
  <script>
  <!-- 
    if($(window).width() <= 400)
      document.location = "m.index.php";
   -->   
  </script>
</head
<body>
<?php
if(isset($_POST['submit']))
{
  
	if(isset($_POST['amka']))
	{
		$_POST['amka']=preg_replace("/[^0-9]/", "", $_POST['amka']);
  	   
  		if( strlen($_POST['amka'])!=11 )
  		{	
			echo 'Λάθος ΑΜΚΑ, βεβαιωθείτε οτι ο ΑΜΚΑ που έχετε εισάγει είναι σωστός και προσπαθήστε ξανα';
  		}
  		else
  		{
  		    
  			if(!isset($_SESSION['allowed']))
  			{
//  			++$_SESSION['lastticket'];
				$_SESSION['serial']->sendMessage("q\n");
				$_SESSION['serial']->sendMessage("t\n");
				preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);
				$_SESSION['allowed'][$_POST['amka']]=$read[0];
  			 
				echo 'Ο ΑΜΚΑ σας έχει  καταχωρηθεί στο μητρώο. Παρακαλώ περάστε απο το ταμείο';
  			}
 		 	else if(!isset($_SESSION['allowed'][$_POST['amka']]))
  			{
//  			++$_SESSION['lastticket'];
				$_SESSION['serial']->sendMessage("q\n");
				$_SESSION['serial']->sendMessage("t\n");
				preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);
				$_SESSION['allowed'][$_POST['amka']]=$read[0];
				echo 'Ο ΑΜΚΑ σας έχει  καταχωρηθεί στο μητρώο. Παρακαλώ περάστε απο το ταμείο';
			}
			else
			{
				echo 'Ο ΑΜΚΑ σας είναι ήδη καταχωρημένος στο μητρώο!';
			}
  		} 
	}
}
?>

<div id="content" >
	<div id="refresh" >
		<div id="lastserved">

<?php
		$_SESSION['serial']->sendMessage("c\n");
		$_SESSION['serial']->readPort();
		preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);
		print_r ( $read);
		
//    	echo '<h3>Αριθμός που εξυπηρετείται:</h2><h1>'.$_SESSION["lastserved"].'</br></h1>';
		if ($read)
			print "<h3>Αριθμός που εξυπηρετείται:</h2><h1>".$read[0]."</br></h1>";
?>

		</div>
		<div id="lastticket" >
	
<?php 
		$_SESSION["serial"]->sendMessage("t\n");
		preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);
//    	echo '<h3>Τελευταίος αριθμός στην ουρά:</h2><h1>'.$_SESSION["lastticket"].'</h1>';
    	echo "<h3>Τελευταίος αριθμός στην ουρά:</h2><h1>".$read[0]."</h1>";
?>

		</div>
	</div>
	<div id="form" >
    <form id="get_a_ticket" action="" method="POST">
      
       <!-- Επίθετο: <input type="text" name="Surname_Gr" >
        </br>
        Όνομα: <input type="text" name="Name_Gr" >
        </br>
        Όνομα Πατέρα: <input type="text" name="FName_Gr" >
        </br>
        Όνομα Μητέρας: <input type="text" name="MName_Gr" >
        </br>
        Ημ/νία Γέννησης: (Ημ/Μη/Χρ)
        <input type="text" size="2" maxlength="2" name="DBirth"  > /
        <input type="text" size="2" maxlength="2" name="MBirth"  > /
        <input type="text" size="2" maxlength="2" name="YBirth"  >
       -->
        ΑΜΚΑ: <input type="text" size="11" maxlength="11" name="amka" >
        </br>
        <input type="submit" value="submit" name="submit">
    </form>
	</div>
</div>
<footer>
  <p>About Us: <a href="about.html">click here</a>.</p>
</footer>
</body>
</html>
