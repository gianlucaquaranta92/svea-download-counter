<?php
/*
Plugin Name: SVEA Checkout Downloads Counter
Description: Create a notice in the admin panel to show in real time the downloads of the SVEA WP-plugin.
Version: 1.0
Author: Gianluca
*/


// Hook to set up the dashboard widget
add_action('wp_dashboard_setup', 'svea_add_dashboard_widget');

function svea_add_dashboard_widget() {
    wp_add_dashboard_widget(
        'svea_dashboard_widget',  // Widget slug
        'SVEA Checkout Plugin Downloads',  // Widget title
        'svea_dashboard_widget_display'  // Callback function
    );
}

// Function to display content in the widget
function svea_dashboard_widget_display() {
echo 'hi im a widget in the dashboard';
}