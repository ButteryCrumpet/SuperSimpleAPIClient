<?php

namespace SuperSimpleAPIClient;

class SuperSimpleAPIClient
{
    private $endpoints;

    /**
     * @param array $endpoints array of key => Endpoint pairs
     */
    public function __construct(array $endpoints)
    {
        $this->endpoints = $endpoints;
    }

    /**
     * @param string $id
     * @param Endpoint $endpoint
     * @return Endpoint Added Endpoint
     *
     * @throws \InvalidArgumentException When $id is not a string
     */
    public function addEndpoint($id, Endpoint $endpoint)
    {
        if (!\is_string($id)) {
            throw new \InvalidArgumentException(sprintf("Endpoint key must be a string. %s was given", gettype($id)));
        }

        $this->endpoints[$id] = $endpoint;
        return $this->endpoints[$id];
    }

    /**
     * @param string $id
     * @return Endpoint The endpoint for the given key
     *
     * @throws \InvalidArgumentException When $id is not string or does not exist
     */
    public function getEndpoint($id)
    {
        $this->checkKey($id);
        return $this->endpoints[$id];
    }

    /**
     * @param string $id The endpoint ID
     * @param array $params Query parameters
     * @return mixed The parsed response from the endpoint
     *
     * @throws \InvalidArgumentException When $id is not string or does not exist
     */
    public function get($id, $params = [])
    {
        $this->checkKey($id);
        return $this->endpoints[$id]->request("GET", $params);
    }

    /**
     * @param string $id The endpoint ID
     * @param array $params Query parameters
     * @param string $body
     * @return mixed The parsed response from the endpoint
     *
     * @throws \InvalidArgumentException When $id is not string or does not exist
     */
    public function post($id, $params, $body = null)
    {
        $this->checkKey($id);
        return $this->endpoints[$id]->request("POST", $params, $body);
    }

    public function put($endpoint, $params, $body = null)
    {
        $this->checkKey($endpoint);
        return $this->endpoints[$endpoint]->request("PUT", $params, $body);
    }

    public function delete($endpoint, $params)
    {
        $this->checkKey($endpoint);
        return $this->endpoints[$endpoint]->request("DELETE", $params);
    }

    private function checkKey($id)
    {
        if (!\is_string($id)) {
            throw new \InvalidArgumentException(sprintf("Endpoint key must be a string. %s was given", gettype($id)));
        }
        if (!isset($this->endpoints[$id])) {
            throw new \InvalidArgumentException(sprintf("Endpoint %s does not exist", $id));
        }
    }
}
