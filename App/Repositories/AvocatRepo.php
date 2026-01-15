<?php

namespace App\Repositories;

use App\Core\MyEntityManager;
use App\Entity\Avocat;
 

class AvocatRepo extends BaseRepository
{


    public function __construct()
    {
        $this->em = MyEntityManager::get();
        $this->entityClass = Avocat::class;
    }
}
