<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole;

use KimaiConsole\Exception\ConnectionProblemException;
use KimaiConsole\Exception\InvalidConfigurationException;
use Symfony\Component\Console\Application as SymfonyApplication;
use Symfony\Component\Console\Command\HelpCommand;
use Symfony\Component\Console\Command\ListCommand;
use Symfony\Component\Console\Input\InputDefinition;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Console\Style\SymfonyStyle;

class Application extends SymfonyApplication
{
    private static $logo = ' _  _____ __  __    _    ___
| |/ /_ _|  \/  |  / \  |_ _|
| \' / | || |\/| | / _ \  | |
| . \ | || |  | |/ ___ \ | |
|_|\_\___|_|  |_/_/   \_\___|

';

    public function __construct()
    {
        parent::__construct(Constants::SOFTWARE, Constants::VERSION);
    }

    public function getLongVersion(): string
    {
        return sprintf('<info>%s</info> version <comment>%s</comment> %s (#%s)', $this->getName(), $this->getVersion(), Constants::DATE, Constants::GIT);
    }

    public function doRun(InputInterface $input, OutputInterface $output): int
    {
        $io = new SymfonyStyle($input, $output);

        try {
            if ($input->hasParameterOption('--profile')) {
                $startTime = microtime(true);
            }

            $result = parent::doRun($input, $output);

            if (isset($startTime)) {
                $io->writeln('<info>Memory usage: ' . round(memory_get_usage() / 1024 / 1024, 2) . 'MiB (peak: ' . round(memory_get_peak_usage() / 1024 / 1024, 2) . 'MiB), time: ' . round(microtime(true) - $startTime, 2) . 's');
            }

            return $result;
        } catch (InvalidConfigurationException $e) {
            $io->error([
                $e->getMessage(),
                'You can create a default configuration with: bin/kimai dump-configuration'
            ]);

            return 1;
        } catch (ConnectionProblemException $e) {
            $io->error([$e->getMessage()]);

            return 2;
        } catch (\Exception $e) {
            $io->error('Failed execution: ' . $e->getMessage());

            return 3;
        }
    }

    protected function getDefaultCommands(): array
    {
        return [
            new HelpCommand(),
            new ListCommand(),
            new Command\ActiveCommand(),
            new Command\StartCommand(),
            new Command\StopCommand(),
            new Command\ActivityListCommand(),
            new Command\ProjectListCommand(),
            new Command\CustomerListCommand(),
            new Command\ConfigurationCommand(),
            new Command\VersionCommand(),
        ];
    }

    protected function getDefaultInputDefinition(): InputDefinition
    {
        $definition = parent::getDefaultInputDefinition();
        $definition->addOption(new InputOption('--profile', null, InputOption::VALUE_NONE, 'Display timing and memory usage information'));
        $definition->addOption(new InputOption('--csv', null, InputOption::VALUE_NONE, 'Render raw data instead of styled tables'));
        //$definition->addOption(new InputOption('--json', null, InputOption::VALUE_NONE, 'Render JSON data instead of styled tables'));

        return $definition;
    }

    public function getHelp(): string
    {
        return self::$logo . parent::getHelp();
    }
}
