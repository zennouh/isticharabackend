<?php

namespace App\Repositories;

use App\Core\MyEntityManager;
 
use App\Entity\Ville;

class VilleRepo extends BaseRepository
{


    public function __construct()
    {
        $this->em = MyEntityManager::get();
        $this->entityClass = Ville::class;
    }
}
