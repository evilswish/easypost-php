<?php

// Example Code

EasyPost::setApiKey("cueqNZUb3ldeWTNX7MU3Mel8UXtaAMUi");

$address = array('street1' => '388 Townsend St',
                           'street2' => 'Apt 20',
                           'city' => 'San Francisco',
                           'state' => 'CA',
                           'zip' => '94107');

echo "<p>";
$response = EasyPost_Address::verify($address);
echo $response['address'];
echo "</p>";

$rates = array(
    'parcel' => array(
      'predefined_package' => 'SmallFlatRateBox',
      'weight' => 10.0
    ),
    'to' => array(
        'name' => 'Reed Rothchild',
        'street1' => '101 California St',
        'street2' => 'Suite 1290',
        'city' => 'San Francisco',
        'state' => 'CA',
        'zip' => '94111'
    ),
    'from' => array(
        'name' => 'Dirk Diggler',
        'phone' => '3108085243',
        'street1' => '300 Granelli Ave',
        'city' => 'Half Moon Bay',
        'state' => 'CA',
        'zip' => '94019'
    ),
    'carrier' => 'USPS',
    'service' => 'Priority'
  );

echo "<p>";
$response = EasyPost_Postage::rates($rates);
echo $response['rates'];
echo "</p>";

echo "<p>";
$response = EasyPost_Postage::buy($rates);
echo $response['rate'];
echo "</p>";

echo "<p>";
echo EasyPost_Postage::get("test.png");
echo "</p>";

echo "<p>";
echo EasyPost_Postage::listAll();
echo "</p>";

?>