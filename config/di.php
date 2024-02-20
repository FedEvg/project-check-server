<?php


use Jekamars\CheckServer\Entity\Server;
use Jekamars\CheckServer\Factory\HandlerServerFactory;
use Jekamars\CheckServer\Factory\iHandlerServerFactory;

use Jekamars\CheckServers\Database;
use src\Services\Notification\iNotification;
use src\Services\Notification\Telegram;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

use function DI\autowire;
use function DI\get;

return [
    'db.configs' => require_once __DIR__ . '/database.php',

    Database::class => autowire()
        ->constructorParameter('configs', get('db.configs')),

    Server::class => autowire()
        ->constructorParameter('database', get(Database::class))
        ->constructorParameter('tableName', 'servers'),

    FilesystemLoader::class => autowire()
        ->constructorParameter('paths', 'templates'),

    Environment::class => autowire()
        ->constructorParameter('loader', get(FilesystemLoader::class)),

    iHandlerServerFactory::class => get(HandlerServerFactory::class),

    Telegram::class => autowire()
        ->constructorParameter('token', '***')
        ->constructorParameter('chatId', '***'),

    iNotification::class => get(Telegram::class),
];