<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use Swagger\Client\ApiException;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ActiveCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('active')
            ->setDescription('List active timesheets, update description and tags')
            ->setHelp('This command shows all currently running timesheet records and lets you update them')
            ->addOption('description', 'd', InputOption::VALUE_OPTIONAL, 'Set the given description or if none was given, you will be prompted for one.', false)
            ->addOption('tags', 't', InputOption::VALUE_OPTIONAL, 'Set the given (comma separated list) of tags or if no tags were given, you will be prompted for them.', false)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $api = $this->getTimesheetApi();
        $running = $api->apiTimesheetsActiveGet();

        if (\count($running) === 0) {
            $io->writeln('You have no active timesheets');

            return 0;
        }

        $update = false;
        if (false !== ($description = $input->getOption('description'))) {
            $update = true;
        }
        if (false !== ($tags = $input->getOption('tags'))) {
            $update = true;
        }

        $rows = [];

        if (!$update) {
            foreach ($running as $timesheet) {
                $rows[] = [
                    $timesheet->getId(),
                    $timesheet->getBegin()->format(\DateTime::ISO8601),
                    $timesheet->getActivity() !== null ? $timesheet->getActivity()->getName() : '', // @phpstan-ignore-line
                    $timesheet->getProject() !== null ? $timesheet->getProject()->getName() : '', // @phpstan-ignore-line
                    $timesheet->getProject() !== null ? $timesheet->getProject()->getCustomer()->getName() : '', // @phpstan-ignore-line
                    $timesheet->getDescription() !== null ? $timesheet->getDescription() : '', // @phpstan-ignore-line
                    implode(', ', $timesheet->getTags()),
                ];
            }

            $this->formatOutput($input, $output, ['ID', 'Started at', 'Activity', 'Project', 'Customer', 'Description', 'Tags'], $rows);
        } else {
            $timesheet = $this->getSelectedTimesheet($io, $running);

            try {
                $this->updateTimesheet($io, $timesheet, $description, $tags);

                $io->success('Updated timesheet');
            } catch (ApiException $ex) {
                $this->renderApiException($input, $io, $ex, 'Failed updating timesheet');

                return 1;
            }
        }

        return 0;
    }
}
