<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use KimaiConsole\Api\Configuration;
use KimaiConsole\Api\Connection;
use KimaiConsole\Client\Api\DefaultApi;
use KimaiConsole\Exception\ConnectionProblemException;
use KimaiConsole\Exception\InvalidConfigurationException;
use Symfony\Component\Console\Command\Command;

abstract class BaseCommand extends Command
{
    protected function getApi(): DefaultApi
    {
        $filename = Configuration::getFilename();
        if (!file_exists($filename)) {
            throw new InvalidConfigurationException('Missing configuration file: ' . $filename);
        }

        if (!is_readable($filename)) {
            throw new InvalidConfigurationException('Cannot read configuration: ' . $filename);
        }

        try {
            $result = json_decode(file_get_contents($filename), true);
            $config = new Configuration($result);
        } catch (\Exception $ex) {
            throw new InvalidConfigurationException('Invalid configuration: ' . $ex->getMessage());
        }

        try {
            $connection = new Connection($config);
            $connection->connect();

            return $connection->getApi();
        } catch (\Exception $ex) {
            throw new ConnectionProblemException('Failed to connect to API: ' . $ex->getMessage());
        }
    }
}
