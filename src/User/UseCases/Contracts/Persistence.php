<?php

namespace App\User\UseCases\Contracts;

use App\User\Entities\User;

interface Persistence
{
    /**
     * perist the user
     * 
     * @param array $data
     * @return int
     */
    public function save(array $data): int;
 

    /**
     * Check if the email already exists
     * 
     * @param string $email
     * @return bool
     */
    public function emailExists(string $email): bool;
}