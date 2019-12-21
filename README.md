# Kimai 2 - Remote Console

A PHP application to access your Kimai 2 installation via its API (http).

## Environment variables

The following environment variables are supported:

- `KIMAI_MEMORY_LIMIT` - configures the allowed memory limit (eg `128MB`, or `-1` for unlimited) (see [here](https://www.php.net/manual/en/ini.core.php#ini.memory-limit)) 
- `KIMAI_CONFIG` - path to your configuration file (default: $HOME/.kimai2-console.json) 

## Roadmap

- [add auto completion support](https://github.com/stecman/symfony-console-completion)

