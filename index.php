<?php
session_start();
$_SESSION["lastserved"]=isset($_SESSION["lastserved"]) ? $_SESSION["lastserved"] : 0 ;
$_SESSION["lastticket"]=isset($_SESSION["lastticket"]) ? $_SESSION["lastticket"] : 0 ; 
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script src="jquery.js"></script>
  <script>
    if($(window).width() <= 400)
      document.location = "m.index.php";
  </script>
  <script type="text/javascript">//script refreshing every 5secs
    var auto_refresh = setInterval( function () { 
    $('#refresh').load('refresh.php').fadeIn("slow");
    }, 500); // refresh every 10000 milliseconds 
  </script>
</head
<body>
<?php
if(isset($_POST['submit']))
{
   ++$_SESSION['lastticket'];
}

if(isset($_POST['amka']))
{
  $_POST['amka']=preg_replace("/[^0-9]/", "", $_POST['amka']);
  if( strlen($_POST['amka'])!=11)
  {
    $_POST['amka']="";
  } 
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
        Επίθετο: <input type="text" name="Surname_Gr" >
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
        </div>
        ΑΜΚΑ: <input type="text" size="11" maxlength="11" name="amka" >
        </br>
        <input type="submit" value="submit" name="submit">
    </form>
	</div>
</div>
</body>
</html>
