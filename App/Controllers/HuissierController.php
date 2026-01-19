<?php

namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Router\Attributes\Route;
use App\Core\Services\JsonResponse;
use App\Core\Services\ObjectMapper;
use App\Entity\Huissier;
use App\Repositories\HuissierRepo;


class HuissierController
{

    public function __construct(private HuissierRepo $huissierRepo) {}


    #[Route("/huissiers", "GET")]
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
        $huissiers = $this->huissierRepo->findBy($newArray, $max, $start);


        foreach ($huissiers as $av) {
            // var_dump($av->getVille()->getCodePostale());
            $resultArray[]  = ObjectMapper::normalizer($av);
        }


        $response  = new JsonResponse([
            'success' => true,
            'data' => $resultArray,
        ], 200);

        $response->send();
    }

    #[Route("/huissiers", "POST")]
    public function store(Request $request)
    {

        $huissier = $request->getPostParams(Huissier::class);

        $this->huissierRepo->save($huissier);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Huissier created',
        ], 201);
        $response->send();
    }

    #[Route("/huissiers/{id}", "PATCH")]
    public function update(Request $request, int $id): void
    {
        $huissierArray = $request->bodyParam();

        $huissierObject = $this->huissierRepo->find($id);

        $obj = ObjectMapper::updateObject($huissierObject, $huissierArray);

        // var_dump($obj === $avocatObject);

        // return;

        $this->huissierRepo->update($obj);


        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Huissier Has been updated',

        ], 201);

        $response->send();
    }


    #[Route("/huissiers/{id}", "DELETE")]
    public function destroy(int $id)
    {
        $this->huissierRepo->delete(Huissier::class, $id);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Huissier has been deleted',
        ], 200);

        $response->send();
    }
}
