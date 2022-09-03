<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Api;

use GuzzleHttp\Client;
use Swagger\Client\Api\DefaultApi;
use Swagger\Client\Configuration as SwaggerConfiguration;

final class Connection
{
    /**
     * @var Client
     */
    private $client;
    /**
     * @var SwaggerConfiguration
     */
    private $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = SwaggerConfiguration::getDefaultConfiguration();
        $this->configuration->setApiKey('X-AUTH-TOKEN', $configuration->getApiKey());
        $this->configuration->setApiKey('X-AUTH-USER', $configuration->getUsername());
        $this->configuration->setHost(rtrim($configuration->getUrl(), '/'));

        $clientOptions = $configuration->getCurlOptions();
        $this->client = new Client($clientOptions);

        $apiInstance = new DefaultApi($this->client, $this->configuration);
        $apiInstance->apiPingGet();
    }

    public function getClient(): Client
    {
        return $this->client;
    }

    public function getConfiguration(): SwaggerConfiguration
    {
        return $this->configuration;
    }
}
