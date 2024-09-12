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

function svea_dashboard_widget_display() {
   // Check if the data is cached
    $transient_key = 'svea_download_count';
    $plugin_data = get_transient($transient_key);
   
    // If it is cached
    if ($plugin_data !== false) {

        // Display cached data
        echo '<p>Total Downloads: ' . $plugin_data->downloaded . '</p>';
        echo '<p>Last updated: ' . $plugin_data->last_updated . '</p>';

    // If not cached
    } else {
        // Fetch plugin stats 
        $plugin_slug = 'svea-checkout-for-woocommerce';  
        $response = wp_remote_get("https://api.wordpress.org/plugins/info/1.1/?action=plugin_information&request[slug]={$plugin_slug}");

        // Check the API response 
        if (is_wp_error($response)) {
            echo '<p>Something went wrong, could not fetch the data.</p>';
            return;
        }

        //  Retrieve the data and decode it in a php format
        $plugin_data = json_decode(wp_remote_retrieve_body($response));
     
        // If downloaded has value
        if (isset($plugin_data->downloaded)) {
            echo '<p>Total Downloads: ' . $plugin_data->downloaded . '</p>';
            echo '<p>Last updated: ' . $plugin_data->last_updated . '</p>';
            
         // Set a cache for the duration of 24h based on the time of update of the API(once a day)
            set_transient($transient_key, $plugin_data, DAY_IN_SECONDS); 

        //If not
        } else {
            echo '<p>Something went wrong, could not get the downloaded data.</p>';
        }
    }
}


