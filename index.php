<?php
  include "PhpSerial.php";
  include "defines.php";

  session_start();
  
  if (!isset($_SESSION["serial"])) {
    $_SESSION["serial"] = new PhpSerial;
    $_SESSION["serial"]->deviceSet("/tmp/ttyeqemu");
    $_SESSION["serial"]->confBaudRate(38400);
    $_SESSION["serial"]->confParity("none");
    $_SESSION["serial"]->confCharacterLength(8);
    $_SESSION["serial"]->confStopBits(1);
    $_SESSION["serial"]->confFlowControl("none");
    $_SESSION["serial"]->deviceOpen('r+') or die("failed to open device\n");
  }
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">

<?php
	echo '
    <script src="jquery.js"></script>
    <script>
    <!-- 
    if($(window).width() <=' . SCREEN_WIDTH .' )
    document.location = "m.index.php";
    -->   
    </script>

    <script type="text/javascript">//script refreshing every 5secs
    <!--
    var auto_refresh = setInterval( function () { 
        $(' . '#refresh' . ').load("refresh.php").fadeIn("slow");
        },' . REFRESH_TIME . ');
    --> 
    </script>
    ';
?>

</head


<body>
<?php
  if(isset($_POST['submit'])) {
    if(isset($_POST['amka'])) {
      $_POST['amka']=preg_replace("/[^0-9]/", "", $_POST['amka']);

      if(strlen($_POST['amka']) != AMKA_LENGTH)
      {
        echo 'Μη εγκύρος ΑΜΚΑ, βεβαιωθείτε οτι ο ΑΜΚΑ που έχετε εισάγει είναι σωστός και προσπαθήστε ξανα';
        return;
      }

      $day= substr($_POST['amka'], 0, 2);
      $month=substr($_POST['amka'], 2, 2);
      $year=substr($_POST['amka'], 4, 2);

      if(!checkdate($month,$day, $year)) { 
        echo 'Μη εγκύρος ΑΜΚΑ, βεβαιωθείτε οτι ο ΑΜΚΑ που έχετε εισάγει είναι σωστός και προσπαθήστε ξανα';
        return;
      }

      if($_SESSION['allowed'][$_POST['amka']]) {
        echo 'Μη εγκύρος ΑΜΚΑ, βεβαιωθείτε οτι ο ΑΜΚΑ που έχετε εισάγει είναι σωστός και προσπαθήστε ξανα';
        return;
      }

      $_SESSION["serial"]->sendMessage("q\n");
      preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);
      if ($read)
        $_SESSION['allowed'][$_POST['amka']]=$read[0];
      echo 'Ο ΑΜΚΑ σας έχει  καταχωρηθεί στο μητρώο. Παρακαλώ περάστε απο το ταμείο';
    }
  }
?>

<div id="content" >
	<div id="refresh" >
		<div id="lastserved">

<?php 
  $_SESSION["serial"]->sendMessage("c\n");
  preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);
  $lastserved = $read ? $read[0] : 0;
  echo '<h3>Αριθμός που εξυπηρετείται:</h2><h1>'.$lastserved.'</br></h1>';
?>

		</div>
		<div id="lastticket" >
	
<?php 
  $_SESSION["serial"]->sendMessage("t\n");
  preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);
  $lastticket = $read ? $read[0] : 0;
  echo '<h3>Τελευταίος αριθμός στην ουρά:</h2><h1>'.$lastticket.'</h1>';
?>

		</div>
	</div>

	<div id="form" >
    <form id="get_a_ticket" action="" method="POST">
        ΑΜΚΑ: <input type="text" size = 
<?php
  echo AMKA_LENGTH
?>
        maxlength=
<?php 
  echo AMKA_LENGTH 
?>
        name="amka" />
        <input type="submit" value="submit" name="submit" />
    </form>
	</div>
</div>
<footer>
  <p>About Us: <a href="about.html">click here</a>.</p>
</footer>

</body>
</html>
