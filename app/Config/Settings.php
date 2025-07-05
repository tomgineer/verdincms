<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Settings extends BaseConfig {
    // Declare an associative array to store settings
    protected $settings = [];

    function __construct() {
        $db = \Config\Database::connect();
        $q  = "SELECT setting, value FROM settings";
        $query   = $db->query($q);
        $results = $query->getResultArray();

        foreach ($results as $item) {
            // Store setting-value pairs in the $settings array
            $this->settings[$item['setting']] = $item['value'];
        }
    }

    // Getter method to retrieve settings
    public function getSetting($name) {
        // Check if the setting exists in the array
        return isset($this->settings[$name]) ? $this->settings[$name] : null;
    }
}
