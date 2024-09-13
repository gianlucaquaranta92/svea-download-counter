=== SVEA Checkout Download Counter Plugin ===

This WordPress plugin displays the total number of downloads for the SVEA Checkout plugin in a dashboard widget.

== Installation ==

1. You can install the plugin either via the WordPress admin panel using your web browser or manually by uploading it through FTP.
2. Activate the plugin through the **Plugins** menu in WordPress.

== Usage ==

Once activated, a widget will appear in the WordPress admin dashboard showing the total number of downloads for the SVEA Checkout plugin. 
The widget updates automatically and caches data for one hour.

== Code explanation ==

- Fetching data: I used the WordPress.org API to retrieve info about the SVEA checkout plugin.
- Error Handling: The code includes checks for API response errors. If there is an issue with the API request (like connection failure or API error), an error message is displayed.
- Display data: The data is displayed in a custom dashboard widget using 'wp_add_dashboard_widget()'.
- Caching: The data is cached for one hour using the 'set_transient()' function to minimize API calls so to not decrease the performance of the website.
- Security: The output is escaped using esc_html() to protect against potential security risks like cross-site scripting attacks, ensuring the displayed content is safe.

=== Time Spent ===

I spent approximately 4/5 hours on this task.

The time includes:
- Development
- Testing  
- Documentation

