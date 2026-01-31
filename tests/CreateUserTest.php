<?php

namespace Tests;

use App\User\EmailAlreadyTaken;
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

        $useCase = $this->createMock(\App\User\UseCases\Create::class);

        $user = $useCase->create(
            'Felipe Bona',
            'felipechiodinibona@hotmail.com',
            '123456'
        );

        $this->assertInstanceOf(User::class, $user);
    }

    public function testCreateUserErrorWithSameEmail()
    {
        $this->expectException(EmailAlreadyTaken::class);
        
        $persistence = $this->createMock(Persistence::class);

        $persistence->method('emailExists')
            ->with('felipechiodinibona@hotmail.com')
            ->willReturn(true);

        $useCase = new \App\User\UseCases\Create($persistence);

        $useCase->create(
            'Felipe Bona',
            'felipechiodinibona@hotmail.com',
            '123456'
        );
    }
}