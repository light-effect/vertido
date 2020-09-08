<?php


namespace App\Resource;


class CustomerCollection extends ResourceCollection
{
    public $type = 'customers';

    public function wrap($entity)
    {
        return [
            'type'       => $this->type,
            'id'         => $entity->getId(),
            'attributes' => [
                'age'   => $entity->getAgeName(),
                'group' => $entity->getGroupName(),
                'zip'   => $entity->getZip(),
            ],
        ];
    }

}
