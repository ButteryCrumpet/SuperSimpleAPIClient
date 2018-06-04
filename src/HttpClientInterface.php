<?php

namespace SuperSimpleAPIClient;

use Psr\Http\Message\RequestInterface;

interface HttpClientInterface
{
    public function sendRequest(RequestInterface $request);
}
