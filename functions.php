<?php
/**
 * Custom functions for the Abl Plugin.
 * Contains definition of constants, file includes and enqueuing stylesheets and scripts.
 *
 * @package CF7 Mobile Verification
 */

class Contact_Form_7_Mobile_Verification_Public
{
	
	function __construct()
	{
		add_action( 'wp_ajax_cf7mv_ajax_hook', [$this, 'ajax_handler'] );

		add_action( 'wp_ajax_nopriv_cf7mv_ajax_hook', [$this, 'ajax_handler'] );

		add_action( 'wp_enqueue_scripts', [$this, 'public_scripts'] );
		
		add_action( 'admin_enqueue_scripts', [$this, 'admin_scripts'] );
	}

	public function send_otp( $mob_number, $country_code, $otp_pin, $message_template ) {
		$auth_key = get_option( 'cf7mv_auth_key' );
		$otp_length = strlen( $otp_pin );
		$message = str_replace( '{OTP}', $otp_pin, $message_template );
		$sender_id = get_option( 'cf7mv_sender_id' );
		$country_code = str_replace( '+', '', $country_code );
	  	$mob_number = $_POST['data']['mob'] ;
		$message = urlencode( $message );
		
   
		$url = "http://sms.imdigital.co/smsapi?api_key=$auth_key&type=text&contacts=88$mob_number&senderid=$sender_id&msg=$message";
		
		$response = wp_remote_post($url);
 
	 return true;
		 
	}
	public function generate_otp( $mobile_number, $message_template ) {
		$otp_pin = mt_rand( 100000, 500000 );
		$country_code = get_option( 'cf7mv_country_code' );
		$country_code_length = strlen( $country_code );

		// Get the first two characters of the user input.
		 
		$response = $this->send_otp( $mobile_number, $country_code, $otp_pin, $message_template );
		return ( $response ) ? $otp_pin : '';
	}

	function ajax_handler() {
		if ( isset( $_POST['security'] ) ) {
			$nonce_val = esc_html( wp_unslash( $_POST['security'] ) );
		}

		if ( ! wp_verify_nonce( $nonce_val, 'cf7mv_nonce_action_name' ) ) {
			wp_die();
		}
		$mobile_number = $_POST['data']['mob'];
		$mobile_number = ( isset( $mobile_number ) && is_numeric( $mobile_number ) ) ? wp_unslash( $mobile_number ) : '';
		$mobile_number = absint( $mobile_number );
		$message_template = get_option( 'cf7mv_msg_template' );
		$otp_pin = $this->generate_otp( $mobile_number, $message_template );

		wp_send_json_success(
			array(
				'otp_pin_sent_to_js' => $otp_pin,
				'data_recieved_from_js'    => $_POST,
			)
		);
	}

	public function public_scripts()
	{
		wp_enqueue_style( 'cf7mv_styles', plugin_dir_url( __FILE__ ) . 'css/style.css' );

		wp_enqueue_script( 'cf7mv_alert_js', plugin_dir_url( __FILE__ ) .  'js/alert.js', array( 'jquery' ), '', true );

		wp_enqueue_script( 'cf7mv_main_js', plugin_dir_url( __FILE__ ) .  'js/main.js', array( 'jquery' ), '', true );

		wp_localize_script(
			'cf7mv_main_js', 'otp_obj', array(
				'ajax_url'   => admin_url( 'admin-ajax.php' ),
				'ajax_nonce' => wp_create_nonce( 'cf7mv_nonce_action_name' ),
				'form_selector' => get_option( 'cf7mv_form_selector' ),
				'submit_btn_selector' => get_option( 'cf7mv_submit_btn-selector' ),
				'input_required' => get_option( 'cf7mv_mobile_input_required' ),
				'mobile_input_name' => get_option( 'cf7mv_mobile_input_name' ),
			)
		);

	}

	public function admin_scripts($hook)
	{
		if ( 'settings_page_cf7-mobile-verification' != $hook ) {
			return;
		}
		wp_enqueue_style( 'cf7mv_admin_styles', plugin_dir_url( __FILE__ ) .  'css/admin.css' );
		wp_enqueue_script( 'cf7mv_admin_script', plugin_dir_url( __FILE__ ) . 'js/admin.js', array( 'jquery' ), '', true );
	}
	
	
}

new Contact_Form_7_Mobile_Verification_Public();