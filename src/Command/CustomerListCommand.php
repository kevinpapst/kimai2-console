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

final class CustomerListCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('customer:list')
            ->setDescription('List available customers')
            ->setHelp('This command lets you search for customer')
            ->addOption('term', null, InputOption::VALUE_OPTIONAL, 'A search term to filter customer', null)
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $term = null;

        if (null !== $input->getOption('term')) {
            $term = $input->getOption('term');
        }

        $api = $this->getApi();
        $collection = $api->apiCustomersGet(true, null, null, $term);

        $rows = [];
        foreach ($collection as $customer) {
            $rows[] = [
                $customer->getId(),
                $customer->getName(),
            ];
        }

        $this->formatOutput($input, $output, ['Id', 'Name'], $rows);

        return 0;
    }
}
