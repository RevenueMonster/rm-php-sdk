<?php

namespace RevenueMonster\SDK\Modules;

class MerchantModule extends Module
{
    public function profile()
    {
        $uri = $this->getOpenApiUrl('v3', '/merchant');
        return $this->mapResponse($this->callApi('get', $uri)->send());
    }

    public function subscriptions()
    {
        $uri = $this->getOpenApiUrl('v3', '/merchant/subscriptions');
        return $this->mapResponse($this->callApi('get', $uri)->send());
    }
}
