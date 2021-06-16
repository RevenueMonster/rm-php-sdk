<?php

namespace RevenueMonster\SDK\Modules;

class UserModule extends Module
{
    public function profile()
    {
        $uri = $this->getOpenApiUrl('v3', '/user');
        return $this->mapResponse($this->callApi('get', $uri)->send());
    }
}
