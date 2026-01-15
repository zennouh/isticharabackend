<?php


namespace App\Controllers;

use App\Core\Http\Request;
use App\Core\Router\Attributes\Route;
use App\Core\Services\JsonResponse;
use App\Core\Services\ObjectMapper;
use App\Entity\Admin;
use App\Repositories\AdminRepo;

class AdminController
{
    public function __construct(private AdminRepo $adminRepo) {}


    #[Route("/admin", "GET")]
    public function index()
    {
        $resultArray = [];
        $admin = $this->adminRepo->findAll();


        foreach ($admin as $av) {
            $resultArray[]  = ObjectMapper::normalizer($av);
        }


        $response  = new JsonResponse([
            'success' => true,
            'data' => $resultArray,
        ], 200);

        $response->send();
    }

    #[Route("/admin", "POST")]
    public function store(Request $request)
    {

       $admin = $request->getPostParams(Admin::class);

        $this->adminRepo->save($admin);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Admin created',
        ], 201);
        $response->send();
    }

    #[Route("/admin/{id}", "PATCH")]
    public function update(Request $request, int $id): void
    {
       $adminArray = $request->bodyParam();

       $adminObject = $this->adminRepo->find($id);

        $obj = ObjectMapper::updateObject($adminObject,$adminArray);

        $this->adminRepo->update($obj);


        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Admin Has been updated',

        ], 201);

        $response->send();
    }


    #[Route("/admin/{id}", "DELETE")]
    public function destroy(int $id)
    {
        $this->adminRepo->delete(Admin::class, $id);
        $response  = new JsonResponse([
            'success' => true,
            'message' => 'Admin has been deleted',
        ], 200);

        $response->send();
    }
}
