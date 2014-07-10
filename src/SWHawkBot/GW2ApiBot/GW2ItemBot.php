<?php
namespace SWHawkBot\GW2ApiBot;

use GuzzleHttp\Client;
use SWHawkBot\Factories\ItemFactory;

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
     * @var \GuzzleHttp\Client
     */
    protected $client_list;

    /**
     * Client Guzzle pour obtenir les informations sur un objet
     *
     * @var \GuzzleHttp\Client
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

    private function __construct($version = parent::DFLT_VERSION, $lang = parent::DFLT_LANG)
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

        $this->client_list = new Client(array(
            'base_url' => $url . self::ITEMS_JSON
        ));

        $this->client_details = new Client(array(
            'base_url' => $url . self::ITEM_DETAILS_JSON
        ));

        self::$item_ids = $this->getItemIds();
    }

    /**
     * Permet la récupération de la liste des identifiants des objets
     * de l'API GuildWars2
     *
     * @return int[]
     */
    public function getItemIds()
    {
        return $this->client_list->get()->json()['items'];
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
        $request = $this->client_details->createRequest('GET');
        $request->getQuery()
            ->set('item_id', $id)
            ->set('lang', $this->lang);
        return $this->client_details->send($request)->json();
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
    public static function getItemBotInstance($version, $lang)
    {
        if (true === is_null(self::$instance)) {
            self::$instance = new self($version, $lang);
        }
        return self::$instance;
    }
}

?>
