<?php
// Create connection
//get request data from client(terminal)
//getting form follow.
//GET['serverAddress'],GET['userName'],GET['password'],GET['serverPort']
//
$con=mysqli_connect("localhost","root","","magento");
// $db = mysqli_select_db("magento",$con)
// Check connection
if (mysqli_connect_errno())
{
  echo "Failed to connect to MySQL: " . mysqli_connect_error();
}
 
$sql = "SHOW TABLES";
$filename = 'file'.(rand()).'.csv';
if ($result = mysqli_query($con, $sql))
{
	$fp = fopen($filename, 'w');
	while($table = mysqli_fetch_array($result,MYSQL_NUM))
	{	
		if($result1 = mysqli_query($con,"SHOW COLUMNS FROM $table[0]")){

			$num = mysqli_affected_rows($con);
			$res = mysqli_fetch_all($result1); 

			for($i=0;$i<($num-1);$i++){
				if($res[$i][1] > $res[$i+1][1]){
					$t = $res[$i];
					$res[$i] = $res[$i+1];
					$res[$i+1] = $res[$i];
				}
			}

			for($i=0;$i<$num;$i++){
	    		fputcsv($fp, array($table[0],$res[$i][0],$res[$i][1]));
			}
			mysqli_free_result($result1);
		}
	}
	fclose($fp);
	mysqli_free_result($result);
	// unlink($filename);
	// echo json_encode($resultArray);
}
 
// Close connections
mysqli_close($con);
?>