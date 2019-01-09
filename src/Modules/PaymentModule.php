<?php

namespace RM\SDK\Modules;

class PaymentModule extends Module
{
    public function qrPay(array $args = [])
    {
        $uri = $this->getAPIUrl('v3', '/payment/transaction/qrcode');
        return $this->callApi('post', $uri, $args)->send()->body->item;
    }

    public function qrCode(string $qrCode)
    {
        $uri = $this->getAPIUrl('v3', "/payment/transaction/qrcode/$qrCode");
        return $this->callApi('get', $uri)->send()->body->item;
    }
    
    public function transactionsByQrCode(string $qrCode, int $limit = 10)
    {
        $uri = $this->getAPIUrl('v3', "/payment/transaction/qrcode/$qrCode/transactions?limit=$limit");
        return collect($this->callApi('get', $uri)->send()->body->items);
    }

    public function quickPay(array $args = [])
    {
        $uri = $this->getAPIUrl('v3', '/payment/quickpay');
        return $this->callApi('post', $uri, $args)->send()->body->item;
    }

    public function refund(array $args = [])
    {
        $uri = $this->getAPIUrl('v3', '/payment/refund');
        return $this->callApi('post', $uri, $args)->send()->body->item;
    }

    public function reverse(array $args = [])
    {
        $uri = $this->getAPIUrl('v3', '/payment/reverse');
        return $this->callApi('post', $uri, $args)->send()->body->item;
    }

    public function paginate(int $limit = 100)
    {
        $uri = $this->getAPIUrl('v3', "/payment/transactions?limit=$limit");
        return collect($this->callApi('get', $uri)->send()->body->items);
    }

    public function find(string $transactionId)
    {
        $uri = $this->getAPIUrl('v3', "/payment/transaction/$transactionId");
        return $this->callApi('get', $uri)->send()->body->item;
    }

    public function findByOrderId(string $orderId)
    {
        $uri = $this->getAPIUrl('v3', "/payment/transaction/order/$orderId");
        return $this->callApi('get', $uri)->send()->body->item;
    }
}