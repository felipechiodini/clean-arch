<?php

namespace App;

use App\CircuitBreaker\CircuitBreakerConfig;
use App\CircuitBreaker\Repository;
use App\MySQL\Connection;
use App\User\Infra\MySQLPersistence;
use App\User\UseCases\Contracts\Persistence;
use App\User\UseCases\Create;
use DI\ContainerBuilder;
use FelipeChiodini\CircuitBreaker\CircuitBreaker;

class App
{
    public function run(): void
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

        $repository = new Repository($container->get(Connection::class));

        $config = new CircuitBreakerConfig();

        $circuitBreaker = new CircuitBreaker($repository);

        $e = $circuitBreaker->run(function() {
            throw new \Exception('KKKKKKKKKKKKKKK');
            return 'Hello World!';
        }, $config);

        var_dump($e);
    }
}