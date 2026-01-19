<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Middleware\Attributes\Middleware;
use App\Core\Middleware\RoleMiddleware;
use App\Core\Router\Attributes\Route;
use App\Core\Services\JsonResponse;
use App\Core\Services\LoggerService;
use App\Core\Services\ObjectMapper;
use App\Entity\Avocat;
use App\Repositories\AvocatRepo;


class AvocatController
{

    public function __construct(private AvocatRepo $avocatRepo) {}


    #[Route("/avocats", "GET")]
    #[Middleware(
        middlewares: [
            [RoleMiddleware::class, ["admin"]]
        ],
    )]
    public function index(Request $request)
    {
        $queryArray = $request->getQueryParams();
        $start = isset($queryArray["start"]) ? $queryArray["start"] : 0;
        $max = isset($queryArray["max"]) ? $queryArray["max"] : 5;
        $resultArray = [];

        $newArray = array_diff_key(
            $queryArray,
            array_flip(['start', 'max'])
        );
        $avocats = $this->avocatRepo->findBy($newArray, $max, $start);



        foreach ($avocats as $av) {
            $resultArray[]  = ObjectMapper::normalizer($av);
        }


        $response  = new JsonResponse([
            'success' => true,
            'data' => $resultArray,
        ], 200);
        LoggerService::getInstance()
            ->info("all avocat has been fetched", []);
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

        // var_dump($obj === $avocatObject);

        // return;

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
