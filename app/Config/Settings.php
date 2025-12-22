<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Settings extends BaseConfig {
    /**
     * @var array Loaded settings from JSON
     */
    protected $settings = [];

    /**
     * Constructor: Load settings from ROOTPATH/config/config.json
     */
    public function __construct() {
        $path = ROOTPATH . 'config/config.json';

        if (file_exists($path)) {
            $json = file_get_contents($path);
            $this->settings = json_decode($json, true) ?? [];
        }
    }

    /**
     * Get a setting value using dot notation (e.g., 'site.title')
     *
     * @param string $key
     * @param mixed $default
     * @return mixed|null
     */
    public function get(string $key, $default = null) {
        $keys = explode('.', $key);
        $value = $this->settings;

        foreach ($keys as $segment) {
            if (!is_array($value) || !array_key_exists($segment, $value)) {
                return $default;
            }
            $value = $value[$segment];
        }

        return $value;
    }

    /**
     * Get all settings as array
     *
     * @return array
     */
    public function all(): array {
        return $this->settings;
    }
}
