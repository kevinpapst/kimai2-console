<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Entity;

use Swagger\Client\Model\ProjectCollection;
use Swagger\Client\Model\ProjectEntity;

final class Project
{
    /**
     * @var int
     */
    private $id;
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $customerId;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name)
    {
        $this->name = $name;
    }

    public function getCustomerId(): ?int
    {
        return $this->customerId;
    }

    public function setCustomerId(int $customerId)
    {
        $this->customerId = $customerId;
    }

    public static function fromEntity(ProjectEntity $entity): Project
    {
        $project = new Project();
        $project->setId($entity->getId());
        $project->setName($entity->getName());
        $project->setCustomerId($entity->getCustomer());

        return $project;
    }

    public static function fromCollection(ProjectCollection $entity): Project
    {
        $project = new Project();
        $project->setId($entity->getId());
        $project->setName($entity->getName());
        $project->setCustomerId($entity->getCustomer());

        return $project;
    }
}
