<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Constants;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SelfUpdateCommand extends AbstractSelfCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('self:update')
            ->setDescription('Update to the latest available version')
            ->setHelp('This command lets you update the "Remote Console" application to the latest version')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        $updater = $this->getUpdater();

        try {
            $result = $updater->update();
            if ($result) {
                $io->success(sprintf('Updated from version %s to %s', $updater->getOldVersion(), $updater->getNewVersion()));
            } else {
                $io->success(sprintf('Using latest version %s already', Constants::VERSION));
            }
        } catch (\Exception $ex) {
            $io->error('Failed updating: ' . $ex->getMessage());

            return 1;
        }

        return 0;
    }
}
