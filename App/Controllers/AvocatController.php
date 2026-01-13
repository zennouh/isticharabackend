<?php

namespace App\Controllers;

use App\Repository\AvocatRepo;
use Core\Router\Attributes\Route;

class AvocatController
{

    public function __construct(private AvocatRepo $avocatRepo) {}


    #[Route(name: "/avocats", methods: "GET")]
    public function index()
    {
        // $data = $this->avocatRepo->findAll();
        echo "all avocats";
    }
}
