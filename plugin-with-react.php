<?php

/**
 * Plugin Name: Plugin With React Js
 * Author: Sifat
 * Description: Plugin with ReactJs
 * Version: 1.0.0
 */

 if( ! defined( 'ABSPATH' ) ) : exit(); endif; // No direct access allowed.

/**
* Define Plugins Contants
*/
define ( 'WPWR_PATH', trailingslashit( plugin_dir_path( __FILE__ ) ) );
define ( 'WPWR_URL', trailingslashit( plugins_url( '/', __FILE__ ) ) );

add_action('admin_enqueue_scripts','load_scripts');
function load_scripts(){
    wp_enqueue_script( 'wp-react-plugin', WPWR_URL . 'dist/bundle.js', [ 'jquery', 'wp-element' ], wp_rand(), true );
    wp_localize_script( 'wp-react-plugin', 'appLocalizer', [
        'apiUrl' => home_url('/wp-json'),
        'nonce' => wp_create_nonce('wp_rest')
    ] );
}

function new_dashboard_setup(){
    wp_add_dashboard_widget( 
        'new_dashboard_widget',
        'New Graph Widget',
        'new_dashboard_widget_callback'
    );
}
add_action('wp_dashboard_setup', 'new_dashboard_setup');

function new_dashboard_widget_callback(){
    echo '<div id="new-dashboard-widget"></div>';
}

function pwr_table_init() {
   global $wpdb;
   $table_name = $wpdb->prefix. 'chartTable';
   $sql = "CREATE TABLE {$table_name} (
      id INT NOT NULL AUTO_INCREMENT,
      'name' VARCHAR(250),
      uv INT,
      pv INT,
      amt INT,
      dateT DATE,
      PRIMARY KEY (id)
   );";

   require_once ABSPATH. "wp-admin/includes/upgrade.php";
   dbDelta( $sql );

   $insert_query = "INSERT into ".$table_name." (name,uv,pv,amt,dateT) VALUES
   ('Page A',4000,2000,2400,'2024-03-21'),
   ('Page B',2000,4000,3000,'2024-03-13'),
   ('Page C',6000,3000,2000,'2024-04-6'),
   ('Page D',1000,2000,5000,'2024-04-1'),
   ('Page E',6000,1000,4000,'2024-03-16')
   ";
   $wpdb->query($insert_query);
}
register_activation_hook( __FILE__, 'pwr_table_init' );

require_once WPWR_PATH . 'classes/create-rest-api.php';

?>