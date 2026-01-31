<?php

namespace App\User\Entities;

readonly class User
{
    /**
     * @param int $id
     * @param string $name
     */
    public function __construct(
        public int $id,
        public string $name,
        public string $email,
        public string $password
    ) {

    }
}