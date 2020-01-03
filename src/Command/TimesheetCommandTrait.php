<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Client\Api\DefaultApi;
use KimaiConsole\Client\Model\Activity;
use KimaiConsole\Client\Model\ActivityCollection;
use KimaiConsole\Client\Model\ActivityEntity;
use KimaiConsole\Client\Model\Customer;
use KimaiConsole\Client\Model\CustomerCollection;
use KimaiConsole\Client\Model\CustomerEntity;
use KimaiConsole\Client\Model\Project;
use KimaiConsole\Client\Model\ProjectCollection;
use KimaiConsole\Client\Model\ProjectEntity;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

trait TimesheetCommandTrait
{
    abstract protected function getApi(): DefaultApi;

    private function findCustomer(InputInterface $input, OutputInterface $output, SymfonyStyle $io, $customerId)
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
                    $customer = $this->loadCustomerById($io, $customerList[0]->getId());
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

    private function loadCustomerById(SymfonyStyle $io, int $id): ?CustomerEntity
    {
        $api = $this->getApi();

        try {
            return $api->apiCustomersIdGet($id);
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
    private function askForCustomer(SymfonyStyle $io, array $customers): CustomerEntity
    {
        $choices = [];
        foreach ($customers as $customer) {
            $choices[$customer->getId()] = $customer->getName();
        }

        $id = $io->choice('Please select a customer', $choices);

        $flipped = array_flip($choices);
        $id = $flipped[$id];

        return $this->loadCustomerById($io, intval($id));
    }

    // ==============================================================================================================

    private function findProject(InputInterface $input, OutputInterface $output, SymfonyStyle $io, $projectId, ?CustomerEntity $customer = null): ?ProjectEntity
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
                    $project = $this->loadProjectById($io, $projectList[0]->getId());
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

    private function loadProjectById(SymfonyStyle $io, int $id): ?ProjectEntity
    {
        $api = $this->getApi();

        try {
            return $api->apiProjectsIdGet($id);
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
    private function askForProject(SymfonyStyle $io, array $projects): ProjectEntity
    {
        $choices = [];
        /** @var ProjectCollection $project */
        foreach ($projects as $project) {
            $choices[$project->getId()] = $project->getName();
        }

        $id = $io->choice('Please select a project', $choices);

        $flipped = array_flip($choices);
        $id = $flipped[$id];

        return $this->loadProjectById($io, intval($id));
    }

    // ==============================================================================================================

    private function findActivity(InputInterface $input, OutputInterface $output, SymfonyStyle $io, $activityId, ?ProjectEntity $projectEntity = null): ?ActivityEntity
    {
        $api = $this->getApi();
        $activity = null;
        $projectId = null !== $projectEntity ? $projectEntity->getId() : null;

        if (null !== $activityId) {
            if (intval($activityId)) {
                $activityId = intval($activityId);
                $activity = $this->loadActivityById($io, $activityId);
            } else {
                $activityList = $api->apiActivitiesGet($projectId, true, 'true', null, null, null, $activityId);
                if (count($activityList) === 1) {
                    $activity = $this->loadActivityById($io, $activityList[0]->getId());
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

        $activityList = $api->apiActivitiesGet($projectId, true, 'true');

        if (count($activityList) === 0) {
            $io->error('Could not find any activity');

            return null;
        }

        return $this->askForActivity($io, $activityList);
    }

    private function loadActivityById(SymfonyStyle $io, int $id): ?ActivityEntity
    {
        $api = $this->getApi();

        try {
            return $api->apiActivitiesIdGet($id);
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
     * @param array<ActivityCollection> $activitys
     * @return Activity
     */
    private function askForActivity(SymfonyStyle $io, array $activitys): ActivityEntity
    {
        $choices = [];
        /** @var ActivityCollection $activity */
        foreach ($activitys as $activity) {
            $choices[$activity->getId()] = $activity->getName();
        }

        $id = $io->choice('Please select an activity', $choices);

        $flipped = array_flip($choices);
        $id = $flipped[$id];

        return $this->loadActivityById($io, intval($id));
    }
}
