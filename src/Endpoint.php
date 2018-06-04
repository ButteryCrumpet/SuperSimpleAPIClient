<?php

namespace SuperSimpleAPIClient;

use Psr\Http\Message\StreamInterface;

class Endpoint
{
    private $uri;
    private $params;
    private $client;
    private $parser;
    private $requestFactory;

    /**
     * @param string $uri
     * @param HttpClientInterface $client
     * @param ResponseParserInterface $parser
     * @param RequestFactoryInterface $requestFactory
     * @param array $params
     */
    public function __construct(
        $uri,
        HttpClientInterface $client,
        ResponseParserInterface $parser,
        RequestFactoryInterface $requestFactory,
        array $params = []
    ) {
        $this->uri = $uri;
        $this->client = $client;
        $this->parser = $parser;
        $this->requestFactory = $requestFactory;
        $this->params = $params;
    }

    /**
     * @return string $uri
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * @return HttpClientInterface $client
     */
    public function getClient()
    {
        return $this->client;
    }

    /**
     * @return array $params
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * @return ResponseParserInterface $parser
     */
    public function getParser()
    {
        return $this->parser;
    }

    /**
     * @param string $key
     * @param string $value
     * @return string $value The set value
     */
    public function setParam($key, $value)
    {
        $this->params[$key] = $value;
        return $this->params[$key];
    }

    /**
     * @param array $params key => value array of query parameters
     * @return array $params
     */
    public function setParams(array $params)
    {
        $this->params = array_merge($this->params, $params);
        return $this->params;
    }

    /**
     * @param string $method
     * @param array $params Additional query parameters
     * @param StreamInterface $body
     * @return mixed $response Parsed response
     */
    public function request($method, array $params = [], StreamInterface $body = null)
    {
        $params = empty($params) ? $this->params : array_merge($this->params, $params);
        $uri = empty($params) ? $this->uri : $this->uri . "?" . http_build_query($params);

        $request = $this->requestFactory->build("GET", $uri);
        if ($body !== null) {
            $request = $request->withBody($body);
        }
        $response = $this->client->sendRequest($request);
        return $this->parser->parse($response);
    }
}
