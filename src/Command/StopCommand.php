<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

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
            ->setDescription('Stops running timesheets')
            ->setHelp('This command lets you stop running timesheets, if multiple are running you can choose of them')
            ->addOption('all', 'a', InputOption::VALUE_NONE, 'Stop all running tasks without asking')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $api = $this->getApi();
        $running = $api->apiTimesheetsActiveGet();

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
            $choices = [];
            $options = [];
            foreach ($running as $timesheet) {
                $options[] = $timesheet->getId();
                $choices[] = [
                    $timesheet->getId(),
                    $timesheet->getBegin()->format(\DateTime::ISO8601),
                    $timesheet->getActivity() !== null ? $timesheet->getActivity()->getName() : '',
                    $timesheet->getProject() !== null ? $timesheet->getProject()->getName() : '',
                    $timesheet->getProject() !== null ? $timesheet->getProject()->getCustomer()->getName() : '',
                ];
            }

            $io->table(
                ['ID', 'Started at', 'Activity', 'Project', 'Customer'],
                $choices
            );

            $stopIds[] = $io->choice('Which record should be stopped', $options);
        }

        foreach ($stopIds as $id) {
            $api->apiTimesheetsIdStopPatch($id);
        }
        $io->writeln(sprintf('Stopped %s active timesheet(s) with ID: %s', count($stopIds), implode(', ', $stopIds)));

        return 0;
    }
}
