<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ActiveCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('active')
            ->setDescription('List active timesheets')
            ->setHelp('This command shows all currently running timesheet records')
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

        $choices = [];

        foreach ($running as $timesheet) {
            $choices[] = [
                $timesheet->getId(),
                $timesheet->getBegin()->format(\DateTime::ISO8601),
                $timesheet->getActivity() !== null ? $timesheet->getActivity()->getName() : '',
                $timesheet->getProject() !== null ? $timesheet->getProject()->getName() : '',
                $timesheet->getProject() !== null ? $timesheet->getProject()->getCustomer()->getName() : '',
                $timesheet->getDescription() !== null ? $timesheet->getDescription() : '',
            ];
        }

        $this->formatOutput($input, $output, ['ID', 'Started at', 'Activity', 'Project', 'Customer', 'Description'], $choices);

        return 0;
    }
}
