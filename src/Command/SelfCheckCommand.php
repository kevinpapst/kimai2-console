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

class SelfCheckCommand extends AbstractSelfCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('self:check')
            ->setDescription('Checks for available updates')
            ->setHelp('This command checks if there is a new version available')
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
            $result = $updater->hasUpdate();

            if ($result) {
                // this is also triggered, if the current local version is higher then the remote version
                // it does not trigger a version_compare, but only compare if the two versions are equal
                $io->warning(sprintf('There is a new release available in version: %s', $updater->getNewVersion()));
            } elseif (false === $updater->getNewVersion()) {
                $io->error('There are no stable builds available.');
            } else {
                $io->success(sprintf('You are running the latest version: %s', Constants::VERSION));
            }
        } catch (\Exception $ex) {
            $io->error('Failed to check for updates: ' . $ex->getMessage());

            return 1;
        }

        return 0;
    }
}
