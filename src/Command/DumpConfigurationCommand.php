<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Api\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class DumpConfigurationCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function configure()
    {
        $this
            ->setName('dump-configuration')
            ->setDescription('Dumps a default configuration file')
            ->setHelp('This command creates a default configuration file.')
        ;
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $io = new SymfonyStyle($input, $output);

        if (false === $filename = getenv('KIMAI_CONFIG')) {
            $filename = getenv('HOME') . DIRECTORY_SEPARATOR . '.kimai2-console.json';
        }

        if (file_exists($filename)) {
            $io->warning('Skipping, as configuration file already exists: ' . $filename);

            return 2;
        }

        if (!is_writable(dirname($filename))) {
            $io->error('Cannot write config file: ' . $filename);

            return 1;
        }

        $config = Configuration::getDefaultConfiguration();

        $json = json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES);

        if (false === $json) {
            $io->error('Failed generating JSON configuration: ' . $filename);

            return 3;
        }

        if (false === file_put_contents($filename, $json)) {
            $io->error('Failed writing configuration to file: ' . $filename);

            return 4;
        }

        $io->success('Created default configuration, please adjust it at: ' . $filename);

        return 0;
    }
}
