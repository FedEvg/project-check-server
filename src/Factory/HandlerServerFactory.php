<?php

namespace Jekamars\CheckServer\Factory;

use Jekamars\CheckServers\HandlerServer;

class HandlerServerFactory implements iHandlerServerFactory
{
    public function create(string $serverName): HandlerServer
    {
        return new HandlerServer($serverName);
    }
}