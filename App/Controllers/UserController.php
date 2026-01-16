<?php


namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Router\Attributes\Route;
use App\Core\Services\JsonResponse;
use App\Core\Services\ObjectMapper;
use App\Entity\User;
use App\Repositories\UserRepo;

class UserController
{
    public function __construct(private UserRepo $userRepo) {}


    #[Route("/user", "GET")]
    public function index()
    {
        $resultArray = [];
        $user = $this->userRepo->findAll();


        foreach ($user as $av) {
            $resultArray[]  = ObjectMapper::normalizer($av);
        }


        $response  = new JsonResponse([
            'success' => true,
            'data' => $resultArray,
        ], 200);

        $response->send();
    }

    #[Route("/user", "POST")]
    public function store(Request $request)
    {

       $user = $request->getPostParams(User::class);

        $this->userRepo->save($user);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'User created',
        ], 201);
        $response->send();
    }

    #[Route("/user/{id}", "PATCH")]
    public function update(Request $request, int $id): void
    {
       $adminArray = $request->bodyParam();

       $adminObject = $this->userRepo->find($id);

        $obj = ObjectMapper::updateObject($adminObject,$adminArray);

        $this->userRepo->update($obj);


        $response  = new JsonResponse([
            'success' => true,
            'message' => 'User Has been updated',

        ], 201);

        $response->send();
    }


    #[Route("/user/{id}", "DELETE")]
    public function destroy(int $id)
    {
        $this->userRepo->delete(User::class, $id);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'User has been deleted',
        ], 200);

        $response->send();
    }
}
