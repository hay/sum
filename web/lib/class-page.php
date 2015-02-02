<?php
use \Httpful\Request;

class Page {
    public $root, $lang, $title, $fullurl, $errorCode, $langlabel, $langcodes;
    private $settings;

    function __construct() {
        $this->root = ROOT;
        $this->version = VERSION;
        $this->settings = new Settings();
        $this->title = "The Sum of All Knowledge";
        $this->fullurl = $this->root;
        $this->langcodes = $this->getLangCodes();
        $this->langcodesPrimary = [];

        foreach (Config::$primaryLanguages as $code) {
            $this->langcodesPrimary[$code] = $this->langcodes[$code];
        }

        $this->lang = $this->getLanguage();
        $this->langlabel = $this->langcodes[$this->lang];
    }

    public function setErrorCode($code) {
        $this->errorCode = $code;
    }

    private function getLangCodes() {
        $json = file_get_contents(ABSPATH . '/data/langcodes.json');
        $langs = json_decode($json);
        $langcodes = [];

        foreach($langs as $code => $lang) {
            $parts = explode("(", $lang);
            $langcodes[$code] = trim($parts[0]);
        }

        return $langcodes;
    }

    private function getLanguage() {
        if (!empty($_GET['lang'])) {
            $lang = strtolower($_GET['lang']);

            if (array_key_exists($lang, $this->langcodes)) {
                $this->settings->set("lang", $lang);
                return $lang;
            }
        }

        if ($this->settings->has("lang")) {
            return $this->settings->get("lang");
        } else {
            $this->settings->set("lang", DEFAULT_LANGUAGE);
            return DEFAULT_LANGUAGE;
        }
    }
}