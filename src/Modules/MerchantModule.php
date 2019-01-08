<?php

namespace RM\SDK\Modules;

use RM\SDK\Models\Merchant as Merchant;

class MerchantModule extends Module 
{
    public function profile()
    {
        $url = 'https://sb-open.revenuemonster.my/v3/merchant';
        return $this->callApi('get', $url)->send()->body->item;
    }

    public function subscriptions() 
    {
        $url = 'https://sb-open.revenuemonster.my/v3/merchant/subscriptions';
        return $this->callApi('get', $url)->send()->body->item;
    }
}