<?php

namespace App\Core\Router\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Route
{
    public function __construct(public string $name, public string $method) {}
}
