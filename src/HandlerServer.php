<?php

namespace Jekamars\CheckServers;

class HandlerServer
{
    public function __construct(private string $serverName)
    {
    }

    public function pingServer(): bool
    {
        exec("ping $this->serverName", $output, $result);
        return !($result === 1);
    }

    public function multiPingServer(): bool
    {
        $data = [];
        for ($i = 1; $i <= 3; $i++) {
            $data[$i] = $this->pingServer();
        }
        return max($data);
    }
}