<?php
session_start();
include "defines.php";
include "serial_functions.php";

queue_init();
?>

<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">
  <script type="text/javascript" src="jquery.js"></script>
<?php
include "jsrefresh.php";
?>
</head>

<body>

<?php
if(isset($_POST['submit'])) {
  $sel_radio = $_POST['selections'];
  if(isset($sel_radio)) {
    if($sel_radio == 'clearall') {
      queue_reset();

      $con = mysqli_connect(HOST, USER, PASS, DB, 9999) or die(mysqli_connect_error());
      $query = "delete from queue";
      $res = mysqli_query($con, $query) or die(mysqli_error());
    }
  }
}
?>

  <div id="infotitle">
    <h3>Γενικές Πληροφορίες:</h3>
  </div>

  <div id="info" name="info">
  </div>

  <br/>

  <div id="actionstitle" name="actionstitle">
    <h3>Επιλογές:</h3>
  </div>

  <div id="actions" name="actions">
    <form action="" name="selections" id="selections" method="POST">
      <input type="radio" class="radio" id="selShow" name="selections" value="showall" /> Εμφάνιση όλων των
        των ηλεκτρονικών εισιτηρίων <br/>
      <input type="radio" name="selections" class="radio" value="clearall" /> Επανεκκίνηση μηχανήματος / Καθαρισμός εγγραφών <br/>

      <input type="hidden" name="page" id="page" value=0 />
      <input type="submit" name="submit" id="submit" value="Καταχώρηση"/>
      <br></br>
      <br</br>
      <input type="submit" class="buttons" name="previous" id="previous" value="<"/>
      <input type="submit" class="buttons" name="next" id="next" value=">"/>
    </form>
  </div>
  <script type="text/javascript">
   if (document.getElementById('page').value == 0)
   {
    ///$('#next').hide();
    ///$('#previous').hide();
   }
  $('#next').click(function () {
  	document.getElementById('page').value = 1;
        $('input[name="selections"][value="showall"]').prop('checked', true);
  });
  $('#previous').click(function () {
  	document.getElementById('page').value = -1;
        $('input[name="selections"][value="showall"]').prop('checked', true);
  });
  

  
  </script>

  <div id="dbentries" name="dbentries">
<?php
function getFromDB($page){
      	$con = mysqli_connect(HOST, USER, PASS, DB, 9999) or die(mysqli_connect_error());
      	$numPage=$page;
      	$offset=$numPage * 5;
      	$query = "select * from queue LIMIT 5 OFFSET $offset";
      	$res = mysqli_query($con, $query) or die(mysqli_error());
      	if($res->num_rows > 0) {
        		echo "<table><tbody><tr><th>ID</th><th>AMKA</th><th>Σειρά</th><th>Ημερομηνία</th></tr>";
        		while($row = $res->fetch_array(MYSQLI_ASSOC)) {
          		$id = $row['id'];
          		$amka = $row['amka'];
          		$num = $row['num'];
          		$date = $row['date'];
          		echo "<tr>";
          		echo "<td>$id</td>";
          		echo "<td>$amka</td>";
          		echo "<td>$num</td>";
          		echo "<td>$date</td>";
          		echo "</tr>";
        			}
      		}
    		}
    		

if(isset($_POST['submit']) || isset($_POST['next']) || isset($_POST['previous']) ){
  $sel_radio = $_POST['selections'];
  if(isset($sel_radio)) {
    if($sel_radio == 'showall') {
    	if($_POST['page'] == 0) {
    		#echo $_POST['page'];
            $page= 0;
            $_SESSION["previous"]= $page;
            getFromDB($page);
    }
    	elseif($_POST['page'] == 1) {
            $page= $_SESSION["previous"] +1;
            $_SESSION["previous"]=$page;
            getFromDB($page);
    }
        elseif ($_POST['page']== -1) {
            $page= $_SESSION["previous"]-1;
            $_SESSION["previous"]=$page;
            getFromDB($page);
    
}
    	
    }
  }
  }



?>
     </tbody>
     </table>
  </div>
  <div id="about" name="about" value="about">
    <a href="about.html">Πληροφορίες</a>
  </div>
</body>
