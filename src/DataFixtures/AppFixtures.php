<?php

namespace App\DataFixtures;

use App\Api\Post\Entity\District;
use App\Entity\Customer;
use App\Entity\Policy;
use App\Enum\AgeGroup;
use App\Enum\PeopleGroup;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Persistence\ObjectManager;

class AppFixtures extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $districts = [[8000, 'zh'], [6005, 'lu'], [9436, 'sg']];

        $data = [
            [$districts[0], PeopleGroup::ALONE, AgeGroup::YOUNG, 12.43],
            [$districts[0], PeopleGroup::ALONE, AgeGroup::OLD,   8.5],
            [$districts[0], PeopleGroup::GROUP, AgeGroup::YOUNG, 23.3],
            [$districts[0], PeopleGroup::GROUP, AgeGroup::OLD,   9.1],
            [$districts[1], PeopleGroup::ALONE, AgeGroup::YOUNG, 7.4],
            [$districts[1], PeopleGroup::ALONE, AgeGroup::OLD,   89.12],
            [$districts[1], PeopleGroup::GROUP, AgeGroup::YOUNG, 78.6],
            [$districts[1], PeopleGroup::GROUP, AgeGroup::OLD,   21.5],
            [$districts[2], PeopleGroup::ALONE, AgeGroup::YOUNG, 37.4],
            [$districts[2], PeopleGroup::ALONE, AgeGroup::OLD,   15.4],
            [$districts[2], PeopleGroup::GROUP, AgeGroup::YOUNG, 8.7],
            [$districts[2], PeopleGroup::GROUP, AgeGroup::OLD,   1.6],
        ];

        foreach ($data as $row) {

            $district = new District();
            $district->setZip($row[0][0]);
            $district->setCity($row[0][1]);

            $customer = new Customer();

            $customer->setDistrict($district);
            $customer->setPeopleCount($row[1]);
            $customer->setAge($row[2]);

            $manager->persist($customer);


            $policy = new Policy();

            $policy->addCustomer($customer);
            $policy->setPrice($row[3]);

            $manager->persist($policy);
        }

        $manager->flush();
    }
}
