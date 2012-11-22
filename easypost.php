<?php

class EasyPost {
  private static $base_url = 'http://www.easypost.co/api';
  public static $api_key = '...';

  public static function setApiKey($api_key) {
    self::$api_key = $api_key;
  }

  public static function apiUrl($type, $action) {
    return self::$base_url . '/' . $type . '/' . $action;
  }

  public static function post($url, $params) {
    $process = curl_init($url);
    curl_setopt($process, CURLOPT_USERPWD, self::$api_key . ":");
    curl_setopt($process, CURLOPT_POST, 1);
    if(empty($params)) {
      $params = array();
    }
    curl_setopt($process, CURLOPT_POSTFIELDS, http_build_query($params));
    $return = json_decode(curl_exec($process));
    return $return;
  }

}

class EasyPost_Address {
  private static $type = "address";

  public static function verify($address) {
    $params = array('address' => $address);
    return EasyPost::post(EasyPost::apiUrl(self::$type, "verify"), $params);
  }
}

class EasyPost_Postage {
  private static $type = "postage";

  public static function rates($params) {
    return EasyPost::post(EasyPost::apiUrl(self::$type, "rates"), $params);
  }

  public static function compare($params) {
    return self::rates($params);
  }

  public static function buy($params) {
    return EasyPost::post(EasyPost::apiUrl(self::$type, "buy"), $params);
  }

  public static function get($filename) {
    array('label_file_name' => $filename);
    return EasyPost::post(EasyPost::apiUrl(self::$type, "get"), array('label_file_name' => $filename));
  }

  public static function listAll() {
    return EasyPost::post(EasyPost::apiUrl(self::$type, "list"));
  }


}


// Example Code

EasyPost::setApiKey("cueqNZUb3ldeWTNX7MU3Mel8UXtaAMUi");

$address = array('street1' => '388 Townsend St',
                           'street2' => 'Apt 20',
                           'city' => 'San Francisco',
                           'state' => 'CA',
                           'zip' => '94107');

echo "<p>";
echo EasyPost_Address::verify($address)['address'];
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
echo EasyPost_Postage::rates($rates)['rates'];
echo "</p>";

echo "<p>";
echo EasyPost_Postage::buy($rates)['rate'];
echo "</p>";

echo "<p>";
echo EasyPost_Postage::get("test.png");
echo "</p>";

echo "<p>";
echo EasyPost_Postage::listAll();
echo "</p>";

?>
