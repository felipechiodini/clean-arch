<?php

namespace App\User\UseCases;

use App\User\EmailAlreadyTaken;
use App\User\Entities\User;
use App\User\UseCases\Contracts\Hasher;
use App\User\UseCases\Contracts\Persistence;

/**
 * Author: Felipe Chiodini Bona
 * email: felipechiodinibona@hotmail.com
 * 
 * Cria um usuário
 */
class Create
{
    /**
     * @param Persistence $persistence
     */
    public function __construct(
        protected Persistence $persistence
    ) {
    }

    /**
     * Cria um usuário
     * 
     * @param string $name
     * @param string $email
     * @param string $password
     * 
     * @return User
     */
    public function create(string $name, string $email, string $password): User
    {
        if ($this->persistence->emailExists($email)) {
            throw new EmailAlreadyTaken();
        }

        $password = password_hash($password, PASSWORD_DEFAULT);

        $id = $this->persistence->save([
            'name' => $name,
            'email' => $email,
            'password' => $password
        ]);

        return new User(
            $id,
            $name,
            $email,
            $password
        );
    }
}