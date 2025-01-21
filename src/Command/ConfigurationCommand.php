<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Api\Configuration;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

final class ConfigurationCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('configuration')
            ->setDescription('Handle the Kimai configuration file')
            ->setHelp('This command creates a default configuration file or displays its information.')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        if (false === $filename = getenv('KIMAI_CONFIG')) {
            $filename = getenv('HOME') . DIRECTORY_SEPARATOR . '.kimai-api.json';
        }

        if (file_exists($filename)) {
            try {
                $result = json_decode(file_get_contents($filename), true);
                $config = new Configuration($result);

                $io->success(
                    'Configuration file: ' . $filename . PHP_EOL .
                    'URL: ' . $config->getUrl() . PHP_EOL .
                    'Username: ' . $config->getUsername() . PHP_EOL
                );

                return 0;
            } catch (\Exception $ex) {
                $io->error(sprintf('Invalid configuration file %s: %s', $filename, $ex->getMessage()));
            }

            return 2;
        }

        if (!is_writable(\dirname($filename))) {
            $io->error('Cannot write config file: ' . $filename);

            return 1;
        }

        $config = Configuration::getDefaultConfiguration();

        // TODO ask for connection details

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
