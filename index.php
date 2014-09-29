<?php
include "defines.php";
include "serial_functions.php";
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">

<?php
include "jsrefresh.php";
?>

  <script>
  <!-- 
     if($(window).width() < <?php echo SCREEN_WIDTH ?> )
	      	document.location = "m.index.php";
  -->   
 </script>


</head>

<body>

<!-- QUEUE INFO -->
  <div id="intro">
    <h3>Γενικές Πληροφορίες</h3>
  </div>

  <div id="info">
  </div>

<!-- END QUEUE INFO -->

  <div id="new">
    <br/>
    <h3>Νέα έκδοση:</h3>
    Παρακαλούμε πληκτρολογείστε το ΑΜΚΑ σας:
  </div>
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

    queue_init();
    $last_cust = queue_get_last_customer();

    $con = mysqli_connect(HOST, USER, PASS, DB, 9999) or die(mysqli_connect_error());
    $query = "select * from queue where amka like '$_POST[amka]'";

    $res = mysqli_query($con, $query) or die(mysqli_error());
    if($res->num_rows > 0) {
      $row = $res->fetch_array(MYSQLI_ASSOC);
      if($row['num'] > $last_cust) {
        echo 'Ο ΑΜΚΑ που προσπαθείτε να καταχωρήσετε έχει ήδη πάρει σειρά. Παρακαλούμε επικοινωνήστε με τη δημόσια υπηρεσία.';
        return;
      }

      $num = queue_get_last_ticket() + 1;
      $query = "update queue set num = $num where amka = $_POST[amka]";
      $res = mysqli_query($con, $query) or die(mysqli_error());
      queue_add();
      echo "Η σειρά σας είχε περάσει. Έχετε τώρα τον αριθμό $num. Παρακαλούμε να προσέλθετε στη δημόσια υπηρεσία με το ΑΜΚΑ σας $_POST[amka] και την ταυτότητά σας.";
      return;
    }

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
  
  <div id="about" name="about" value="about">
    <a href="about.html">Πληροφορίες</a>
  </div>
</body>
</html>
