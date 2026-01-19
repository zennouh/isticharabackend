<?php

namespace App\Core\Middleware;

use App\Core\Http\Request;
use App\Core\Middleware\MiddlewareInterface;
use Exception;

class RoleMiddleware implements MiddlewareInterface
{
    private array $allowedRoles;

    public function __construct(array|string $roles)
    {
        $this->allowedRoles = (array)$roles;
    }
    public function handle(Request $request): void
    {
        $role = $request->getRole();

        // echo $role;

        if (!$role) {
            throw  new Exception("Unauthenticated", 401);
        }

        if (!in_array($role ?? '', $this->allowedRoles)) {
            throw  new Exception("Forbidden: insufficient permissions", 403);
        }
    }
}
