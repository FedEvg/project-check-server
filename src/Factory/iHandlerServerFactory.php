<?php

namespace Jekamars\CheckServer\Factory;

use Jekamars\CheckServers\HandlerServer;
interface iHandlerServerFactory
{
    public function create(string $serverName): HandlerServer;
}