<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>

<body>
<?php
include 'PhpSerial.php';

$serial = new PhpSerial;
#$serial->deviceSet("/dev/ttyUSB0");
#$serial->deviceSet("/dev/pts/30");
$serial->deviceSet("/tmp/ttyeqemu");
$serial->confBaudRate(38400);
$serial->confParity("none");
$serial->confCharacterLength(8);
$serial->confStopBits(1);
$serial->confFlowControl("none");

$serial->deviceOpen('r+') or die("failed to open device\n");

#$serial->sendMessage("h\n");
#print "help:".$serial->readPort()."\n";

print "<table border=1><tbody>\n";
print "<tr>\n";
print "<th>Επόμενος πελάτης</th>\n";
print "<th>Σειρά (τελευταίο χαρτάκι)</th>\n";
print "</tr>\n";

print "<tr>\n";
print "<td>";
$serial->sendMessage("c\n");
preg_match('/\d+/', $serial->readPort(), $read);
if ($read)
	print $read[0];
print "</td>\n";
print "<td>";
$serial->sendMessage("t\n");
preg_match('/\d+/', $serial->readPort(), $read);
if ($read)
	print $read[0];
print "</td>\n";
print "</tr>\n";
print "</tbody></table>\n";

$serial->deviceClose();
?>
</body>
</html>
