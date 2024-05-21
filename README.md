# <span style="color:#28b76b">SmartyTerminal v1.0</span>


SmartyTerminal is a Laravel console/terminal, for the SmartyCMS content management system (CRUD) package.

**Updated to work with Laravel 8 and PHP 8.0+**

**At this moment we support these commands:**

-   **[artisan](#artisan)** - Artisan is the command line interface included with Laravel
-   **[cleanup](#cleanup)** - Cleaning up the vendor folder
-   **[clear](#clear)** - Clear screen in shell script
-   **[completion](#completion)** - Dump the shell completion script
-   **[composer](#composer)** - Run the Composer dependency manager
-   **[find](#find)** - Search for files in a directory hierarchy (!)
-   **[help](#help)** - Display help for a command
-   **[list](#list)** - List commands
-   **[mysql](#mysql)** - Run MySQL console
-   **[tail](#tail)** - Run Tail command to get a real time log message
-   **[tinker](#tinker)** - Laravel Tinker is a powerful REPL for the Laravel framework
-   **[vi](#vi)** - Run Vi editor

For usage documentation see **Usage section** bellow.

**Supports:** Laravel 6.0+, 7.0+, 8.0+ and PHP 7.2+, 8.0+

**Important:** Please, make sure you're at the latest version of Laravel 6, 7 or 8 to get PHP 8 support.

## Installation

**🟡 Install using composer:**

```
$ composer require smartystudio/smartyterminal
```

**🔵 Install using private package repository (BitBucket):**

#### Step 1
Add `"smartystudio/smartyterminal": "dev-master"` to your `composer.json` file.

#### Step 2

Add the following to your `composer.json` file after the `scripts` section:

```json
"repositories": [
    {
        "type": "vcs",
        "url": "git@bitbucket.org:smartystudio/smartyterminal.git",
        "options": {
            "symlink": false
        }
    }
],
```

**❗ NOTICE**

If you want to develop the package locally, you need to add the following to your `composer.json` file after the `repositories` section:

```json
"repositories": [
    {
        "type": "path",
        "url": "packages/smartystudio/smartyterminal",
        "options": {
            "symlink": true
        }
    }
],
```

**💡 More info about Laravel package development, see here: [Laravel Package Development](https://laravelpackage.com/)**

In Laravel 5.5+, with Package Auto Discovery it should all be set automatically.

**For Laravel < 5.5, follow these instructions after composer finishes package installation:**

Add the service provider to the **providers** array in `config/app.php` for Laravel 5.4 and lower:

```php
SmartyStudio\SmartyTerminal\TerminalServiceProvider::class,
```

## Compiling Assets (Mix)

**npm install**

```
$ cd src
$ npm install
```

**bower install**

```
$ cd src
$ bower install
```

**build**

```
$ cd src
$ npm run production
```

**⚠️WARNING ⚠️**

If npm trow an error, then do this:

#### 1) Clear npm cache

#### 👇 clean your npm cache
`npm cache clean --force`

#### 👇 delete your node modules folder
`rm -rf node_modules`

#### 👇 delete your package-lock.json and yarn.lockfile
`rm package-lock.json && rm yarn.lock`

#### 👇 install the dependencies again
`npm install`

#### 2) Install npm again

```
$ npm install cross-env
$ npm install 
```

#### 3) Run npm again

`$ npm run dev` or `$ npm run prod` ('prod' is build for production environment).

## Publish Assets, Views and Config files

Now, when your package's users execute the vendor:publish command, your assets will be copied to the specified publish location. Since you will typically need to overwrite the assets every time the package is updated, you may use the --force flag:

`$ php artisan vendor:publish --tag=smartyterminal --force`

## Terminal Path

`https://yourwebiste.com/path/to/terminal`

## Config File

*file: src/config/terminal.php*

```php
return [

    /*
    |--------------------------------------------------------------------------
    | Package Enabled
    |--------------------------------------------------------------------------
    |
    | This value determines whether the package is enabled. By default, it
    | will be enabled if APP_DEBUG is true.
    |
    */

    'enabled' => env('APP_DEBUG'),

    /*
    |--------------------------------------------------------------------------
    | Whitelisted IP Addresses
    |--------------------------------------------------------------------------
    |
    | This value contains a list of IP addresses that are allowed to access
    | the SmartyTerminal.
    |
    */

    'whitelists' => ['127.0.0.1'],

    /*
    |--------------------------------------------------------------------------
    | Route Configuration
    |--------------------------------------------------------------------------
    |
    | This value sets the route information such as the prefix and middleware.
    |
    */

    'route' => [
        'prefix' => config('smartycms_config.route_prefix') . '/terminal',
        'as'     => 'terminal.',

        // If you need auth, you need to use 'web' and specify an 'auth' middleware
        'middleware' => [
            'web',
            SmartyStudio\SmartyCms\Http\Middleware\AuthenticateAdmin::class,
            'role:superadministrator',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Enabled Commands
    |--------------------------------------------------------------------------
    |
    | This value contains a list of class names for the available commands
    | for SmartyTerminal.
    |
    */

    'commands' => [
        SmartyStudio\SmartyTerminal\Console\Commands\Artisan::class,
        SmartyStudio\SmartyTerminal\Console\Commands\ArtisanTinker::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Cleanup::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Composer::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Find::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Mysql::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Tail::class,
        SmartyStudio\SmartyTerminal\Console\Commands\Vi::class,
    ],
];
```

## Add Command

*file: src/Console/Commands/MyNewCommandClass.php*

```php
namespace SmartyStudio\SmartyTerminal\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Inspiring;
use SmartyStudio\SmartyTerminal\Contracts\TerminalCommand;

class Inspire extends Command implements TerminalCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'inspire';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Display an inspiring quote';

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->comment(PHP_EOL.Inspiring::quote().PHP_EOL);
    }
}
```

## Commands Usage

### Artisan
```bash
$ artisan

# Running migrations and database seeds
$ artisan migrate --seed
```

### Cleanup
```bash
$ cleanup
```

### Clear
```bash
$ clear
```

### Completion
```bash
$  completion
```

### Composer
```bash
$  composer
```

### Find
```bash
$ find ./ -name * -maxdepth 1

# Not full support yet, but you can delete file using this command
# Don't forget to check file permissions
$ find ./vendor -name tests -type d -maxdepth 4 -delete

# Find and delete combination
$ find ./storage/logs -name * -maxdepth 1 -delete
```

### Help
```bash
$ help
```

### List
```bash
$ list
```

### MySQL
```bash
$ mysql
mysql> select * from users;

# Change database connection
mysql> use sqlite;
mysql> select * from users;
```

### Tail
```bash
$ tail
$ tail --line=1
$ tail server.php
$ tail server.php --line 5
```

### Tinker
```bash
$ artisan tinker
```

### Vi
```bash
$ vi server.php
```

## TODO

- [] Add tests

## Documentation

Visit our [Documentation](https://smartystudio.github.io/smartycms/terminal) for detailed usage instructions.

## Contributing

Contributions to the SmartyCMS library are welcome. Please note the following guidelines before submitting your pull request.

-   Follow [PSR-4](http://www.php-fig.org/psr/psr-4/) coding standards.
-   Write tests for new functions and added features
-   use [Laravel Mix](https://laravel.com/docs/master/mix) for assets

## License

This is licensed software. All copyrights are reserved by Smarty Studio MBN Ltd. In the event of improper use of the software or use without the permission of the author, all legal action will be taken.
