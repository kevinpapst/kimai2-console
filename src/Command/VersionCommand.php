<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class VersionCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('version')
            ->setDescription('Show the Kimai version')
            ->setHelp('This command shows the Kimai version from the remote server')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $version = $this->getApi()->getAppApiStatusVersion();

        $io = new SymfonyStyle($input, $output);
        $io->writeln($version->getCopyright());

        return 0;
    }
}
