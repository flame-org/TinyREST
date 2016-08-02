# Nette REST library

Smart and tiny implementation of REST API for Nette framework

## Content

1. [Requirements](#requirements)
2. [Installation](#installation)
3. [Configuration](#configuration)
4. [Authentication](#authentication)
5. [Routing and presenters](#routing-and-presenters)
6. [Examples](#examples)
7. [Patrons](#patrons)

## Requirements

For full requirements list pleas see [this file](https://github.com/flame-org/TinyRest/blob/master/composer.json)

* PHP 5.4 or higher
* [Nette Framework](https://nette.org) 2.1 or higher

## Installation

The best way to install flame\tiny-rest is using [Composer](https://getcomposer.org)

```sh
$ composer require flame/tiny-rest:@dev
```

and register extension:

```yaml
extensions:
    rest: Flame\Rest\DI\RestExtension
```

## Configuration

This package provide next options:

* `authenticators` - list of classes implements `Flame\Rest\Security\IAuthenticator` for authentication requests.
* `cors` - List of settings for cross-domain requests
    - `origin` - list of allowed origins, or `*` for all
    - `headers` - list of allowed headers, or `*` for all
    - `methods` - list of allowed methods, or `*` for all
* `ips` - list of allowed IP address, or nothing for allow all
* `referers` - list of allowed referers, or nothing for allow all

Example configuration:
```yaml
tinyRest:
    cors:
        origin: *
        headers: *
        methods: *
    authenticators:
        - My\Super\Authenticator
```

## Authentication

This package provide several authorization method.

1. Authorization by IP address - this authorization is enabled automatically when you set `ips` option in config file.
2. Authorization by HTTP referer - this authorization is enabled automatically when you set `referers` option in config file
3. Authentication by settings for cross-domain requests - this authorization is automatically enabled when you set `cors` option in config file and respects [this](https://developer.mozilla.org/en-US/docs/Web/HTTP/Access_control_CORS) rules

Next authorization methods is token-based authorization. For this authorization type you must do some steps:

1. You can create own authenticator implenets `Flame\Rest\Security\IAuthenticator` <strike>or you can use default authenticator from this package</strike>
2. You must create own token provider class implements `Flame\Rest\Security\Tokens\ITokenProvider`. This class with `getToken()` must get token from request (request is provided as argument) and create and return a new instance of `Flame\Rest\Security\Tokens\IToken` (there you must create own implementation <strike>or you can use default</strike>)
3. You must create own implementation of `Flame\Rest\Security\Tokens\ITokenManager` wḧich provides method for validate token and getting identity for concrete token.

Implementation you can see in [Examples](#examples).

## Routing and presenters


### Routing

This package provide one basic route:

```php
$router = new RouteList();
$router[] = new RestRoute('Api:V1');

return $router;
```

This route has one optional argument with module path for searchnig presenter. In this example expects models with names Api and V1.

Structure of URLs which is created by this router is `/<module>/<presenter>[/<specific_action>][/<id>]`. For our example will be `/api/v1/<presenter>[/<specific_action>][/<id>]`

All this URLs is mapped to actions in presenter by rule `action<create|update|read|readAll|delete><specific_action>(<id>)` when `POST` = `create`, `PUT` = `update`, `DELETE` = `delete`, `GET` **without id** = `readAll` and `GET` **with id** = `read`. For example:

* `GET /api/v1/accounts` -> `actionReadAll()`
* `GET /api/v1/accounts/1` -> `actionRead($id)`
* `GET /api/v1/accounts/disabled/1` -> `actionReadDisabled($id)`

### Presenter

All API presenter should be extended from `RestPresenter`. When you can send data you must it write into `resource`:

```php
public function actionRead($id) {
    $this->resource->id = $id;
    $this->resource->name = 'John';
}
```

or for better works you can use `data` property of `resource`

```php
public function actionRead($id) {
    $this->resource->data = [
        'id' => $id,
        'name' => 'John'
    ];
}
```

Sending responses is automatically on end of action method with HTTP code 200. When you can change it, you must call `sendResource($code)` manually.

```php
public function actionRead($id) {
    $this->resource->data = [
        'id' => $id,
        'name' => 'John'
    ];
    $this->sendResource(500);
}
```

And for processing and logging errors you can use `sendErrorResponse` method.

You can get data from POST, or query by `input` or `getInput()` member. You can get query valus by `getQuery()`, `POST` values by `getData()` or `FILES` by `getFiles()`

```php
public function actionReadAll() {
    $limit = $this->getInput()->getQuery('limit');
    $this->resource->data = [
        'id' => $,
        'name' => 'John'
    ];
    $this->sendResource(500);
}
```

## Examples

Router:

```php
$router = new RouteList();
$router[] = new RestRoute('Api:V1');

return $router;
```

Presenter AccountsPresenter.php

```php
class AccountsPresenter extends RestPresenter
{
    /** User @inject */
    public $user;

    /**
     * @User loggedIn
     */
    public function actionReadAll()
    {
        $this->resource->data = $user->getIdentity();
    }
}
```

Create own Token implementation:

```php
class Token implements IToken 
{
    private $token;

    public function __construct($token)
    {
        $this->token = $token;
    }

    public function getToken()
    {
        return this->token;
    }
}
```

Create a own TokenGetter:

```php
class TokenGetter implements ITokenGetter
{
    public function getToken(Request $request)
    {
        return new Token($request->getHeader('Authorozation'));
    }
}
```

Crate own TokenManager

```php
class TokenManager implements ITokenManager
{
    private $sessionManager;

    public function __construct(SessionManager $sessionManager) 
    {
        $this->sessionManager = $sessionManager;
    }

    public function isTokenValid(IToken $token)
    {
        $item = $this->sessionManager->getSessionByToken($token->getToken());

        return $item['expiration'] < new \DateTime();
    }

    public function getIdentity(IToken $token)
    {
        $item = $this->sessionManager->getSessionByToken($token->getToken());

        return $item['identity'];
    }
}
```

In this example when I send `GET` request on `/api/v1/accounts` with `Authorization: valid` header and use `BasicAuthenticator` for authenticate by `@User` annotation API returns identity of logged user.

##Patrons
**Big thanks to these guys!**
* Ondra Zaruba (aka [@budry](https://github.com/budry))
