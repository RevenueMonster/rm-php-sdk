<?php

namespace RevenueMonster\SDK\Modules;

use RevenueMonster\SDK\Request\TokenizedCustomer;
use RevenueMonster\SDK\Request\RecurringCustomer;
use RevenueMonster\SDK\Request\CustomerOrderAmount;

class TokenizedCustomerModule extends Module
{

    /**
     * Create Recurring Customer
     * @param RecurringCustomer $args
     * @return stdClass
     * @throws ApiException
     */
    public function createRecurringCustomer($args)
    {
        if ($args instanceof RecurringCustomer) {
            $args = $args->jsonSerialize();
        }
// print_r($args);

        $uri = $this->getOpenApiUrl('v3', '/recurring-payment');
        return $this->mapResponse($this->callApi('post', $uri, $args)->send());
    }

    /**
     * Create Tokenized Customer
     * @param TokenizedCustomer $args
     * @return stdClass
     * @throws ApiException
     */
    public function createTokenizedPayment($args)
    {
        if ($args instanceof TokenizedCustomer) {
            $args = $args->jsonSerialize();
        }
// print_r($args);

        $uri = $this->getOpenApiUrl('v3', '/tokenized-payment');
        return $this->mapResponse($this->callApi('post', $uri, $args)->send());
    }


    /**
     * Toggle customer status by Customer ID
     * @param string $customerId
     * @return stdClass
     * @throws ApiException
     */
    public function toggleCustomerStatusById(string $customerId)
    {
        $uri = $this->getOpenApiUrl('v3', "/customer/$customerId/status");
        return $this->mapResponse($this->callApi('put', $uri)->send());
    }

    /**
     * Get Customer Orders by Customer ID
     * @param string $customerId
     * @return stdClass
     * @throws ApiException
     */
    public function getCustomerOrdersById(string $customerId)
    {
        $uri = $this->getOpenApiUrl('v3', "/customer/$customerId/orders");
        return $this->mapResponse($this->callApi('get', $uri)->send());
    }


    /**
     * Create Customer Order by Customer ID
     * @param string $customerId, obj $args
     * @return stdClass
     * @throws ApiException
     */
    public function createCustomerOrderById(string $customerId, $args)
    {
        if ($args instanceof CustomerOrderAmount) {
            $args = $args->jsonSerialize();
        }
// print_r($args);

        $uri = $this->getOpenApiUrl('v3', "/customer/$customerId/order");
        return $this->mapResponse($this->callApi('post', $uri, $args)->send());
    }

    /**
     * Get Customer Tokens ( Customer ID based on your side pass in to Web Payment )
     * @param string $customerId
     * @return stdClass
     * @throws ApiException
     */
    public function getCustomerTokensById(string $customerId)
    {
        $uri = $this->getOpenApiUrl('v3', "/payment/tokens/$customerId");
        return $this->mapResponse($this->callApi('get', $uri)->send());
    }
}
