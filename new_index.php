<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <link rel="stylesheet" type="text/css" href="style.css">

<?php
include "defines.php";
?>

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
</head>

<body>

<!-- QUEUE INFO -->

  <div id="queue">
  </div>

<!-- END QUEUE INFO -->

<!-- NEW CUSTOMER - AMKA AUTH -->
  <div id = "new_cust" name = "new_cust">
    <form name="cust_det" id="cust_det" method="POST" action="">
      AMKA: <input type="text" name="amka" id="amka" value="" />
      <input type="submit" name="submit" id="submit" value="Καταχώρηση" />
    </form>
  </div>
<!-- END NEW CUSTOMER - AMKA AUTH -->

</body>
</html>
