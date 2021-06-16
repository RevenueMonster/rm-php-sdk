<?php

namespace RevenueMonster\SDK\Modules;

class StoreModule extends Module
{
    public function paginate(int $limit = 10)
    {
        $uri = $this->getOpenApiUrl('v3', "/stores?limit=$limit");
        return $this->mapResponse($this->callApi('get', $uri)->send());
    }

    public function find(string $storeId)
    {
        $uri = $this->getOpenApiUrl('v3', "/store/$storeId");
        return $this->mapResponse($this->callApi('get', $uri)->send());
    }

    public function create($store)
    {
        $uri = $this->getOpenApiUrl('v3', '/store');
        return $this->mapResponse($this->callApi('post', $uri, $store)->send());
    }

    public function update($store)
    {
        $uri = $this->getOpenApiUrl('v3', '/store');
        return $this->mapResponse($this->callApi('patch', $uri, $store)->send());
    }

    public function delete(string $storeId)
    {
        $uri = $this->getOpenApiUrl('v3', "/store/$storeId");
        return $this->mapResponse($this->callApi('delete', $uri)->send());
    }
}
