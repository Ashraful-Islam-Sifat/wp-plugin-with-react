<?php 
class React_Rest_Api {

    public function __construct() {
        add_action( 'rest_api_init', [$this, 'create_rest_rountes'] );
    }

    public function create_rest_rountes() {
        register_rest_route( 'wpwr/v2', '/settings/', [
            'methods'=> 'GET',
            'callback' => [$this,'get_settings'],
            'permission_callback' => [$this, 'get_settings_permission']
        ] );

        register_rest_route( 'wpwr/v2', '/last-n-days/(?P<days>\d+)/', [
            'methods'=> 'GET',
            'callback' => [$this,'get_last_n_days_data'],
            'permission_callback' => [$this, 'get_settings_permission']
        ] );    
    }

    public function get_settings() {
        global $wpdb;
		$table_name = $wpdb->prefix . 'wpwr_chart_table';
		$sql        = "SELECT * FROM $table_name";
		$results    = $wpdb->get_results( $wpdb->prepare( $sql ), ARRAY_A );
		return $results;
    }
    
    /**
	 * Check permissions
	 *
	 * @return bool
	 */
    public function get_settings_permission() {
        return true;
    }

    

    /**
    * Get data from database and return array as json.
    *
    * @return array
    */
   public function get_last_n_days_data( $request ) {
       $days = $request['days'];
       return $this->get_data_for_days( $days );
   }

   /**
     * Get data from database and return array as json.
     *
     * @return array
     */
	public function get_data_for_days( $days ) {
		global $wpdb;
		$table_name = $wpdb->prefix . 'wpwr_chart_table';
		$query        = "SELECT * FROM $table_name WHERE dateT >= DATE_SUB( NOW(), INTERVAL $days DAY )";
		$results    = $wpdb->get_results( $wpdb->prepare( $query ), ARRAY_A );
		return $results;
	}

}

new React_Rest_Api();
?>