<?php

namespace SuperSimpleAPIClient;

use Psr\Http\Message\ResponseInterface;

interface ResponseParserInterface
{
    public function parse(ResponseInterface $response);
}
