<?php
include "serial_functions.php";
include "defines.php";

session_start();
register_shutdown_function('queue_shutdown');

queue_init();
queue_read_last_ticket();
queue_read_last_customer_served();
?>
