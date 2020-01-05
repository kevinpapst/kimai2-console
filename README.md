# Kimai 2 - Remote Console

A PHP application to access your Kimai 2 installation via its API (http).

**Requirements**

- PHP 7.2.5
- cURL extension
- json extension
- iconv extension
- zlib extension

## Installation

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
kimai configuration
```

Make sure the file is only readable for your own user:
 
```bash
chmod 600 ~/.kimai2-console.json
```

That's it, you can use Kimai from the command line now.

By default the configuration file targets the demo installation and will work... but now its time to target your own Kimai, so 
edit the config file and change the settings: URL, username and API token.

The following config keys are available:

- `URL`: the Kimai installation URL
- `USERNAME`: the Kimai installation URL
- `API_KEY`: your Kimai API key (can be set when editing your profile)
- `OPTIONS`: an array of request options for CURL (see [guzzle docs](http://docs.guzzlephp.org/en/stable/request-options.html))

FAQ:

- `I want to use a self-signed certificate` - add `"OPTIONS": {"verify": false}` to your configuration

## Available commands

You get a list of all available commands with `kimai`.

- `kimai active` - display and update all running timesheets (via `--description` and `--tags`)
- `kimai stop` - stop currently active timesheets and update them (via `--description` and `--tags`)
- `kimai start` - start a new timesheet (see below)
- `kimai customer:list` - show a list of customers
- `kimai project:list` - show a list of projects
- `kimai activity:list` - show a list of activities
- `kimai version` - show the full version string of the remote installation
- `kimai configuration` - creates the initial configuration file or displays it

The following commands will help you with updating the command:

- `kimai self:check` - check if there is a new version available
- `kimai self:update` - update your local version to the latest release
- `kimai self:rollback` - rollback to a previous release

To get help for a dedicated command use the `--help` switch, eg: `kimai project:list --help`

### Start a timesheet

This command tries to detect customer, project and activity from your input in the following way:

- if it is a number, then it tries to load the entity by its ID
  - if a entity is found, it will be used
- if it is a string, then this is just as search term
  - if one entity is found, it will be used
  - if multiple entities are found, a select list is shown
- if nothing is given or no result was found in the previous steps, a list of all entities is fetched and shown for selection
  - this list might be filtered (eg. only activities for found project)

This most simple example will display a select list for all customers, then a filtered list for the projects of the chosen customer and finally a select list for all activities for the chosen project: 
```
bin/kimai start
```

Example to start a new timesheet by search terms only, adding a description and some tags: 
```
bin/kimai start --customer Schowalter --project analyzer --activity iterate --description "working for fun" --tags "test, bla foo, tagging"

 [OK] Started timesheet                                                                                                 

 ------------- ------------------------------------ 
  ID            5085                                
  Begin         2020-01-03T23:34:26+0100            
  Description   working for fun                     
  Tags          bla foo                             
                test                                
                tagging                             
  Customer      Schowalter PLC                      
  Project       Grass-roots system-worthy analyzer  
  Activity      iterate viral infomediaries         
 ------------- ------------------------------------ 
```

### Output format

The `:list`ing commands display a formatted table of all found entities.

If you want to use the output in a script, instead of manually looking at them, please use the `--csv` switch. 

## Environment variables

The following environment variables are supported:

- `KIMAI_MEMORY_LIMIT` - configures the allowed memory limit (eg `128MB`, or `-1` for unlimited) (see [here](https://www.php.net/manual/en/ini.core.php#ini.memory-limit)) 
- `KIMAI_CONFIG` - path to your configuration file (defaults to: $HOME/.kimai2-console.json) 

## How to build a release

- Bump version in `src/Constants.php`
- Execute `box compile`
- Prepare a new GitHub release
- Upload the file `kimai.phar` to the new release
