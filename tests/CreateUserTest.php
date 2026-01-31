<?php

namespace Tests;

use App\User\Entities\User;
use App\User\UseCases\Contracts\Persistence;
use PHPUnit\Framework\TestCase;

class CreateUserTest extends TestCase
{
    public function testCreateUSer()
    {
        $persistence = $this->createMock(Persistence::class);

        $persistence->method('save')
            ->willReturn(1);

        $persistence->method('emailExists')
            ->willReturn(false);

        $useCase = new \App\User\UseCases\Create($persistence);
        $user = $useCase->create(
            'Felipe Bona',
            'felipechiodinibona@hotmail.com',
            '123456'
        );

        $this->assertInstanceOf(User::class, $user);
    }
}