<?php

namespace SWHawkBot\GW2ApiBot;

use GuzzleHttp\Client;

/**
 * Classe du bot communicant avec l'API des recettes
 * d'artisanat de GuildWars2
 * 
 * @author SwHawk
 */
class GW2RecipeBot extends GW2ApiBot {

    /**
     * Client Guzzle pour obtenir la liste des identifiants
     * des recettes
     * 
     * @var \GuzzleHttp\Client
     */
    protected $client_list;
    
    /**
     * Client Guzzle pour obtenir des informations concernant
     * une recette particulière
     * 
     * @var \GuzzleHttp\Client
     */
    protected $client_details;
    
    /**
     * Liste des identifiants des recettes présentes dans
     * l'API GuildWars2
     * 
     * @var array:integer
     */
    protected $recipes_id;

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

    public function __construct($version = parent::DFLT_VERSION, $lang = parent::DFLT_LANG) {
        if(is_numeric($version)) {
            $version = "v".$version;
        }
        $this->version = $version;
        if(!in_array($lang,unserialize(parent::LANGS))) {
            $lang = "fr";
        }
        $this->lang= "fr";

        $url = parent::BASE_URL . $this->version . "/";

        $this->client_list = new Client(array('base_url' => $url.self::RECIPE_JSON));
        $this->client_details = new Client(array('base_url' => $url.self::RECIPE_DETAILS_JSON));

        $this->recipes_id = $this->getRecipesIds();
    }

    /**
     * Permet la récupération de la liste des identifiants des recettes
     * de l'API GuildWars2
     * 
     * @return array:integer
     */
    public function getRecipesIds() {
        return $this->client_list->get()->json()['recipes'];
    }

    /**
     * Détermine si une recette existe dans l'API GuildWars2 grâce
     * à la liste des identifiants
     * 
     * @param integer $id
     * @return boolean
     */
    protected function isValidRecipeId($id) {
        if(!is_numeric($id)) {
            return false;
        }
        return (bool) in_array($id,$this->recipes_id);
    }
    
    /**
     * Retourne le tableau JSON de la recette renvoyé par l'API
     * GuildWars2
     *
     * @param integer $id
     * @return array|null
     */
    public function getRecipeRaw($id) {
		if(!$this->isValidRecipeId($id)) {
			return null;
		}
		$request = $this->client_details->createRequest('GET');
        $request->getQuery()->set('recipe_id',$id)->set('lang',$this->lang);
        return $this->client_details->send($request)->json();
    }
	
}

?>

