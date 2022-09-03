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
use Symfony\Component\Console\Style\SymfonyStyle;

final class CustomerListCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('customer:list')
            ->setDescription('List available customers')
            ->setHelp('This command lets you search for customer')
            ->addOption('term', null, InputOption::VALUE_OPTIONAL, 'A search term to filter customer', null)
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        $term = null;

        if (null !== $input->getOption('term')) {
            $term = $input->getOption('term');
        }

        $api = $this->getCustomerApi();

        $visible = '1';
        $order = null;
        $order_by = null;

        $collection = $api->apiCustomersGet($visible, $order, $order_by, $term);

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
