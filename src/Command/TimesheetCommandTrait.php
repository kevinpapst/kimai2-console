<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Client\Api\DefaultApi;
use KimaiConsole\Client\Model\ActivityCollection;
use KimaiConsole\Client\Model\CustomerCollection;
use KimaiConsole\Client\Model\ProjectCollection;
use KimaiConsole\Entity\Activity;
use KimaiConsole\Entity\Customer;
use KimaiConsole\Entity\Project;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

trait TimesheetCommandTrait
{
    abstract protected function getApi(): DefaultApi;

    private function findCustomer(InputInterface $input, OutputInterface $output, SymfonyStyle $io, $customerId): ?Customer
    {
        $api = $this->getApi();
        $customer = null;

        if (null !== $customerId) {
            if (intval($customerId)) {
                $customerId = intval($customerId);
                $customer = $this->loadCustomerById($io, $customerId);
            } else {
                $customerList = $api->apiCustomersGet(true, null, null, $customerId);
                if (count($customerList) === 1) {
                    $customer = Customer::fromCollection($customerList[0]);
                } elseif (count($customerList) > 1) {
                    $customer = $this->askForCustomer($io, $customerList);
                } else {
                    $io->warning(sprintf('Could not find customer with term: %s', $customerId));
                }
            }
        }

        if (null !== $customer) {
            return $customer;
        }

        $customerList = $api->apiCustomersGet(true);

        if (count($customerList) === 0) {
            $io->error('Could not find any customer');

            return null;
        }

        return $this->askForCustomer($io, $customerList);
    }

    private function loadCustomerById(SymfonyStyle $io, int $id): ?Customer
    {
        $api = $this->getApi();

        try {
            $customerEntity = $api->apiCustomersIdGet($id);

            return Customer::fromEntity($customerEntity);
        } catch (\Exception $ex) {
            if ($ex->getCode() === 404) {
                $io->error(sprintf('Customer with ID %s does not exist', $id));
            } else {
                $io->error(sprintf('Failed loading customer with ID %s: %s', $id, $ex->getMessage()));
            }
        }

        return null;
    }

    /**
     * @param SymfonyStyle $io
     * @param array<CustomerCollection> $customers
     * @return Customer
     */
    private function askForCustomer(SymfonyStyle $io, array $customers): ?Customer
    {
        $choices = [];
        /** @var CustomerCollection $customerEntity */
        foreach ($customers as $customerEntity) {
            $choices[$customerEntity->getId()] = $customerEntity->getName();
        }

        $id = $io->choice('Please select a customer', $choices);

        $flipped = array_flip($choices);
        $id = intval($flipped[$id]);

        /** @var CustomerCollection $customerEntity */
        foreach ($customers as $customerEntity) {
            if ($customerEntity->getId() !== $id) {
                continue;
            }

            return Customer::fromCollection($customerEntity);
        }

        $io->error('Failed loading customer with ID ' . $id);

        return null;
    }

    // ==============================================================================================================

    private function findProject(InputInterface $input, OutputInterface $output, SymfonyStyle $io, $projectId, ?Customer $customer = null): ?Project
    {
        $api = $this->getApi();
        $project = null;
        $customerId = null !== $customer ? $customer->getId() : null;

        if (null !== $projectId) {
            if (intval($projectId)) {
                $projectId = intval($projectId);
                $project = $this->loadProjectById($io, $projectId);
            } else {
                $projectList = $api->apiProjectsGet($customerId, true, null, null, $projectId);
                if (count($projectList) === 1) {
                    $project = Project::fromCollection($projectList[0]);
                } elseif (count($projectList) > 1) {
                    $project = $this->askForProject($io, $projectList);
                } else {
                    $io->warning(sprintf('Could not find project with term: %s', $projectId));
                }
            }
        }

        if (null !== $project) {
            return $project;
        }

        $projectList = $api->apiProjectsGet($customerId, true);

        if (count($projectList) === 0) {
            $io->error('Could not find any project');

            return null;
        }

        return $this->askForProject($io, $projectList);
    }

