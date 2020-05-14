<?php

// use twilio-php-master\src\Twilio\Rest\Client; 
 require __DIR__ . '/Twilio/autoload.php';
 use Twilio\Rest\Client;

 // Declare variables and sanitize input
$custName = $_POST['fullname'];
$custEmail = $_POST['email'];
$phone = $_POST['number'];
$message = $_POST['message'];
$myemail = "hkthreading@gmail.com,palakhirpara1996@gmail.com,aruna.patel45@yahoo.com,samip1990@gmail.com";
// $aruna = "9723576526";
$aruna = "2142325441";


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

list($hr, $minute) = explode(":", $hourSelected, 2);
$hr = intval($hr);
if($hr < 12 && $hr >= 10){
    $hourSelected = "$hourSelected AM"; 
}
else{
    $hourSelected = "$hourSelected PM ";
}


// Send SMS
$sid    = "AC86b527d79aef7895cf0c70160ae2029e"; 
$token  = "pleaseinputtokenhere";
$twilio = new Client($sid, $token);
$person = "";

// Send SMS to Customer
if($nameSelected != 'Other'){
     $person = " with $nameSelected"; 
}
$textMsg = "Your appointment on " . $dateSelected . " at " . $hourSelected . $person . " is confirmed. Due to the current COVID-19 pandemic, you MUST have your FACE MASK on at all times while you are inside the salon. Please wait outside till you get a text or call from one of our employees. Thank you.";

// $textMsg = "Hi, " . $custName . ". This is from HK Threading Salon. Your appointment on " . $dateSelected . " at " . $hourSelected . $person ." is confirmed. Due to the current COVID-19 pandemic, you MUST have your FACE MASK on at all times while you are inside the salon. Please wait outside till you get a text or call from one of our employees. Thank you.";

$messageTwilio = $twilio->messages 
                  ->create($phone, // to 
                           array(  
                               "messagingServiceSid" => "MG4c7320eb91e01a6d75dd6dae8b05600a",
                               "body" => $textMsg
                           ) 
                  );

 // Send SMS to Employee
$textMsg = "HK Appointnment Made. " . $custName . " made an appointment on " . $dateSelected . " at " . $hourSelected . " with " . $nameSelected . " for " . $serviceSelected . ". Customer's phone number is " . $phone;
$messageTwilio = $twilio->messages 
                  ->create($aruna, // to 
                           array(  
                               "messagingServiceSid" => "MG4c7320eb91e01a6d75dd6dae8b05600a",
                               "body" => $textMsg
                           ) 
                  );

// Send Email Message to the Customer
$msgCustomer = "You have an Appointnment at HK Threading Salon!\nName: " . $custName . "\nStaff: " . $nameSelected . "\nDate: " . $dateSelected . "\nService: " . $serviceSelected . "\nTime: " . $hourSelected . "\nThank You for Choosing HK Threading Salon.";
mail($custEmail,"Appointnment at HK Threading Salon",$msgCustomer);

// Send Email Message to the Employee
$msgUs = "New Appointment Made\nCustomer Name: " . $custName . "\nStaff Member: " . $nameSelected . "\nDate: " . $dateSelected . "\nService: " . $serviceSelected . "\nTime: " . $hourSelected . "\nCustomer Phone Number: " . $phone . "\nMessage: " . $message;
mail($myemail,"New Appointment Made",$msgUs);

echo "$msgCustomer Email sent to the Customer and the HK Threading";


?>
