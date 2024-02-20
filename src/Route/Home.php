<?php

namespace Jekamars\CheckServer\Route;

use Exception;
use Jekamars\CheckServer\Entity\Server;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class Home
{
    public function __construct(private Environment $view, private Server $server)
    {
    }

    /**
     * @throws RuntimeError
     * @throws SyntaxError
     * @throws LoaderError
     * @throws Exception
     */
    public function __invoke(Request $request, Response $response, $args = []): Response
    {
        $hosts = $this->server->servers();

        $body = $this->view->render('servers.twig', [
            'hosts' => $hosts,
        ]);
        $response->getBody()->write($body);
        return $response;
    }
}