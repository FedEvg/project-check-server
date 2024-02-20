<?php

namespace Jekamars\CheckServer\Route;

use Jekamars\CheckServer\Entity\Server;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Delete
{
    public function __construct(private Server $server)
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, $args = []): Response
    {
        $this->server->delete($args['id']);

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/servers');
    }
}