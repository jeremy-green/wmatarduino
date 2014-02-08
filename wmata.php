<?php
require 'php-serial/php_serial.class.php';

$serial = new \phpSerial\phpSerial;
$serial->phpSerial();
//chmod 777 /dev/ttyACM0
$serial->deviceSet('/dev/ttyACM0');
$serial->confBaudRate(9600);
$serial->confParity("none");
$serial->confCharacterLength(8);
$serial->confStopBits(1);
$serial->deviceOpen();
//wait for board to boot
sleep(5);

function grabIt($serial) {
  $stations = 'D03,F03';
  $api_key = '<API_KEY>';
  $url = 'http://api.wmata.com/StationPrediction.svc/json/GetPrediction/' . $stations . '?api_key=' . $api_key;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
  curl_setopt($ch, CURLOPT_HEADER, 0);
  $output = curl_exec($ch);
  curl_close($ch);
  $train_resp = json_decode($output);
  $trains = $train_resp->Trains;

  $line = 48;
  foreach ($trains as $key => $train) {
    $min = $train->Min;

    if ($min == 'BRD' || $min == 'ARR') {
      switch ($train->Line) {
        case 'RD':
          $line  = 49;
          break;
        case 'BL':
          $line = 50;
          break;
        case 'GR':
          $line = 51;
          break;
        case 'OR':
          $line = 52;
          break;
        case 'YL':
          $line = 53;
          break;
        default:
          //
          break;
      }
    }
  }
  $serial->sendMessage(chr($line));
  //sleep ten seconds then call aagain
  sleep(10);
  grabIt($serial);
}

grabIt($serial);
