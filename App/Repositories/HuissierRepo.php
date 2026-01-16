<?php

namespace App\Repositories;

use App\Core\MyEntityManager;
use App\Entity\Huissier;
 

class HuissierRepo extends BaseRepository
{


    public function __construct()
    {
        $this->em = MyEntityManager::get();
        $this->entityClass = Huissier::class;
    }
}
