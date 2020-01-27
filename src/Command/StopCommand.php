<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Client\ApiException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class StopCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('stop')
            ->setDescription('Stop running timesheets, set description and tags')
            ->setHelp('This command lets you stop running timesheets, if multiple are running you can choose of them')
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'Stop all running tasks without asking')
            ->addOption('description', 'd', InputOption::VALUE_OPTIONAL, 'Set the given description for the stopped timesheet. If none was given, you will be prompted for one.', false)
            ->addOption('tags', 't', InputOption::VALUE_OPTIONAL, 'Set the given (comma separated list) of tags for the stopped timesheet. If no tags were given, you will be prompted for them.', false)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        try {
            $api = $this->getApi();
            $running = $api->apiTimesheetsActiveGet();
        } catch (ApiException $ex) {
            $this->renderApiException($input, $io, $ex, 'Failed loading active timesheets');

            return 1;
        }

        if (count($running) === 0) {
            $io->writeln('You have no active timesheets');

            return 0;
        }

        $stopIds = [];

        if (false !== $input->getOption('all')) {
            foreach ($running as $timesheet) {
                $stopIds[] = $timesheet->getId();
            }
        } else {
            $timesheet = $this->getSelectedTimesheet($io, $running);

            if (null === $timesheet) {
                $io->error('You must selected a timesheet');

                return 1;
            }

            $stopIds[] = $timesheet->getId();
        }

        $updateBeforeStop = false;
        if (false !== ($description = $input->getOption('description'))) {
            $updateBeforeStop = true;
        }
        if (false !== ($tags = $input->getOption('tags'))) {
            $updateBeforeStop = true;
        }

        if ($updateBeforeStop) {
            foreach ($running as $timesheet) {
                if (!in_array($timesheet->getId(), $stopIds)) {
                    continue;
                }

                $row = [
                    $timesheet->getId(),
                    $timesheet->getBegin()->format(\DateTime::ISO8601),
                    $timesheet->getActivity() !== null ? $timesheet->getActivity()->getName() : '',
                    $timesheet->getProject() !== null ? $timesheet->getProject()->getName() : '',
                    $timesheet->getProject() !== null ? $timesheet->getProject()->getCustomer()->getName() : '',
                ];

                $io->table(
                    ['ID', 'Started at', 'Activity', 'Project', 'Customer'],
                    [$row]
                );

                try {
                    $this->updateTimesheet($io, $timesheet, $description, $tags);

                    $io->success('Updated timesheet');
                } catch (ApiException $ex) {
                    $this->renderApiException($input, $io, $ex, 'Failed updating timesheet');

                    return 1;
                }
            }
        }

        $stopped = [];
        foreach ($stopIds as $id) {
            try {
                $api->apiTimesheetsIdStopPatch($id);
                $stopped[] = $id;
            } catch (ApiException $ex) {
                $this->renderApiException($input, $io, $ex, 'Failed stopping timesheet');
            }
        }

        $io->success(sprintf('Stopped %s active timesheet(s) with ID: %s', count($stopped), implode(', ', $stopped)));

        return 0;
    }
}
