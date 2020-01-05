<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Command;

use Humbug\SelfUpdate\Updater;
use KimaiConsole\Constants;

abstract class AbstractSelfCommand extends BaseCommand
{
    /**
     * {@inheritdoc}
     */
    protected function getUpdater(): Updater
    {
        $updater = new Updater(null, false, Updater::STRATEGY_GITHUB);
        $updater->getStrategy()->setPackageName('kevinpapst/kimai2-console');
        $updater->getStrategy()->setPharName('kimai.phar');
        $updater->getStrategy()->setCurrentLocalVersion(Constants::VERSION);

        return $updater;
    }
}
