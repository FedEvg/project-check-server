<?php

namespace Jekamars\CheckServer\Route;

use Jekamars\CheckServer\Entity\Server;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class ServerPage
{
    public function __construct(private Environment $view, private Server $server)
    {
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, $args = []): Response
    {
        $host = $this->server->getServerById((int)$args['id']);
        $body = $this->view->render('server.twig', [
            'host' => $host,
        ]);
        $response->getBody()->write($body);
        return $response;
    }
}