#Nette REST library

Smart and tiny implementation of REST API for Nette framework

###Example

```php
<?php
/**
 * Class SessionPresenter
 *
 * @author: Jiří Šifalda <sifalda.jiri@gmail.com>
 * @date: 06.07.13
 */
namespace ApiModule\V1Module;

use Flame\Rest\Application\UI\RestPresenter;

class SessionPresenter extends RestPresenter
{

	public function actionRead()
	{
		$this->resource->now = new \DateTime();
	}

}
```

**OUTPUT** is:
`{"now":"2013-07-07T10:35:04+02:00","status":"success","code":200}`

**Great working with extension [adamstipak/nette-rest-route](https://github.com/newPOPE/Nette-RestRoute)**

###Router setup

```php
/**
 * Router factory.
 */
class RouterFactory
{

	/**
	 * @return \Nette\Application\IRouter
	 */
	public function createRouter()
	{
		$router = new RouteList();
		# $router[] = new Route('template/[<path .+>]', 'Template:default');
		$router[] = new \AdamStipak\RestRoute('Api:V1');
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}
}

```

##Instalation
Register in your bootstrap:
`\Flame\Rest\DI\RestExtension::install($configurator);`

###Configuration
```yaml
REST:
	time: 
		validator: Flame\Rest\Validators\DateTimeConverter
		format: c
	validators: []
```



