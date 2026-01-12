<?php

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

require_once __DIR__ . '/../vendor/autoload.php';

$config = ORMSetup::createAttributeMetadataConfiguration(
    [__DIR__ . '/../src/Entity'],
    true
);

$connectionParams = [
    'driver' => 'pdo_mysql',
    'host' => 'localhost',
    'user' => 'root',
    'password' => '',
    'dbname' => 'your_database_name',
    'charset' => 'utf8mb4',
];

$connection = DriverManager::getConnection($connectionParams);

$entityManager = new EntityManager($connection, $config);

return $entityManager;
