<?php
include "defines.php";
include "PhpSerial.php";

function queue_init()
{
  session_start();
  if (!isset($_SESSION["start"]))
  {
    $_SESSION["serial"] = new PhpSerial;
    $_SESSION["serial"]->deviceSet("/tmp/ttyeqemu");
    $_SESSION["serial"]->confBaudRate(38400);
    $_SESSION["serial"]->confParity("none");
    $_SESSION["serial"]->confCharacterLength(8);
    $_SESSION["serial"]->confStopBits(1);
    $_SESSION["serial"]->confFlowControl("none");
    $_SESSION["serial"]->deviceOpen('r+') or die("failed to open device\n");
  }
}

function queue_shutdown()
{
  if (isset($_SESSION["serial"]))
    $_SESSION["serial"]->deviceClose() or die("failed to close device\n");
}

function queue_read_last_ticket()
{
  /* read last ticket */
  $_SESSION["serial"]->sendMessage("t\n");
  preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);

  echo "<br/>Τελευταίο νούμερο που εκδόθηκε: ";
  print_r($read[0]);

  return $read[0];
}

function queue_read_last_customer_served()
{
  /* read last cust num */
  $_SESSION["serial"]->sendMessage("c\n");
  preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);

  echo "<br/>Αριθμός που εξυπηρετείται: ";
  echo $read[0];

  return $read[0];
}

function queue_get_last_ticket()
{
  /* read last cust num */
  $_SESSION["serial"]->sendMessage("t\n");
  preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);

  return $read[0];
}

function queue_get_last_customer()
{
  /* read last cust num */
  $_SESSION["serial"]->sendMessage("c\n");
  preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);

  return $read[0];
}

function queue_add()
{
  $_SESSION["serial"]->sendMessage("q\n");
  preg_match('/\d+/', $_SESSION["serial"]->readPort(), $read);

  return $read[0];
}

function queue_reset()
{
  $_SESSION["serial"]->sendMessage("r\n");
}

?>
