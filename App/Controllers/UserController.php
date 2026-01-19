<?php


namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Router\Attributes\Route;
use App\Core\Services\JsonResponse;
use App\Core\Services\JwtGenerate;
use App\Core\Services\MailService;
use App\Core\Services\ObjectMapper;
use App\Entity\User;
use App\Repositories\UserRepo;
use Exception;

class UserController
{
    public function __construct(private UserRepo $userRepo) {}

    #[Route("/login", "POST")]
    public function login(Request $request)
    {


        $inputs = $request->bodyParam();

        $user = $this->userRepo->findOneBy([
            "email" => $inputs["email"],
            "password" => $inputs["password"],
        ]);
        if (!$user) {
            throw new Exception("User not found", 404);
        }
        JwtGenerate::generate(["role" => $user->role]);
        $userData = ObjectMapper::normalizer($user);

        MailService::getInstance()->send(
            "nnouh.nowile@gmail.com",
            "Login successfully",
            "Your login request has been accepted"
        );
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'User logged in',
            'data' => $userData
        ], 201);
        $response->send();
    }


    #[Route("/user", "GET")]
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
        $user = $this->userRepo->findBy($newArray, $max, $start);


        foreach ($user as $av) {
            $resultArray[]  = ObjectMapper::normalizer($av);
        }


        $response  = new JsonResponse([
            'success' => true,
            'data' => $resultArray,
        ], 200);

        $response->send();
    }

    #[Route("/signup", "POST")]
    public function signup(Request $request)
    {

        $user = $request->getPostParams(User::class);
        $jwt =  JwtGenerate::generate(["role" => "admin"]);

        $this->userRepo->save($user);
        $response  = new JsonResponse([
            'success' => true,
            'token' => $jwt,
            'message' => 'User created',
        ], 201);
        $response->send();
    }

    #[Route("/user/{id}", "PATCH")]
    public function update(Request $request, int $id): void
    {
        $adminArray = $request->bodyParam();

        $adminObject = $this->userRepo->find($id);

        $obj = ObjectMapper::updateObject($adminObject, $adminArray);

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
