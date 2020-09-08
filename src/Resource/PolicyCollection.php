<?php


namespace App\Resource;



class PolicyCollection extends ResourceCollection
{
    public $type = 'policies';

    public function wrap($entity)
    {
        return [
            'type'       => $this->type,
            'id'         => $entity->getId(),
            'attributes' => [
                'price' => $entity->getPrice(),
            ],
            'relationships' => [
                'customers' => (new CustomerCollection($entity->getCustomers()->toArray()))->toArray()
            ],
        ];
    }

}
