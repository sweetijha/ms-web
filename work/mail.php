<?php
// the message
$msg = $_POST['msg'];
$from = $_POST['from'];
// $msg = "Hi Mohit.\n\nYour order is confirmed.\n\n1. Dog food\n2. Biscuits";

// use wordwrap() if lines are longer than 70 characters
// $msg = wordwrap($msg,70);
$headers = "From: ".$from;

// send email
mail("mohit@ideesys.com,work@myshoperoo.com","Order from MyShoperoo",$msg, $headers);
?>
