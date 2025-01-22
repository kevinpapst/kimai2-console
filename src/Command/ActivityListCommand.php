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

final class ActivityListCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('activity:list')
            ->setDescription('List available activities')
            ->setHelp('This command lets you search for activities')
            ->addOption('project', null, InputOption::VALUE_OPTIONAL, 'The project to be filtered', null)
            ->addOption('term', null, InputOption::VALUE_OPTIONAL, 'A search term to filter activities', null)
            ->addOption('globals', null, InputOption::VALUE_NONE, 'Show global activities only (will ignore project option)')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $project = null;
        $term = null;

        if (null !== $input->getOption('project')) {
            $project = $input->getOption('project');
        }

        if (null !== $input->getOption('term')) {
            $term = $input->getOption('term');
        }

        $api = $this->getActivityApi();

        $visible = '1';
        $globals = null;
        $order_by = 'project';
        $order = null;

        if ($input->getOption('globals')) {
            $globals = '1';
        }

        $collection = $api->getGetActivities(
            $project,
            null, // @phpstan-ignore argument.type
            $visible,
            $globals,
            $order_by,
            $order,
            $term
        );

        $rows = [];
        foreach ($collection as $activity) {
            $projectId = '';
            $projectName = '';
            if (!empty($activity->getProject())) {
                $projectId = $activity->getProject();
                $projectName = $activity->getParentTitle();
            }
            $rows[] = [
                $activity->getId(),
                $activity->getName(),
                $projectId,
                $projectName,
            ];
        }

        $this->formatOutput($input, $output, ['Id', 'Name', 'Project ID', 'Project Name'], $rows);

        return 0;
    }
}
