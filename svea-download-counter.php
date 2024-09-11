<?php
/*
Plugin Name: SVEA Checkout Downloads Counter
Description: Create a widghet in the admin dashboard to show in real time the downloads of the SVEA WP-plugin.
Version: 1.0
Author: Gianluca
*/


// Dashboard widget
add_action('wp_dashboard_setup', 'svea_add_dashboard_widget');

function svea_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'svea_dashboard_widget',  // Widget slug
        'SVEA Checkout Plugin Downloads',  // Widget title
        'svea_dashboard_widget_display'  // Callback function
    );
}

// Display content inside the widget
function svea_dashboard_widget_display() {


    // Fetch plugin download stats 
    $plugin_slug = 'svea-checkout-for-woocommerce';  
    $response = wp_remote_get("https://api.wordpress.org/plugins/info/1.1/?action=plugin_information&request[slug]={$plugin_slug}");
    
    // Check the API response 
    if (is_wp_error($response)) {
        echo '<p>Something went wrong,could not fetch the data.</p>';
        return;
    }

    $plugin_data = json_decode(wp_remote_retrieve_body($response));

    if (isset($plugin_data->downloaded)) {
   
        echo '<p>Total Downloads: ' . $plugin_data->downloaded . '</p>';
        echo '<p>Last updated: ' . $plugin_data->last_updated . '</p>';
    } else {
        echo '<p>Something went wrong,could not get the downloaded data.</p>';
    }
}