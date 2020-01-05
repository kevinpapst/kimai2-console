<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Api;

use GuzzleHttp\Client;
use KimaiConsole\Client\Api\DefaultApi;

final class Connection
{
    /**
     * @var Configuration
     */
    private $configuration;
    /**
     * @var DefaultApi
     */
    private $api;
    private $connected = false;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = $configuration;
    }

    public function connect()
    {
        if (!$this->connected) {
            $config = \KimaiConsole\Client\Configuration::getDefaultConfiguration();
            $config->setApiKey('X-AUTH-TOKEN', $this->configuration->getApiKey());
            $config->setApiKey('X-AUTH-USER', $this->configuration->getUsername());
            $config->setHost(rtrim($this->configuration->getUrl(), '/'));

            $clientOptions = $this->configuration->getCurlOptions();

            $apiInstance = new DefaultApi(
                new Client($clientOptions),
                $config
            );

            $r = $apiInstance->apiPingGet();

            $this->api = $apiInstance;

            $this->connected = true;
        }

        return $this->api;
    }

    public function getApi(): DefaultApi
    {
        if (!$this->connected) {
            $this->connect();
        }

        return $this->api;
    }
}