    private function loadProjectById(SymfonyStyle $io, int $id): ?Project
    {
        $api = $this->getApi();

        try {
            $projectEntity = $api->apiProjectsIdGet($id);

            return Project::fromEntity($projectEntity);
        } catch (\Exception $ex) {
            if ($ex->getCode() === 404) {
                $io->error(sprintf('Project with ID %s does not exist', $id));
            } else {
                $io->error(sprintf('Failed loading project with ID %s: %s', $id, $ex->getMessage()));
            }
        }

        return null;
    }

    /**
     * @param SymfonyStyle $io
     * @param array<ProjectCollection> $projects
     * @return Project
     */
    private function askForProject(SymfonyStyle $io, array $projects): ?Project
    {
        $choices = [];
        /** @var ProjectCollection $projectEntity */
        foreach ($projects as $projectEntity) {
            $choices[$projectEntity->getId()] = $projectEntity->getName();
        }

        $id = $io->choice('Please select a project', $choices);

        $flipped = array_flip($choices);
        $id = intval($flipped[$id]);

        /** @var ProjectCollection $projectEntity */
        foreach ($projects as $projectEntity) {
            if ($projectEntity->getId() !== $id) {
                continue;
            }

            return Project::fromCollection($projectEntity);
        }

        $io->error('Failed loading project with ID ' . $id);

        return null;
    }

    // ==============================================================================================================

    private function findActivity(InputInterface $input, OutputInterface $output, SymfonyStyle $io, $activityId, ?Project $projectEntity = null): ?Activity
    {
        $api = $this->getApi();
        $activity = null;
        $projectId = null !== $projectEntity ? $projectEntity->getId() : null;

        if (null !== $activityId) {
            if (intval($activityId)) {
                $activityId = intval($activityId);
                $activity = $this->loadActivityById($io, $activityId);
            } else {
                $activityList = $api->apiActivitiesGet($projectId, true, null, null, null, null, $activityId);
                if (count($activityList) === 1) {
                    $activity = Activity::fromCollection($activityList[0]);
                } elseif (count($activityList) > 1) {
                    $activity = $this->askForActivity($io, $activityList);
                } else {
                    $io->warning(sprintf('Could not find activity with term: %s', $activityId));
                }
            }
        }

        if (null !== $activity) {
            return $activity;
        }

        $activityList = $api->apiActivitiesGet($projectId, true, null);

        if (count($activityList) === 0) {
            $io->error('Could not find any activity');

            return null;
        }

        return $this->askForActivity($io, $activityList);
    }

    private function loadActivityById(SymfonyStyle $io, int $id): ?Activity
    {
        $api = $this->getApi();

        try {
            $activityEntity = $api->apiActivitiesIdGet($id);

            return Activity::fromEntity($activityEntity);
        } catch (\Exception $ex) {
            if ($ex->getCode() === 404) {
                $io->error(sprintf('Activity with ID %s does not exist', $id));
            } else {
                $io->error(sprintf('Failed loading activity with ID %s: %s', $id, $ex->getMessage()));
            }
        }

        return null;
    }

    /**
     * @param SymfonyStyle $io
     * @param array<ActivityCollection> $activities
     * @return Activity
     */
    private function askForActivity(SymfonyStyle $io, array $activities): Activity
    {
        $choices = [];
        /** @var ActivityCollection $activityEntity */
        foreach ($activities as $activityEntity) {
            $choices[$activityEntity->getId()] = $activityEntity->getName();
        }

        $id = $io->choice('Please select an activity', $choices);

        $flipped = array_flip($choices);
        $id = intval($flipped[$id]);

        /* @var ActivityCollection $activity */
        foreach ($activities as $activityEntity) {
            if ($activityEntity->getId() !== $id) {
                continue;
            }

            return Activity::fromCollection($activityEntity);
        }

        $io->error('Failed loading activity with ID ' . $id);

        return null;
    }
}
