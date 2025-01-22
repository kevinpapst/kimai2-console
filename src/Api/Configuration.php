<?php

/*
 * This file is part of the "Remote Console" for Kimai.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Api;

final class Configuration
{
    /**
     * @param array{URL: string, API_TOKEN: string, OPTIONS: array<string, mixed>} $settings
     * @throws \Exception
     */
    public function __construct(private readonly array $settings)
    {
        $this->validate($settings);
    }

    public function getApiToken(): string
    {
        return $this->settings['API_TOKEN'];
    }

    public function getUrl(): string
    {
        return $this->settings['URL'];
    }

    /**
     * @return array<string, mixed>
     */
    public function getCurlOptions(): array
    {
        if (!\array_key_exists('OPTIONS', $this->settings)) {
            return [];
        }

        return $this->settings['OPTIONS'];
    }

    /**
     * @return array<string, string>
     */
    public static function getDefaultConfiguration(): array
    {
        return [
            'URL' => 'https://demo.kimai.org/',
            'API_TOKEN' => 'token_super',
        ];
    }

    public static function getFilename(): string
    {
        if (false === ($filename = getenv('KIMAI_CONFIG'))) {
            $old = getenv('HOME') . DIRECTORY_SEPARATOR . '.kimai2-console.json';
            $new = getenv('HOME') . DIRECTORY_SEPARATOR . '.kimai-api.json';
            if (file_exists($old)) {
                rename($old, $new);
            }
            $filename = $new;
        }

        return $filename;
    }

    /**
     * @param array{URL: string, API_TOKEN: string, OPTIONS: null|array<string, mixed>} $settings
     * @throws \Exception
     */
    private function validate(array $settings): bool
    {
        if (!\array_key_exists('URL', $settings) || $settings['URL'] === '') {
            throw new \Exception('Missing API URL with the key "URL"');
        }

        if (!\array_key_exists('API_TOKEN', $settings) || $settings['API_TOKEN'] === '') {
            throw new \Exception('Missing API token with the key "API_TOKEN"');
        }

        if (\array_key_exists('OPTIONS', $settings) && !\is_array($settings['OPTIONS'])) {
            throw new \Exception('Invalid config "OPTIONS": key-value array expected');
        }

        return true;
    }
}
