<?php

namespace Jekamars\CheckServer\Route;


use Jekamars\CheckServer\Factory\iHandlerServerFactory;
use Jekamars\CheckServer\Entity\Server;
use Psr\Http\Message\RequestInterface as Request;
use Psr\Http\Message\ResponseInterface as Response;
use src\Services\Notification\iNotification;

class UpdateStatusServer
{
    public function __construct(
        private Server        $server,
        private iNotification $notification,
        private iHandlerServerFactory $handlerServerFactory
    )
    {
    }

    /**
     * @throws \Exception
     */
    public function __invoke(Request $request, Response $response, $args = []): Response
    {
        $server = $this->server->getServerById((int)$args['id']);

        $handlerServer = $this->handlerServerFactory->create($server['name']);

        $resultPing = $handlerServer->pingServer();

        if ($resultPing === false) {
            $server['status'] = Server::STATUS_FALSE;
            $this->notification->sendMessage('Server error: ' . $server['name']);
        } else {
            $server['status'] = Server::STATUS_TRUE;
        }

        $this->server->update($server);

        return $response
            ->withStatus(302)
            ->withHeader('Location', '/servers');
    }
}