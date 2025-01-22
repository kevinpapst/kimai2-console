<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Entity;

use Swagger\Client\Model\CustomerCollection;
use Swagger\Client\Model\CustomerEntity;

final class Customer
{
    private ?int $id = null;
    private ?string $name = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public static function fromEntity(CustomerEntity $entity): Customer
    {
        $customer = new Customer();
        $customer->setId($entity->getId());
        $customer->setName($entity->getName());

        return $customer;
    }

    public static function fromCollection(CustomerCollection $entity): Customer
    {
        $customer = new Customer();
        $customer->setId($entity->getId());
        $customer->setName($entity->getName());

        return $customer;
    }
}
