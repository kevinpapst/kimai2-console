<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

final class ProjectListCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('project:list')
            ->setDescription('List available projects')
            ->setHelp('This command lets you search for projects')
            ->addOption('customer', null, InputOption::VALUE_OPTIONAL, 'A customer ID to filter projects by (comma separated list possible)')
            ->addOption('term', null, InputOption::VALUE_OPTIONAL, 'A search term to filter projects')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $term = null;
        $customer = null;

        if (null !== $input->getOption('term')) {
            $term = $input->getOption('term');
        }

        if (null !== $input->getOption('customer')) {
            $customer = $input->getOption('customer');
        }

        $api = $this->getProjectApi();

        $visible = '1';
        $start = null;
        $end = null;
        $global_activities = null;
        $ignore_dates = null;
        $order = null;
        $order_by = 'customer';

        // null parameters are deprecated
        $collection = $api->getGetProjects(
            $customer,
            null,  // @phpstan-ignore argument.type
            $visible,
            $start,
            $end,
            $ignore_dates,
            $global_activities,
            $order,
            $order_by,
            $term
        );

        $rows = [];
        foreach ($collection as $project) {
            $rows[] = [
                $project->getId(),
                $project->getName(),
                $project->getCustomer(),
                $project->getParentTitle(),
            ];
        }

        $this->formatOutput($input, $output, ['Id', 'Name', 'Customer ID', 'Customer Name'], $rows);

        return 0;
    }
}
