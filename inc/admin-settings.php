<?php
/**
 * Custom functions for creating admin menu settings for the plugin.
 *
 * @package CF7 Mobile Verification
 */
/**
 * 
 */
class Contact_Form_7_Mobile_Verification_Admin
{
	
	function __construct()
	{
		add_action( 'admin_menu', [$this, 'create_submenu_page'] );

		add_action( 'admin_init', [$this, 'register_plugin_settings'] );

		
	}
	public function create_submenu_page()
	{
		add_submenu_page( 'options-general.php','CF7 Mobile Verification', 'CF7 Mobile Verification', 'administrator', 'cf7-mobile-verification', [$this, 'settings_page']);
	}
	public function register_plugin_settings()
	{
		$cf7mvSettings = [
			'cf7mv_auth_key',
			'cf7mv_sender_id',
			'cf7mv_country_code',
			'cf7mv_form_selector',
			'cf7mv_submit_btn-selector',
			'cf7mv_msg_template',
			'cf7mv_mobile_input_name',
		];
		foreach ($cf7mvSettings as $settings) {
			 register_setting( 'cf7mv-plugin-settings-group', $settings );
		}
	}
	
	public function settings_page() {
		?>
	<div class="wrap">
		<h1>
			CF7 Mobile Verification
		</h1>

		<ul class="nav nav-tabs">
			<li class="active">
				<a href="#tab-1">SMS Setup</a>
			</li>

			<li>
				<a href="#tab-2">Contact Form 7 Settings</a>
			</li>
		</ul>

		<form action="options.php" method="post">
			<?php settings_fields( 'cf7mv-plugin-settings-group' ); ?><?php do_settings_sections( 'cf7mv-plugin-settings-group' ); ?>
			<div class="tab-content">
				<div class="tab-pane active" id="tab-1">
					<h3>SMS Setup</h3>
					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="cf7mv_country_code">Country Code <span class="cf7mv-red">*</span></label>
							</th>
							<td>
								<input class="regular-text" name="cf7mv_country_code" type="text" value="<?php echo esc_attr( get_option( 'cf7mv_country_code' ) ); ?>">
							</td>
						</tr>

						<tr>
							<th scope="row">
								<label for="cf7mv_auth_key">API Auth Key<span class="cf7mv-red">*</span></label>
							</th>
							<td>
								<input class="regular-text" name="cf7mv_auth_key" type="text" value="<?php echo esc_attr( get_option( 'cf7mv_auth_key' ) ); ?>">
							</td>
						</tr>

						<tr>
							<th scope="row">
								<label for="cf7mv_sender_id">Sender Number<span class="cf7mv-red">*</span></label>
							</th>
							<td>
								<input class="regular-text" name="cf7mv_sender_id" type="text" value="<?php echo esc_attr( get_option( 'cf7mv_sender_id' ) ); ?>">
							</td>
						</tr>

						<tr>
							<th scope="row">
								Message Template<span class="cf7mv-red">*</span>
							</th>
							<td>
								<textarea class="large-text code" cols="60" name="cf7mv_msg_template" rows="3"><?php echo esc_attr( get_option( 'cf7mv_msg_template' ) ); ?></textarea>
								<p class="description" id="cf7mv_msg_template">
									EX: Your One Time Password is {OTP}. This OTP is valid for today and please don't share this OTP with anyone for security
								</p>
							</td>
						</tr>
					</table>
				</div>

				<div class="tab-pane" id="tab-2">
					<h3>
						Contact Form 7 Settings
					</h3>

					<table class="form-table">
						<tr>
							<th scope="row">
								<label for="cf7mv_form_selector">Contact Form Selector <span class="cf7mv-red">*</span></label>
							</th>
							<td>
								<input class="regular-text" name="cf7mv_form_selector" type="text" value="<?php echo esc_attr( get_option( 'cf7mv_form_selector' ) ); ?>">
								<p class="description">
									prefix . for Class name and # for ID
								</p>
							</td>
						</tr>

						<tr>
							<th scope="row">
							<label for="cf7mv_submit_btn">Submit Btn Selector<span class="cf7mv-red">*</span></label>
							</th>
							<td>
								<input name="cf7mv_submit_btn-selector" type="text" class="regular-text" value="<?php echo esc_attr( get_option( 'cf7mv_submit_btn-selector' ) ); ?>">
								<p class="description">( prefix . for Class name and # for ID )</p>
							</td>
						</tr>

						
						<tr id="cf7mv_mobile_input_name">
							<th scope="row">
								<label for="cf7mv_mobile_input_name">PreExisting Mobile Input Field Name: <span class="cf7mv-red">*</span></label>
							</th>
							<td>
								<input class="cf7mv_mob_input_name regular-text" name="cf7mv_mobile_input_name" type="text" value="<?php echo esc_attr( get_option( 'cf7mv_mobile_input_name' ) ); ?>">
							</td>
						</tr>
					</table>
				</div>

			</div>
				<?php submit_button(); ?>
		</form>
	</div>
		<?php
	}
}
 new Contact_Form_7_Mobile_Verification_Admin();