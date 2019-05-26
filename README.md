# ConfigSlalom
Do configuration magic easily in PHP!

## Installation:
Type

```
composer require spaceboy/config-slalom
```

and that's all.

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
        ->throw(new \Exception('Wrong server host.'))
    ->finally()
        ->execute(
            function ($configurator) {
                // do something
            }
        )
    ->run();
```

## Public methods:

- ### `start([mixed $configurator]): ConfigSlalom`
  First directive.
  
  Starts whole "slalom".

- ### `when(): ConfigSlalom`
  Directive.
  
  Starts an option.

  Use everytime you want to start new option with new set of condition(s).

- ### `serverNameIs(string $serverName): ConfigSlalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) equals `$serverName`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameIsNot(string $serverName): ConfigSlalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) does *not* equal `$serverName`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameIsIn(array $serverNameArray): ConfigSlalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) is in `$serverNameArray`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameNotIn(array $serverNameArray): ConfigSlalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) is *not* in `$serverNameArray`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameMatches(string $serverNamePattern): ConfigSlalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) matches `$serverNamePattern`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `serverNameNotMatches(string $serverNamePattern): ConfigSlalom`
  Adds condition.

  If current server name (`$_SERVER['SERVER_NAME']`) does *not* match `$serverNamePattern`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestUriIs(string $requestUri): ConfigSlalom`
  Adds condition.

  If current request URI (`$_SERVER['REQUEST_URI']`) is eqal to `$requestUri`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestUriStarts(string $requestUri): ConfigSlalom`
  Adds condition.

  If current request URI (`$_SERVER['REQUEST_URI']`) starts with `$requestUri`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestUriContains(string $requestUri): ConfigSlalom`
  Adds condition.

  If current request URI (`$_SERVER['REQUEST_URI']`) contains `$requestUri`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestUriNotContains(string $requestUri): ConfigSlalom`
  Adds condition.

  If current request URI (`$_SERVER['REQUEST_URI']`) does *not* contain `$requestUri`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestMethodIs(string $requestMethod): ConfigSlalom`
  Adds condition.

  If current request method (`$_SERVER['REQUEST_METHOD']`) is eqal to `$requestMethod`,continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestMethodIsNot(string $requestMethod): ConfigSlalom`
  Adds condition.

  If current request method (`$_SERVER['REQUEST_METHOD']`) is *not* eqal to `$requestMethod`,continue. Otherwise, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestMethodIsIn(array $requestMethodArray): ConfigSlalom`
  Adds condition.

  If current request method (`$_SERVER['REQUEST_METHOD']`) is in `$requestMethodArray`,continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `requestMethodNotIn(array $requestMethodArray): ConfigSlalom`
  Adds condition.

  If current request method (`$_SERVER['REQUEST_METHOD']`) is *not* in `$requestMethodArray`, continue. Otherwise continue to next opinion (nexr `when`, `otherwise` or `finally`).

- ### `isTrue(callable $callable): ConfigSlalom`
  Adds condition.

  If result of `$callable`) is boolean true, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

  `$callable` expects 1 parameter: `$configurator`.

- ### `portIs(string $port): ConfigSlalom`
  Adds condition.

  If current port (`$_SERVER['SERVER_PORT']`) is equal to `$port`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `portIsNot(string $port): ConfigSlalom`
  Adds condition.

  If current port (`$_SERVER['SERVER_PORT']`) is *not* equal to `$port`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `portIsIn(array $portArray): ConfigSlalom`
  Adds condition.

  If current port (`$_SERVER['SERVER_PORT']`) is in `$portArray`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `portIsNotIn(array $portArray): ConfigSlalom`
  Adds condition.

  If current port (`$_SERVER['SERVER_PORT']`) is *not* in `$portArray`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `protocolIs(string $protocol): ConfigSlalom`
  Adds condition.

  If current protocol (`$_SERVER['SERVER_PORT']`) is equal to `$protocol`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `protocolIsNot(string $protocol): ConfigSlalom`
  Adds condition.

  If current protocol (`$_SERVER['SERVER_PORT']`) is *not* equal to `$protocol`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `protocolIsIn(array $protocolArray): ConfigSlalom`
  Adds condition.

  If current protocol (`$_SERVER['SERVER_PORT']`) is in `$protocolArray`, continue. If not, continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `protocolIsNotIn(array $protocolArray): ConfigSlalom`
  Adds condition.

  If current protocol (`$_SERVER['SERVER_PORT']`) is *not* in `$protocolArray`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`).

- ### `phpVersionIs(integer $phpVersion): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionIsNot(integer $phpVersion): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is *not* `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionIsIn(integer[] $phpVersions): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is in `$phpVersions`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionNotIn(integer[] $phpVersions): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is *not* in `$phpVersions`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionLT(integer $phpVersion): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is *less* than `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionLE(integer $phpVersion): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is *less or equal* to `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionEQ(integer $phpVersion): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is *equal* to `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionNE(integer $phpVersion): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is *not equal* to `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionGE(integer $phpVersion): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is *greater or equal* to `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `phpVersionGT(integer $phpVersion): ConfigSlalom`
  Adds condition.

  If current protocol version of PHP (`PHP_VERSION_ID`) is *greater* than `$phpVersion`, continue. Otherwise continue to next opinion (next `when`, `otherwise` or `finally`). Argument `$phpVersion` is integer, in `PHP_VERSION_ID` constant format (eg. 50207 for PHP 5.2.7).

- ### `andContinue(): ConfigSlalom`
  Directive.

  After execution of directives, continue.

- ### `throw(throwable $throwable): ConfigSlalom`
  Provides an action. 
  
  Throws `$throwable`.

- ### `otherwise(): ConfigSlalom`
  Directive.

  Defines action which will be exuceted when no other action fits conditions.

- ### `skip([bool $skip = TRUE]): ConfigSlalom`
  Directive.

  When `$skip` is `TRUE`, skip this clause and continue.

- ### `execute(callable $callable[, mixed $args]): ConfigSlalom`
  Provides an action.

  Executes `$callable` (a custom action), possibly with `$args`. First argument passed to `$callable` is always `$configurator`.

- ### `run(): mixed`
  Last directive.
  
  Executes whole "slalom"; without this method, nothing will be done.

  Returns `$configurator` passed in `start()` method.

  ## Possible conflicts:
  For PHP versions before "5.2.7-extra" defines constant `PHP_VERSION_ID`. So if you define constant `PHP_VERSION_ID` *after* `ConfigSlalom` include, you can experience a conflict.