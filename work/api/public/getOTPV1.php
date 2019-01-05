<?php
require 'sinch.php';

$sinch = new sinch();
$countryCode = $_POST["countryCode"];
$phoneNumber = $_POST["mobileNumber"];
// echo 'sdf'.$phoneNumber;
$result = $sinch->sendCode($countryCode . $phoneNumber);
echo json_encode($result);

?>
