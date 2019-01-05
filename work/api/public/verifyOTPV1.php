<?php
require 'sinch.php';

$sinch = new sinch();
$countryCode = $_POST["countryCode"];
$phoneNumber = $_POST["mobileNumber"];
$receivedCode = $_POST["oneTimePassword"];
$result = $sinch->verifyMobile($countryCode . $phoneNumber, $receivedCode);

echo json_encode($result);
?>
