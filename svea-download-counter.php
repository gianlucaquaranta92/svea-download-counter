<?php
/*
Plugin Name: SVEA Checkout Downloads Counter
Description: Create a widghet in the admin dashboard to show the downloads of the SVEA WP-plugin.
Version: 1.0
Author: Gianluca
*/


// Created a new dashboard widget
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
     $total_downloads = get_transient($transient_key);
   
    // If it is cached
    if ( $total_downloads !== false) {

        // Display cached data
        echo '<p>Total Downloads: ' .  esc_html($total_downloads) . '</p>';
   

    // If not cached
    } else {
        // Fetch plugin stats 
        $plugin_slug = 'svea-checkout-for-woocommerce';  
        $response = wp_remote_get("https://api.wordpress.org/plugins/info/1.1/?action=plugin_information&request[slug]={$plugin_slug}");

        // Check the API response 
        if (is_wp_error($response)) {
            $error_message = $response->get_error_message();
            echo '<p>Something went wrong: ' . esc_html($error_message) . '</p>';
           return;
        }

        //Retrieve the request status code
        $request_code = wp_remote_retrieve_response_code($response);
        if($request_code !== 200){
            echo '<p>Failed to fetch the data: HTTP code response: '. esc_html($request_code) .'</p>';
            return ;
        }

        //  Retrieve the data and decode it in a php format
        $plugin_data = json_decode(wp_remote_retrieve_body($response));
        $total_downloads = $plugin_data->downloaded;
      
     
        // If downloaded has value
        if (isset( $total_downloads)) {
            echo '<p>Total Downloads: ' .  esc_html($total_downloads) . '</p>';
      
            
         // Set a cache for the duration of 1 hour
            set_transient($transient_key,  $total_downloads,  3600); 

        //If not
        } else {
            echo '<p>Something went wrong, could not get the downloaded data.</p>';
        }
    }
}


