<?php

namespace RevenueMonster\SDK\Modules;

class BridgeModule extends Module
{
    public function AlaCartAPI($method, $store)
    {
        $uri = $this->getOpenApiUrl('v3', '/service');
        return $this->mapResponse($this->callApi($method, $uri, $store)->send());
    }

    public function LoyaltyVoucherAPI($method, $store, $link)
    {
        $uri = $this->getOpenApiUrl('v3', '/loyalty'.$link);
        return $this->mapResponse($this->callApi($method, $uri, $store)->send());
    }
}
