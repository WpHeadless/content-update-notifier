<?php
/*
Plugin Name: Content update notifier
Plugin URI: https://github.com/tsertkov/content-update-notifier
Description: Call HTTP endpoint on content updates
Author: Aleksandr Tsertkov <tsertkov@gmail.com>
Author URI: https://github.com/tsertkov
License: MIT
*/

defined( 'ABSPATH' ) or die( 'No script kiddies please!' );

require_once plugin_dir_path( __FILE__ ) . 'includes/admin.php';
require_once plugin_dir_path( __FILE__ ) . 'includes/notifier.php';
