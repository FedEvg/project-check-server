<?php

namespace Jekamars\CheckServer\Route;

use Generator;
use Jekamars\CheckServer\Server;
use Jekamars\CheckServers\HandlerServer;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig\Environment;

class UpdateStatusServers
{
    public function __construct(private Environment $view, private Server $server)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, $args = []): Response
    {
        $hosts = $this->server->servers();
        function getResultHosts($servers): Generator
        {
            foreach ($servers as $server) {
                $handlerServer = new HandlerServer($server['name']);

                $resultPing = $handlerServer->multiPingServer();

                if ($resultPing === false) {
                    $server['status'] = Server::STATUS_FALSE;
                }

                yield $server;
            }
        }

        $resultHosts = getResultHosts($hosts);

        foreach ($resultHosts as $resultsHost) {
            $this->server->update($resultsHost);
        }

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/servers');
    }
}