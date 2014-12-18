<?php
// Read / Save settings in a cookie
class Settings {
    const COOKIE_ID = "sum-bykr-org";
    const SECONDS_IN_A_YEAR = 31536000;

    private $settings, $expires;

    function __construct() {
        $this->expires = time() + self::SECONDS_IN_A_YEAR;
        $this->settings = $this->load();
        $this->save();
    }

    public function set($key, $value) {
        $this->settings[$key] = $value;
        $this->save();
    }

    public function get($key) {
        if ($this->has($key)) {
            return $this->settings[$key];
        } else {
            return null;
        }
    }

    public function has($key) {
        return !empty($this->settings[$key]);
    }

    private function load() {
        if (!isset($_COOKIE[self::COOKIE_ID])) {
            return [];
        }

        $cookie = $_COOKIE[self::COOKIE_ID];
        return unserialize($cookie);
    }

    private function save() {
        setcookie(
            self::COOKIE_ID,
            serialize($this->settings),
            $this->expires
        );
    }
}