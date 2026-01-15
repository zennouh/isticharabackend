<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Router\Attributes\Route;
use App\Core\Services\JsonResponse;
use App\Core\Services\ObjectMapper;
use App\Entity\Avocat;
use App\Repositories\AvocatRepo;


class AvocatController
{

    public function __construct(private AvocatRepo $avocatRepo) {}


    #[Route("/avocats", "GET")]
    public function index()
    {
        $resultArray = [];
        $avocats = $this->avocatRepo->findAll();


        foreach ($avocats as $av) {
            $resultArray[]  = ObjectMapper::normalizer($av);
        }


        $response  = new JsonResponse([
            'success' => true,
            'data' => $resultArray,
        ], 200);

        $response->send();
    }

    #[Route("/avocats", "POST")]
    public function store(Request $request)
    {

        $avocat = $request->getPostParams(Avocat::class);

        $this->avocatRepo->save($avocat);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Avocat created',
        ], 201);
        $response->send();
    }

    #[Route("/avocats/{id}", "PATCH")]
    public function update(Request $request, int $id): void
    {
        $avocatArray = $request->bodyParam();

        $avocatObject = $this->avocatRepo->find($id);

        $obj = ObjectMapper::updateObject($avocatObject, $avocatArray);

        $this->avocatRepo->update($obj);


        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Avocat Has been updated',

        ], 201);

        $response->send();
    }


    #[Route("/avocats/{id}", "DELETE")]
    public function destroy(int $id)
    {
        $this->avocatRepo->delete(Avocat::class, $id);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Avocat has been deleted',
        ], 200);

        $response->send();
    }
}
