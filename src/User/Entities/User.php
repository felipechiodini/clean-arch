<?php

namespace App\User\Entities;

readonly class User
{
    /**
     * @param int $id
     * @param string $name
     * @param string $email
     * @param string $password
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password
    ) {

    }
}