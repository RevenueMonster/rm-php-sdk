# RM-API-SDK-PHP

```bash
composer require RevenueMonster/RM-API-SDK-PHP
```

```php
require __DIR__.'/../vendor/autoload.php';

use RM\SDK\RevenueMonster;

$rm = new RevenueMonster([
  'clientId' => '5499912462549392881',
  'clientSecret' => 'pwMapjZzHljBALIGHxfGGXmiGLxjWbkT',
  'privateKey' => file_get_contents(__DIR__.'/private_key.pem'),
  'sandbox' => false,
]);

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
} catch(Exception $e) {
    echo $e->getMessage();
}

```
