<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Entity;

use KimaiConsole\Client\Model\CustomerCollection;
use KimaiConsole\Client\Model\CustomerEntity;

final class Customer
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name)
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
