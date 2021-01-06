<?php

require __DIR__.'/../vendor/autoload.php';

use RevenueMonster\SDK\RevenueMonster;
use RevenueMonster\SDK\Request\PredictMykad;
use RevenueMonster\SDK\Request\VerifyFace;
use RevenueMonster\SDK\Exceptions\ApiException;
use RevenueMonster\SDK\Exceptions\ValidationException;

echo '<div style="width: 100%; word-break: break-all;">';
$rm = new RevenueMonster([
  'clientId' => '1553826822294112891',
  'clientSecret' => 'nbPqwJtxdiZBiSQkyWLOYPQEufOABAuv',
  'privateKey' => file_get_contents(__DIR__.'/private_key.pem'),
  'version' => 'stable',
  'isSandbox' => true,
]);

try {
  echo '<pre>';
  $mykad = new PredictMykad();
  $mykad->base64Image = file_get_contents(__DIR__.'/mykad.txt');
  $response = $rm->ekyc->call($mykad);
  var_dump($response);
  echo '</pre>';

  echo '<pre>';
  $image = file_get_contents(__DIR__.'/face.txt');
  $face = new VerifyFace();
  $face->base64Image1 = $image;
  $face->base64Image2 = $image;
  $response = $rm->ekyc->call($face);
  var_dump($response);
  echo '</pre>';

} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(ValidationException $e) { 
  var_dump($e->getMessage());
}  catch(Exception $e) {
  echo $e->getMessage();
}

?>