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
    private Client $client;
    private SwaggerConfiguration $configuration;

    public function __construct(Configuration $configuration)
    {
        $this->configuration = SwaggerConfiguration::getDefaultConfiguration();
        $this->configuration->setAccessToken($configuration->getApiToken());
        $this->configuration->setHost(rtrim($configuration->getUrl(), '/'));

        $clientOptions = $configuration->getCurlOptions();
        $this->client = new Client($clientOptions);

        $apiInstance = new DefaultApi($this->client, $this->configuration);
        $apiInstance->getAppApiStatusPing();
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
