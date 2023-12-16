<?php
/*
Plugin Name: CH Simple Filter
Description: Easy to use Plugin for filtering posts with tags and categories
Version: 1.101
Author: Christian Hoppe
License: GPLv3
License URI: https://www.gnu.org/licenses/gpl-3.0.html
*/

// Include Settings
require_once plugin_dir_path(__FILE__) . 'includes/settings.php';

// Include Enqueue Styles
require_once plugin_dir_path(__FILE__) . 'includes/enqueue-styles.php';

// Include Settings Page
require_once plugin_dir_path(__FILE__) . 'includes/settings-page.php';

// Include Shortcodes
require_once plugin_dir_path(__FILE__) . 'includes/shortcodes.php';

// Include Admin Menu
require_once plugin_dir_path(__FILE__) . 'includes/admin-menu.php';
?>
