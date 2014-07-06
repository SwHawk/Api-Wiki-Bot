<?php

namespace SWHawkBot\GW2ApiBot;

/**
 * Classe abstraite contenant les constantes auxquelles
 * accèdent les bots communicant avec l'API GuildWars2
 * 
 * @author SwHawk
 */
abstract class GW2ApiBot {

    protected $version;
    protected $lang;

    const BASE_URL = "https://api.guildwars2.com/";
    const LANGS = "a:4:{i:0;s:2:\"de\";i:1;s:2:\"en\";i:2;s:2:\"es\";i:3;s:2:\"fr\";}";
    const DFLT_VERSION = "v1";
    const DFLT_LANG = "fr";

}

?>
