# ConfigSlalom
Do configuration magic easily in PHP!

## Installation:

For PHP 5.3 or higher, use `composer`:

```
composer require spaceboy/config-slalom
```

For lower versions, copy `PHP52` directory and require `autoload.php` file:
```
<?php
...
require_once('PHP52/autoload.php');
...
```

## Example:

```
use Spaceboy\ConfigSlalom\Slalom;

$configurator = Slalom::start(new Configurator)
    ->when()
        ->serverNameIs('localhost')
        ->andContinue()
    ->when()
        ->serverNameIsIn(['localhost', 'production-server.com'])
        ->execute(function ($configurator) {
            // do something
        })
        ->andContinue()
    ->when()
        ->requestUriStarts('/img/')
        ->execute(function ($configurator) {
            $configurator->handleImages();
        })
    ->when()
        ->requestUriIs('/upload')
        ->methodIs('POST')
        ->skip(file_exists('uploaded.file'))
        ->execute(function ($configurator) {
            // do something
        })
    ->otherwise()
        ->throwException(new \Exception('Wrong server host.'))
    ->finally()
        ->execute(
            function ($configurator) {
                // do something
            }
        )
    ->run();
```

## Public methods:

- ### `start([mixed $configurator]): Slalom`
  First directive.
  
  Starts whole "slalom".

- ### `when([bool $apply = TRUE]): Slalom`
  Directive.
  
  Starts an option.

  Use everytime you want to start new option with new set of condition(s).

  When `$apply` is `TRUE` (or is not set), new option starts. Otherwise whole `when` clause is ignored.

## Actions:

- ### `throwException(throwable $throwable): Slalom`
  Provides an action. 
  
  Throws `$throwable`.

- ### `execute(callable $callable[, mixed $args]): Slalom`
  Provides an action.

  Executes `$callable` (a custom action), possibly with `$args`. First argument passed to `$callable` is always `$configurator`.

- ### `define(string $name, mixed $value): Slalom`

- ### `defineNow(string $name, mixed $value): Slalom`

## Conditions:

