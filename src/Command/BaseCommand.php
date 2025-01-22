<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Api\Configuration;
use KimaiConsole\Api\Connection;
use KimaiConsole\Exception\ConnectionProblemException;
use KimaiConsole\Exception\InvalidConfigurationException;
use Swagger\Client\Api\ActivityApi;
use Swagger\Client\Api\CustomerApi;
use Swagger\Client\Api\DefaultApi;
use Swagger\Client\Api\ProjectApi;
use Swagger\Client\Api\TimesheetApi;
use Swagger\Client\ApiException;
use Swagger\Client\Model\TimesheetCollectionExpanded;
use Swagger\Client\Model\TimesheetEditForm;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

abstract class BaseCommand extends Command
{
    private ?Connection $connection = null;

    protected function getApi(): DefaultApi
    {
        $connection = $this->getConnection();

        return new DefaultApi($connection->getClient(), $connection->getConfiguration());
    }

    protected function getTimesheetApi(): TimesheetApi
    {
        $connection = $this->getConnection();

        return new TimesheetApi($connection->getClient(), $connection->getConfiguration());
    }

    protected function getProjectApi(): ProjectApi
    {
        $connection = $this->getConnection();

        return new ProjectApi($connection->getClient(), $connection->getConfiguration());
    }

    protected function getActivityApi(): ActivityApi
    {
        $connection = $this->getConnection();

        return new ActivityApi($connection->getClient(), $connection->getConfiguration());
    }

    protected function getCustomerApi(): CustomerApi
    {
        $connection = $this->getConnection();

        return new CustomerApi($connection->getClient(), $connection->getConfiguration());
    }

    protected function getConnection(): Connection
    {
        if ($this->connection === null) {
            $filename = Configuration::getFilename();
            if (!file_exists($filename)) {
                throw new InvalidConfigurationException('Missing configuration file: ' . $filename);
            }

            if (!is_readable($filename)) {
                throw new InvalidConfigurationException('Cannot read configuration: ' . $filename);
            }

            $configFile = file_get_contents($filename);
            if ($configFile === false) {
                throw new InvalidConfigurationException('Failed reading configuration: ' . $filename);
            }

            try {
                $result = json_decode($configFile, true);
                $config = new Configuration($result);
            } catch (\Exception $ex) {
                throw new InvalidConfigurationException('Invalid configuration: ' . $ex->getMessage());
            }

            try {
                $this->connection = new Connection($config);
            } catch (\Exception $ex) {
                throw new ConnectionProblemException('Failed to connect to API: ' . $ex->getMessage());
            }
        }

        return $this->connection;
    }

    /**
     * @param array<string> $headers
     * @param list<array<int, mixed>> $rows
     */
    protected function formatOutput(InputInterface $input, OutputInterface $output, array $headers, array $rows): void
    {
        $io = new SymfonyStyle($input, $output);

        if (false !== $input->getOption('csv')) {
            $io->writeln(implode(',', $headers));
            foreach ($rows as $row) {
                $io->writeln('"' . implode('","', $row) . '"');
            }

            return;
        }
        /*elseif (false !== $input->getOption('json')) {
            echo json_encode($rows);

            return;
        }*/

        $io->table($headers, $rows);
    }

    protected function renderApiException(InputInterface $input, SymfonyStyle $io, ApiException $ex, string $title): void
    {
        if ($ex->getCode() === 400) {
            $message = json_decode($ex->getResponseBody(), true);
            if (false === $message) {
                $io->error($ex->getMessage());
            } else {
                $messages = [$message['code'] . ' ' . $message['message']];

                // only happens for validation problems
                if (isset($message['errors']['children'])) {
                    foreach ($message['errors']['children'] as $field => $errors) {
                        if (\array_key_exists('errors', $errors)) {
                            foreach ($errors['errors'] as $msg) {
                                $messages[] = $field . ': ' . $msg;
                            }
                        }
                    }
                }

                $io->error($messages);
            }

            return;
        }

        $io->error($ex->getMessage());

        if ($input->getOption('verbose') === true) {
            $io->note($ex->getResponseBody());
        }
    }

    /**
     * @param SymfonyStyle $io
     * @param TimesheetCollectionExpanded[] $timesheets
     */
    protected function getSelectedTimesheet(SymfonyStyle $io, array $timesheets): ?TimesheetCollectionExpanded
    {
        if (\count($timesheets) === 0) {
            return null;
        }

        $rows = [];
        $options = [];
        foreach ($timesheets as $timesheet) {
            $options[] = $timesheet->getId();
            $rows[] = [
                $timesheet->getId(),
                $timesheet->getBegin()->format(\DateTime::ISO8601),
                $timesheet->getActivity() !== null ? $timesheet->getActivity()->getName() : '',
                $timesheet->getProject() !== null ? $timesheet->getProject()->getName() : '',
                $timesheet->getProject() !== null ? $timesheet->getProject()->getCustomer()->getName() : '',
                $timesheet->getDescription(),
                implode(', ', $timesheet->getTags()),
            ];
        }

        $io->table(
            ['ID', 'Started at', 'Activity', 'Project', 'Customer', 'Description', 'Tags'],
            $rows
        );

        $id = $io->choice('Please select a timesheet', $options);
        $id = \intval($id);

        foreach ($timesheets as $timesheet) {
            if ($timesheet->getId() === $id) {
                return $timesheet;
            }
        }

        return null;
    }

    protected function updateTimesheet(SymfonyStyle $io, TimesheetCollectionExpanded $timesheet, bool|string|null $description = false, bool|string|null $tags = false): void
    {
        $form = new TimesheetEditForm();

        if (false !== $description) {
            if (null === $description) {
                $description = $io->ask('Please enter the description for this timesheet', $timesheet->getDescription());
            }
            $form->setDescription($description);
        }

        if (false !== $tags) {
            if (null === $tags) {
                $tags = $io->ask('Please enter the tags for this timesheet (comma separated)', implode(', ', $timesheet->getTags()));
            }
            $form->setTags($tags);
        }

        $api = $this->getTimesheetApi();
        $api->patchPatchTimesheet($form, (string) $timesheet->getId());
    }
}
