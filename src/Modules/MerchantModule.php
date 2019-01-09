<?php

namespace RM\SDK\Modules;

use RM\SDK\Models\Merchant as Merchant;

class MerchantModule extends Module 
{
    public function profile()
    {
        $uri = $this->getAPIUrl('v3', '/merchant');
        return $this->callApi('get', $uri)->send()->body->item;
    }

    public function subscriptions() 
    {
        $uri = $this->getAPIUrl('v3', '/merchant/subscriptions');
        return collect($this->callApi('get', $uri)->send()->body->item);
    }
}