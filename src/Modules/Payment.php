<?php

namespace RM\SDK\Modules;

class Payment extends Module
{
    public function qrPay(array $args = [])
    {
        $url = 'https://sb-open.revenuemonster.my/v3/payment/transaction/qrcode';
        
        $body = $this->callApi('post', $url, $args)->send()->body;
        var_dump(json_encode($body, JSON_UNESCAPED_SLASHES));
        return $body->item;
    }

    public function qrCode(string $qrCode)
    {
        $url = "https://sb-open.revenuemonster.my/v3/payment/transaction/qrcode/$qrCode";
        return $this->callApi('get', $url)->send()->body;
    }
    
    public function transactionsByQrCode(string $qrCode, int $limit = 10)
    {
        $url = "https://sb-open.revenuemonster.my/v3/payment/transaction/qrcode/$qrCode/transactions?limit=$limit";
        
        return $this->callApi('get', $url)->send()->body;
    }

    public function quickPay(array $args = [])
    {
        $url = 'https://sb-open.revenuemonster.my/v3/payment/quickpay';
        
        $body = $this->callApi('post', $url, $args)->send()->body;
        var_dump(json_encode($body, JSON_UNESCAPED_SLASHES));
        return $body->item;
    }

    public function refund(array $args = [])
    {
        $url = 'https://sb-open.revenuemonster.my/v3/payment/refund';
        
        $body = $this->callApi('post', $url, $args)->send()->body;
        var_dump(json_encode($body, JSON_UNESCAPED_SLASHES));
        return $body->item;
    }

    public function reverse(array $args = [])
    {
        $url = 'https://sb-open.revenuemonster.my/v3/payment/reverse';
        
        $body = $this->callApi('post', $url, $args)->send()->body;
        var_dump(json_encode($body, JSON_UNESCAPED_SLASHES));
        return $body->item;
    }

    public function paginate(int $limit = 100)
    {
        $url = "https://sb-open.revenuemonster.my/v3/payment/transactions?limit=$limit";
        $body = $this->callApi('get', $url)->send()->body;
        var_dump(json_encode($body));
        return $body;
    }

    public function find(string $transactionId)
    {
        $url = "https://sb-open.revenuemonster.my/v3/payment/transaction/$transactionId";
        return $this->callApi('get', $url)->send()->body;
    }

    public function findByOrderId(string $orderId)
    {
        $url = "https://sb-open.revenuemonster.my/v3/payment/transaction/order/$orderId";
        return $this->callApi('get', $url)->send()->body;
    }

    // public function dailySettlementReport(string $orderId)
    // {
    //     $url = "https://sb-open.revenuemonster.my/v3/payment/transaction/order/$orderId";
    //     return $this->callApi('get', $url)->send()->body;
    // }
}