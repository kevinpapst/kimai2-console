<?php

/*
 * This file is part of the Kimai 2 - Remote Console.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace KimaiConsole\Api;

final class Configuration
{
    /**
     * @var array
     */
    private $settings;

    public function __construct(array $settings)
    {
        $this->validate($settings);

        $this->settings = $settings;
    }

    public function getUsername(): string
    {
        return $this->settings['USERNAME'];
    }

    public function getApiKey(): string
    {
        return $this->settings['API_KEY'];
    }

    public function getUrl(): string
    {
        return $this->settings['URL'];
    }

    public static function getDefaultConfiguration(): array
    {
        return [
            'URL' => 'https://demo.kimai.org/',
            'USERNAME' => 'susan_super',
            'API_KEY' => 'api_kitten',
        ];
    }

    public static function getFilename(): string
    {
        if (false === $filename = getenv('KIMAI_CONFIG')) {
            $filename = getenv('HOME') . DIRECTORY_SEPARATOR . '.kimai2-console.json';
        }

        return $filename;
    }

    /**
     * @param array $settings
     * @return bool
     * @throws \Exception
     */
    private function validate(array $settings)
    {
        foreach (self::getDefaultConfiguration() as $key => $value) {
            if (!array_key_exists($key, $settings)) {
                throw new \Exception('Missing config: ' . $key);
            } elseif (empty($settings[$key])) {
                throw new \Exception('Empty config: ' . $key);
            }
        }

        return true;
    }
}
