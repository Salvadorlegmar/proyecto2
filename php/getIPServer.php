<?php
	$command="/sbin/ifconfig ".$_POST['Eth']." | grep 'inet addr:' | cut -d: -f2 | awk '{ print $1}'";
	$IP = exec ($command);
	echo $IP;
?>
