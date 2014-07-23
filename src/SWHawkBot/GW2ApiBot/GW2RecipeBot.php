<?php
namespace SWHawkBot\GW2ApiBot;

use GuzzleHttp\Client as G4Client;
use Guzzle\Http\Client as G3Client;
use Doctrine\Common\Cache\MemcachedCache;
use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Cache\DoctrineCacheAdapter;

/**
 * Classe du bot communicant avec l'API des recettes
 * d'artisanat de GuildWars2, singleton
 *
 * @author SwHawk
 */
class GW2RecipeBot extends GW2ApiBot
{

    /**
     * Instance du singleton
     *
     * @var GW2RecipeBot
     */
    private static $instance;

    /**
     * Client Guzzle pour obtenir la liste des identifiants
     * des recettes
     *
     * @var G4Client|G3Client
     */
    protected $client_list;

    /**
     * Client Guzzle pour obtenir des informations concernant
     * une recette particulière
     *
     * @var G4Client|G3Client
     */
    protected $client_details;

    /**
     * Liste des identifiants des recettes présentes dans
     * l'API GuildWars2
     *
     * @var array:integer
     */
    protected static $recipes_id;

    /**
     * Endpoint du client de liste des identifiants
     *
     * @var string
     */
    const RECIPE_JSON = "recipes.json";

    /**
     * Endpoint du client d'informations concernant une
     * recette
     *
     * @var string
     */
    const RECIPE_DETAILS_JSON = "recipe_details.json";

    /**
     * Constructeur du singleton
     *
     * @param int $version
     * @param string $lang
     */
    private function __construct($version = parent::DFLT_VERSION, $lang = parent::DFLT_LANG)
    {
        if (is_numeric($version)) {
            $version = "v" . $version;
        }
        $this->version = $version;
        if (! in_array($lang, unserialize(parent::LANGS))) {
            $lang = "fr";
        }
        $this->lang = "fr";

        $url = parent::BASE_URL . $this->version . "/";

        if ($gversion == 3 || $gversion == 4)
        {
            $this->setGuzzleVersion($gversion);
        } else {
            $this->setGuzzleVersion(self::DFLT_GUZZLE_VERSION);
        }

        if ($this->getGuzzleVersion() == 4)
        {
            $this->client_list = new G4Client(array(
                'base_url' => $url . self::RECIPE_JSON
            ));
            $this->client_details = new G4Client(array(
                'base_url' => $url . self::RECIPE_DETAILS_JSON,
                'defaults' => array(
                    'query' => array(
                        'lang' => $this->lang
                    )
                )
            ));
        } elseif ($this->getGuzzleVersion() == 3)
        {
            $memcached = new \Memcached();

            $memcached->addServer('127.0.0.1',11211);

            $cacheBackend = new MemcachedCache();
            $cacheBackend->setMemcached($memcached);

            $cachePlugin = new CachePlugin(new DoctrineCacheAdapter($cacheBackend));


            $this->client_list = new G3Client($url . self::RECIPE_JSON, array(
                'request.options' => array(
                    'plugins' => array(
                        $cachePlugin
                    )
                )
            ));

            $this->client_details = new G3Client($url . self::RECIPE_DETAILS_JSON, array(
                'request.options' => array(
                    'query' => array(
                        'lang' => $this->lang
                    ),
                    'plugins' => array(
                        $cachePlugin
                    )
                )
            ));
        }

        self::$recipes_id = $this->getRecipesIds();
    }

    private function setGuzzleVersion($version)
    {
        $this->guzzleVersion = $version;
    }

    private function getGuzzleVersion()
    {
        return $this->guzzleVersion;
    }

    /**
     * Permet la récupération de la liste des identifiants des recettes
     * de l'API GuildWars2
     *
     * @return array:integer
     */
    public function getRecipesIds()
    {
        if ($this->getGuzzleVersion() == 4)
        {
            return $this->client_list->get()->json()['recipes'];
        } elseif ($this->getGuzzleVersion() == 3)
        {
            return $this->client_list->get()->send()->json()['recipes'];
        }
    }

    /**
     * Détermine si une recette existe dans l'API GuildWars2 grâce
     * à la liste des identifiants
     *
     * @param integer $id
     * @return boolean
     */
    public function isValidRecipeId($id)
    {
        if (! is_numeric($id)) {
            return false;
        }
        return (bool) in_array($id, self::$recipes_id);
    }

    /**
     * Retourne le tableau JSON de la recette renvoyé par l'API
     * GuildWars2
     *
     * @param integer $id
     * @return array|null
     */
    public function getRecipeRaw($id)
    {
        if (! $this->isValidRecipeId($id)) {
            return null;
        }
        if ($this->getGuzzleVersion() == 4)
        {
            $request = $this->client_details->createRequest('GET');
            $request->getQuery()
                ->set('recipe_id', $id);
            return $this->client_details->send($request)->json();
        } elseif ($this->getGuzzleVersion() == 3)
        {
            $request = $this->client_details->get();
            $request->getQuery->set('recipe_id', $id);
            return $request->send()->json();
        }

    }

    /**
     * Retourne l'instance du singleton
     *
     * @param string $version
     * @param string $lang
     * @return \SWHawkBot\GW2ApiBot\GW2RecipeBot
     */
    public static function getInstance($version = null, $lang = null)
    {
        if (true === is_null(self::$instance)) {
            self::$instance = new self($version, $lang);
        }
        return self::$instance;
    }
}

?>

