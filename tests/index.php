<?php

require __DIR__.'/../vendor/autoload.php';
// require __DIR__.'/src/helper/util.php';

use RevenueMonster\SDK\RevenueMonster;
use RevenueMonster\SDK\Exceptions\ApiException;

echo '<div style="width: 100%; word-break: break-all;">';
echo round(microtime(true) * 1000).'<br/>';
$rm = new RevenueMonster([
  'clientId' => '1548837233666152574',
  'clientSecret' => 'VKAnRLBESgXwNgwSDbGNsvHzpxhNcvRu',
  'privateKey' => file_get_contents(__DIR__.'/private_key.pem'), 
  'version' => 'stable',
  'isSandbox' => false,
]);


try {
  echo '<p>';
  var_dump($rm->merchant->profile());
  echo '</p>';
  echo '<p>';
  var_dump($rm->merchant->subscriptions());
  echo '</p>';
  echo '<p>';
  var_dump($rm->store->paginate(1));
  echo '</p>';
  $response = $rm->payment->qrPay([
    "currencyType" => "MYR",
    "amount" => 100,
    "expiry" => [
      "type" => "PERMANENT",
    ],
    "isPreFillAmount" => true,
    "method" => ["WECHATPAY"],
    "order" => [
      "title" => "test",
      "detail" => "test",
    ],
    "redirectUrl" => "https://www.baidu.com",
    "storeId" => "10946114768247530",
    "type" => "DYNAMIC",
  ]);
  echo '<p>';
  var_dump($response);
  echo '</p>';
  echo '<p>QR PAY with unicode</p>';
  $response = $rm->payment->qrPay([
    "currencyType" => "MYR",
    "amount" => 100,
    "expiry" => [
      "type" => "PERMANENT",
    ],
    "isPreFillAmount" => true,
    "method" => ["WECHATPAY"],
    "order" => [
      "title" => "服务费",
      "detail" => "test",
    ],
    "redirectUrl" => "https://www.baidu.com",
    "storeId" => "10946114768247530",
    "type" => "DYNAMIC",
  ]);
  echo '<p>';
  var_dump($response);
  echo '</p>';
  $response = $rm->payment->qrCode('732eb1e935983d274695f250dee9eb75');
  echo '<p>';
  var_dump($response);
  echo '</p>';
  $response = $rm->payment->transactionsByQrCode('732eb1e935983d274695f250dee9eb75');
  echo '<p>';
  var_dump($response);
  echo '</p>';
  $response = $rm->payment->paginate(5);
  echo '<p>';
  var_dump($response);
  echo '</p>';
  $response = $rm->payment->find('190107025318010324788828');
  echo '<p>';
  var_dump($response);
  echo '</p>';
  $response = $rm->payment->findByOrderId('123443df32323414');
  echo '<p>';
  var_dump($response);
  echo '</p>';
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

// $rm->store->find($id); // $store->save();
// $rm->store->delete($id);
// $rm->store->create($store);
// $rm->store->save($store);
// $rm->user->profile();
// $rm->payment->createTxnQrCode();
// $rm->payment->getTxnQrByCode();
// $rm->payment->getTxnQrCodes();
// $rm->payment->getTransactionsByCode();
// $rm->payment->createQuickPay();
// $rm->payment->refund();
// $rm->payment->reverse();
// $rm->payment->transaction->all();
// $rm->payment->find();
// $rm->payment->all();
// $rm->loyalty->getMembers();
// $rm->loyalty->findMember();
// $rm->loyalty->getMemberPointHistories();
// $rm->pushNotification->byMerchant();
// $rm->pushNotification->byStore();
// $rm->pushNotification->byUser();
// var_dump($rm);

?>
<!-- <!DOCTYPE html>

<html lang="en">
  <head>
    <meta charset="utf-8" />
    <title>My PHP Website</title>
  </head>

  <body>
    <h1>My PHP Website</h1>
    <h2>fuck you lah</h2>
    <p>Here is some static content.</p>
    <p><?php echo "Here is some dynamic content"; ?></p>
  </body>
</html> -->
