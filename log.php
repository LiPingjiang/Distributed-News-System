<?php

header("Access-Control-Allow-Origin: *");

header('Content-type:application/json;charset=utf-8');

switch ( $_GET['TYPE'] )
{
	case 'WRITE':{
		$con = mysqli_connect('localhost','root','rootuser');

		if (!$con) {
			die('Could not connect: ' . mysqli_error($con));
		}

		mysqli_select_db($con,"distributed_system");

		//reset auto increasement index
		mysqli_query($con,"ALTER TABLE log AUTO_INCREMENT = 1");
 
		$sql="INSERT INTO `log`( `Timestamp`, `Log` ) VALUES ('" . $_GET['Timestamp'] . "','" . $_GET['Log'] . "')";

		$result = mysqli_query($con,$sql);

		mysqli_close($con);
				
		echo $result;

		break;

	}
	default:
		echo 'bye';
}

