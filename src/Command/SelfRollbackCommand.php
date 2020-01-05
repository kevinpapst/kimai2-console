<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class SelfRollbackCommand extends AbstractSelfCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('self:rollback')
            ->setDescription('Rollback to the latest available version')
            ->setHelp('This command lets you rollback an updated application to the previous version')
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
            $result = $updater->rollback();
            if ($result) {
                $io->success(sprintf('Rollback from version %s to %s', $updater->getOldVersion(), $updater->getNewVersion()));
            } else {
                $io->success('Cannot rollback');
            }
        } catch (\Exception $ex) {
            $io->error('Failed to rollback! ' . $ex->getMessage());

            return 1;
        }

        return 0;
    }
}
