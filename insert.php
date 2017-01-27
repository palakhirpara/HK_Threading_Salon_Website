 <?php
 
error_reporting(-1);
ini_set('display_errors', 'On');
 $con = mysqli_connect('localhost','palak_hirpara','qwerty123', 'hkthreading');

if (!$con) {

    echo mysqli_connect_error();
    die('Could not connect:');


    echo "Connection Not Successful";
    $error = 'Unable to connect to the database server.';
 
}


mysqli_select_db($con, "hkthreading");




$nameSelected = $_POST['name'];
 $dateSelected = $_POST['date'];
 $serviceSelected = $_POST['service'];
 $hourSelected = $_POST['hour'];


 // $serviceSelected = trim($serviceSelected, " ");
 // $nameSelected = trim($nameSelected, " ");
 // $nameSelected = mysqli_escape_string($con, $nameSelected);
 // $dateSelected = mysqli_escape_string($con, $dateSelected);
 // $serviceSelected = mysqli_escape_string($con, $serviceSelected);
 // $hourSelected = mysqli_escape_string($con, $hourSelected);
 $serviceSelected = trim($serviceSelected, " ");
 $nameSelected = trim($nameSelected, "\n");
  $serviceSelected = trim($serviceSelected, "\n");
 $serviceSelected = trim($serviceSelected, " ");
 $nameSelected = trim($nameSelected);

$dateSelected = date("Y-m-d", strtotime($dateSelected));



// $sql= "SELECT * FROM employees WHERE DATE(Date) ='$date' AND name = '$name'";
// $result = mysqli_query($con,$sql) or die(mysqli_error()) ;
$sql = "INSERT INTO employees (name, Date, Hour, Service) VALUES ('$nameSelected', '$dateSelected', '$hourSelected', '$serviceSelected');";

 $query = mysqli_query($con, $sql);

 echo $sql;
 echo('Datahas been saved');



  ?>