- ### `serverNameIs(string $serverName): Slalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) equals `$serverName`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameIsNot(string $serverName): Slalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) does *not* equal `$serverName`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameIsIn(array $serverNameArray): Slalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) is in `$serverNameArray`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameNotIn(array $serverNameArray): Slalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) is *not* in `$serverNameArray`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameMatches(string $serverNamePattern): Slalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) matches `$serverNamePattern`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameNotMatches(string $serverNamePattern): Slalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) does *not* match `$serverNamePattern`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestUriIs(string $requestUri): Slalom`
  Adds condition.

  If current request URI (`$_SERVER['REQUEST_URI']`) is eqal to `$requestUri`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestUriStarts(string $requestUri): Slalom`
  Adds condition.

  If current request URI (`$_SERVER['REQUEST_URI']`) starts with `$requestUri`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestUriContains(string $requestUri): Slalom`
  Adds condition.

  If current request URI (`$_SERVER['REQUEST_URI']`) contains `$requestUri`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestUriNotContains(string $requestUri): Slalom`
  Adds condition.

  If current request URI (`$_SERVER['REQUEST_URI']`) does *not* contain `$requestUri`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestMethodIs(string $requestMethod): Slalom`
  Adds condition.

  If current request method (`$_SERVER['REQUEST_METHOD']`) is eqal to `$requestMethod`,continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestMethodIsNot(string $requestMethod): Slalom`
  Adds condition.

  If current request method (`$_SERVER['REQUEST_METHOD']`) is *not* eqal to `$requestMethod`,continue. Otherwise, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestMethodIsIn(array $requestMethodArray): Slalom`
  Adds condition.

  If current request method (`$_SERVER['REQUEST_METHOD']`) is in `$requestMethodArray`,continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestMethodNotIn(array $requestMethodArray): Slalom`
  Adds condition.

  If current request method (`$_SERVER['REQUEST_METHOD']`) is *not* in `$requestMethodArray`, continue. Otherwise continue to next opinion (nexr `when`, `otherwise` or `finally`).

- ### `isTrue(callable $callable): Slalom`
  Adds condition.

  If result of `$callable`) is boolean true, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

  `$callable` expects 1 parameter: `$configurator`.

- ### `portIs(string $port): Slalom`
  Adds condition.

  If current port (`$_SERVER['SERVER_PORT']`) is equal to `$port`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `portIsNot(string $port): Slalom`
  Adds condition.

  If current port (`$_SERVER['SERVER_PORT']`) is *not* equal to `$port`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `portIsIn(array $portArray): Slalom`
  Adds condition.

  If current port (`$_SERVER['SERVER_PORT']`) is in `$portArray`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `portIsNotIn(array $portArray): Slalom`
  Adds condition.

  If current port (`$_SERVER['SERVER_PORT']`) is *not* in `$portArray`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `protocolIs(string $protocol): Slalom`
  Adds condition.

  If current protocol (`$_SERVER['SERVER_PORT']`) is equal to `$protocol`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `protocolIsNot(string $protocol): Slalom`
  Adds condition.

  If current protocol (`$_SERVER['SERVER_PORT']`) is *not* equal to `$protocol`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `protocolIsIn(array $protocolArray): Slalom`
  Adds condition.

  If current protocol (`$_SERVER['SERVER_PORT']`) is in `$protocolArray`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `protocolIsNotIn(array $protocolArray): Slalom`
  Adds condition.

  If current protocol (`$_SERVER['SERVER_PORT']`) is *not* in `$protocolArray`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `phpVersionIs(integer $phpVersion): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionIsNot(integer $phpVersion): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is *not* `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionIsIn(integer[] $phpVersions): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is in `$phpVersions`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionNotIn(integer[] $phpVersions): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is *not* in `$phpVersions`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionLT(integer $phpVersion): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is *less* than `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionLE(integer $phpVersion): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is *less or equal* to `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionEQ(integer $phpVersion): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is *equal* to `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionNE(integer $phpVersion): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is *not equal* to `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionGE(integer $phpVersion): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is *greater or equal* to `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionGT(integer $phpVersion): Slalom`
  Adds condition.

  If current version of PHP (`PHP_VERSION_ID`) is *greater* than `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpSapiIs(string $sapi): Slalom`
  Adds condition.

  If current Server API for this build of PHP (`PHP_SAPI`) is equal to `$sapi`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `phpSapiIsNot(string $sapi): Slalom`
  Adds condition.

  If current Server API for this build of PHP (`PHP_SAPI`) is *not* equal to `$sapi`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `phpSapiIsIn(string[] $sapi): Slalom`
  Adds condition.

  If current Server API for this build of PHP (`PHP_SAPI`) is in `$sapi`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `phpSapiIsNotIn(string[] $sapi): Slalom`
  Adds condition.

  If current Server API for this build of PHP (`PHP_SAPI`) is *not* in `$sapi`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileExists(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` exists, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileNotExists(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` *not* exists, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileIsReadable(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` is readable, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileIsNotReadable(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` is *not* readable, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileIsFile(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` is file, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileIsNotFile(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` is *not* file, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileIsDir(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` is directory, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileIsNotDir(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` is *not* directory, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileIsLink(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` is link, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `fileIsNotLink(string $fileName): Slalom`
  Adds condition.

  If file `$fileName` is *not* link, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

## Directives:

- ### `andContinue(): Slalom`
  Directive.

  After execution of directives, continue.

- ### `onExceptionContinue([bool $continue = TRUE]): Slalom`
  Directive.

  When an exception is throwed, `Slalom` run continues.

  Doesn't overwrite `onException`.

  When set to `TRUE`, exception thrown by `throwException` is ignored, too.

- ### `onException(callable $callback): Slalom`
  Directive.

  When an exception is throwed, `$callback` is executed.

  When set, automatically sets `onExceptionContinue` to `FALSE`.

  `$callback` is executed with two parameters:
    - `Exception $exception`: thrown exception
    - `mixed $configurator`: `$configurator`

  When set, runs also when an exception is thrown by `throwException` direction.

- ### `otherwise(): Slalom`
  Directive.

  Defines action which will be exuceted when no other action fits conditions.

- ### `skip([bool $skip = TRUE]): Slalom`
  Directive.

  When `$skip` is `TRUE` (or not set), skip this clause and continue.

- ### `run(): mixed`
  Last directive.
  
  Executes whole "slalom"; without this method, nothing will be done.

  Returns `$configurator` passed in `start()` method.

## Possible conflicts:
For PHP versions before "5.2.7-extra" defines constant `PHP_VERSION_ID`. So if you define constant `PHP_VERSION_ID` *after* `ConfigSlalom` include, you can experience a conflict.