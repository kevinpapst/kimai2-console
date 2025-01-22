<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Entity;

use Swagger\Client\Model\ActivityCollection;
use Swagger\Client\Model\ActivityEntity;

final class Activity
{
    private ?int $id = null;
    private ?string $name = null;
    private ?int $projectId = null;

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

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProjectId(?int $projectId): void
    {
        $this->projectId = $projectId;
    }

    public static function fromEntity(ActivityEntity $entity): Activity
    {
        $activity = new Activity();
        $activity->setId($entity->getId());
        $activity->setName($entity->getName());
        $activity->setProjectId($entity->getProject());

        return $activity;
    }

    public static function fromCollection(ActivityCollection $entity): Activity
    {
        $activity = new Activity();
        $activity->setId($entity->getId());
        $activity->setName($entity->getName());
        $activity->setProjectId($entity->getProject());

        return $activity;
    }
}
