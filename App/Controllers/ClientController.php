<?php


namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Router\Attributes\Route;
use App\Core\Services\JsonResponse;
use App\Core\Services\ObjectMapper;
use App\Entity\Client;
use App\Repositories\ClientRepo;

class ClientController
{
    public function __construct(private ClientRepo $clienRepo) {}


    #[Route("/clients", "GET")]
    public function index()
    {
        $resultArray = [];
        $clients = $this->clienRepo->findAll();


        foreach ($clients as $av) {
            $resultArray[]  = ObjectMapper::normalizer($av);
        }


        $response  = new JsonResponse([
            'success' => true,
            'data' => $resultArray,
        ], 200);

        $response->send();
    }

    #[Route("/clients", "POST")]
    public function store(Request $request)
    {

       $client = $request->getPostParams(Client::class);

        $this->clienRepo->save($client);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Client created',
        ], 201);
        $response->send();
    }

    #[Route("/clients/{id}", "PATCH")]
    public function update(Request $request, int $id): void
    {
       $adminArray = $request->bodyParam();

       $adminObject = $this->clienRepo->find($id);

        $obj = ObjectMapper::updateObject($adminObject,$adminArray);

        $this->clienRepo->update($obj);


        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Client Has been updated',

        ], 201);

        $response->send();
    }


    #[Route("/clients/{id}", "DELETE")]
    public function destroy(int $id)
    {
        $this->clienRepo->delete(Client::class, $id);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Client has been deleted',
        ], 200);

        $response->send();
    }
}
