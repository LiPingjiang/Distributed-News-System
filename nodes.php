<?php

header("Access-Control-Allow-Origin: *");

header('Content-type:application/json;charset=utf-8');

switch ( $_GET['TYPE'] )
{
	case 'GET':{
		$con = mysqli_connect('localhost','root','rootuser');
		if (!$con) {
			die('Could not connect: ' . mysqli_error($con));
		}
		mysqli_select_db($con,"distributed_system");
		$sql="SELECT * FROM nodes";
		$result = mysqli_query($con,$sql);

		$arr = array ( );
									
		while($row = mysqli_fetch_array($result)) {
			$arr[] = array( 'ID'=>$row['ID'], 'Name'=>$row['Name'], 'IPAddress'=>$row['IPAddress'], 'Password' => $row['Password'] );
		}

		echo json_encode($arr);

		break;
	}
	case 'POST':{
		$con = mysqli_connect('localhost','root','rootuser');
		if (!$con) {
			die('Could not connect: ' . mysqli_error($con));
		}

		mysqli_select_db($con,"distributed_system");

		//reset auto increasement index
		mysqli_query($con,"ALTER TABLE nodes AUTO_INCREMENT = 1");
		
		$sql="INSERT INTO `nodes`( `Name`, `IPAddress`, `Password` ) VALUES ('" . $_GET['Name'] . "','" . $_GET['IPAddress'] . "','" . $_GET['Password']  . "')";

		$result = mysqli_query($con,$sql);

		mysqli_close($con);

				
		echo $result;

		break;
	}

	default:
		echo 'bye';
}
?>

