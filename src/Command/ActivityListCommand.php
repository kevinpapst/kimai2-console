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

final class ActivityListCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('activity:list')
            ->setDescription('List available activities')
            ->setHelp('This command lets you search for activities')
            ->addOption('project', null, InputOption::VALUE_OPTIONAL, 'The project to be filtered', null)
            ->addOption('term', null, InputOption::VALUE_OPTIONAL, 'A search term to filter activities', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $project = null;
        $term = null;

        if (null !== $input->getOption('project')) {
            $project = $input->getOption('project');
        }

        if (null !== $input->getOption('term')) {
            $term = $input->getOption('term');
        }

        $api = $this->getApi();
        $collection = $api->apiActivitiesGet($project, true, null, null, 'project', null, $term);

        $rows = [];
        foreach ($collection as $activity) {
            $project = '-';
            if (null !== ($prj = $activity->getProject())) {
                $project = $prj;
            }
            $rows[] = [
                $activity->getId(),
                $activity->getName(),
                $project
            ];
        }
        $io->table(['Id', 'Name', 'Project ID'], $rows);

        return 0;
    }
}
