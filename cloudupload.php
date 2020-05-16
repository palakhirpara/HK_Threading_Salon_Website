<?php
require __DIR__ . '/vendor/autoload.php';

use Google\Spreadsheet\DefaultServiceRequest;
use Google\Spreadsheet\ServiceRequestFactory;
use GuzzleHttp\Client;

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
$phone = preg_replace('/\D+/', '', $phone);
$custEmail = trim($custEmail);
$message = trim($message);
$nameSelected = trim($nameSelected, "\n");
$nameSelected = trim($nameSelected);
$serviceSelected = trim($serviceSelected, " ");
$serviceSelected = trim($serviceSelected, "\n");
$serviceSelected = trim($serviceSelected, " ");

// Add AM or PM to Hour selected
list($hr, $minute) = explode(":", $hourSelected, 2);
$hr = intval($hr);
if($hr < 12 && $hr >= 10){
    $hourSelected = "$hourSelected AM"; 
}
else{
    $hourSelected = "$hourSelected PM ";
}

// Set Variables
$apiKey = "PUT_API_KEY_HERE";
$apiUrl = 'https://sheets.googleapis.com/v4/spreadsheets/';
$spreadsheetId = '1uWbypQAZ7-t7OKaDeib0wdbuWZPDYU0dUicY_fti00M';

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
echo "Appointment Saved to Google Sheet\n";

// Update the Filter (Filter by Date is today and Sort by Hour in ASCENDING order)
// raw json in pretty at the end of the file
$raw_json = '{"requests":[{"setBasicFilter":{"filter":{"range":{"sheetId":0,"startRowIndex":0,"startColumnIndex":0,"endColumnIndex":10},"sortSpecs":[{"sortOrder":"ASCENDING","dimensionIndex":1}],"criteria":{"0":{"condition":{"type":"DATE_EQ","values":[{"relativeDate":"TODAY"}]}}}}}}],"includeSpreadsheetInResponse":true}';
$myJSON = json_decode($raw_json);
$client = new GuzzleHttp\Client();
$res = $client->request('POST', $apiUrl . $spreadsheetId . ':batchUpdate?alt=json&access_token='. $accessToken.'&prettyPrint=true&key=' . $apiKey, ['json' => $myJSON]);
echo "Sheet Fitler Updated. POST Status: " . $res->getStatusCode() . "\n";





// {
//   "requests": [
//     {
//       "setBasicFilter": {
//         "filter": {
//           "range": {
//             "sheetId": 0,
//             "startRowIndex": 0,
//             "endRowIndex": 500, // not required
//             "startColumnIndex": 0,
//             "endColumnIndex": 10
//           },
//           "sortSpecs": [
//             {
//               "sortOrder": "ASCENDING",
//               "dimensionIndex": 1
//             }
//           ],
//           "criteria": {
//             "0": {
//               "condition": {
//                 "type": "DATE_EQ",
//                 "values": [
//                   {
//                     "relativeDate": "TODAY"
//                   }
//                 ]
//               }
//             }
//           }
//         }
//       }
//     }
//   ],
//   "includeSpreadsheetInResponse": true
// }


