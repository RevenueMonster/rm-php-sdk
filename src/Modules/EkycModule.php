<?php

namespace RevenueMonster\SDK\Modules;

use stdClass;

class EKYCModule extends Module
{
    public function call($args)
    {
        $uri = $this->getOpenApiUrl('v3', '/service');
        $req = new stdClass;
        $req->service = "ekyc";
        $req->version = "v1";

        $args = $args->jsonSerialize();
        $args = (array) array_merge((array) $args, (array) $req);

        return $this->mapResponse($this->callApi('post', $uri, $args)->send());
    }
}
