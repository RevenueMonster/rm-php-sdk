<?php

require __DIR__.'/../vendor/autoload.php';
// require __DIR__.'/src/helper/util.php';

use RevenueMonster\SDK\RevenueMonster;
use RevenueMonster\SDK\Exceptions\ApiException;
use RevenueMonster\SDK\Exceptions\ValidationException;
use RevenueMonster\SDK\Request\QRPay;
use RevenueMonster\SDK\Request\QuickPay;
use RevenueMonster\SDK\Request\WebPayment;

echo '<div style="width: 100%; word-break: break-all;">';
echo round(microtime(true) * 1000).'<br/>';
$rm = new RevenueMonster([
  'clientId' => '1553826822294112891',
  'clientSecret' => 'nbPqwJtxdiZBiSQkyWLOYPQEufOABAuv',
  'privateKey' => file_get_contents(__DIR__.'/private_key.pem'),
  // 'publicKey' => file_get_contents(__DIR__.'/public_key.pem'),
  'version' => 'stable',
  'isSandbox' => true,
]);


try {
  $qrPay = new QRPay();
  $qrPay->currencyType = 'MYR';
  $qrPay->amount = 100;
  $qrPay->isPreFillAmount = true;
  $qrPay->method = [];
  $qrPay->order->title = '服务费';
  $qrPay->order->detail = 'testing';
  $qrPay->redirectUrl = 'https://shop.v1.mamic.asia/app/index.php?i=6&c=entry&m=ewei_shopv2&do=mobile&r=order.pay_rmwxpay.complete&openid=ot3NT0dxs4A8h4sVZm-p7q_MUTtQ&fromwechat=1';
  $qrPay->storeId = '1553067342153519097';
  $qrPay->type = 'DYNAMIC';
  $response = $rm->payment->qrPay($qrPay);
  var_dump($response);
  
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
    "redirectUrl" => "https://shop.v1.mamic.asia/app/index.php?i=6&c=entry&m=ewei_shopv2&do=mobile&r=order.pay_rmwxpay.complete&openid=ot3NT0dxs4A8h4sVZm-p7q_MUTtQ&fromwechat=1",
    "storeId" => "10946114768247530",
    "type" => "DYNAMIC",
  ]);
  // echo '<p>';
  // echo '</p>';
  // $response = $rm->payment->qrCode('732eb1e935983d274695f250dee9eb75');
  // echo '<p>';
  echo '<p><b>QR Payment</b><p>';
  var_dump($response);
  // echo '</p>';
  // $response = $rm->payment->transactionsByQrCode('732eb1e935983d274695f250dee9eb75');
  // echo '<p>';
  // var_dump($response);
  // echo '</p>';
  // $response = $rm->payment->paginate(5);
  // echo '<p>';
  // var_dump($response);
  // echo '</p>';
  // $response = $rm->payment->find('190107025318010324788828');
  // echo '<p>';
  // var_dump($response);
  // echo '</p>';
  // $response = $rm->payment->findByOrderId('123443df32323414');
  // echo '<p>';
  // var_dump($response);
  // echo '</p>';
  $wp = new WebPayment();
  $wp->order->id = uniqid();
  $wp->order->title = 'Testing Web Payment';
  $wp->order->currencyType = 'MYR';
  $wp->order->amount = 100;
  $wp->order->detail = '';
  $wp->order->additionalData = '';
  $wp->storeId = "1553067342153519097";
  $wp->redirectUrl = 'https://google.com'; 
  $wp->notifyUrl = 'https://google.com';

  $response = $rm->payment->createWebPayment($wp);
  echo '<p>'.$response->checkoutId.'</p>'; // Checkout ID
  echo '<p>'.$response->url.'</p>'; // Payment gateway url

  $wp->order->id = '48842';
  $wp->order->title = '【原味系列】 猫山王榴';
  $wp->order->currencyType = 'MYR';
  $wp->order->amount = 13800;
  $wp->order->detail = '';
  $wp->order->additionalData = 'SH20190819100656262762';
  $wp->method = ['ALIPAY_CN'];
  $wp->storeId = "1553067342153519097";
  $wp->redirectUrl = 'http://ydd.gzchujiao.com/app/index.php?i=3&c=entry&m=ewei_shopv2&do=mobile&r=order.pay.success&id=442'; 
  $wp->notifyUrl = 'http://ydd.gzchujiao.com/addons/ewei_shopv2/payment/rm/notify.php';
  $wp->layoutVersion = 'v1';

  $response = $rm->payment->createWebPayment($wp);
  var_dump($response);
  echo '<p>'.$response->checkoutId.'</p>'; // Checkout ID
  echo '<p>'.$response->url.'</p>';

  $qp = new QuickPay;
  $qp->authCode = '281011026026517778602435';
  $qp->order->id = '443';
  $qp->order->title = '【原味系列】 猫山王榴';
  $qp->order->currencyType = 'MYR';
  $qp->order->amount = 10;
  $qp->order->detail = '';
  $qp->order->additionalData = 'SH20190819100656262762';
  $qp->ipAddress = '8.8.8.8';
  $qp->storeId = "1553067342153519097";

  echo '<p>QuickPay</p>';
  $response = $rm->payment->quickPay($qp);
  var_dump($response);

} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(ValidationException $e) { 
  var_dump($e->getMessage());
}  catch(Exception $e) {
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
