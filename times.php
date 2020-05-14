<?php

$date = ($_GET['dt']);

error_reporting(-1);
ini_set('display_errors', 'On');
$name = utf8_decode($_GET['nm']);


$con = mysqli_connect('localhost','palak_hirpara','qwerty123', 'hkthreading');
// $con = mysqli_connect('localhost','root','', 'hkthreading');
// ini_set('display_errors', 'On');

if (!$con) {

    echo mysqli_connect_error();
    die('Could not connect:');


    echo "Connection Not Successful";
    $error = 'Unable to connect to the database server.';
 
}


mysqli_select_db($con, "hkthreading");
$name = trim($name," ");
$date = trim($date," ");
$date = date("Y-m-d", strtotime($date));
$sql= "SELECT * FROM employees WHERE DATE(Date) ='$date' AND name = '$name'";
$result = mysqli_query($con,$sql) or die(mysqli_error()) ;

$num=mysqli_num_rows($result); 
//echo $sql;
//echo $num;

if ( false===$result ) {
   //echo mysql_error()." ".$query; 
  //echo "REUSLTING FALSE";
}

$data=array();
if($result)
{
  while($row = mysqli_fetch_array($result))
  {
    //echo "<h1>".$row['name']."</h1>";
    $data[] = $row['Hour'];

  }
  $data_json = json_encode($data); 
  echo $data_json;
} 

//echo "RESULT NOT CAME"; 
mysqli_close($con);
?>

