<?php

namespace App\Entity;

use App\Api\Post\Entity\District;
use App\Api\Post\Repository\DistrictRepository;
use App\Enum\AgeGroup;
use App\Repository\CustomerRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CustomerRepository::class)
 */
class Customer
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $district_zip;

    /**
     * @ORM\Column(type="integer")
     */
    private $age;

    /**
     * @ORM\Column(type="integer")
     */
    private $people_count;

    /**
     * @ORM\ManyToMany(targetEntity=Policy::class, mappedBy="customers")
     */
    private $policies;

    public function __construct()
    {
        $this->policies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDistrict(): ?District
    {
        return  (new DistrictRepository())->findByZip($this->district_zip);
    }

    public function getZip()
    {
        return $this->district_zip;
    }

    public function setDistrict(?District $district): self
    {
        $this->district_zip = $district->getZip();

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->age;
    }

    public function getAgeName()
    {
        if ($this->age >= AgeGroup::YOUNG && $this->age < AgeGroup::OLD) {
            return 'Young';
        }
        return 'Old';
    }

    public function setAge(int $age): self
    {
        if ($age >= AgeGroup::YOUNG && $age < AgeGroup::OLD) {
            $this->age = AgeGroup::YOUNG;
        } else if ($age >= AgeGroup::OLD && $age <= AgeGroup::MAX) {
            $this->age = AgeGroup::OLD;
        } else {
            throw new \Exception('Wrong age');
        }

        return $this;
    }

    public function getPeopleCount(): ?int
    {
        return $this->people_count;
    }

    public function setPeopleCount(int $people_count): self
    {
        $this->people_count = $people_count;

        return $this;
    }

    public function getGroupName()
    {
        if ($this->people_count === 1) {
            return 'Alone';
        }

        return 'Group';
    }

    /**
     * @return Collection|Policy[]
     */
    public function getPolicies(): Collection
    {
        return $this->policies;
    }

    public function addPolicy(Policy $policy): self
    {
        if (!$this->policies->contains($policy)) {
            $this->policies[] = $policy;
            $policy->addCustomer($this);
        }

        return $this;
    }

    public function removePolicy(Policy $policy): self
    {
        if ($this->policies->contains($policy)) {
            $this->policies->removeElement($policy);
            $policy->removeCustomer($this);
        }

        return $this;
    }
}
