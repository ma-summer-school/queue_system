<script type="text/javascript" src="https://code.jquery.com/jquery-latest.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  var auto_refresh = setInterval(
  function() {
      $("#info").load("queueinfo.php?randval=" + Math.floor(Math.random() * 101));
  }, <?php echo REFRESH_TIME; ?>);
  });
</script>
