<?php

namespace App\Repositories;

use App\Core\MyEntityManager;
use App\Entity\Admin;
 

class AdminRepo extends BaseRepository
{


    public function __construct()
    {
        $this->em = MyEntityManager::get();
        $this->entityClass = Admin::class;
    }
}
