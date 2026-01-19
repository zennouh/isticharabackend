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


    public static function normalizer(object $entity, int $depth = 0, array $bring = []): array
    {

        if ($depth > 1) {
            return [];
        }

        $result = [];
        $reflection = new ReflectionClass($entity);

        foreach ($reflection->getProperties() as $property) {

            $propName   = $property->getName();
            $columnName = self::camelToSnake($propName);
            $value      = $property->getValue($entity);

            if ($value === null) {
                $result[$columnName] = null;
                continue;
            }


            if (is_object($value)) {

                if (method_exists($value, 'getId')) {
                    $result[$columnName] = [
                        'id' => $value->getId(),
                    ];

                    if (method_exists($value, 'getName')) {
                        $result[$columnName]['name'] = $value->getName();
                    }
                } else {
                    $result[$columnName] = self::normalizer($value, $depth + 1);
                }

                continue;
            }

            $result[$columnName] = $value;
        }

        return $result;
    }




    public static function camelToSnake(string $input): string
    {

        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $input));
    }
}
