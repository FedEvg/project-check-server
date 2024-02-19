<?php

namespace Jekamars\CheckServer\Route;

use Jekamars\CheckServer\Server;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Update
{
    public function __construct(private Server $server)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, $args = []): Response
    {
        $data = $request->getParsedBody();

        $this->server->update($data);

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/servers');
    }
}