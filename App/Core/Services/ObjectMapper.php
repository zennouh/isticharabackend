<?php

namespace App\Core\Services;

use App\Core\MyEntityManager;
use Doctrine\ORM\Mapping\JoinColumn;
use ReflectionClass;

class ObjectMapper
{



    public static function toObject(
        string $className,
        array $data,

    ): object {
        $reflection = new ReflectionClass($className);
        $object = $reflection->newInstanceWithoutConstructor();

        foreach ($reflection->getProperties() as $property) {


            $propName = $property->getName();
            $columnName = self::camelToSnake($propName);

            $manyToOne = $property->getAttributes(\Doctrine\ORM\Mapping\ManyToOne::class);
            if ($manyToOne) {
                $relationColumn = $columnName . '_id';

                if (!isset($data[$relationColumn])) {
                    continue;
                }

                $targetEntity = $manyToOne[0]->newInstance()->targetEntity;


                $reference = MyEntityManager::get()->getReference($targetEntity, (int)$data[$relationColumn]);

                $property->setValue($object, $reference);
                continue;
            }


            if (
                !$property->getType() ||
                !$property->getType()->isBuiltin() ||
                !array_key_exists($columnName, $data)
            ) {
                continue;
            }

            $value = $data[$columnName];
            $type  = $property->getType()->getName();

            $value = match ($type) {
                'int'    => (int)$value,
                'float'  => (float)$value,
                'bool'   => (bool)$value,
                'string' => (string)$value,
                default  => $value,
            };

            $property->setValue($object, $value);
        }

        return $object;
    }


    public static function updateObject(object $obj, array $data): object
    {
        $reflection = new ReflectionClass($obj);

        foreach ($reflection->getProperties() as $property) {

            $propName = $property->getName();
            $columnName = ObjectMapper::camelToSnake($propName);

            if (!array_key_exists($columnName, $data)) {
                continue;
            }

            $value = $data[$columnName];

            // handle type conversion
            $type = $property->getType()?->getName();
            $value = match ($type) {
                'int'    => (int) $value,
                'float'  => (float) $value,
                'bool'   => (bool) $value,
                'string' => (string) $value,
                default  => $value,
            };

            $property->setValue($obj, $value);
        }

        return $obj;
    }
    public static function normalizer(object $className): array
    {
        $resultArray = [];
        $reflection = new ReflectionClass($className);
        $props = $reflection->getProperties();
        foreach ($props as $prop) {
            $propName = $prop->getName();
            $columnName = self::camelToSnake($propName);


            $value = $prop->getValue($className);


            $resultArray[$columnName] = $value;
        }
        return $resultArray;
    }



    public static function camelToSnake(string $input): string
    {

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
