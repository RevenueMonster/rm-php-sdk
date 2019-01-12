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

// Initialise sdk instance
$rm = new RevenueMonster([
  'clientId' => '5499912462549392881',
  'clientSecret' => 'pwMapjZzHljBALIGHxfGGXmiGLxjWbkT',
  'privateKey' => file_get_contents(__DIR__.'/private_key.pem'),
  'sandbox' => false,
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

// create QR pay
try {
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
} catch(ApiException $e) {
  echo "statusCode : {$e->getCode()}, errorCode : {$e->getErrorCode()}, errorMessage : {$e->getMessage()}";
} catch(Exception $e) {
  echo $e->getMessage();
}

```
