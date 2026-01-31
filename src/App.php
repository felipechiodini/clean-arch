<?php

namespace App;

use App\MySQL\Connection;
use App\User\Infra\MySQLPersistence;
use App\User\UseCases\Contracts\Persistence;
use App\User\UseCases\Create;
use DI\ContainerBuilder;

class App
{
    public function run()
    {
        $builder = new ContainerBuilder();

        $builder->addDefinitions([
            Connection::class => function () {
                return new Connection();
            },
            Persistence::class => function ($container) {
                return new MySQLPersistence($container->get(Connection::class));
            },
            Create::class => function ($container) {
                return new Create($container->get(Persistence::class));
            }
        ]);

        $container = $builder->build();

        /** @var Create */
        $create = $container->get(Create::class);

        var_dump($create->create('Felipe Bona', 'felipechiodinibona@hotmail.com', '123456'));
    }
}