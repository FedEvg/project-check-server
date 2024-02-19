<?php

namespace Jekamars\CheckServer\Route;

use Exception;
use Jekamars\CheckServer\Server;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;

class Create
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
        $result = $this->server->create($data['name'], $data['description']);

        if (!$result) {
            throw new Exception('Don`t add servers.');
        }

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/servers');
    }
}