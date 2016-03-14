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

				$sql = "SELECT * FROM news";
				$result = mysqli_query($con,$sql);

				$arr = array ( );
									

				switch ($_GET['NEWSTYPE'] ){
						case 'PUBLIC':{
								#$sql="SELECT * FROM news";
								#$result = mysqli_query($con,$sql);

								#$arr = array ( );
				
								

								while($row = mysqli_fetch_array($result)) {
										if($row['Type']== 'public')
												$arr[] = array( 'ID'=>$row['ID'], 'Type'=>$row['Type'], 'News'=>$row['News'], 'Time' => $row['Time'] );
								}
								#echo json_encode($arr);

								break;
						}
						case 'PRIVATE':{
								
								#$sql="SELECT * FROM news";
								#$result = mysqli_query($con,$sql);

								#$arr = array ( );
				
			

								while($row = mysqli_fetch_array($result)) {
										if($row['Type']== 'private')
												$arr[] = array( 'ID'=>$row['ID'], 'Type'=>$row['Type'], 'News'=>$row['News'], 'Time' => $row['Time'] );
								}
								#echo json_encode($arr);
								break;
						}
						default:{
								#$sql="SELECT * FROM news";
								#$result = mysqli_query($con,$sql);

								#$arr = array ( );
				 
								while($row = mysqli_fetch_array($result)) {
										$arr[] = array( 'ID'=>$row['ID'], 'Type'=>$row['Type'], 'News'=>$row['News'], 'Time' => $row['Time'] );
								}

								//echo json_encode($arr);
								break;
				
						}
							   
				}

				//echo json_encode($arr);

				//$jsonresult = json_encode($arr);
				$jsonresult = json_encode($arr);



				# --- ENCRYPTION ---

				//$iv = '12345678';
				//$passphrase = '8chrsLng';

				//$jsonresult =  base64_encode (mcrypt_encrypt(MCRYPT_BLOWFISH, $passphrase, $jsonresult, MCRYPT_MODE_CBC, $iv) ); 
				$jsonresult = base64_encode($jsonresult);


				echo $jsonresult;




				mysqli_close($con);

				break;
		}

		case 'UPDATE':{
				$con = mysqli_connect('localhost','root','rootuser');


				if (!$con) {
						die('Could not connect: ' . mysqli_error($con));
				}

				mysqli_select_db($con,"distributed_system");

				//$sql="UPDATE news SET 'Type'='"+$_GET['Type']+"','News'='"+$_GET['News']+"','Time'='"+date('Y-m-d')+"'" ;
					   
				//reset auto increasement index
				mysqli_query($con,"ALTER TABLE news AUTO_INCREMENT = 1");
		
				$sql="INSERT INTO `news`( `Type`, `News`, `Time` ) VALUES ('" . $_GET['Type'] . "','" . $_GET['News'] . "','" . date('Y-m-d') . "')";

				$result = mysqli_query($con,$sql);

				mysqli_close($con);

				
				echo $result;

				break;
	

		}
		default:
				echo 'bye';
}
?>
