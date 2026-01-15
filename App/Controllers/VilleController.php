<?php


namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Router\Attributes\Route;
use App\Core\Services\JsonResponse;
use App\Core\Services\ObjectMapper;
use App\Entity\Ville;
use App\Repositories\VilleRepo;

class ClientController
{
    public function __construct(private VilleRepo $villeRepo) {}


    #[Route("/villes", "GET")]
    public function index()
    {
        $resultArray = [];
        $villes = $this->villeRepo->findAll();


        foreach ($villes as $av) {
            $resultArray[]  = ObjectMapper::normalizer($av);
        }


        $response  = new JsonResponse([
            'success' => true,
            'data' => $resultArray,
        ], 200);

        $response->send();
    }

    #[Route("/villes", "POST")]
    public function store(Request $request)
    {

       $ville = $request->getPostParams(Ville::class);

        $this->villeRepo->save($ville);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Ville created',
        ], 201);
        $response->send();
    }

    #[Route("/villes/{id}", "PATCH")]
    public function update(Request $request, int $id): void
    {
       $adminArray = $request->bodyParam();

       $adminObject = $this->villeRepo->find($id);

        $obj = ObjectMapper::updateObject($adminObject,$adminArray);

        $this->villeRepo->update($obj);


        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Ville Has been updated',

        ], 201);

        $response->send();
    }


    #[Route("/villes/{id}", "DELETE")]
    public function destroy(int $id)
    {
        $this->villeRepo->delete(Ville::class, $id);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Ville has been deleted',
        ], 200);

        $response->send();
    }
}
