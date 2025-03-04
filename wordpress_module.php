<?php
/**
 * Plugin Name:     [LeadActiv] Etude de cas
 * Plugin URI:      https://www.genesii.fr
 * Description:     Type de post dédié aux études de cas
 * Author:          Genesii
 * Author URI:      https://www.genesii.fr
 * Text Domain:     genesii
 * Domain Path:     /translations
 * Version:         0.0.1
 * Modified by Aicha Hawa War 
 */

$path = plugin_dir_path(__FILE__);

require_once($path . 'vendor/autoload.php');

use Genesii\Kernel\Plugin;

new Plugin($path);