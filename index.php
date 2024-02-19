<?php

use DI\ContainerBuilder;
use Jekamars\CheckServer\Route\{Add, Create, Delete, Home, ServerPage, Update, UpdateStatusServer, UpdateStatusServers};
use Slim\Factory\AppFactory;

include_once __DIR__ . '/vendor/autoload.php';

$builder = new ContainerBuilder();
$builder->addDefinitions('config/di.php');

try {
    $container = $builder->build();
    AppFactory::setContainer($container);

    $app = AppFactory::create();

    $app->get('/', Home::class);

    $app->get('/servers', Home::class);

    $app->get('/server/add', Add::class);

    $app->post('/server/create', Create::class);

    $app->post('/server/update', Update::class);

    $app->get('/server/delete/{id}', Delete::class);

    $app->get('/server/{id}', ServerPage::class);

    $app->get('/servers/status_update/{id}', UpdateStatusServer::class);

    $app->get('/servers/status_update', UpdateStatusServers::class);

    $app->run();

} catch (PDOException|Exception $exception) {
    echo $exception->getMessage();
}