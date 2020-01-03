<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Entity;

use KimaiConsole\Client\Model\ActivityCollection;
use KimaiConsole\Client\Model\ActivityEntity;

final class Activity
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
    private $projectId;

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

    public function getProjectId(): ?int
    {
        return $this->projectId;
    }

    public function setProjectId(?int $projectId)
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
