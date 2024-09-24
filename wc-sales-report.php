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

// Hook to capture sales data when an order is completed
add_action('woocommerce_order_status_completed', 'wc_sales_report_save_sales_data');

function wc_sales_report_save_sales_data($order_id)
{
    $order = wc_get_order($order_id);
    $country = $order->get_shipping_country();
    $total_sales = $order->get_total();

    // Insert sales data into custom table
    global $wpdb;
    $table_name = $wpdb->prefix . 'sales_by_country';
    $wpdb->insert($table_name, [
        'country' => $country,
        'total_sales' => $total_sales,
        'date' => current_time('mysql')
    ]);
}

// Add a new menu page to display the sales report in the admin dashboard
add_action('admin_menu', 'wc_sales_report_menu');

function wc_sales_report_menu()
{
    add_menu_page(
        'Sales Report', // Page title
        'Sales Report', // Menu title
        'manage_options',    // Capability required to access
        'wc-sales-report',   // Menu slug
        'wc_sales_report_page' // Callback function to render the page
    );
}

// Callback function to render the sales report page in the dashboard
function wc_sales_report_page()
{
?>
    <div class="wrap">
        <h1>International Sales Report</h1>
        <canvas id="salesChart"></canvas>
    </div>
<?php
}

// Enqueue Chart.js library and generate the sales report chart
add_action('admin_enqueue_scripts', 'wc_sales_report_enqueue_chart_js');

function wc_sales_report_enqueue_chart_js()
{
    wp_enqueue_script('chart-js', 'https://cdn.jsdelivr.net/npm/chart.js', [], null, true);
    wp_add_inline_script('chart-js', wc_sales_report_generate_chart());
}

// Generate sales report chart using Chart.js
function wc_sales_report_generate_chart()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'sales_by_country';
    $results = $wpdb->get_results("SELECT country, SUM(total_sales) as sales FROM $table_name GROUP BY country");

    $countries = [];
    $sales = [];

    foreach ($results as $row) {
        $countries[] = $row->country;
        $sales[] = $row->sales;
    }

    return "
        var ctx = document.getElementById('salesChart').getContext('2d');
        var chart = new Chart(ctx, {
            type: 'bar',
            data: {
                labels: " . json_encode($countries) . ",
                datasets: [{
                    label: 'Sales by Country',
                    data: " . json_encode($sales) . ",
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            }
        });
    ";
}
