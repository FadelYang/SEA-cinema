<?php

namespace App\Repositories;

class EloquentUserRepository
{
    public function getLoginUser()
    {
        return auth()->user();
    }
}