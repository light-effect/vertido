<?php


namespace App\Resource;


use Exception;
use ReflectionClass;
use ReflectionException;

class ResourceCollection
{
    private $data = [];

    public $type = 'resource';

    public function __construct(array $data)
    {
        if (is_array($this->data) === false) {
            throw new Exception('Wrong data format in resource');
        }

        foreach ($data as $entity)
        {
            $this->data[] = $this->wrap($entity);
        }
    }

    public function toArray()
    {
        return $this->data;
    }

    public function wrap($entity)
    {
        return [
            'type'       => $this->type,
            'id'         => $entity->getId(),
            'attributes' => [],
        ];
    }
}
