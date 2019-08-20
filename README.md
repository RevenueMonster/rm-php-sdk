# RM-API-SDK-PHP

```bash
composer require revenuemonster/sdk
```

### Covered Functions

- [x] Client Credentials (Authentication)
- [x] Refresh Token (Authentication)
- [x] Get Merchant Profile
- [x] Get Merchant Subscriptions
- [x] Get Stores
- [x] Get Stores By ID
- [x] Create Store
- [x] Update Store
- [x] Delete Store
- [x] Get User Profile
- [x] Payment (Transaction QR) - Create Transaction QRCode/URL
- [x] Payment (Transaction QR) - Get Transaction QRCode/URL
- [x] Payment (Transaction QR) - Get Transaction QRCode/URL By Code
- [x] Payment (Transaction QR) - Get Transactions By Code
- [x] Payment (Quick Pay) - Payment
- [x] Payment (Quick Pay) - Refund
- [x] Payment (Quick Pay) - Reverse
- [x] Payment (Quick Pay) - Get All Payment Transactions
- [x] Payment (Quick Pay) - Get All Payment Transaction By ID
- [ ] Payment (Quick Pay) - Daily Settlement Report
- [x] Payment (Checkout) - Create Web/Mobile Payment (New UI support)
- [ ] Give Loyalty Point
- [ ] Get Loyalty Members
- [ ] Get Loyalty Member
- [ ] Get Loyalty Member Point History
- [ ] Issue Voucher
- [ ] Void Voucher
- [ ] Get Voucher By Code
- [ ] Get Voucher Batches
- [ ] Get Voucher Batch By Key
- [ ] Send Notification (Merchant)
- [ ] Send Notification (Store)
- [ ] Send Notification (User)

### Examples

```php
require __DIR__.'/vendor/autoload.php';

use RevenueMonster\SDK\RevenueMonster;
use RevenueMonster\SDK\Exceptions\ApiException;
use RevenueMonster\SDK\Exceptions\ValidationException;
use RevenueMonster\SDK\Request\WebPayment;
use RevenueMonster\SDK\Request\QRPay;

// Initialise sdk instance
$rm = new RevenueMonster([
  'clientId' => '5499912462549392881',
  'clientSecret' => 'pwMapjZzHljBALIGHxfGGXmiGLxjWbkT',
  'privateKey' => file_get_contents(__DIR__.'/private_key.pem'),
  'isSandbox' => false,
]);

// Get merchant profile
try {
  $response = $rm->merchant->profile();
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

// Get merchant subscriptions
try {
  $response = $rm->merchant->subscriptions();
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

// Get merchant's stores
try {
  $response = $rm->store->paginate(10);
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

// Get transactions by QR Code
try {
  $qrCode = '732eb1e935983d274695f250dee9eb75';
  $response = $rm->payment->transactionsByQrCode($qrCode);
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

// Get transactions
try {
  $response = $rm->payment->paginate(5);
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

// Find transaction by transaction id
try {
  $transactionId = '100922222732432874823';
  $response = $rm->payment->find($transactionId);
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

// Find transaction by order id
try {
  $orderId = '1234';
  $response = $rm->payment->findByOrderId($orderId);
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

// create QR pay
try {
  $qrPay = new QRPay();
  $qrPay->currencyType = 'MYR';
  $qrPay->amount = 100;
  $qrPay->isPreFillAmount = true;
  $qrPay->order->title = '服务费';
  $qrPay->order->detail = 'testing';
  $qrPay->method = [];
  $qrPay->redirectUrl = 'https://shop.v1.mamic.asia/app/index.php?i=6&c=entry&m=ewei_shopv2&do=mobile&r=order.pay_rmwxpay.complete&openid=ot3NT0dxs4A8h4sVZm-p7q_MUTtQ&fromwechat=1';
  $qrPay->storeId = '1553067342153519097';
  $qrPay->type = 'DYNAMIC';
  $response = $rm->payment->qrPay($qrPay);
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}


try {
  $wp = new WebPayment;
  $wp->order->id = '10020';
  $wp->order->title = 'Testing Web Payment';
  $wp->order->currencyType = 'MYR';
  $wp->order->amount = 100;
  $wp->order->detail = '';
  $wp->order->additionalData = '';
  $wp->storeId = "1553067342153519097";
  $wp->redirectUrl = 'https://google.com';
  $wp->notifyUrl = 'https://google.com';
  $wp->layoutVersion = 'v1';

  $response = $rm->payment->createWebPayment($wp);
  echo $response->checkoutId; // Checkout ID
  echo $response->url; // Payment gateway url
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(ValidationException $e) {
  var_dump($e->getMessage());
}  catch(Exception $e) {
  echo $e->getMessage();
}
```
