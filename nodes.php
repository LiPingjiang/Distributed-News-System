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

	default:
                echo 'bye';
}
?>

