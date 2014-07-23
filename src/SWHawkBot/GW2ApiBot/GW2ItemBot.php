<?php
namespace SWHawkBot\GW2ApiBot;

use GuzzleHttp\Client as G4Client;
use Guzzle\Http\Client as G3Client;
use SWHawkBot\Factories\ItemFactory;
use Doctrine\Common\Cache\MemcachedCache;
use Guzzle\Plugin\Cache\CachePlugin;
use Guzzle\Cache\DoctrineCacheAdapter;

/**
 * Classe du bot communicant avec l'API des objets de GuildWars2,
 * réalisée selon le design pattern Singleton.
 *
 * @author SwHawk
 */
class GW2ItemBot extends GW2ApiBot
{

    /**
     * Instance du singleton
     *
     * @var GW2ItemBot
     */
    private static $instance;

    /**
     * Client Guzzle pour obtenir la liste des identifiants d'objets
     *
     * @var G4Client|G3Client
     */
    protected $client_list;

    /**
     * Client Guzzle pour obtenir les informations sur un objet
     *
     * @var G4Client|G3Client
     */
    protected $client_details;

    /**
     * Liste des identifiants des objets de l'API GuildWars2
     *
     * @var int[]
     */
    protected static $item_ids;

    /**
     * Endpoint du client de la liste des objets
     *
     * @var string
     */
    const ITEMS_JSON = "items.json";

    /**
     * Endpoint du client d'informations concernant
     * un objet
     *
     * @var string
     */
    const ITEM_DETAILS_JSON = "item_details.json";

    private function __construct($version = parent::DFLT_VERSION, $lang = parent::DFLT_LANG, $gversion = parent::DFLT_GUZZLE_VERSION)
    {
        if (is_numeric($version)) {
            $version = "v" . $version;
        }
        $this->version = $version;
        if (! in_array($lang, unserialize(parent::LANGS))) {
            $lang = "fr";
        }
        $this->lang = $lang;

        $url = parent::BASE_URL . $this->version . "/";

        if ($gversion = 3 || $gversion = 4)
        {
            $this->setGuzzleVersion($gversion);
        } else {
            $this->setGuzzleVersion(self::DFLT_GUZZLE_VERSION);
        }

        if ($this->getGuzzleVersion() = 4)
        {
            $this->client_list = new G4Client(array(
                'base_url' => $url . self::ITEMS_JSON
            ));

            $this->client_details = new G4Client(array(
                'base_url' => $url . self::ITEM_DETAILS_JSON,
                'defaults' => array(
                    'query' => array(
                        'lang' => $this->lang
                    )
                )
            ));
        } else {

            $memcached = new \Memcached();

            $memcached->addServer('127.0.0.1',11211);

            $cacheBackend = new MemcachedCache();
            $cacheBackend->setMemcached($memcached);

            $cachePlugin = new CachePlugin(new DoctrineCacheAdapter($cacheBackend));


            $this->client_list = new G3Client($url . self::ITEMS_JSON, array(
                'request.options' => array(
                    'plugins' => array(
                        $cachePlugin
                    )
                )
            ));

            $this->client_details = new G3Client($url . self::ITEMS_JSON, array(
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

        self::$item_ids = $this->getItemIds();
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
     * Permet la récupération de la liste des identifiants des objets
     * de l'API GuildWars2
     *
     * @return int[]
     */
    public function getItemIds()
    {
        if ($this->getGuzzleVersion() = 4)
        {
            return $this->client_list->get()->json()['items'];
        } elseif ($this->getGuzzleVersion() = 3)
        {
            return $this->client_list->get()->send()->json()['items'];
        }
    }

    /**
     * Détermine si un objet existe dans l'API GuildWars2 grâce
     * à la liste des identifiants
     *
     * @param integer $id
     * @return boolean
     */
    public function isValidItemId($id)
    {
        if (! is_numeric($id)) {
            return false;
        }

        return (bool) in_array($id, self::$item_ids);
    }

    /**
     * Retourne le tableau JSON de l'objet renvoyé par l'API
     * GuildWars2
     *
     * @param integer $id
     * @return array|null
     */
    public function getItemRaw($id)
    {
        if (! $this->isValidItemId($id)) {
            echo "L'id spécifié (" . $id . ") n'est pas dans la liste des items.\n";
            return null;
        }
        if ($this->getGuzzleVersion() = 4)
        {
            $request = $this->client_details->createRequest('GET');
            $request->getQuery()
                ->set('item_id', $id);
            return $this->client_details->send($request)->json();
        } elseif ($this->getGuzzleVersion() = 3)
        {
            $request = $this->client_details->get();
            $request->getQuery()->set('item_id', $id);
            return $request->send()->json();
        }
    }

    /**
     * @TODO Fonction retournant une instance de l'objet recherché
     * grâce à la classe ItemFactory
     */
    public function getItem($id)
    {

    }

    /**
     * Retourne l'instance du singleton
     *
     * @param string $version
     * @param string $lang
     * @return GW2ItemBot
     */
    public static function getItemBotInstance($version = self::DFLT_VERSION, $lang = self::DFLT_LANG, $gversion = self::DFLT_GUZZLE_VERSION)
    {
        if (true === is_null(self::$instance)) {
            self::$instance = new self($version, $lang, $gversion);
        }
        return self::$instance;
    }
}

?>
