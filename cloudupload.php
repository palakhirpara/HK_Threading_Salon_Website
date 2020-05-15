<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;

// Get the Input
$dateSelected = $_POST['date'];
$hourSelected = $_POST['hour'];
$custName = $_POST['fullname'];
$phone = $_POST['number'];
$custEmail = $_POST['email'];
$message = $_POST['message'];
$nameSelected = $_POST['name'];
$serviceSelected = $_POST['service'];

// Sanitize the input
$phone = trim($phone);
$custEmail = trim($custEmail);
$message = trim($message);
$nameSelected = trim($nameSelected, "\n");
$nameSelected = trim($nameSelected);
$serviceSelected = trim($serviceSelected, " ");
$serviceSelected = trim($serviceSelected, "\n");
$serviceSelected = trim($serviceSelected, " ");

list($hr, $minute) = explode(":", $hourSelected, 2);
$hr = intval($hr);
if($hr < 12 && $hr >= 10){
    $hourSelected = "$hourSelected AM"; 
}
else{
    $hourSelected = "$hourSelected PM ";
}

// Get the access
putenv('GOOGLE_APPLICATION_CREDENTIALS=' . __DIR__ . '/client_secret.json');
$client = new Google_Client;
$client->useApplicationDefaultCredentials();

$client->setApplicationName("HK Threading Appointments");
$client->setScopes(['https://www.googleapis.com/auth/drive','https://spreadsheets.google.com/feeds']);

if ($client->isAccessTokenExpired()) {
    $client->refreshTokenWithAssertion();
}

$accessToken = $client->fetchAccessTokenWithAssertion()["access_token"];
ServiceRequestFactory::setInstance(
    new DefaultServiceRequest($accessToken)
);

// Get our spreadsheet
$spreadsheet = (new Google\Spreadsheet\SpreadsheetService)
   ->getSpreadsheetFeed()
   ->getByTitle('HK Appointments');

// Get the first worksheet (tab)
$worksheets = $spreadsheet->getWorksheetFeed()->getEntries();
$worksheet = $worksheets[0];
$listFeed = $worksheet->getListFeed();

// Insert the Appointment
$listFeed->insert([
   'date' => $dateSelected,
   'time' => $hourSelected,
   'customername' => $custName,
   'customerphone' => $phone,
   'customeremail' => $custEmail,
   'message' => $message ,
   'employeename' => $nameSelected ,
   'service' => $serviceSelected 
]);

echo "Appointment Saved to Google Sheet";


