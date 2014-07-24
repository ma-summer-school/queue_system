

<?php
	echo "DEVICE OPEN MODULE</br>";
	$device="/tmp/ttyeqemu";
	$fd=fopen($device,"r+b");
	
	if($fd==FALSE)
	{
	   echo "FAILED TO OPEN DEVICE".$device;
	}
	else
	{
	$n=fwrite($fd,"n\n");
	if($n==FALSE)
	echo "ERROR WRITING TO DEVICE".$device."</br>";
	else
	echo  $n."</br>";
	echo "Trying to read from device :";
	$str="a";
	while($str!=FALSE)
	{

	while(TRUE)
	{
	$num=18;
	/*EDW h fread kremaei an  num >= (oti exei sto buffer h seiriakh) 
	$str=fread($fd,);
	echo "string read:". $str."</br>";
	echo "$str length:".strlen($str);
	}
	}
	fclose($fd);
	}


?>