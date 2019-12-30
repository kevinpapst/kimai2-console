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

final class ProjectListCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('project:list')
            ->setDescription('List available projects')
            ->setHelp('This command lets you search for projects')
            ->addOption('customer', null, InputOption::VALUE_OPTIONAL, 'A customer to filter projects by', null)
            ->addOption('term', null, InputOption::VALUE_OPTIONAL, 'A search term to filter projects', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $term = null;
        $customer = null;

        if (null !== $input->getOption('term')) {
            $term = $input->getOption('term');
        }

        if (null !== $input->getOption('customer')) {
            $customer = $input->getOption('customer');
        }

        $api = $this->getApi();
        $collection = $api->apiProjectsGet($customer, true, null, 'customer', $term);

        $rows = [];
        foreach ($collection as $project) {
            $rows[] = [
                $project->getId(),
                $project->getName(),
                '[' . $project->getCustomer() . '] '  . $project->getParentTitle(),
            ];
        }
        $io->table(['Id', 'Name', 'Customer ID'], $rows);

        return 0;
    }
}
