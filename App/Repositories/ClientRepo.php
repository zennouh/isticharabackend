<?php

namespace App\Repositories;

use App\Core\MyEntityManager;
 
use App\Entity\Client;

class ClientRepo extends BaseRepository
{


    public function __construct()
    {
        $this->em = MyEntityManager::get();
        $this->entityClass = Client::class;
    }
}
