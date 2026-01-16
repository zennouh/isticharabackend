<?php

namespace App\Repositories;

use App\Core\MyEntityManager;
use App\Entity\User;
 

class UserRepo extends BaseRepository
{


    public function __construct()
    {
        $this->em = MyEntityManager::get();
        $this->entityClass = User::class;
    }
}
