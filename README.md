#Nette REST library

Smart and tiny implementation of REST API for Nette framework

###Example

```php
<?php
use Flame\Rest\Application\UI\RestPresenter;
use Symb\LyricsModule\Entity\Lyrics;

class LyricsPresenter extends RestPresenter
{

	/**
	 * @inject
	 * @var \Symb\LyricsModule\Rest\CrudManager
	 */
	public $crudManager;

	/**
	 * @inject
	 * @var \Symb\LyricsModule\Model\RestLyricsModel
	 */
	public $lyricsModel;

	# for POST method
	# request: example.com/api/v1/lyrics
	public function actionCreate()
	{
		try {
			$postData = $this->input->getData();
			$this->resource->lyrics = $this->crudManager->create($postData);

			# shortcut for the same
			# $this->resource->lyrics = $this->crudManager->create($this->input->data);
		}catch (\Exception $ex) {
			$this->sendErrorResource($ex);
		}
	}

	# for GET method
	# request: example.com/api/v1/lyrics/<id>
	public function actionRead($id = null)
	{
		try {

			$this->resource->lyrics = $this->lyricsModel->findOneById($id);
		}catch (\Exception $ex) {
			$this->sendErrorResource($ex);
		}
	}

	# for GET method without @id
	# request: example.com/api/v1/lyrics
	public function actionReadAll()
	{
		try {
			$lyrics = $this->lyricsModel->findAll($this->input->getQuery('limit', 10), $this->input->getQuery('limit', 0));
			$this->resource->lyrics = $lyrics;
		}catch (\Exception $ex) {
			$this->sendErrorResource($ex);
		}
	}

	# for GET method
	# request: example.com/api/v1/lyrics/count
    public function actionReadCount()
    {
        try {
            $this->resource->count = count($this->lyricsModel->findAll());
        }catch (\Exception $ex) {
            $this->sendErrorResource($ex);
        }
    }

    # for POST method
    # request: example.com/api/v1/lyrics/lyrics-without-author
    public function actionCreateLyricsWithoutAuthor()
    {
        try {
            $this->resource->lyrics = $this->crudManager->create($this->input->data);
        }catch (\Exception $ex) {
            $this->sendErrorResource($ex);
        }
    }
}
```

**With custom REST Route: Flame\Rest\Application\Routers\RestRoute**

Learn more about associations (and more...) [from inspired Route](https://github.com/newPOPE/Nette-RestRoute#associations)

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
		$router[] = new \Flame\Rest\Application\Routers\RestRoute('Api:V1');
		$router[] = new Route('<presenter>/<action>[/<id>]', 'Homepage:default');
		return $router;
	}
}

```

## Authorization

TinyRest contains four basic authenticators:

1. BasicAuthenticator - Works with `Authorization` HTTP header and exptects value in `Basic XXXX` format. This authenticator is a good way for token authorization
2. SessionAuthenticator - Works with regular PHP sessions and with `Nette\Security\User` object.
3. RefererAuthenticator - works with HTTP referer. Check if is referef of actual request is enabled in `referers` section in config file.
4. IpAuthorizatir - Works with IP adress of request. Check if is IP of actual request is enabled in `ips` section in config file.

### Basic Authenticator

For usage Basic authenticator you must create own implementation of `IUserRepository`. This method get user identity by token hash. For example:

```php
class UserRepository implements IUserRepository
{
    /** @var array */
    private $identity = null;

    /**
     * @param string $hash
     * @return IUser
     */
    public function findUserByHash($hash)
    {
        $this->identity = $this->db->query("SELECT users.name, users.email FROM loggedUsers WHERE hash = ? LEFT JOIN users ON loggedUsers.userId = users.id", $hash)->fetchOne();
    }

    /**
     * @return mixed
     */
    public function getIdentity()
    {
        return $this->identity;
    }
}
```

Now you can use `@User` annotation with `loggedIn` option in your REST presenter for authorized requests.

```php
class MyPresenter extends RestPresenter
{
    /**
     * @User loggedIn
     */
    public function actionRead($id)
    {
        /** ..... */
    }
}
```

##Instalation
Register in your bootstrap:
`\Flame\Rest\DI\RestExtension::register($configurator);`

or in newer Nette versions in config file:
```yaml
extensions:
	- \Flame\Rest\DI\RestExtension
```

###Configuration
```yaml
rest:
	systemSalt: deepSalt34
	authenticators: []
	cors: []
	ips: []
	referers: []
```

##Patrons
**Big thanks to these guys!**
* Ondra Zaruba (aka [@budry](https://github.com/budry))
