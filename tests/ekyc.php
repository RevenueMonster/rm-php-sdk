<?php

require __DIR__.'/../vendor/autoload.php';

use RevenueMonster\SDK\RevenueMonster;
use RevenueMonster\SDK\Request\EkycMyKad;
use RevenueMonster\SDK\Request\EkycFaceCompare;
use RevenueMonster\SDK\Request\EkycGetResult;
use RevenueMonster\SDK\Request\EkycGetMyKadResult;
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
  // ekyc - send in base64 mykad image
  echo '<pre>';
  $request = new EkycMyKad();
  $request->notifyUrl = "https://client-server/notify-webhook";
  $request->base64Image = file_get_contents(__DIR__.'/mykad.txt');
  $response = $rm->ekyc->call($request);
  var_dump($response);
  echo '</pre>';

  // ekyc - face compare of 2 different faces
  echo '<pre>';
  $image = file_get_contents(__DIR__.'/face.txt');
  $request = new EkycFaceCompare();
  $request->base64Image1 = $image;
  $request->base64Image2 = $image;
  $response = $rm->ekyc->call($request);
  var_dump($response);
  echo '</pre>';
  
  // ekyc - get complete ekyc result after liveness check
  echo '<pre>';
  $request = new EkycGetResult();
  $request->id = "62201d52239b18052126e289";
  $ekycResult = $rm->ekyc->call($request);
  var_dump($ekycResult);

  echo $ekycResult->mykadRequestId;
  echo '</pre>';
  
  // ekyc - get mykad specific result
  echo '<pre>';
  $request = new EkycGetMyKadResult();
  $request->id = $ekycResult->mykadRequestId;
  $response = $rm->ekyc->call($request);
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