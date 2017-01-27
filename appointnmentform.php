<?php
// Emails form data to you and the person submitting the form
// This version requires no database.
// Set your email below

// Variables
// Receive and sanitize input
$custName = $_POST['fullname'];
$custEmail = $_POST['email'];
$phone = $_POST['number'];
$message = $_POST['message'];
//$myemail = "hkthreading@gmail.com"; // Replace with your email, please
$myemail = "palakhirpara1996@gmail.com";


$nameSelected = $_POST['name'];
$dateSelected = $_POST['date'];
$serviceSelected = $_POST['service'];
$hourSelected = $_POST['hour'];

 $serviceSelected = trim($serviceSelected, " ");
 $nameSelected = trim($nameSelected, "\n");
 $serviceSelected = trim($serviceSelected, "\n");
 $serviceSelected = trim($serviceSelected, " ");
 $nameSelected = trim($nameSelected);
 $custEmail = trim($custEmail);
 $phone = trim($phone);
 $message = trim($message);


if($hourSelected <= 12 && $hourSelected >= 10){
	$hourSelected = "$hourSelected:00 AM";
	
}
else{
	$hourSelected = "$hourSelected:00 PM ";
}



// Send Message to the Customer
$msgCustomer = "You have an Appointnment at HK Threading Salon!\nName: " . $custName . "\nStaff: " . $nameSelected . "\nDate: " . $dateSelected . "\nService: " . $serviceSelected . "\nTime: " . $hourSelected . "\nThank You for Choosing HK Threading Salon";


$msgUs = "New Appointment Made\nCustomer Name: " . $custName . "\nStaff Member: " . $nameSelected . "\nDate: " . $dateSelected . "\nService: " . $serviceSelected . "\nTime: " . $hourSelected . "\nCustomer Phone Number: " . $phone . "\nMessage: " . $message;



mail($custEmail,"Appointnment at HK Threading Salon",$msgCustomer);
mail($myemail,"New Appointment Made",$msgUs);

echo "$msgCustomer Email sent to the Customer and the HK Threading";

?>
