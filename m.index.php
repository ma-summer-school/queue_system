<?php
include "defines.php";
include "serial_functions.php";
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="mstyle.css">

  <script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
  <script type="text/javascript">
  <!--
  $(document).ready(function() {
    var auto_refresh = setInterval(
    function() {
        $("#queue").load("queueinfo.php?randval=" + Math.floor(Math.random() * 101));
    }, <?php echo REFRESH_TIME; ?>);
    });
  -->
  </script>
  <script>
  <!-- 
     if($(window).width() > <?php echo SCREEN_WIDTH ?> )
	      	document.location = "index.php";
  -->   
 </script>


</head>

<body>

<!-- QUEUE INFO -->

  <div id="queue">
  </div>

<!-- END QUEUE INFO -->

<!-- NEW CUSTOMER - AMKA AUTH -->
  <div id="new_cust" name="new_cust">
    <form name="cust_det" id="cust_det" method="POST" action="">
      AMKA: <input type="text" name="amka" id="amka" value="" maxlength="11"/>
      <input type="submit" name="submit" id="submit" value="Καταχώρηση" />
    </form>
  </div>
<!-- END NEW CUSTOMER - AMKA AUTH -->

  <div id="message" name="message">
<?php
if(isset($_POST['submit'])) {
  if(isset($_POST['amka'])) {
    $_POST['amka']=preg_replace("/[^0-9]/", "", $_POST['amka']);

    if(strlen($_POST['amka']) != AMKA_LENGTH)
    {
      echo 'Μη εγκύρος ΑΜΚΑ, βεβαιωθείτε οτι ο ΑΜΚΑ που έχετε εισάγει είναι σωστός και προσπαθήστε ξανα';
      return;
    }

    $day = substr($_POST['amka'], 0, 2);
    $month =substr($_POST['amka'], 2, 2);
    $year =substr($_POST['amka'], 4, 2);

    if(!checkdate($month,$day, $year)) { 
      echo 'Μη εγκύρος ΑΜΚΑ, βεβαιωθείτε οτι ο ΑΜΚΑ που έχετε εισάγει είναι σωστός και προσπαθήστε ξανα';
      return;
    }

    $con = mysqli_connect(HOST, USER, PASS, DB, 9999) or die(mysqli_connect_error());
    $query = "select * from queue where amka like '$_POST[amka]'";
    $res = mysqli_query($con, $query);

    if($res->num_rows > 0) {
      echo 'Ο ΑΜΚΑ που προσπαθείτε να καταχωρήσετε έχει ήδη πάρει σειρά. Παρακαλούμε επικοινωνήστε με τη δημόσια υπηρεσία.';
      return;
    }

    queue_init();
    $num = queue_get_last_ticket() + 1;

    $query = "insert into queue (num, amka, date) values ($num, '$_POST[amka]', NOW());" or die(mysqli_error());
    $res = mysqli_query($con, $query);
    if ($res == FALSE)
    {
      echo 'Παρακαλούμε προσπαθήστε ξανα';
      return;
    }
    mysqli_close($con);
    queue_add();

    echo "Έχετε τον αριθμό $num. Παρακαλούμε να προσέλθετε στη δημόσια υπηρεσία με το ΑΜΚΑ σας $_POST[amka] και την ταυτότητά σας.";
  }
}
?>
  </div>
</body>
</html>

