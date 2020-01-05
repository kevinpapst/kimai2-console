<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Client\ApiException;
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
            ->addOption('customer', 'c', InputOption::VALUE_OPTIONAL, 'The customer to filter the project list, can be an ID or a search term or empty (you will be prompted for a customer).')
            ->addOption('project', 'p', InputOption::VALUE_OPTIONAL, 'The project to use, can be an ID or a search term or empty. You will be prompted for the project.')
            ->addOption('activity', 'a', InputOption::VALUE_OPTIONAL, 'The activity ID to use')
            ->addOption('tags', 't', InputOption::VALUE_OPTIONAL, 'Comma separated list of tag names')
            ->addOption('description', 'd', InputOption::VALUE_OPTIONAL, 'The timesheet description')
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
        $projectId = $input->getOption('project');
        $activityId = $input->getOption('activity');

        if (null === $projectId) {
            $customer = $this->findCustomer($input, $output, $io, $customerId);
        }

        $project = $this->findProject($input, $output, $io, $projectId, $customer);
        if (null === $project) {
            $io->error('Cannot start timesheet: missing project');

            return 1;
        }

        if (null === $customer) {
            $customer = $this->loadCustomerById($io, $project->getCustomerId());
        }

        $activity = $this->findActivity($input, $output, $io, $activityId, $project);
        if (null === $activity) {
            $io->error('Cannot start timesheet: missing activity');

            return 1;
        }

        $api = $this->getApi();
        $form = new TimesheetEditForm();
        $form->setProject($project->getId());
        $form->setActivity($activity->getId());

        // TODO ask for tags if given empty
        if (null !== ($tags = $input->getOption('tags'))) {
            $form->setTags($tags);
        }

        // TODO ask for description if given empty
        if (null !== ($description = $input->getOption('description'))) {
            $form->setDescription($description);
        }

        try {
            $timesheet = $api->apiTimesheetsPost($form);
        } catch (ApiException $ex) {
            $this->renderApiException($input, $io, $ex, 'Failed creating timesheet');

            return 1;
        }

        $fields = [
            'ID' => $timesheet->getId(),
            'Begin' => $timesheet->getBegin()->format(\DateTime::ISO8601),
            'Description' => $timesheet->getDescription(),
            'Tags' => implode(PHP_EOL, $timesheet->getTags()),
            'Customer' => $customer->getName(),
            'Project' => $project->getName(),
            'Activity' => $activity->getName(),
        ];

        $io->success('Started timesheet');
        $io->horizontalTable(array_keys($fields), [$fields]);

        return 0;
    }
}
