# WooCommerce Sales Report Plugin 📊

## Description 📝

WooCommerce Sales Report is a custom WordPress plugin that generates an **international sales report** and visualizes sales data by country using a bar chart. This plugin integrates directly with WooCommerce and provides an easy-to-read graphical representation of sales data within the WordPress admin dashboard.

- **🌍 Track sales by country**: Automatically logs sales data whenever an order is completed in WooCommerce.
- **📈 Visualize sales performance**: View your sales performance by country in an interactive chart using **Chart.js**.

## Features ✨

- ✅ Automatically logs sales by country.
- 📊 Displays a bar chart of sales data directly in the WordPress dashboard.
- 💻 No need for external CSV or PDF downloads; everything is displayed within the dashboard.
- ⚡ Easy to integrate and lightweight.

## Installation 🚀

### Step 1: Requirements ✅

- WordPress 5.0 or higher
- WooCommerce 3.0 or higher
- PHP 7.0 or higher

### Step 2: Installing the Plugin ⚙️

1. Download the plugin's zip file or clone the repository from GitHub.
2. Upload the plugin folder to the `/wp-content/plugins/` directory.
3. Activate the plugin through the **Plugins** menu in WordPress.
4. Ensure you have WooCommerce activated for the plugin to function correctly.

### Step 3: Testing on a Fresh WooCommerce Installation 🧪

1. **Go to WooCommerce > Orders** and complete a few test orders.
2. **Navigate to Sales Report** under the WordPress admin menu to view the international sales chart.
3. You should now see a bar chart displaying the sales data by country.

## Usage 💡

- 🛒 The plugin automatically logs sales as soon as an order is marked as "completed."
- 📊 View the sales report by navigating to **Sales Report** in the WordPress admin menu.
- 🔄 The chart updates dynamically as new orders are completed.

## Screenshot of Sales Report 📸

![Sales Report Graph](https://clickiu.com/images/sales_report_plugin.png)

<!-- Add the image once you have the chart ready -->

## How it Works ⚙️

- The plugin hooks into WooCommerce’s `woocommerce_order_status_completed` action to log the country and total sales for each completed order.
- Data is stored in a custom database table that the plugin creates on activation.
- The data is then displayed in the WordPress dashboard using **Chart.js**, showing sales by country in a visually appealing bar chart.

## Uninstallation 🗑️

If you deactivate the plugin, it will clean up all data stored in the custom table to ensure no unnecessary data remains in the database.

## License 📄

This plugin is licensed under the **GPLv3 or later**.
