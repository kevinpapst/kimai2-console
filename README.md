# Kimai 2 - Remote Console

A PHP application to access your Kimai 2 installation via its API (http).

**Requirements**

- PHP 7.2.5
- cURL extension
- json extension
- iconv extension
- zlib extension

## Installation and updates

To install and update the Kimai console tools, execute the following commands: 

```bash
curl -LO https://github.com/kevinpapst/kimai2-console/releases/latest/download/kimai.phar
chmod +x kimai.phar
mv kimai.phar /usr/local/bin/kimai
```

### Configuration file

Before using it the first time, you have to create a configuration file, which holds the connection infos for Kimai.
By default this config file will be located at `~/.kimai2-console.json`:

```bash
kimai configuration:create
```

Make sure the file is only readable for your own user:
 
```bash
chmod 600 ~/.kimai2-console.json
```

That's it, you can use Kimai from the command line now.

By default the configuration file targets the demo installation and will work... but now its time to target your own Kimai, so 
edit the config file and change the settings: URL, username and API token.

## Available commands

You get a list of all available commands with `kimai`.

- `kimai customer:list` - show a list of customers
- `kimai project:list` - show a list of projects
- `kimai activity:list` - show a list of activities
- `kimai version` - show the full version string of the remote installation
- `kimai configuration:create` - creates the initial configuration file

To get help for a dedicated command use the `--help` switch, eg: `kimai project:list --help`

## Environment variables

The following environment variables are supported:

- `KIMAI_MEMORY_LIMIT` - configures the allowed memory limit (eg `128MB`, or `-1` for unlimited) (see [here](https://www.php.net/manual/en/ini.core.php#ini.memory-limit)) 
- `KIMAI_CONFIG` - path to your configuration file (defaults to: $HOME/.kimai2-console.json) 

## How to build a release

- Bump version in `src/Constants.php`
- Execute `box compile`
- Prepare a new GitHub release
- Upload the file `kimai.phar` to the new release
