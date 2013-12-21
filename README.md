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
	public function actionRead($id)
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

##Instalation
Register in your bootstrap:
`\Flame\Rest\DI\RestExtension::register($configurator);`

###Configuration
```yaml
REST:
	authenticator: 'Flame\Rest\Security\Authenticators\BasicAuthenticator'
	tokens:
		expiration: '+ 30 days'
	cors: false
```



