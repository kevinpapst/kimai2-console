<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Client\Model\TimesheetEditForm;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class StartCommand extends BaseCommand
{
    use TimesheetCommandTrait;

    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('start')
            ->setDescription('Starts a new timesheet')
            ->setHelp('This command lets you start a new timesheet')
            ->addOption('customer', null, InputOption::VALUE_OPTIONAL, 'The customer to filter the project list, can be an ID or a search term or empty (you will be prompted for a customer).', false)
            ->addOption('project', null, InputOption::VALUE_OPTIONAL, 'The project to use, can be an ID or a search term or empty. You will be prompted for the project.')
            ->addOption('activity', null, InputOption::VALUE_OPTIONAL, 'The activity ID to use')
            ->addOption('tags', null, InputOption::VALUE_OPTIONAL, 'Comma separated list of tag names')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $customer = null;

        $customerId = $input->getOption('customer');
        if (false !== $customerId) {
            $customer = $this->findCustomer($input, $output, $io, $customerId);
        }

        $projectId = $input->getOption('project');
        $project = $this->findProject($input, $output, $io, $projectId, $customer);

        $activityId = $input->getOption('activity');
        $activity = $this->findActivity($input, $output, $io, $activityId, $project);

        if (null === $project) {
            $io->error('Cannot start timesheet: missing project');

            return 1;
        }

        if (null === $activity) {
            $io->error('Cannot start timesheet: missing activity');

            return 1;
        }

        $api = $this->getApi();
        $form = new TimesheetEditForm();
        $form->setProject($project->getId());
        $form->setActivity($activity->getId());

        if (null !== ($tags = $input->getOption('tags'))) {
            $form->setTags($tags);
        }

        $timesheet = $api->apiTimesheetsPost($form);
        $io->success('Started timesheet');
        $io->listing([
            'ID: ' . $timesheet->getId(),
            'Begin: ' . $timesheet->getBegin()->format(\DateTime::ISO8601),
            'Project: ' . $project->getName(),
            'Activity: ' . $activity->getName()
        ]);

        return 0;
    }
}
