<?php

namespace App\Controllers;

use App\Core\Router\Attributes\Route;
use App\Core\Services\ExportService;
use App\Repositories\AvocatRepo;

class XlsxController
{
    public function __construct(private AvocatRepo $avocatRepo) {}
    #[Route("/avocatexport", "GET")]
    public function exportAllAvocat()
    {
        $exp = new ExportService();
        $avocats = $this->avocatRepo->findAll();
        $array = [];
        foreach ($avocats as $avocat) {
            $array[] = [$avocat->getId(), $avocat->getFullname()];
        }
        $exp->export($array, ["ID", "NAME"]);
    }
}
