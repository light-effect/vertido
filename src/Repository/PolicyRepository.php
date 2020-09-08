<?php

namespace App\Repository;

use App\Api\Post\Repository\DistrictRepository;
use App\Entity\Customer;
use App\Entity\District;
use App\Entity\Policy;
use App\Exception\ValidationException;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * @method Policy|null find($id, $lockMode = null, $lockVersion = null)
 * @method Policy|null findOneBy(array $criteria, array $orderBy = null)
 * @method Policy[]    findAll()
 * @method Policy[]    findBy(array $criteria, array $orderBy = null, $limit = null, $offset = null)
 */
class PolicyRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Policy::class);
    }

    public function findByRequest(Request $request)
    {
        if ($request->get('filter')) {
            $this->validateFilter($request->get('filter'));

            $filters            = $request->get('filter');
            $districtRepository = new DistrictRepository();

            $district = $districtRepository->findByZip($filters['zip']);
            $customer = new Customer();

            $customer->setAge($filters['age']);
            $customer->setPeopleCount($filters['group']);

            $query = $this->getEntityManager()->createQuery(
                'SELECT p, c
                FROM App\Entity\Policy p
                INNER JOIN p.customers c
                WHERE c.age = :age
                AND c.people_count = :group
                AND c.district_zip = :zip'
            )->setParameter('age', $customer->getAge())->setParameter('group', $customer->getPeopleCount())->setParameter('zip', $district->getZip());

            return $query->getResult();
        }

        return $this->findAll();
    }

    private function validateFilter(array $filter)
    {
        if (isset($filter['age']) === false || isset($filter['group']) === false || isset($filter['zip']) === false) {
            throw new ValidationException('filter empty');
        }
    }

    // /**
    //  * @return Policy[] Returns an array of Policy objects
    //  */
    /*
    public function findByExampleField($value)
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->orderBy('p.id', 'ASC')
            ->setMaxResults(10)
            ->getQuery()
            ->getResult()
        ;
    }
    */

    /*
    public function findOneBySomeField($value): ?Policy
    {
        return $this->createQueryBuilder('p')
            ->andWhere('p.exampleField = :val')
            ->setParameter('val', $value)
            ->getQuery()
            ->getOneOrNullResult()
        ;
    }
    */
}
