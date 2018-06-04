<?php

namespace SuperSimpleAPIClient;

interface RequestFactoryInterface
{
    public function build($method, $uri);
}
