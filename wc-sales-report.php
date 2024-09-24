<?php

/**
 * Plugin Name: WooCommerce Sales Report
 * Description: Plugin that displays an international sales report on the WordPress dashboard.
 * Version: 1.0
 * Author: Abel Pomares A
 * License: GPLv3 or later
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit; // Terminate if accessed outside of WordPress
}

// Create custom table to store sales by country when the plugin is activated
register_activation_hook(__FILE__, 'wc_sales_report_create_table');

function wc_sales_report_create_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'sales_by_country';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE IF NOT EXISTS $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        country varchar(100) NOT NULL,
        total_sales decimal(10,2) NOT NULL,
        date datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}
