# Kimai 2 - Remote Console

A PHP application to access your Kimai 2 installation via its API (http).

**Requirements**

- PHP 7.2.5
- cURL extension
- json extension
- iconv extension

## Installation and updates

```bash
wget curl -LJO https://github.com/kevinpapst/kimai2-console/releases/latest/download/kimai.phar
chmod +x kimai.phar
mv kimai.phar /usr/local/bin/kimai
```

Now you need to create a configuration file, which is required to connect to Kimai:

```bash
kimai dump-configuration
```

Afterwards edit the file and change the URL, username and API token to your needs.

By default the configuration file targets the demo installation and will work, but this is likely not want you intent to use ;-)

That's it, you can use Kimai now with e.g. `kimai customer:list`.

## Environment variables

The following environment variables are supported:

- `KIMAI_MEMORY_LIMIT` - configures the allowed memory limit (eg `128MB`, or `-1` for unlimited) (see [here](https://www.php.net/manual/en/ini.core.php#ini.memory-limit)) 
- `KIMAI_CONFIG` - path to your configuration file (defaults to: $HOME/.kimai2-console.json) 

