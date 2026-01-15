<?php

namespace App\Core;

use Doctrine\DBAL\DriverManager;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;

class MyEntityManager
{
    private static ?EntityManager $entityManager = null;

    public static function get(): EntityManager
    {


        if (self::$entityManager === null) {

            $config = ORMSetup::createAttributeMetadataConfiguration(
                ['../App/Entity'],
                true,
            );

            $connectionParams = [
                'driver'   => 'pdo_mysql',
                'host'     => 'localhost',
                'user'     => 'root',
                'password' => '',
                'dbname'   => 'istishara',
                'charset'  => 'utf8mb4',
            ];

            $connection = DriverManager::getConnection($connectionParams);

            self::$entityManager = new EntityManager(
                $connection,
                $config
            );
        }

        return self::$entityManager;
    }
}
