<?php

defined( 'ABSPATH' ) || die();

// Include the Gravity Forms Payment Add-On Framework.
GFForms::include_payment_addon_framework();

/**
 * Gravity Forms Gravity Forms PayPal Commerce Platform Add-On.
 *
 * @since     1.0
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2019, Rocketgenius
 */
class GF_PPCP extends GFPaymentAddOn {

	/**
	 * Contains an instance of this class, if available.
	 *
	 * @since  1.0
	 * @var    GF_PPCP $_instance If available, contains an instance of this class
	 */
	private static $_instance = null;

	/**
	 * Defines the version of the Gravity Forms PayPal Commerce Platform Add-On.
	 *
	 * @since  1.0
	 * @var    string $_version Contains the version.
	 */
	protected $_version = GF_PPCP_VERSION;

	/**
	 * Defines the minimum Gravity Forms version required.
	 *
	 * @since  1.0
	 * @var    string $_min_gravityforms_version The minimum version required.
	 */
	protected $_min_gravityforms_version = GF_PPCP_MIN_GF_VERSION;

	/**
	 * Defines the plugin slug.
	 *
	 * @since  1.0
	 * @var    string $_slug The slug used for this plugin.
	 */
	protected $_slug = 'gravityformsppcp';

	/**
	 * Defines the main plugin file.
	 *
	 * @since  1.0
	 * @var    string $_path The path to the main plugin file, relative to the plugins folder.
	 */
	protected $_path = 'gravityformsppcp/ppcp.php';

	/**
	 * Defines the full path to this class file.
	 *
	 * @since  1.0
	 * @var    string $_full_path The full path.
	 */
	protected $_full_path = __FILE__;

	/**
	 * Defines the URL where this add-on can be found.
	 *
	 * @since  1.0
	 * @var    string The URL of the Add-On.
	 */
	protected $_url = 'http://gravityforms.com';

	/**
	 * Defines the title of this add-on.
	 *
	 * @since  1.0
	 * @var    string $_title The title of the add-on.
	 */
	protected $_title = 'Gravity Forms PayPal Commerce Platform Add-On';

	/**
	 * Defines the short title of the add-on.
	 *
	 * @since  1.0
	 * @var    string $_short_title The short title.
	 */
	protected $_short_title = 'PayPal Commerce Platform';

	/**
	 * Defines if Add-On should use Gravity Forms servers for update data.
	 *
	 * @since  1.0
	 * @access protected
	 * @var    bool
	 */
	protected $_enable_rg_autoupgrade = true;

	/**
	 * Defines if callbacks/webhooks/IPN will be enabled and the appropriate database table will be created.
	 *
	 * @since  1.0
	 * @access protected
	 *
	 * @var bool $_supports_callbacks true
	 */
	protected $_supports_callbacks = true;

	/**
	 * If true, feeds w/ conditional logic will evaluated on the frontend and a JS event will be triggered when the feed
	 * is applicable and inapplicable.
	 *
	 * @since 1.0
	 * @access protected
	 *
	 * @var bool
	 */
	protected $_supports_frontend_feeds = true;

	/**
	 * Defines the capabilities needed for the Gravity Forms PayPal Commerce Platform Add-On
	 *
	 * @since  1.0
	 * @access protected
	 * @var    array $_capabilities The capabilities needed for the Add-On
	 */
	protected $_capabilities = array( 'gravityforms_ppcp', 'gravityforms_ppcp_uninstall' );

	/**
	 * Defines the capability needed to access the Add-On settings page.
	 *
	 * @since  1.0
	 * @access protected
	 * @var    string $_capabilities_settings_page The capability needed to access the Add-On settings page.
	 */
	protected $_capabilities_settings_page = 'gravityforms_ppcp';

	/**
	 * Defines the capability needed to access the Add-On form settings page.
	 *
	 * @since  1.0
	 * @access protected
	 * @var    string $_capabilities_form_settings The capability needed to access the Add-On form settings page.
	 */
	protected $_capabilities_form_settings = 'gravityforms_ppcp';

	/**
	 * Defines the capability needed to uninstall the Add-On.
	 *
	 * @since  1.0
	 * @access protected
	 * @var    string $_capabilities_uninstall The capability needed to uninstall the Add-On.
	 */
	protected $_capabilities_uninstall = 'gravityforms_ppcp_uninstall';

	/**
	 * Contains an instance of the PayPal Commerce Platform API library, if available.
	 *
	 * @since  1.0
	 * @var    GF_PPCP_API $api If available, contains an instance of the PayPal Commerce Platform API library.
	 */
	protected $api = null;

	/**
	 * Returns an instance of this class, and stores it in the $_instance property.
	 *
	 * @since  1.0
	 *
	 * @return GF_PPCP $_instance An instance of the GF_PPCP class
	 */
	public static function get_instance() {

		if ( self::$_instance == null ) {
			self::$_instance = new GF_PPCP();
		}

		return self::$_instance;

	}

	/**
	 * Load the PayPal field.
	 *
	 * @since 1.0
	 */
	public function pre_init() {
		parent::pre_init();

		require_once 'includes/class-gf-field-paypal.php';
	}

	/**
	 * Register initialization hooks.
	 *
	 * @since  1.0
	 */
	public function init() {

		parent::init();

		add_action( 'script_loader_src', array( $this, 'remove_args' ), 10, 2 );
		add_action( 'script_loader_tag', array( $this, 'add_custom_data' ), 10, 2 );
		add_filter( 'gform_register_init_scripts', array( $this, 'register_init_scripts' ), 10, 3 );
		add_filter( 'gform_submit_button', array( $this, 'add_smart_payment_buttons' ), 10, 2 );
		add_filter( 'gform_form_tag', array( $this, 'add_ppcp_inputs' ), 10, 2 );
		add_filter( 'gform_pre_submission', array( $this, 'populate_credit_card_fields' ) );
		add_filter( 'gform_field_css_class', array( $this, 'paypal_field_css_class' ), 10, 3 );

		add_action( 'gform_field_standard_settings', array( 'GF_Field_PayPal', 'payment_methods_standard_settings' ) );
		add_action( 'gform_field_appearance_settings', array( 'GF_Field_PayPal', 'payment_methods_appearance_settings' ) );
		add_filter( 'gform_tooltips', array( 'GF_Field_PayPal', 'add_tooltips' ) );

	}

	/**
	 * Register admin initialization hooks.
	 *
	 * @since  1.0
	 */
	public function init_admin() {

		parent::init_admin();

		add_action( 'admin_init', array( $this, 'maybe_update_credentials' ) );
		// Add a PayPal Commerce Platform feed if the saved form has the PayPal field.
		add_filter( 'gform_after_save_form', array( $this, 'maybe_add_feed' ), 10, 2 );
		add_action( 'admin_notices', array( $this, 'maybe_display_account_status_notices' ) );
	}

	/**
	 * Register AJAX callbacks.
	 *
	 * @since  1.0
	 */
	public function init_ajax() {

		parent::init_ajax();

		// Finish the seller onboarding process and get the seller's client id and secret.
		add_action( 'wp_ajax_gfppcp_onboarding', array( $this, 'ajax_onboarding' ) );
		add_action( 'wp_ajax_gfppcp_disconnect', array( $this, 'ajax_disconnect' ) );
		add_action( 'wp_ajax_nopriv_gfppcp_get_order_data', array( $this, 'ajax_get_order_data' ) );
		add_action( 'wp_ajax_gfppcp_get_order_data', array( $this, 'ajax_get_order_data' ) );
		add_action( 'wp_ajax_nopriv_gfppcp_create_order', array( $this, 'ajax_create_order' ) );
		add_action( 'wp_ajax_gfppcp_create_order', array( $this, 'ajax_create_order' ) );
		add_action( 'wp_ajax_nopriv_gfppcp_get_country_code', array( $this, 'ajax_get_country_code' ) );
		add_action( 'wp_ajax_gfppcp_get_country_code', array( $this, 'ajax_get_country_code' ) );

	}

	/**
	 * Display the PayPal Connect message.
	 *
	 * @since 1.0
	 *
	 * @param string $plugin_name The plugin filename.  Immediately overwritten.
	 * @param array  $plugin_data An array of plugin data.
	 */
	public function plugin_row( $plugin_name, $plugin_data ) {
		parent::plugin_row( $plugin_name, $plugin_data );

		$settings    = $this->get_plugin_setting( $this->get_environment() );
		$credentials = rgar( $settings, 'credentials' );

		if ( empty( $credentials ) ) {
			$message = sprintf( esc_html__( '%sConnect your PayPal account%s to start accepting payments on your website.', 'gravityformsppcp' ), "<a href='" . admin_url( 'admin.php?page=gf_settings&subview=' . $this->get_slug() ) . "'>", '</a>' );

			self::display_plugin_message( $message, false );
		}
	}

	/**
	 * Add account status warning messages.
	 *
	 * @since 1.0
	 */
	public function maybe_display_account_status_notices() {
		$classes = 'notice notice-error';
		$seller  = $this->is_seller_onboarded();

		if ( false === $seller ) {
			return;
		}

		$credit_card_support = $this->is_custom_card_fields_supported( $seller );
		$message             = '';

		if ( ! $this->initialize_api() ) {
			if ( ! rgar( $seller, 'primary_email_confirmed' ) ) {
				$message = sprintf(
					/* translators: 1: Open link tag 2: Close link tag */
					esc_html__( 'PayPal has sent an confirmation email to your email address. You need to confirm your email to use the Gravity Forms PayPal Commerce Platform add-on. %1$sLearn more here%2$s.', 'gravityformsppcp' ),
					'<a href="https://docs.gravityforms.com/setting-up-the-paypal-commerce-platform-add-on/#email-confirmed" target="_blank">',
					'</a>'
				);
			} elseif ( ! rgar( $seller, 'payments_receivable' ) ) {
				$message = sprintf(
					/* translators: 1: Open link tag 2: Close link tag */
					esc_html__( 'Your PayPal account currently cannot receive payments. Please contact PayPal for more details. %1$sLearn more here%2$s.', 'gravityformsppcp' ),
					'<a href="https://docs.gravityforms.com/setting-up-the-paypal-commerce-platform-add-on/#payment-receivable" target="_blank">',
					'</a>'
				);
			}
		} elseif ( $credit_card_support !== false && ( $credit_card_support === 'IN_REVIEW' || $credit_card_support === 'PENDING' ) ) {
			$message = sprintf(
				/* translators: 1: Open link tag 2: Close link tag */
				esc_html__( 'PayPal is currently reviewing your application to enable the Credit Card Field feature. You can %1$sset up the PayPal Commerce Platform add-on%2$s and start with PayPal Checkout first. Once the application is approved, the Credit Card Field will be enabled automatically.', 'gravityformsppcp' ),
				'<a href="' . admin_url( 'admin.php?page=gf_settings&subview=' . $this->_slug ) . '">',
				'</a>'
			);
		}

		$environment = $this->get_environment();
		$settings    = $this->get_plugin_settings();

		if ( ! empty( $message ) ) {
			// Set the seller_onboarded to false so we will check the seller info on each API call.
			$settings[ $environment ]['seller_onboarded'] = false;
			$this->update_plugin_settings( $settings );

			/* translators: 1: CSS classes 2: The message text */
			echo sprintf( '<div class="%1$s"><p>%2$s</p></div>', $classes, $message );
		} else {
			if ( ! rgars( $settings, $environment . '/seller_onboarded' ) ) {
				$settings[ $environment ]['seller_onboarded'] = true;
				$this->update_plugin_settings( $settings );
			}
		}
	}

	/**
	 * Register PayPal Commerce Platform script when displaying form.
	 *
	 * @since 1.0
	 *
	 * @param array $form         Form object.
	 * @param array $field_values Current field values. Not used.
	 * @param bool  $is_ajax      If form is being submitted via AJAX.
	 *
	 * @return void
	 */
	public function register_init_scripts( $form, $field_values, $is_ajax ) {

		if ( ! $this->frontend_script_callback( $form ) ) {
			return;
		}

		// Initialize PayPal Commerce Platform script.
		$args = array(
			'formId'              => $form['id'],
			'isAjax'              => $is_ajax,
			'currency'            => GFCommon::get_currency(),
			'feeds'               => array(),
			'smartPaymentButtons' => array(
				'buttonsLayout' => $this->get_smart_payment_buttons_default( 'layout' ),
				'buttonsSize'   => $this->get_smart_payment_buttons_default( 'size' ),
				'buttonsShape'  => $this->get_smart_payment_buttons_default( 'shape' ),
				'buttonsColor'  => $this->get_smart_payment_buttons_default( 'color' ),
			),
		);

		if ( $this->has_paypal_field( $form ) ) {
			$cc_field                    = $this->get_paypal_field( $form );
			$args['smartPaymentButtons'] = array(
				'buttonsLayout' => $cc_field->buttonsLayout,
				'buttonsSize'   => $cc_field->buttonsSize,
				'buttonsShape'  => $cc_field->buttonsShape,
				'buttonsColor'  => $cc_field->buttonsColor,
			);

			$args['ccFieldId']      = $cc_field->id;
			$args['ccPage']         = $cc_field->pageNumber;
			$args['paymentMethods'] = $this->is_custom_card_fields_supported() ? $cc_field->methods : array( 'PayPal Checkout' );

			$card_style        = array(
				'input'  => array(
					'font-size' => '1em',
				),
				':focus' => array(
					'color' => 'black',
				),
			);
			$args['cardStyle'] = apply_filters( 'gform_ppcp_card_style', $card_style, $form['id'] );
		}

		// Get feed data.
		$feeds = $this->get_feeds( $form['id'] );
		foreach ( $feeds as $feed ) {
			if ( rgar( $feed, 'is_active' ) === '0' ) {
				continue;
			}

			$feed_settings = array(
				'feedId'          => $feed['id'],
				'feedName'        => rgars( $feed, 'meta/feedName' ),
				'first_name'      => rgars( $feed, 'meta/billingInformation_first_name' ),
				'last_name'       => rgars( $feed, 'meta/billingInformation_last_name' ),
				'email'           => rgars( $feed, 'meta/billingInformation_email' ),
				'address_line1'   => rgars( $feed, 'meta/billingInformation_address' ),
				'address_line2'   => rgars( $feed, 'meta/billingInformation_address2' ),
				'address_city'    => rgars( $feed, 'meta/billingInformation_city' ),
				'address_state'   => rgars( $feed, 'meta/billingInformation_state' ),
				'address_zip'     => rgars( $feed, 'meta/billingInformation_zip' ),
				'address_country' => rgars( $feed, 'meta/billingInformation_country' ),
				'no_shipping'     => rgars( $feed, 'meta/no_shipping' ),
				'intent'          => $this->get_intent( $form['id'], $feed['id'] ),
			);

			if ( rgars( $feed, 'meta/transactionType' ) === 'product' ) {
				$feed_settings['paymentAmount'] = rgars( $feed, 'meta/paymentAmount' );
			} else {
				$feed_settings['paymentAmount'] = rgars( $feed, 'meta/recurringAmount' );
				if ( rgars( $feed, 'meta/setupFee_enabled' ) ) {
					$feed_settings['setupFee'] = rgars( $feed, 'meta/setupFee_product' );
				}
			}

			$args['feeds'][] = $feed_settings;
		}

		$args   = apply_filters( 'gform_ppcp_object', $args, $form['id'] );
		$script = 'new GFPPCP( ' . json_encode( $args, JSON_FORCE_OBJECT ) . ' );';

		// Add PayPal Commerce Platform script to form scripts.
		GFFormDisplay::add_init_script( $form['id'], 'ppcp', GFFormDisplay::ON_PAGE_RENDER, $script );
	}

	/**
	 * Register scripts.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	public function scripts() {

		$min      = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['gform_debug'] ) ? '' : '.min';
		$settings = $this->get_plugin_setting( $this->get_environment() );
		$args     = array(
			'components'       => 'hosted-fields,buttons',
			// When using "hosted-fields,buttons", the standard card fields will be disabled.
			'client-id'        => rgars( $settings, 'credentials/client_id' ),
			'currency'         => GFCommon::get_currency(),
			'integration-date' => date( 'Y-m-d' ),
		);

		// Disable all funding by default.
		$disabled_funding = self::get_disable_funding();
		if ( ! empty( $disabled_funding ) ) {
			$args['disable-funding'] = $disabled_funding;
		}

		$js_sdk_src = add_query_arg(
			$args,
			'https://www.paypal.com/sdk/js'
		);

		$scripts = array(
			array(
				'handle'    => 'paypal_partner_js',
				'src'       => 'https://www.paypal.com/webapps/merchantboarding/js/lib/lightbox/partner.js',
				'enqueue'   => array(
					array(
						'admin_page' => array( 'plugin_settings' ),
						'tab'        => $this->_slug,
					),
				),
				'in_footer' => true, // need to put in footer or the mini-browser couldn't work.
			),
			array(
				'handle' => 'gform_paypal_sdk',
				'src'    => $js_sdk_src,
			),
			array(
				'handle'  => 'gform_ppcp_pluginsettings',
				'deps'    => array( 'jquery' ),
				'src'     => $this->get_base_url() . "/js/plugin_settings{$min}.js",
				'version' => $this->_version,
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_settings' ),
						'tab'        => $this->_slug,
					),
				),
				'strings' => array(
					'is_legacy_markup'   => $this->is_gravityforms_supported( '2.5-beta' ) ? 'false' : 'true',
					'prefixes'           => array(
						'input' => $this->is_gravityforms_supported( '2.5-beta' ) ? '_gform_setting_' : '_gaddon_setting_',
						'field' => $this->is_gravityforms_supported( '2.5-beta' ) ? 'gform_setting_' : 'gaddon-setting-row-',
					),
					'onboarding_nonce'   => wp_create_nonce( 'gf_ppcp_onboarding' ),
					'disconnect_nonce'   => wp_create_nonce( 'gf_ppcp_disconnect' ),
					'onboarding_error'   => wp_strip_all_tags( __( 'We cannot finish the onboarding process. Please try again later.', 'gravityformsppcp' ) ),
					'settings_url'       => admin_url( 'admin.php?page=gf_settings&subview=' . $this->get_slug() ),
					'sandbox_action_url' => $this->get_action_url( 'sandbox' ),
					'live_action_url'    => $this->get_action_url( 'live' ),
					'disconnect'         => array(
						'site'    => wp_strip_all_tags( __( 'Are you sure you want to disconnect from PayPal for this website?', 'gravityformsppcp' ) ),
						'feed'    => wp_strip_all_tags( __( 'Are you sure you want to disconnect from PayPal for this feed?', 'gravityformsppcp' ) ),
						'account' => wp_strip_all_tags( __( 'Are you sure you want to disconnect all Gravity Forms sites connected to this PayPal account?', 'gravityformsppcp' ) ),
					),
				),
			),
			array(
				'handle'  => 'gform_ppcp_form_editor',
				'deps'    => array( 'jquery', 'gform_paypal_sdk' ),
				'src'     => $this->get_base_url() . "/js/form_editor{$min}.js",
				'version' => $this->_version,
				'enqueue' => array(
					array( 'admin_page' => array( 'form_editor' ) ),
				),
				'strings' => array(
					'initialize_api'                  => $this->initialize_api(),
					'is_custom_card_fields_supported' => $this->is_custom_card_fields_supported(),
					'active'                          => wp_strip_all_tags( __( 'Active', 'gravityformsppcp' ) ),
					'inactive'                        => wp_strip_all_tags( __( 'Inactive', 'gravityformsppcp' ) ),
					'show'                            => wp_strip_all_tags( __( 'Show', 'gravityformsppcp' ) ),
					'imgurl'                          => GFCommon::get_base_url() . '/images/',
					'must_have_method'                => wp_strip_all_tags( __( 'At least one payment method should be selected.', 'gravityformsppcp' ) ),
					'only_one_paypal_field'           => wp_strip_all_tags( __( 'Only one PayPal field can be added to the form', 'gravityformsppcp' ) ),
				),
			),
			array(
				'handle'    => 'gforms_ppcp_frontend',
				'src'       => $this->get_base_url() . "/js/frontend{$min}.js",
				'version'   => $this->_version,
				'deps'      => array( 'jquery', 'gform_json', 'gform_gravityforms', 'gform_paypal_sdk', 'wp-a11y' ),
				'in_footer' => false,
				'enqueue'   => array(
					array( $this, 'frontend_script_callback' ),
				),
				'strings'   => array(
					'card_not_supported'  => wp_strip_all_tags( __( 'is not supported. Please enter one of the supported credit cards.', 'gravityformsppcp' ) ),
					'card_info_error'     => wp_strip_all_tags( __( 'Your credit card information is invalid. Please check it and try again.', 'gravityformsppcp' ) ),
					'threed_secure_error' => wp_strip_all_tags( __( 'You have not passed the 3-D secure authentication. Please try again.', 'gravityformsppcp' ) ),
					'skipped_by_buyer'    => wp_strip_all_tags( __( 'Are you sure to skip the 3-D secure authentication?', 'gravityformsppcp' ) ),
					'on_approve_nonce'    => wp_create_nonce( 'gf_ppcp_on_approve_nonce' ),
					'create_order_nonce'  => wp_create_nonce( 'gf_ppcp_create_order_nonce' ),
					'ajaxurl'             => admin_url( 'admin-ajax.php' ),
				),
			),
		);

		return array_merge( parent::scripts(), $scripts );

	}

	/**
	 * Register styles.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	public function styles() {

		$min = defined( 'SCRIPT_DEBUG' ) && SCRIPT_DEBUG || isset( $_GET['gform_debug'] ) ? '' : '.min';

		$styles = array(
			array(
				'handle'  => 'gform_ppcp_pluginsettings',
				'src'     => $this->get_base_url() . "/css/plugin_settings{$min}.css",
				'version' => $this->_version,
				'enqueue' => array(
					array(
						'admin_page' => array( 'plugin_settings' ),
						'tab'        => $this->_slug,
					),
					array( 'query' => 'page=gf_edit_forms' ),
				),
			),
			array(
				'handle'  => 'gform_ppcp_frontend',
				'src'     => $this->get_base_url() . "/css/frontend{$min}.css",
				'version' => $this->_version,
				'enqueue' => array(
					array( $this, 'frontend_script_callback' ),
				),
			),
		);

		return array_merge( parent::styles(), $styles );

	}





	// # PLUGIN SETTINGS -----------------------------------------------------------------------------------------------

	/**
	 * Define plugin settings fields.
	 *
	 * @since  1.0
	 *
	 * @return array
	 */
	public function plugin_settings_fields() {

		return array(
			array(
				'title'       => esc_html__( 'PayPal Account', 'gravityformsppcp' ),
				'description' => $this->get_description( 'paypal_account' ),
				'fields'      => $this->api_settings_fields(),
			),
		);

	}

	/**
	 * Get the description for settings section.
	 *
	 * @since 1.0
	 *
	 * @param string $section The section name.
	 *
	 * @return string
	 */
	public function get_description( $section ) {
		ob_start(); ?>
		<p>
			<?php
			printf(
				esc_html__( 'The PayPal Commerce Platform is an all-in-one global solution, you can accept payments from 286 million PayPal customers, in over 100 currencies and across 200 markets, with advanced Fraud Protection and unprecedented control. %1$sLearn more%2$s.', 'gravityformsppcp' ),
				'<a href="https://docs.gravityforms.com/using-the-paypal-commerce-platform-add-on/" target="_blank">',
				'</a>'
			);
			?>
		</p>
		<?php

		return ob_get_clean();
	}

	/**
	 * Define the settings which appear in the PayPal account section.
	 *
	 * @since  1.0
	 *
	 * @return array The API settings fields.
	 */
	public function api_settings_fields() {
		$status_tooltip = sprintf(
			/* translators: 1. Open paragraph tag 2. Close paragraph tag 3. Open strong tag 4. Close strong tag */
			esc_html__( '%1$sYou can only use the PayPal Commerce Platform add-on if the Email Confirmed and Payment Receivable status is %3$sYes%4$s.%2$s%1$sIf the Credit Card field support is %3$sSUBSCRIBED%4$s, you can use both PayPal Checkout and Credit Card, otherwise you can only use PayPal Checkout to accept payments.%2$s', 'gravityformsppcp' ),
			'<p>',
			'</p>',
			'<strong>',
			'</strong>'
		);

		return array(
			array(
				'name'       => 'environment',
				'label'      => esc_html__( 'Environment', 'gravityformsppcp' ),
				'type'       => 'radio',
				'choices'    => array(
					array(
						'label' => esc_html__( 'Live', 'gravityformsppcp' ),
						'value' => 'live',
					),
					array(
						'label' => esc_html__( 'Sandbox', 'gravityformsppcp' ),
						'value' => 'sandbox',
					),
				),
				'horizontal' => true,
				'tooltip'    => '<h6>' . esc_html__( 'Environment', 'gravityformsppcp' ) . '</h6>' . esc_html__( 'Start with the Sandbox environment if you are still testing the integration. Use the Live environment on your production site.', 'gravityformsppcp' ),
			),
			array(
				'name' => 'live_auth_button',
				'type' => 'auth_button',
			),
			array(
				'name' => 'sandbox_auth_button',
				'type' => 'auth_button',
			),
			array(
				'name'    => 'live_account_status',
				'type'    => 'account_status',
				'label'   => esc_html__( 'Account Status', 'gravityformsppcp' ),
				'tooltip' => '<h6>' . esc_html__( 'Account Status', 'gravityformsppcp' ) . '</h6>' . $status_tooltip,
			),
			array(
				'name'    => 'sandbox_account_status',
				'type'    => 'account_status',
				'label'   => esc_html__( 'Account Status', 'gravityformsppcp' ),
				'tooltip' => '<h6>' . esc_html__( 'Account Status', 'gravityformsppcp' ) . '</h6>' . $status_tooltip,
			),
		);
	}

	/**
	 * The auth token button html.
	 *
	 * @since 1.0
	 *
	 * @param array $field_name The field name.
	 */
	public function settings_auth_button( $field_name ) {
		ob_start();

		$environment = rgar( $field_name, 'name' ) === 'live_auth_button' ? 'live' : 'sandbox';
		$seller      = $this->is_seller_onboarded( $environment );

		if ( $seller === false ) {
			// Ban localhost from displaying the connect button.
			if ( $_SERVER['SERVER_NAME'] === 'localhost' ) { ?>
				<div class="alert_red">
					<h4><?php esc_html_e( 'Hostname localhost is not allowed', 'gravityformsppcp' ); ?></h4>
					<?php
					/* translator: 1. Open code tag 2. Close code tag */
					printf( esc_html__( 'PayPal does not allow connections from %1$slocalhost%2$s. To test locally, you need to use a top-level domain such as %1$s.local%2$s.', 'gravityformsppcp' ), '<code>', '</code>' );
					?>
				</div>
			<?php } elseif ( is_ssl() ) {
				$connect_button = '<svg width="182" height="33" viewBox="0 0 182 33" fill="none" xmlns="http://www.w3.org/2000/svg">
				<title>' . esc_html__( 'Click here to connect to PayPal', 'gravityformsppcp' ) . '</title>
<rect width="182" height="33" rx="16.5"/>
<path d="M31.6023 11.6734C31.8196 10.2881 31.6008 9.34541 30.8514 8.4916C30.0264 7.55162 28.5359 7.14893 26.6289 7.14893H21.0932C20.7035 7.14893 20.3717 7.43244 20.311 7.81736L18.006 22.4327C17.9604 22.7211 18.1834 22.9818 18.4753 22.9818H21.8927L21.6569 24.4774C21.6171 24.7297 21.812 24.9579 22.0674 24.9579H24.9478C25.2889 24.9579 25.5791 24.7098 25.6323 24.3731L25.6606 24.2267L26.2032 20.786L26.2382 20.5959C26.2913 20.2591 26.5816 20.0111 26.9225 20.0111H27.3533C30.1439 20.0111 32.329 18.8774 32.9674 15.5989C33.2343 14.2291 33.0964 13.0856 32.3909 12.2816C32.1774 12.0386 31.912 11.8374 31.6023 11.6734Z" fill="#ACCDE3"/>
<path d="M31.6023 11.6738C31.8196 10.2884 31.6008 9.34562 30.8514 8.49172C30.0264 7.55166 28.5359 7.14893 26.6289 7.14893H21.0932C20.7035 7.14893 20.3717 7.43247 20.311 7.81742L18.006 22.4342C17.9604 22.7226 18.1834 22.9833 18.4753 22.9833H21.8927L22.7511 17.5399L22.7245 17.7106C22.7852 17.3257 23.1143 17.0419 23.504 17.0419H25.1283C28.3182 17.0419 30.8159 15.7459 31.5457 11.998C31.5673 11.8872 31.5858 11.7796 31.6023 11.6738Z" fill="white" fill-opacity="0.7"/>
<path d="M23.6732 11.6923C23.7099 11.4607 23.8584 11.2711 24.0585 11.1751C24.1496 11.1316 24.2512 11.1073 24.3577 11.1073H28.6968C29.211 11.1073 29.6902 11.141 30.1283 11.2116C30.2537 11.2317 30.3754 11.255 30.4939 11.2813C30.6122 11.3074 30.7272 11.3368 30.8384 11.3694C30.8941 11.3856 30.9487 11.4026 31.0026 11.4206C31.2177 11.4919 31.418 11.5762 31.6023 11.6738C31.8196 10.2884 31.6008 9.34562 30.8514 8.49172C30.0264 7.55166 28.5359 7.14893 26.6289 7.14893H21.0932C20.7035 7.14893 20.3717 7.43247 20.311 7.81742L18.006 22.4342C17.9604 22.7226 18.1834 22.9833 18.4753 22.9833H21.8927L23.6732 11.6923Z" fill="white"/>
<path d="M43.7578 13.2051C42.7253 13.2051 41.8789 13.5098 41.2188 14.1191C40.5671 14.7285 40.2412 15.541 40.2412 16.5566C40.2412 17.5638 40.5671 18.3721 41.2188 18.9814C41.8704 19.5908 42.7126 19.8955 43.7451 19.8955C44.109 19.8955 44.4434 19.8659 44.748 19.8066C45.0527 19.7389 45.3574 19.6374 45.6621 19.502V20.7588C45.332 20.8942 45.0146 20.9915 44.71 21.0508C44.4053 21.11 44.071 21.1396 43.707 21.1396C42.2936 21.1396 41.1257 20.7165 40.2031 19.8701C39.2891 19.0153 38.832 17.9108 38.832 16.5566C38.832 15.2025 39.2891 14.1022 40.2031 13.2559C41.1257 12.401 42.2936 11.9736 43.707 11.9736C44.0625 11.9736 44.3926 12.0033 44.6973 12.0625C45.0104 12.1217 45.332 12.2148 45.6621 12.3418V13.6113C45.349 13.4759 45.04 13.3743 44.7354 13.3066C44.4307 13.2389 44.1048 13.2051 43.7578 13.2051ZM49.9023 21.1396C49.0137 21.1396 48.2646 20.818 47.6553 20.1748C47.0459 19.5316 46.7412 18.7233 46.7412 17.75C46.7412 16.7682 47.0459 15.9557 47.6553 15.3125C48.2646 14.6693 49.0137 14.3477 49.9023 14.3477C50.7995 14.3477 51.5527 14.6693 52.1621 15.3125C52.7715 15.9557 53.0762 16.7682 53.0762 17.75C53.0762 18.7233 52.7715 19.5316 52.1621 20.1748C51.5527 20.818 50.7995 21.1396 49.9023 21.1396ZM49.9023 20.0098C50.4609 20.0098 50.9137 19.8024 51.2607 19.3877C51.6077 18.9645 51.7812 18.4186 51.7812 17.75C51.7812 17.0729 51.6077 16.527 51.2607 16.1123C50.9137 15.6891 50.4609 15.4775 49.9023 15.4775C49.3438 15.4775 48.891 15.6891 48.5439 16.1123C48.2054 16.527 48.0361 17.0729 48.0361 17.75C48.0361 18.4186 48.2054 18.9645 48.5439 19.3877C48.891 19.8024 49.3438 20.0098 49.9023 20.0098ZM54.5361 21V14.6143L55.8438 14.3984V15.1221C56.1569 14.8851 56.5039 14.6989 56.8848 14.5635C57.2741 14.4196 57.6634 14.3477 58.0527 14.3477C58.7467 14.3477 59.2842 14.5423 59.665 14.9316C60.0544 15.321 60.249 15.8626 60.249 16.5566V21H58.9287V16.8867C58.9287 16.4043 58.8187 16.0531 58.5986 15.833C58.387 15.6045 58.057 15.4902 57.6084 15.4902C57.2952 15.4902 56.999 15.5326 56.7197 15.6172C56.4404 15.7018 56.1484 15.8415 55.8438 16.0361V21H54.5361ZM62.1787 21V14.6143L63.4863 14.3984V15.1221C63.7995 14.8851 64.1465 14.6989 64.5273 14.5635C64.9167 14.4196 65.306 14.3477 65.6953 14.3477C66.3893 14.3477 66.9268 14.5423 67.3076 14.9316C67.6969 15.321 67.8916 15.8626 67.8916 16.5566V21H66.5713V16.8867C66.5713 16.4043 66.4613 16.0531 66.2412 15.833C66.0296 15.6045 65.6995 15.4902 65.251 15.4902C64.9378 15.4902 64.6416 15.5326 64.3623 15.6172C64.083 15.7018 63.791 15.8415 63.4863 16.0361V21H62.1787ZM72.3477 15.3887C71.8822 15.3887 71.4886 15.541 71.167 15.8457C70.8454 16.1504 70.6423 16.5651 70.5576 17.0898H73.833V17.0264C73.833 16.527 73.7018 16.1292 73.4395 15.833C73.1771 15.5368 72.8132 15.3887 72.3477 15.3887ZM74.8359 19.6035V20.708C74.5228 20.8519 74.1969 20.9577 73.8584 21.0254C73.5283 21.1016 73.1771 21.1396 72.8047 21.1396C71.7721 21.1396 70.9258 20.8223 70.2656 20.1875C69.6139 19.5443 69.2881 18.7233 69.2881 17.7246C69.2881 16.7598 69.5801 15.9557 70.1641 15.3125C70.748 14.6693 71.4844 14.3477 72.373 14.3477C73.2363 14.3477 73.9049 14.627 74.3789 15.1855C74.8613 15.7357 75.1025 16.4889 75.1025 17.4453C75.1025 17.5723 75.1025 17.6696 75.1025 17.7373C75.1025 17.7965 75.0983 17.8558 75.0898 17.915H70.5195C70.5703 18.5583 70.8158 19.0745 71.2559 19.4639C71.7044 19.8447 72.2673 20.0352 72.9443 20.0352C73.3506 20.0352 73.6891 20.0013 73.96 19.9336C74.2393 19.8659 74.5312 19.7559 74.8359 19.6035ZM79.457 21.1396C78.4753 21.1396 77.6585 20.8223 77.0068 20.1875C76.3636 19.5527 76.042 18.7445 76.042 17.7627C76.042 16.764 76.3636 15.9473 77.0068 15.3125C77.6501 14.6693 78.4668 14.3477 79.457 14.3477C79.694 14.3477 79.931 14.373 80.168 14.4238C80.4134 14.4746 80.6335 14.5423 80.8281 14.627V15.7822C80.6335 15.6807 80.4261 15.6087 80.2061 15.5664C79.9945 15.5156 79.7617 15.4902 79.5078 15.4902C78.873 15.4902 78.3483 15.7018 77.9336 16.125C77.5273 16.5482 77.3242 17.0941 77.3242 17.7627C77.3242 18.4144 77.5316 18.9518 77.9463 19.375C78.361 19.7897 78.8815 19.9971 79.5078 19.9971C79.7363 19.9971 79.9648 19.9717 80.1934 19.9209C80.4303 19.8701 80.6546 19.7939 80.8662 19.6924V20.8604C80.6715 20.945 80.443 21.0127 80.1807 21.0635C79.9268 21.1143 79.6855 21.1396 79.457 21.1396ZM81.7041 15.5029V14.4873H82.6562V13.0781L83.9766 12.875V14.4873H86.2363L86.0586 15.5029H83.9766V18.9814C83.9766 19.3031 84.0654 19.5527 84.2432 19.7305C84.4294 19.9082 84.6833 19.9971 85.0049 19.9971C85.3096 19.9971 85.5719 19.9759 85.792 19.9336C86.0205 19.8828 86.2617 19.8066 86.5156 19.7051V20.7842C86.2786 20.9027 86.0163 20.9873 85.7285 21.0381C85.4492 21.0973 85.1488 21.127 84.8271 21.127C84.1585 21.127 83.6296 20.9535 83.2402 20.6064C82.8509 20.2594 82.6562 19.7686 82.6562 19.1338V15.5029H81.7041ZM93.041 19.3115L94.5137 14.4873H95.415L96.9258 19.3242L98.3984 14.4873H99.6172L97.3955 21.0381H96.3926L94.9072 16.3027L93.4346 21.0381H92.4316L90.21 14.4873H91.543L93.041 19.3115ZM101.382 12.9004C101.145 12.9004 100.946 12.82 100.785 12.6592C100.624 12.4984 100.544 12.3037 100.544 12.0752C100.544 11.8467 100.624 11.652 100.785 11.4912C100.946 11.3304 101.145 11.25 101.382 11.25C101.619 11.25 101.818 11.3304 101.979 11.4912C102.139 11.652 102.22 11.8467 102.22 12.0752C102.22 12.3037 102.139 12.4984 101.979 12.6592C101.818 12.82 101.619 12.9004 101.382 12.9004ZM102.029 21H100.722V14.6143L102.029 14.3984V21ZM103.273 15.5029V14.4873H104.226V13.0781L105.546 12.875V14.4873H107.806L107.628 15.5029H105.546V18.9814C105.546 19.3031 105.635 19.5527 105.812 19.7305C105.999 19.9082 106.253 19.9971 106.574 19.9971C106.879 19.9971 107.141 19.9759 107.361 19.9336C107.59 19.8828 107.831 19.8066 108.085 19.7051V20.7842C107.848 20.9027 107.586 20.9873 107.298 21.0381C107.019 21.0973 106.718 21.127 106.396 21.127C105.728 21.127 105.199 20.9535 104.81 20.6064C104.42 20.2594 104.226 19.7686 104.226 19.1338V15.5029H103.273ZM109.431 21V11.0088L110.738 10.8184V15.1221C111.051 14.8851 111.398 14.6989 111.779 14.5635C112.169 14.4196 112.558 14.3477 112.947 14.3477C113.641 14.3477 114.179 14.5423 114.56 14.9316C114.949 15.321 115.144 15.8626 115.144 16.5566V21H113.823V16.8867C113.823 16.4043 113.713 16.0531 113.493 15.833C113.282 15.6045 112.951 15.4902 112.503 15.4902C112.19 15.4902 111.894 15.5326 111.614 15.6172C111.335 15.7018 111.043 15.8415 110.738 16.0361V21H109.431ZM126.887 14.8428C126.887 15.6637 126.59 16.3239 125.998 16.8232C125.414 17.3226 124.644 17.5723 123.688 17.5723H121.834V21H120.476V12.1133H123.688C124.644 12.1133 125.414 12.363 125.998 12.8623C126.59 13.3617 126.887 14.0218 126.887 14.8428ZM125.478 14.8428C125.478 14.3519 125.308 13.9668 124.97 13.6875C124.631 13.3997 124.178 13.2559 123.611 13.2559H121.834V16.4297H123.611C124.178 16.4297 124.631 16.29 124.97 16.0107C125.308 15.723 125.478 15.3337 125.478 14.8428ZM129.108 19.3115C129.108 19.5739 129.197 19.7812 129.375 19.9336C129.561 20.0859 129.807 20.1621 130.111 20.1621C130.382 20.1621 130.645 20.1198 130.898 20.0352C131.152 19.9421 131.427 19.7939 131.724 19.5908V17.9531C130.843 17.987 130.188 18.1182 129.756 18.3467C129.324 18.5667 129.108 18.8883 129.108 19.3115ZM133.158 21H131.851L131.724 20.3145C131.419 20.5853 131.097 20.7926 130.759 20.9365C130.429 21.0719 130.086 21.1396 129.73 21.1396C129.18 21.1396 128.728 20.9788 128.372 20.6572C128.025 20.3356 127.852 19.9167 127.852 19.4004C127.852 18.6979 128.182 18.152 128.842 17.7627C129.502 17.3649 130.463 17.1491 131.724 17.1152V16.7344C131.724 16.3197 131.609 16.0065 131.381 15.7949C131.152 15.5833 130.814 15.4775 130.365 15.4775C130.018 15.4775 129.663 15.5326 129.299 15.6426C128.943 15.7441 128.584 15.9007 128.22 16.1123V14.9951C128.516 14.8005 128.871 14.6439 129.286 14.5254C129.709 14.4069 130.111 14.3477 130.492 14.3477C131.305 14.3477 131.931 14.5508 132.371 14.957C132.811 15.3633 133.031 15.9346 133.031 16.6709V19.7051C133.031 19.9759 133.04 20.2002 133.057 20.3779C133.074 20.5557 133.107 20.763 133.158 21ZM134.364 22.9551C134.881 22.9551 135.299 22.7858 135.621 22.4473C135.951 22.1087 136.315 21.4655 136.713 20.5176L134.034 14.4873H135.443L137.398 19.1592L139.328 14.4873H140.61L137.767 20.9365C137.242 22.113 136.738 22.9212 136.256 23.3613C135.773 23.8099 135.164 24.0342 134.428 24.0342C134.309 24.0342 134.191 24.0215 134.072 23.9961C133.954 23.9792 133.856 23.9538 133.78 23.9199V22.8662C133.865 22.8916 133.958 22.9128 134.06 22.9297C134.17 22.9466 134.271 22.9551 134.364 22.9551ZM148.278 14.8428C148.278 15.6637 147.982 16.3239 147.39 16.8232C146.806 17.3226 146.035 17.5723 145.079 17.5723H143.226V21H141.867V12.1133H145.079C146.035 12.1133 146.806 12.363 147.39 12.8623C147.982 13.3617 148.278 14.0218 148.278 14.8428ZM146.869 14.8428C146.869 14.3519 146.7 13.9668 146.361 13.6875C146.023 13.3997 145.57 13.2559 145.003 13.2559H143.226V16.4297H145.003C145.57 16.4297 146.023 16.29 146.361 16.0107C146.7 15.723 146.869 15.3337 146.869 14.8428ZM150.5 19.3115C150.5 19.5739 150.589 19.7812 150.767 19.9336C150.953 20.0859 151.198 20.1621 151.503 20.1621C151.774 20.1621 152.036 20.1198 152.29 20.0352C152.544 19.9421 152.819 19.7939 153.115 19.5908V17.9531C152.235 17.987 151.579 18.1182 151.147 18.3467C150.716 18.5667 150.5 18.8883 150.5 19.3115ZM154.55 21H153.242L153.115 20.3145C152.811 20.5853 152.489 20.7926 152.15 20.9365C151.82 21.0719 151.478 21.1396 151.122 21.1396C150.572 21.1396 150.119 20.9788 149.764 20.6572C149.417 20.3356 149.243 19.9167 149.243 19.4004C149.243 18.6979 149.573 18.152 150.233 17.7627C150.894 17.3649 151.854 17.1491 153.115 17.1152V16.7344C153.115 16.3197 153.001 16.0065 152.772 15.7949C152.544 15.5833 152.205 15.4775 151.757 15.4775C151.41 15.4775 151.054 15.5326 150.69 15.6426C150.335 15.7441 149.975 15.9007 149.611 16.1123V14.9951C149.908 14.8005 150.263 14.6439 150.678 14.5254C151.101 14.4069 151.503 14.3477 151.884 14.3477C152.696 14.3477 153.323 14.5508 153.763 14.957C154.203 15.3633 154.423 15.9346 154.423 16.6709V19.7051C154.423 19.9759 154.431 20.2002 154.448 20.3779C154.465 20.5557 154.499 20.763 154.55 21ZM157.635 21H156.327V11.0088L157.635 10.8184V21Z" fill="white"/>
</svg>
';
				?>
				<a class="gform_ppcp_connect_button" target="_blank"
				   data-paypal-onboard-complete="onboardedCallback"
				   data-paypal-button="true"><?php echo $connect_button; ?></a>
				<?php
			} else {
				$settings_url = admin_url( 'admin.php?page=gf_settings&subview=' . $this->get_slug(), 'https' );
				?>
				<div class="alert_red">
					<h4><?php esc_html_e( 'SSL Certificate Required', 'gravityformsppcp' ) ?></h4>
					<?php
					printf( esc_html__( 'Make sure you have an SSL certificate installed and enabled, then %1$sclick here to continue%2$s.', 'gravityformsppcp' ), '<a href="' . $settings_url . '">', '</a>' );
					?>
				</div>
			<?php }
		} else {
			$settings     = $this->get_plugin_setting( $environment );
			$display_name = rgar( $settings, 'merchant_id' ) ? $settings['merchant_id'] : '';
			?>
			<p class="connected_to_text">
				<?php
				! empty( $display_name ) ?
					printf(
						esc_html__( 'Your merchant ID on PayPal: %1$s%2$s%3$s.', 'gravityformsppcp' ),
						'<strong>',
						$display_name,
						'</strong>'
					) :
					esc_html_e( 'Connected to PayPal.', 'gravityformsppcp' );
				?>
				<a class="button gform_ppcp_disconnect_button"
				   href="javascript:void(0);"><?php esc_html_e( 'Disconnect from PayPal', 'gravityformsppcp' ); ?></a>
			</p>
		<?php }

		$html = ob_get_clean();

		echo $html;
	}

	/**
	 * Get the SVG icon URL for this add-on.
	 *
	 * @since 1.4
	 *
	 * @return string
	 */
	public function get_menu_icon() {
		return file_get_contents( $this->get_base_path() . '/images/paypal.svg' );
	}

	/**
	 * Display account status.
	 *
	 * @since 1.0
	 *
	 * @param array $field_name The field name.
	 */
	public function settings_account_status( $field_name ) {
		$environment = rgar( $field_name, 'name' ) === 'live_account_status' ? 'live' : 'sandbox';

		$seller = $this->is_seller_onboarded( $environment );

		if ( is_array( $seller ) ) {
			$custom_card_fields_support = $this->is_custom_card_fields_supported( $seller );

			$message = sprintf(
				/* translators: 1. Email confirmation status 2. Payment receivable status 3. Credit Card field support status 4. Open strong tag 5. Close strong tag */
				esc_html__( 'Email confirmed: %4$s%1$s%5$s. Payment Receivable: %4$s%2$s%5$s. Credit Card field support: %4$s%3$s%5$s.', 'gravityformsppcp' ),
				$seller['primary_email_confirmed'] ? esc_html__( 'Yes', 'gravityformsppcp' ) : esc_html__( 'No', 'gravityformsppcp' ),
				$seller['payments_receivable'] ? esc_html__( 'Yes', 'gravityformsppcp' ) : esc_html__( 'No', 'gravityformsppcp' ),
				$custom_card_fields_support ? $custom_card_fields_support : esc_html__( 'No', 'gravityformsppcp' ),
				'<strong>',
				'</strong>'
			);

			echo '<p>' . $message . '</p>';
		}
	}

	/**
	 * Add some data that aren't registered as setting fields when updating plugin settings.
	 *
	 * @since 1.0
	 *
	 * @param array $settings Plugin settings to be saved.
	 */
	public function update_plugin_settings( $settings ) {
		if ( $this->is_save_postback() ) {
			$_settings = $this->get_plugin_settings();

			foreach ( $_settings as $key => $value ) {
				if ( rgempty( $key, $settings ) && ! empty( $value ) ) {
					$settings[ $key ] = $value;
				}
			}
		}

		parent::update_plugin_settings( $settings );
	}

	/**
	 * When users are redirected back to the website after finishing the onboarding, get the seller credentials.
	 *
	 * @since 1.0
	 */
	public function maybe_update_credentials() {
		if ( rgget( 'subview' ) !== $this->get_slug() ) {
			return;
		}

		if ( rgget( 'merchantIdInPayPal' ) && ! $this->is_save_postback() && ! $this->initialize_api() ) {
			$environment = $this->get_environment();
			$settings    = $this->get_plugin_setting( $environment );

			// CSRF check.
			if ( rawurldecode( rgget( 'merchantId' ) ) !== rgar( $settings, 'tracking_id' ) ) {
				$this->log_error( __METHOD__ . '(): Tracking ID does not match. The tracking ID on record: ' . $settings['tracking_id'] . ';  the tracking ID PayPal returned: ' . rawurldecode( rgget( 'merchantId' ) ) );

				GFCommon::add_error_message( esc_html__( 'Tracking ID does not match. Please reconnect again.', 'gravityformsppcp' ) );

				return;
			}

			// Initialize API without credentials.
			$ppcp = new GF_PPCP_API( null, $environment );

			// Get the seller access token.
			$access_token = $ppcp->get_access_token( $settings, $environment );
			if ( is_wp_error( $access_token ) ) {
				$this->log_error( __METHOD__ . '(): ' . $access_token->get_error_message() );

				GFCommon::add_error_message( $this->add_paypal_debug_id( esc_html__( 'No seller access token returned from PayPal.', 'gravityformsppcp' ), $access_token ) );

				return;
			}

			// Get the seller REST API credentials.
			$credentials = $ppcp->get_credentials( $settings['partner_merchant_id'], $access_token );
			if ( is_wp_error( $credentials ) ) {
				$this->log_error( __METHOD__ . '(): ' . $credentials->get_error_message() );

				GFCommon::add_error_message( $this->add_paypal_debug_id( esc_html__( 'No seller API credentials returned from PayPal.', 'gravityformsppcp' ), $credentials ) );

				return;
			}

			$settings['credentials'] = array(
				'client_id'     => rgar( $credentials, 'client_id' ),
				'client_secret' => rgar( $credentials, 'client_secret' ),
			);

			// Create webhooks.
			$webhook = $ppcp->create_webhooks( $settings, $environment );
			if ( is_wp_error( $webhook ) ) {
				$this->log_error( __METHOD__ . '(): ' . $webhook->get_error_message() );

				GFCommon::add_error_message( $this->add_paypal_debug_id( esc_html__( 'Failed to create webhooks.', 'gravityformsppcp' ), $webhook ) );

				return;
			}

			$settings['webhook']['id'] = $webhook;

			// Get the merchant ID.
			$response                = wp_remote_post(
				$this->get_gravity_api_url( '/auth/paypal/merchant' ),
				array(
					'body' => array(
						'environment' => $environment,
						'tracking_id' => rgar( $settings, 'tracking_id' ),
					),
				)
			);
			$response_body           = json_decode( wp_remote_retrieve_body( $response ), true );
			$settings['merchant_id'] = rgars( $response_body, 'data/merchant_id' );

			// Unset the data we no longer need.
			unset( $settings['shared_id'] );
			unset( $settings['auth_code'] );

			$plugin_settings                 = $this->get_plugin_settings();
			$plugin_settings[ $environment ] = $settings;
			$this->update_plugin_settings( $plugin_settings );

			wp_redirect( add_query_arg( array(
				'page'    => 'gf_settings',
				'subview' => $this->get_slug()
			), admin_url( 'admin.php' ) ) );
			exit();
		}
	}

	/**
	 * Initializes the PayPal Commerce Platform API by checking if the seller is onboarded.
	 *
	 * The $api will be set in is_seller_onboarded() but not this method.
	 *
	 * @since  1.0
	 *
	 * @param string $environment The environment.
	 *
	 * @return bool|null API initialization state.
	 */
	public function initialize_api( $environment = null ) {
		if ( empty( $environment ) ) {
			// If the API is already initializes, return true.
			if ( ! is_null( $this->api ) ) {
				return true;
			}

			$environment = $this->get_environment();
		}

		// Check if the seller has onboarded.
		$seller = $this->is_seller_onboarded( $environment );
		if ( is_array( $seller ) && $this->api !== null ) {
			return true;
		}

		return false;
	}

	/**
	 * The AJAX callback function to get authCode and sharedId from when the Seller Onboarding completed.
	 *
	 * @since 1.0
	 */
	public function ajax_onboarding() {
		check_ajax_referer( 'gf_ppcp_onboarding', 'nonce' );

		// If user is not authorized, exit.
		if ( ! GFCommon::current_user_can_any( $this->_capabilities_settings_page ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Access denied.', 'gravityformsppcp' ) ) );
		}

		// Return if the API has been initialized.
		$environment = sanitize_text_field( rgget( 'environment' ) );
		if ( $this->initialize_api( $environment ) ) {
			wp_send_json_success();
		}

		// The data passed by Fetch API needs to be gotten this way. (They are not available in $_POST.).
		$body = trim( file_get_contents( "php://input" ) );
		$data = json_decode( $body, true );

		// If not authCode or sharedId, exit.
		if ( rgempty( 'authCode', $data ) || rgempty( 'sharedId', $data ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'No authCode or sharedId returned from PayPal.', 'gravityformsppcp' ) ) );
		}

		// Store authCode and sharedId.
		$settings                                          = $this->get_plugin_settings();
		$settings['environment']                           = $environment;
		$settings[ $settings['environment'] ]['auth_code'] = sanitize_text_field( rgar( $data, 'authCode' ) );
		$settings[ $settings['environment'] ]['shared_id'] = sanitize_text_field( rgar( $data, 'sharedId' ) );

		$this->log_debug( __METHOD__ . '(): PayPal redirect the seller back to the site; Settings we\'ve got: ' . print_r( $settings, 1 ) );

		// Store tokens and credentials.
		$this->update_plugin_settings( $settings );

		// Return success response.
		wp_send_json_success();
	}

	/**
	 * AJAX helper function to disconnect from PayPal.
	 *
	 * @since 1.0
	 */
	public function ajax_disconnect() {
		check_ajax_referer( 'gf_ppcp_disconnect', 'nonce' );

		// If user is not authorized, exit.
		if ( ! GFCommon::current_user_can_any( $this->_capabilities_settings_page ) ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Access denied.', 'gravityformsppcp' ) ) );
		}

		$environment = sanitize_text_field( rgpost( 'environment' ) );
		$settings    = $this->get_plugin_settings();

		// Delete the webhook.
		if ( $this->initialize_api( $environment ) ) {
			$id = rgars( $settings, $environment . '/webhook/id' );
			if ( $id ) {
				$this->api->delete_webhook( $id );
			}
		}

		// Store tokens and credentials.
		unset( $settings[ $environment ] );
		$this->update_plugin_settings( $settings );

		// Delete the seller info cache.
		delete_transient( 'gform_ppcp_seller_info_' . $environment );

		// Return success response.
		wp_send_json_success();
	}

	/**
	 * Check if the form has an active PayPal Commerce Platform feed.
	 *
	 * @since  1.0
	 *
	 * @param array $form The form currently being processed.
	 *
	 * @return bool If the script should be enqueued.
	 */
	public function frontend_script_callback( $form ) {

		if ( is_admin() ) {
			if ( $this->is_app_settings( $this->_slug ) ) {
				return true;
			}
		} else {
			return $form && $this->has_feed( $form['id'] ) && $this->initialize_api();
		}

	}

	/**
	 * Remove the version from the PayPal JS SDK src (or the JS cannot be loaded).
	 *
	 * @since 1.0
	 *
	 * @param string $src    The JS script SRC.
	 * @param string $handle The script handle.
	 *
	 * @return string
	 */
	public function remove_args( $src, $handle ) {
		if ( strpos( $handle, 'gform_paypal_sdk' ) === 0 ) {
			$src = remove_query_arg( 'ver', $src );
		}

		return $src;
	}

	/**
	 * Add custom data to the PayPal Javascript SDK script tag.
	 *
	 * @since 1.0
	 *
	 * @param string $tag    The HTML tag.
	 * @param string $handle The script handle.
	 *
	 * @return string
	 */
	public function add_custom_data( $tag, $handle ) {
		if ( $handle === 'gform_paypal_sdk' ) {
			if ( ! $this->initialize_api() ) {
				return $tag;
			}

			$response = $this->api->generate_token();
			if ( is_wp_error( $response ) ) {
				wp_send_json_error( array( 'message' => $response->get_error_message() ) );

				return $tag;
			}

			$client_token = rgar( $response, 'client_token' );

			$tag = preg_replace( "/(src=\'.*\')/", "$1 data-client-token='$client_token' data-partner-attribution-id='RocketGenius_PCP' data-identifier='gform_ppcp_js_sdk'", $tag );
		}

		return $tag;
	}





	// # FEED SETTINGS -------------------------------------------------------------------------------------------------

	/**
	 * Enable feed creation.
	 *
	 * @since  1.0
	 *
	 * @return bool
	 */
	public function can_create_feed() {

		return $this->initialize_api() && $this->has_paypal_field();

	}

	/**
	 * If enable feed duplication.
	 *
	 * @since  1.0
	 *
	 * @param int|array $id The ID of the feed to be duplicated or the feed object when duplicating a form.
	 *
	 * @return bool
	 */
	public function can_duplicate_feed( $id ) {

		return false;

	}

	/**
	 * Get the require PayPal field message.
	 *
	 * @since 1.0.
	 *
	 * @return false|string
	 */
	public function feed_list_message() {
		if ( ! $this->has_paypal_field() ) {
			return $this->requires_paypal_field_message();
		}

		return GFFeedAddOn::feed_list_message();
	}

	/**
	 * Display the requiring PayPal field message.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function requires_paypal_field_message() {
		$url = add_query_arg( array( 'view' => null, 'subview' => null ) );

		return sprintf( esc_html__( "You must add a PayPal field to your form before creating a feed. Let's go %sadd one%s!", 'gravityformsppcp' ), "<a href='" . esc_url( $url ) . "'>", '</a>' );
	}

	/**
	 * Define feed settings fields.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function feed_settings_fields() {
		$default_settings = parent::feed_settings_fields();

		// Remove Subscription.
		$transaction_type = parent::get_field( 'transactionType', $default_settings );
		$choices          = $transaction_type['choices'];
		foreach ( $choices as $key => $choice ) {
			if ( $choice['value'] === 'subscription' ) {
				unset( $choices[ $key ] );
			}
		}
		$transaction_type['choices'] = $choices;
		$default_settings            = $this->replace_field( 'transactionType', $transaction_type, $default_settings );

		// Adding the name mapping.
		$billing_info = parent::get_field( 'billingInformation', $default_settings );
		array_unshift(
			$billing_info['field_map'],
			array(
				'name'     => 'first_name',
				'label'    => esc_html__( 'First Name', 'gravityformsppcp' ),
				'required' => false,

			),
			array(
				'name'     => 'last_name',
				'label'    => esc_html__( 'Last Name', 'gravityformsppcp' ),
				'required' => false,

			)
		);
		$default_settings = parent::replace_field( 'billingInformation', $billing_info, $default_settings );

		return $default_settings;
	}

	/**
	 * Options for the PayPal Commerce Platform feed.
	 *
	 * @since 1.0
	 *
	 * @return array
	 */
	public function option_choices() {

		return array(
			array(
				'label' => esc_html__( 'Do not prompt buyer to include a shipping address.', 'gravityformsppcp' ),
				'name'  => 'no_shipping',
				'value' => 1,
			),
		);
	}





	// # FORM SETTINGS -------------------------------------------------------------------------------------------------

	/**
	 * Add supported notification events.
	 *
	 * @since  1.0
	 *
	 * @param array $form The form currently being processed.
	 *
	 * @return array|false The supported notification events. False if feed cannot be found within $form.
	 */
	public function supported_notification_events( $form ) {

		// If this form does not have a Stripe feed, return false.
		if ( ! $this->has_feed( $form['id'] ) ) {
			return false;
		}

		// Return Stripe notification events.
		return array(
			'complete_payment'    => esc_html__( 'Payment Completed', 'gravityformsppcp' ),
			'refund_payment'      => esc_html__( 'Payment Refunded', 'gravityformsppcp' ),
			'fail_payment'        => esc_html__( 'Payment Failed', 'gravityformsppcp' ),
			'add_pending_payment' => esc_html__( 'Payment Pending', 'gravityformsppcp' ),
			'void_authorization'  => esc_html__( 'Authorization Voided', 'gravityformsppcp' ),
		);

	}





	// # TRANSACTIONS --------------------------------------------------------------------------------------------------

	/**
	 * Initialize authorizing the transaction for the Product & Services type feed or return authorization error.
	 *
	 * @since  1.0
	 *
	 * @param array $feed            The Feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form            The Form object currently being processed.
	 * @param array $entry           The Entry object currently being processed.
	 *
	 * @return array
	 */
	public function authorize( $feed, $submission_data, $form, $entry ) {

		// Authorize product.
		return $this->authorize_product( $feed, $submission_data, $form, $entry );

	}

	/**
	 * Create the Gravity Forms PayPal Commerce Platform sale authorization and return any authorization errors which occur.
	 *
	 * @since  1.0
	 *
	 * @param array $feed            The Feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form            The Form object currently being processed.
	 * @param array $entry           The Entry object currently being processed.
	 *
	 * @return array
	 */
	public function authorize_product( $feed, $submission_data, $form, $entry ) {
		if ( ! $this->initialize_api() ) {
			return $this->authorization_error( esc_html__( 'Failed to initialize the API. Cannot authorize the payment.', 'gravityformsppcp' ) );
		}

		$order_id = sanitize_text_field( rgpost( 'ppcp_order_id' ) );

		// Throw an error if no order id available.
		if ( empty( $order_id ) && $submission_data['payment_amount'] > 0 ) {
			$this->log_error( __METHOD__ . '(): No order ID available, cannot create a new payment.' );

			return $this->authorization_error( esc_html__( 'No order ID available, cannot create a new payment.', 'gravityformsppcp' ) );
		}

		// Check if there're error for this order.
		$order = $this->api->get_order( $order_id );
		if ( is_wp_error( $order ) ) {
			$this->log_error( __METHOD__ . '(): ' . $order->get_error_message() );

			return $this->authorization_error( $order->get_error_message() );
		}

		$payment_amount = GFCommon::to_number( rgar( $submission_data, 'payment_amount' ), $entry['currency'] );
		// PayPal API returns a string so turning it to a number.
		$order_total = GFCommon::to_number( rgars( $order, 'purchase_units/0/amount/value' ), $entry['currency'] );
		// Validate if the order total equals to the entry payment amount.
		if ( $order_total !== $payment_amount ) {
			$error = esc_html__( 'The order total from PayPal does not match the payment amount of the submission.', 'gravityformsppcp' );

			$this->log_error( __METHOD__ . '(): ' . $error . ' Payment Amount is: ' . $payment_amount . ' Order details => ' . print_r( $order, true ) );

			return $this->authorization_error( $error );
		}

		// Authorize order if the intent is set to AUTHORIZE.
		if ( $this->get_intent( $form['id'], $feed['id'] ) === 'authorize' ) {
			// Authorize payment for order.
			$authorize = $this->api->authorize( $order_id );
			if ( is_wp_error( $authorize ) ) {
				$this->log_error( __METHOD__ . '(): ' . $authorize->get_error_message() );

				return $this->authorization_error( $this->add_paypal_debug_id( esc_html__( 'Failed to authorize the payment.', 'gravityformsppcp' ), $authorize ) );
			}

			// Return error if the order status is not completed.
			if ( rgar( $authorize, 'status' ) !== 'COMPLETED' ) {
				$this->log_error( __METHOD__ . '(): Cannot authorize the payment; order details => ' . print_r( $authorize, true ) );

				$error = sprintf( esc_html__( 'Cannot authorize the payment. The order status: %s.', 'gravityformsppcp' ), rgar( $authorize, 'status' ) );
				$error = $this->add_paypal_debug_id( $error, $authorize );

				return $this->authorization_error( $error );
			}

			return array(
				'is_authorized'  => true,
				'transaction_id' => rgars( $authorize, 'purchase_units/0/payments/authorizations/0/id' ),
			);
		}

		return array(
			'is_authorized' => true,
		);

	}

	/**
	 * Gets the payment validation result.
	 *
	 * @since  1.0
	 *
	 * @param array $validation_result    Contains the form validation results.
	 * @param array $authorization_result Contains the form authorization results.
	 *
	 * @return array The validation result for the credit card field.
	 */
	public function get_validation_result( $validation_result, $authorization_result ) {
		if ( empty( $authorization_result['error_message'] ) ) {
			return $validation_result;
		}

		$credit_card_page   = 0;
		$has_error_cc_field = false;
		foreach ( $validation_result['form']['fields'] as &$field ) {
			if ( $field->type === 'paypal' && rgpost( 'input_' . $field->id . '_6' ) === 'Credit Card' ) {
				$has_error_cc_field        = true;
				$field->failed_validation  = true;
				$field->validation_message = $authorization_result['error_message'];
				$credit_card_page          = $field->pageNumber;
				break;
			}
		}

		if ( ! $has_error_cc_field ) {
			$credit_card_page = GFFormDisplay::get_max_page_number( $validation_result['form'] );
			add_filter( 'gform_validation_message', array( $this, 'paypal_checkout_error_message' ) );
		}

		$validation_result['credit_card_page'] = $credit_card_page;
		$validation_result['is_valid']         = false;

		return $validation_result;
	}

	/**
	 * Capture the Gravity Forms PayPal Commerce Platform charge which was authorized during validation.
	 *
	 * @since  1.0
	 *
	 * @param array $auth            Contains the result of the authorize() function.
	 * @param array $feed            The Feed object currently being processed.
	 * @param array $submission_data The customer and transaction data.
	 * @param array $form            The Form object currently being processed.
	 * @param array $entry           The Entry object currently being processed.
	 *
	 * @return array
	 */
	public function capture( $auth, $feed, $submission_data, $form, $entry ) {
		// Do not capture if the payment intent is AUTHORIZE.
		if ( $this->get_intent( $form['id'], $feed['id'] ) === 'authorize' ) {
			return array();
		}

		$order_id = sanitize_text_field( rgpost( 'ppcp_order_id' ) );

		// Add entry id to the order.
		$response = $this->api->update_order( $order_id, 'add', 'custom_id', $entry['id'] );
		if ( is_wp_error( $response ) ) {
			$this->log_error( __METHOD__ . '(): ' . $response->get_error_message() );

			$error = $this->add_paypal_debug_id( esc_html__( 'Cannot add entry ID to the custom id in the order.', 'gravityformsppcp' ), $response );

			return array(
				'is_success'    => false,
				'error_message' => $error,
			);
		}

		// Capture order.
		$order = $this->api->capture( $order_id );
		if ( is_wp_error( $order ) ) {
			$this->log_error( __METHOD__ . '(): ' . $order->get_error_message() );

			$error = $this->add_paypal_debug_id( esc_html__( 'Cannot capture the payment.', 'gravityformsppcp' ), $order );

			return array(
				'is_success'    => false,
				'error_message' => $error,
			);
		}

		// Return error if the order status is not completed.
		if ( rgar( $order, 'status' ) !== 'COMPLETED' ) {
			$this->log_debug( __METHOD__ . '(): Cannot capture the payment; order details => ' . print_r( $order, true ) );

			$error = sprintf( esc_html__( 'Cannot capture the payment. The order status: %s.', 'gravityformsppcp' ), rgar( $order, 'status' ) );
			if ( rgar( $order, 'status' ) === 'PENDING' ) {
				$error .= sprintf( esc_html__( ' Reason code: %s.', 'gravityformsppcp' ), rgar( $order, 'reason_code' ) );
			}
			$error = $this->add_paypal_debug_id( $error, $order );

			if ( rgar( $order, 'status' ) === 'PENDING' ) {
				$this->log_debug( __METHOD__ . '(): ' . $error );

				// Mark the payment status as Pending.
				GFAPI::update_entry_property( $entry['id'], 'payment_status', 'Pending' );
				GFAPI::update_entry_property( $entry['id'], 'payment_method', 'PayPal' );
				// Store the order data for later use.
				gform_update_meta( $entry['id'], 'order_data', $order );

				return array();
			} else {
				return array(
					'is_success'    => false,
					'error_message' => $error,
				);
			}
		}

		return array(
			'is_success'     => true,
			'transaction_id' => rgars( $order, 'purchase_units/0/payments/captures/0/id' ),
			'amount'         => rgars( $order, 'purchase_units/0/payments/captures/0/amount/value' ),
			'payment_method' => ( rgpost( 'ppcp_credit_card_type' ) ) ? rgpost( 'ppcp_credit_card_type' ) : 'PayPal',
		);

	}

	/**
	 * Complete authorization (mark entry as pending and create note) for the pending orders.
	 *
	 * @since 1.0
	 *
	 * @param array $entry  Entry data.
	 * @param array $action Authorization data.
	 *
	 * @return bool
	 */
	public function complete_authorization( &$entry, $action ) {
		if ( rgar( $entry, 'payment_status' ) === 'Pending' ) {
			$order                    = gform_get_meta( $entry['id'], 'order_data' );
			$action['amount']         = rgars( $order, 'purchase_units/0/payments/captures/0/amount/value' );
			$action['transaction_id'] = rgars( $order, 'purchase_units/0/payments/captures/0/id' );

			$this->add_pending_payment( $entry, $action );

			return true;
		}

		return parent::complete_authorization( $entry, $action );
	}





	// # WEBHOOKS ------------------------------------------------------------------------------------------------------

	/**
	 * If the PayPal Commerce Platform webhook belongs to a valid entry process the raw response into a standard Gravity Forms $action.
	 *
	 * @since  1.0
	 *
	 * @return array|bool|WP_Error Return a valid GF $action or if the webhook can't be processed a WP_Error object or false.
	 */
	public function callback() {
		$event = $this->get_webhook_event();

		if ( ! $event || is_wp_error( $event ) ) {
			return $event;
		}

		$this->log_webhook_event_details( $event );

		$entry  = GFAPI::get_entry( $this->derive_entry_id_from_webhook_event( $event ) );
		$action = $this->prepare_callback_action( $entry, $event );

		if ( has_filter( 'gform_ppcp_webhook' ) ) {
			$this->log_debug( __METHOD__ . '(): Executing functions hooked to gform_ppcp_webhook.' );

			/**
			 * Enable support for custom webhook events.
			 *
			 * @param array $action An associative array containing the event details.
			 * @param array $event The PayPal event object for the webhook which was received.
			 *
			 * @since 1.0
			 */
			$action = apply_filters( 'gform_ppcp_webhook', $action, $event );
		}

		if ( rgempty( 'entry_id', $action ) ) {
			$this->log_debug( __METHOD__ . '() entry_id not set for callback action; no further processing required.' );

			return is_wp_error( $entry )
				? $this->get_entry_not_found_wp_error( 'transaction', array( 'id' => $event['id'] ), $event )
				: false;
		}

		return $action;
	}

	/**
	 * Prepare the callback action for processing by the payment add-on framework.
	 *
	 * @param array|WP_Error $entry The entry located for the transaction.
	 * @param array          $event The webhook event.
	 *
	 * @since 1.5
	 *
	 * @return array
	 */
	private function prepare_callback_action( $entry, $event ) {
		if ( is_wp_error( $entry ) ) {
			return array(
				'id'             => $event['id'],
				'entry_id'       => '',
				'transaction_id' => '',
			);
		}

		$action = array(
			'id'             => $event['id'],
			'entry_id'       => $entry['id'],
			'transaction_id' => $entry['transaction_id'],
		);

		switch ( $event['event_type'] ) {
			case 'PAYMENT.CAPTURE.REFUNDED':
				$action['type']   = 'refund_payment';
				$action['amount'] = $this->get_amount_import( rgars( $event, 'resource/seller_payable_breakdown/total_refunded_amount/value' ), $entry['currency'] );

				break;
			case 'PAYMENT.AUTHORIZATION.VOIDED':
				$action['type'] = 'void_authorization';

				break;
			case 'PAYMENT.CAPTURE.COMPLETED':
				$payment_status = rgar( $entry, 'payment_status' );
				if ( $payment_status === 'Authorized' ) {
					$action['type']   = 'complete_payment';
					$action['amount'] = $this->get_amount_import( rgars( $event, 'resource/amount/value' ), $entry['currency'] );
				}

				break;
			case 'PAYMENT.CAPTURE.DENIED':
				$payment_status = rgar( $entry, 'payment_status' );
				if ( $payment_status === 'Authorized' ) {
					$action['type']   = 'fail_payment';
					$action['amount'] = $this->get_amount_import( rgars( $event, 'resource/amount/value' ), $entry['currency'] );
				}

				break;
		}

		return $action;
	}

	/**
	 * Log the webhook event details.
	 *
	 * @since 1.5
	 *
	 * @param array $event The webhook event.
	 */
	private function log_webhook_event_details( $event ) {
		$log_details = array(
			'id'               => $event['id'],
			'type'             => $event['event_type'],
			'event_version'    => $event['event_version'],
			'resource_version' => $event['resource_version'],
		);

		$this->log_debug( __METHOD__ . '() Webhook log => ' . print_r( $log_details, 1 ) );
	}

	/**
	 * Derives the entry ID from the event webhook.
	 *
	 * This method checks first for the presence of a custom ID in the webhook response. If it exists, PayPal is
	 * responding to a previous request where that ID was included.
	 *
	 * Otherwise, parse the webhook event for the transaction ID and use it to query WordPress for the entry ID.
	 *
	 * @param array $event The webhook event data.
	 *
	 * @since 1.5
	 *
	 * @return string
	 */
	protected function derive_entry_id_from_webhook_event( $event ) {
		$entry_id = rgars( $event, 'resource/custom_id' );

		if ( $entry_id ) {
			return $entry_id;
		}

		$transaction_id = $this->get_transaction_id_from_webhook_event( $event );

		return $transaction_id ? $this->get_entry_by_transaction_id( $transaction_id ) : '';
	}

	/**
	 * Get the transaction ID from the webhook.
	 *
	 * Some webhook resources have IDs of the PayPal transaction itself. Others hold references
	 * to transactions and require additional parsing.
	 *
	 * @param array $event The webhook event.
	 *
	 * @return string
	 *
	 * @since 1.5
	 */
	protected function get_transaction_id_from_webhook_event( $event ) {
		if ( $this->is_transaction_resource_type( $event ) ) {
			return rgars( $event, 'resource/id' );
		}

		if ( $this->is_linked_to_transaction_resource_type( $event ) ) {
			return $this->get_transaction_id_from_linked_resource( $event );
		}

		if ( rgar( $event, 'resource_type' ) === 'checkout-order' ) {
			return rgars( $event, 'resource/purchase_units/0/payments/captures/0/id' );
		}

		return '';
	}

	/**
	 * Determine whether the event webhook is for a resource type that has an ID corresponding to a transaction.
	 *
	 * @param array $event The webhook event.
	 *
	 * @since 1.5
	 *
	 * @return bool
	 */
	private function is_transaction_resource_type( $event ) {
		return in_array( rgar( $event, 'resource_type' ), array( 'capture', 'authorization' ), true );
	}

	/**
	 * Determine whether the given webhook is linked to a resource with a transaction ID.
	 *
	 * @param array $event The webhook event.
	 *
	 * @since 1.5
	 *
	 * @return bool
	 */
	private function is_linked_to_transaction_resource_type( $event ) {
		return in_array( rgar( $event, 'resource_type', array( 'refund' ), true ) );
	}

	/**
	 * Parse the transaction ID from the uplinked reference in a given resource type.
	 *
	 * @param array $event The webhook event.
	 *
	 * @since 1.5
	 *
	 * @return string
	 */
	private function get_transaction_id_from_linked_resource( $event ) {
		$links = array_filter(
			rgars( $event, 'resource/links' ),
			function( $link ) {
				return isset( $link['rel'] ) && $link['rel'] === 'up';
			}
		);

		return ! empty( $links ) ? end( explode( '/', $links[0]['href'] ) ) : '';
	}

	/**
	 * Retrieve the PayPal Commerce Platform Webhook Event for the received webhook.
	 *
	 * @since 1.0
	 *
	 * @return false|WP_Error|array
	 */
	public function get_webhook_event() {
		if ( ! $this->initialize_api() ) {
			return new WP_Error( 'error_initialize_api', esc_html__( 'Failed to initialize the API. Cannot process the webhook.', 'gravityformsppcp' ) );
		}

		$body     = @file_get_contents( 'php://input' );
		$event    = json_decode( $body, true );
		$settings = $this->get_plugin_setting( $this->get_environment() );

		if ( empty( $event ) ) {
			return false;
		}

		$data = array(
			'transmission_id'   => $_SERVER['HTTP_PAYPAL_TRANSMISSION_ID'],
			'transmission_time' => $_SERVER['HTTP_PAYPAL_TRANSMISSION_TIME'],
			'cert_url'          => $_SERVER['HTTP_PAYPAL_CERT_URL'],
			'auth_algo'         => $_SERVER['HTTP_PAYPAL_AUTH_ALGO'],
			'transmission_sig'  => $_SERVER['HTTP_PAYPAL_TRANSMISSION_SIG'],
			'webhook_id'        => rgars( $settings, 'webhook/id' ),
			'webhook_event'     => $event,
		);

		$result = $this->api->verify_webhook( $data );
		if ( is_wp_error( $result ) ) {
			$this->log_error( __METHOD__ . '(): ' . $result->get_error_message() );

			$error = $this->add_paypal_debug_id( esc_html__( 'Cannot verify the webhook signature.', 'gravityformsppcp' ), $result );

			return new WP_Error( 'error_verify_webhook', $error );
		}

		if ( rgar( $result, 'verification_status' ) === 'SUCCESS' ) {
			return $event;
		} else {
			$this->log_error( __METHOD__ . '(): Webhook verification status is ' . rgar( $result, 'verification_status' ) );

			$error = $this->add_paypal_debug_id( esc_html__( 'Webhook verification failed.', 'gravityformsppcp' ), $result );

			return new WP_Error( 'failed_verification', $error );
		}
	}

	/**
	 * Generate the url PayPal webhooks should be sent to.
	 *
	 * @since  1.0
	 *
	 * @param int $feed_id The feed id.
	 *
	 * @return string The webhook URL.
	 */
	public function get_webhook_url( $feed_id = null ) {

		$url = home_url( '/', 'https' ) . '?callback=' . $this->_slug;

		if ( ! rgblank( $feed_id ) ) {
			$url .= '&fid=' . $feed_id;
		}

		return $url;

	}





	// # HELPER METHODS ------------------------------------------------------------------------------------------------

	/**
	 * Get API environment.
	 *
	 * @since 1.0
	 *
	 * @param array $settings The settings array.
	 *
	 * @return string
	 */
	public function get_environment( $settings = null ) {
		if ( empty( $settings ) ) {
			return $this->get_plugin_setting( 'environment' );
		}

		return rgar( $settings, 'environment' );
	}

	/**
	 * Get Gravity API URL.
	 *
	 * @since 1.0
	 *
	 * @param string $path Path.
	 *
	 * @return string
	 */
	public function get_gravity_api_url( $path = '' ) {
		return ( defined( 'GRAVITY_API_URL' ) ? GRAVITY_API_URL : 'https://gravityapi.com/wp-json/gravityapi/v1' ) . $path;
	}

	/**
	 * Get PayPal Seller Onboarding action URL.
	 *
	 * @since 1.0
	 *
	 * @param string $environment The environment.
	 *
	 * @return string
	 */
	public function get_action_url( $environment = 'live' ) {
		if ( ! is_ssl() || rgget( 'subview' ) !== 'gravityformsppcp' ) {
			return '';
		}

		$settings   = (array) $this->get_plugin_setting( $environment );
		$action_url = rgar( $settings, 'action_url' );
		$expires_in = rgar( $settings, 'expires_in' );

		if ( ! $action_url || ( $expires_in + 32300 < time() ) ) { // The partner access token expires in 32400 seconds.
			$response      = wp_remote_get(
				$this->get_gravity_api_url( '/auth/paypal' ),
				array(
					'body' => array(
						'environment' => $environment,
						'redirect_to' => $settings_url = admin_url( 'admin.php?page=gf_settings&subview=' . $this->get_slug(), 'https' ),
					),
				)
			);
			$response_body = json_decode( wp_remote_retrieve_body( $response ), true );
			if ( rgar( $response_body, 'payload' ) ) {
				$payload                         = json_decode( base64_decode( $response_body['payload'] ), true );
				$settings['action_url']          = rgar( $payload, 'action_url' );
				$settings['seller_nonce']        = rgar( $payload, 'seller_nonce' );
				$settings['partner_merchant_id'] = rgar( $payload, 'partner_merchant_id' );
				$settings['tracking_id']         = rgar( $payload, 'tracking_id' );
				$settings['expires_in']          = time();

				$plugin_settings                 = $this->get_plugin_settings();
				$plugin_settings[ $environment ] = $settings;
				$this->update_plugin_settings( $plugin_settings );
			}
		}

		return rgar( $settings, 'action_url' );
	}

	/**
	 * Check if the seller has finished the onboarding process. It will also set $api to initialize the API.
	 *
	 * @since 1.0
	 *
	 * @param string $environment The environment.
	 *
	 * @return bool|array False if there is pending account status; a seller info array if onboarded.
	 */
	public function is_seller_onboarded( $environment = null ) {
		// Initialize PayPal Commerce Platform API library.
		if ( ! class_exists( 'GF_PPCP_API' ) ) {
			require_once 'includes/class-gf-ppcp-api.php';
		}

		// Get the client credentials.
		if ( empty( $environment ) ) {
			$environment = $this->get_environment();
		}
		$settings    = $this->get_plugin_setting( $environment );
		$credentials = rgar( $settings, 'credentials' );

		// If the credentials are not set, return null.
		if ( rgblank( $credentials ) || rgempty( 'client_id', $credentials ) || rgempty( 'client_secret', $credentials ) ) {
			return false;
		}

		// Initialize a new PayPal Commerce Platform API instance.
		$ppcp = new GF_PPCP_API( $credentials, $environment );

		// Check seller account status.
		$seller = $this->get_seller_info( $environment, $ppcp );
		if ( is_wp_error( $seller ) || ! rgar( $seller, 'payments_receivable' ) || ! rgar( $seller, 'primary_email_confirmed' ) ) {
			if ( is_wp_error( $seller ) ) {
				$this->log_error( __METHOD__ . '(): We are not able to get your account status from PayPal; ' . $seller->get_error_message() );

				return false;
			} else {
				$this->log_error( __METHOD__ . '(): You cannot accept payment yet because your account status is: Payment receivable - ' . rgar( $seller, 'payments_receivable' ) . ', Email confirmed - ' . rgar( $seller, 'primary_email_confirmed' ) );

				return $seller;
			}
		}

		// Assign PayPal Commerce Platform API instance to the Add-On instance.
		$this->api = $ppcp;

		return $seller;
	}

	/**
	 * Get default button styles.
	 *
	 * @since 1.0
	 *
	 * @param string $key The key to get.
	 *
	 * @return array
	 */
	public function get_smart_payment_buttons_default( $key ) {
		$default = array(
			'layout' => 'vertical',
			'size'   => 'medium', // Use the medium size for better compatibility in general.
			'shape'  => 'rect',
			'color'  => 'gold',
		);

		return rgar( $default, $key );
	}

	/**
	 * Get Smart Payment Buttons setting choices.
	 *
	 * @since 1.0
	 *
	 * @param string $field The field name.
	 *
	 * @return array
	 */
	public function smart_payment_buttons_setting_choices( $field ) {
		$choices = array();

		switch ( $field ) {
			case 'buttonsLayout':
				$choices = array(
					array(
						'label' => esc_html__( 'Vertical', 'gravityformsppcp' ),
						'value' => 'vertical',
					),
					array(
						'label' => esc_html__( 'Horizontal', 'gravityformsppcp' ),
						'value' => 'horizontal',
					),
				);
				break;
			case 'buttonsSize':
				$choices = array(
					array(
						'label' => esc_html__( 'Responsive', 'gravityformsppcp' ),
						'value' => 'responsive',
					),
					array(
						'label' => esc_html__( 'Large', 'gravityformsppcp' ),
						'value' => 'large',
					),
					array(
						'label' => esc_html__( 'Medium', 'gravityformsppcp' ),
						'value' => 'medium',
					),
					array(
						'label' => esc_html__( 'Small', 'gravityformsppcp' ),
						'value' => 'small',
					),
				);
				break;
			case 'buttonsShape':
				$choices = array(
					array(
						'label' => esc_html__( 'Rectangle', 'gravityformsppcp' ),
						'value' => 'rect',
					),
					array(
						'label' => esc_html__( 'Pill', 'gravityformsppcp' ),
						'value' => 'pill',
					),
				);
				break;
			case 'buttonsColor':
				$choices = array(
					array(
						'label' => esc_html__( 'Gold', 'gravityformsppcp' ),
						'value' => 'gold',
					),
					array(
						'label' => esc_html__( 'Blue', 'gravityformsppcp' ),
						'value' => 'blue',
					),
					array(
						'label' => esc_html__( 'Silver', 'gravityformsppcp' ),
						'value' => 'silver',
					),
					array(
						'label' => esc_html__( 'White', 'gravityformsppcp' ),
						'value' => 'white',
					),
					array(
						'label' => esc_html__( 'Black', 'gravityformsppcp' ),
						'value' => 'black',
					),
				);
				break;
		}

		return $choices;
	}

	/**
	 * Add Smart Payment Buttons.
	 *
	 * @since 1.0
	 *
	 * @param string $button The Submit button HTML.
	 * @param array  $form   The form object.
	 *
	 * @return string
	 */
	public function add_smart_payment_buttons( $button, $form ) {
		if ( ! $this->has_feed( $form['id'] ) ) {
			return $button;
		}

		$cc_field = $this->get_paypal_field( $form );
		if ( $cc_field ) {
			$size = rgar( $cc_field, 'buttonsSize' );
		} else {
			$size = $this->get_smart_payment_buttons_default( 'size' );
		}

		$button .= '<div id="gform_ppcp_smart_payment_buttons" class="' . $size . '"></div>';

		return $button;
	}

	/**
	 * Add required PayPal Commerce Platform inputs to form.
	 *
	 * @since 1.0
	 *
	 * @param string $content The form content to be filtered.
	 * @param array  $form    The current Form object.
	 *
	 * @return string $content HTML formatted content.
	 */
	public function add_ppcp_inputs( $content, $form ) {

		if ( ! $this->has_feed( $form['id'] ) ) {
			return $content;
		}

		// If the last four credit card digits are provided by PayPal Commerce Platform, populate it to a hidden field.
		if ( rgpost( 'ppcp_order_id' ) ) {
			$content .= '<input type="hidden" name="ppcp_order_id" id="gf_ppcp_order_id" value="' . esc_attr( rgpost( 'ppcp_order_id' ) ) . '" />';
		}

		// If the  credit card type is provided by Stripe, populate it to a hidden field.
		if ( rgpost( 'ppcp_credit_card_type' ) ) {
			$content .= '<input type="hidden" name="ppcp_credit_card_type" id="ppcp_credit_card_type" value="' . esc_attr( rgpost( 'ppcp_credit_card_type' ) ) . '" />';
		}

		if ( $this->frontend_script_callback( $form ) ) {
			$content .= '<div id="payments-sdk__contingency-lightbox"></div>';
		}

		return $content;

	}

	/**
	 * Populate the $_POST with the card type.
	 *
	 * @since 1.0
	 *
	 * @param array $form Form object.
	 */
	public function populate_credit_card_fields( $form ) {
		if ( ! $this->is_payment_gateway || ! $this->has_paypal_field( $form ) ) {
			return;
		}

		if ( $this->has_paypal_field( $form ) ) {
			$cc_field = $this->get_paypal_field( $form );
			$methods  = rgar( $cc_field, 'methods' );

			if ( in_array( 'Credit Card', $methods, true ) && $_POST[ 'input_' . $cc_field->id . '_6' ] === 'Credit Card' ) {
				$_POST[ 'input_' . $cc_field->id . '_4' ] = rgpost( 'ppcp_credit_card_type' );
			} else {
				$_POST[ 'input_' . $cc_field->id . '_4' ] = esc_html__( 'PayPal Checkout', 'gravityformsppcp' );
			}
		}
	}

	/**
	 * Add credit card warning CSS class for the PayPal field.
	 *
	 * @since 1.0
	 *
	 * @param string   $css_class CSS classes.
	 * @param GF_Field $field Field object.
	 * @param array    $form Form array.
	 *
	 * @return string
	 */
	public function paypal_field_css_class( $css_class, $field, $form ) {
		if ( GFFormsModel::get_input_type( $field ) === 'paypal' ) {
			$css_class .= ' gform_ppcp_custom_card_fields';

			if ( $this->is_custom_card_fields_supported() && ! GFCommon::is_ssl() ) {
				$css_class .= ' gfield_creditcard_warning';
			}
		}

		return $css_class;
	}

	/**
	 * The helper function to include PayPal Debug ID into the error message.
	 *
	 * @since 1.0
	 *
	 * @param string         $message The default error message.
	 * @param WP_Error|array $object  The WP Error object or API response.
	 *
	 * @return string
	 */
	public function add_paypal_debug_id( $message, $object ) {
		if ( is_wp_error( $object ) ) {
			$error_data = $object->get_error_data();
			$debug_id   = rgar( $error_data, 'PayPal-Debug-Id' ) ? $error_data['PayPal-Debug-Id'] : $error_data;
		} else {
			$debug_id = rgar( $object, 'PayPal-Debug-Id' );
		}

		if ( is_string( $debug_id ) ) {
			$message .= sprintf( esc_html__( ' PayPal Debug ID: %s', 'gravityformsppcp' ), $debug_id );
		}

		return $message;
	}

	/**
	 * Get the WP_Error to be returned when the entry is not found.
	 *
	 * @since 1.0
	 *
	 * @param string $type   The type to be included in the error message and when getting the id: transaction or subscription.
	 * @param array  $action An associative array containing the event details.
	 * @param array  $event  The PayPal Commerce Platform event object for the webhook which was received.
	 *
	 * @return WP_Error
	 */
	public function get_entry_not_found_wp_error( $type, $action, $event ) {
		$message     = sprintf( __( 'Entry for %s id: %s was not found. Webhook cannot be processed.', 'gravityformsppcp' ), $type, rgar( $action, $type . '_id' ) );
		$status_code = 200;

		/**
		 * Enables the status code for the entry not found WP_Error to be overridden.
		 *
		 * @since 1.0
		 *
		 * @param int   $status_code The status code. Default is 200.
		 * @param array $action      An associative array containing the event details.
		 * @param array $event       The PayPal Commerce Platform event object for the webhook which was received.
		 */
		$status_code = apply_filters( 'gform_ppcp_entry_not_found_status_code', $status_code, $action, $event );

		return new WP_Error( 'entry_not_found', $message, array( 'status_header' => $status_code ) );
	}

	/**
	 * Get payment intent.
	 *
	 * @since 1.0
	 *
	 * @param int|null $form_id The form ID.
	 * @param int|null $feed_id The feed ID.
	 *
	 * @return string
	 */
	public function get_intent( $form_id = null, $feed_id = null ) {
		/**
		 * Set payment intent.
		 *
		 * @since 1.0
		 * @since 1.0.2 Because of the change made in PayPal JS SDK, $feed_id is deprecated.
		 *
		 * @param string $intent  The payment intent. Can be 'capture' or 'authorize'.
		 * @param int    $form_id The form ID.
		 * @param int    $feed_id The feed ID.
		 */
		return apply_filters( 'gform_ppcp_intent', 'capture', intval( $form_id ), intval( $feed_id ) );
	}

	/**
	 * Turn country into two digits for PayPal Commerce Platform.
	 *
	 * @since 1.0
	 */
	public function ajax_get_country_code() {
		check_ajax_referer( 'gf_ppcp_on_approve_nonce', 'nonce' );

		$feed            = $this->get_feed( intval( rgpost( 'feed_id' ) ) );
		$billing_country = rgars( $feed, 'meta/billingInformation_country' );
		$country         = sanitize_text_field( rgpost( 'country' ) );
		$code            = $country;

		if ( ! empty( $billing_country ) && strlen( $country ) > 2 ) {
			$code = GF_Fields::get( 'address' )->get_country_code( $country );
		}

		wp_send_json_success( array( 'code' => $code ) );
	}

	/**
	 * Get the order data.
	 *
	 * @since 1.0
	 */
	public function ajax_get_order_data() {
		check_ajax_referer( 'gf_ppcp_create_order_nonce', 'nonce' );

		$feed    = $this->get_feed( rgpost( 'feed_id' ) );
		$form_id = absint( rgpost( 'form_id' ) );

		$data = array();
		parse_str( rgpost( 'data' ), $data );
		$_POST = $data;
		// Add this to make sure `get_input_value_submission()` in field classes would treat this as a real submission,
		// or fields hidden by conditional logic cannot be included in this temp lead.
		$_POST['is_submit_' . $form_id] = 1;

		$form                 = GFAPI::get_form( $form_id );
		$form_meta            = GFFormsModel::get_form_meta( $form_id );
		$temp_lead            = GFFormsModel::create_lead( $form_meta );
		$temp_submission_data = $this->get_order_data( $feed, $form, $temp_lead );
		$line_items           = array();

		$item_total = $shipping = 0;

		foreach ( $temp_submission_data['line_items'] as $item ) {
			if ( rgar( $item, 'is_shipping' ) && $item['is_shipping'] === 1 ) {
				$shipping = $item['unit_price'] * $item['quantity'];
			} else {
				$line_items[] = array(
					'name'        => $item['name'],
					'description' => $item['description'],
					'unit_amount' => array(
						'value'         => strval( $item['unit_price'] ),
						'currency_code' => GFCommon::get_currency(),
					),
					'quantity'    => $item['quantity'],
				);

				$item_total += GFCommon::to_number( $item['unit_price'] * $item['quantity'] );
			}
		}

		wp_send_json_success( array( 'items' => $line_items, 'itemTotal' => $item_total, 'shipping' => $shipping ) );
	}

	/**
	 * Create an order in for PayPal Commerce Platform.
	 *
	 * @since 1.0
	 */
	public function ajax_create_order() {
		if ( ! $this->initialize_api() ) {
			wp_send_json_error( array( 'message' => esc_html__( 'Cannot create a new order on PayPal. If the error persists, please contact us for further assistance.', 'gravityformsppcp' ) ) );
		}

		$body = trim( file_get_contents( "php://input" ) );
		$data = json_decode( $body, true );

		if ( ! wp_verify_nonce( rgar( $data, 'nonce' ), 'gf_ppcp_create_order_nonce' ) ) {
			wp_send_json_error();
		}

		$payment_details = rgar( $data, 'data' );

		// The payment amount must > 0.
		if ( floatval( $payment_details['purchase_units'][0]['amount']['value'] ) <= 0 ) {
			wp_send_json_error( array( 'message' => esc_html__( 'The payment total must be greater than 0.', 'gravityformsppcp' ) ) );
		}

		// The intent MUST be UPPERCASE.
		$order = $this->api->create_order( array_merge( array( 'intent' => strtoupper( $this->get_intent( rgar( $data, 'form_id' ), rgar( $data, 'feed_id' ) ) ) ), $payment_details ) );

		if ( is_wp_error( $order ) ) {
			$this->log_error( __METHOD__ . '(): ' . $order->get_error_message() . '; error details => ' . print_r( $order->get_error_data(), 1 ) . '; order details: ' . print_r( $payment_details, 1 ) );

			wp_send_json_error( array( 'message' => esc_html__( 'Cannot create a new order on PayPal. If the error persists, please contact us for further assistance.', 'gravityformsppcp' ) ) );
		}

		wp_send_json_success( array( 'orderID' => $order['id'] ) );
	}

	/**
	 * Gets PayPal field object.
	 *
	 * @since 1.0
	 *
	 * @param array $form The Form object.
	 *
	 * @return bool|GF_Field The PayPal field object, if found. Otherwise, false.
	 */
	public function get_paypal_field( $form ) {
		$fields = GFFormsModel::get_fields_by_type( $form, array( 'paypal' ) );

		return empty( $fields ) ? false : $fields[0];
	}

	/**
	 * Get PayPal field for form.
	 *
	 * @since 1.0
	 *
	 * @param array $form Form object. Defaults to null.
	 *
	 * @return boolean
	 */
	public function has_paypal_field( $form = null ) {
		if ( is_null( $form ) ) {
			$form = $this->get_current_form();
		}

		return $this->get_paypal_field( $form ) !== false;
	}

	/**
	 * Display validation error message if using Smart Payment Buttons.
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function paypal_checkout_error_message() {
		$authorization_result = $this->authorization;

		$message = "<div class='validation_error'>" . esc_html__( 'There was a problem with your submission.', 'gravityformsppcp' ) . ' ' . $authorization_result['error_message'] . '</div>';

		return $message;
	}

	/**
	 * Check if Custom Card Fields is supported.
	 *
	 * @since 1.0
	 *
	 * @param array $seller The seller array.
	 *
	 * @return bool|string Return the vetting status is the product is available.
	 */
	public function is_custom_card_fields_supported( $seller = null ) {
		if ( ! $this->initialize_api() ) {
			return false;
		}

		if ( empty( $seller ) || ! is_array( $seller ) ) {
			$seller = $this->get_seller_info( $this->get_environment(), $this->api );
		}

		$products = rgar( $seller, 'products' );
		foreach ( $products as $product ) {
			if ( rgar( $product, 'name' ) === 'PPCP_CUSTOM' ) {
				return rgar( $product, 'vetting_status' );
			}
		}

		return false;
	}

	/**
	 * Filter the GF_Field_PayPal object after it is created.
	 *
	 * @since  1.0
	 *
	 * @param array $form_meta The form meta.
	 * @param bool  $is_new    Returns true if this is a new form.
	 */
	public function maybe_add_feed( $form_meta, $is_new ) {
		if ( $is_new ) {
			return;
		}

		if ( $this->has_paypal_field( $form_meta ) ) {
			$field = $this->get_paypal_field( $form_meta );

			$feeds = $this->get_feeds( $field->formId );
			// Only activate the feed if there's only one.
			if ( count( $feeds ) === 1 ) {
				if ( ! $feeds[0]['is_active'] ) {
					$this->update_feed_active( $feeds[0]['id'], 1 );
				}
			} elseif ( ! $feeds ) {
				// Add a new PayPal Commerce Platform feed.
				$name_field    = GFFormsModel::get_fields_by_type( $form_meta, array( 'name' ) );
				$email_field   = GFFormsModel::get_fields_by_type( $form_meta, array( 'email' ) );
				$address_field = GFFormsModel::get_fields_by_type( $form_meta, array( 'address' ) );

				$feed = array(
					'feedName'                                => $this->get_short_title() . ' Feed 1',
					'transactionType'                         => 'product',
					'paymentAmount'                           => 'form_total',
					'no_shipping'                             => '0',
					'feed_condition_conditional_logic'        => '0',
					'feed_condition_conditional_logic_object' => array(),
				);

				if ( ! empty( $name_field ) ) {
					$feed['billingInformation_first_name'] = $name_field[0]->id . '.3';
					$feed['billingInformation_last_name']  = $name_field[0]->id . '.6';
				}

				if ( ! empty( $email_field ) ) {
					$feed['billingInformation_email'] = $email_field[0]->id;
				}

				if ( ! empty( $address_field ) ) {
					$feed['billingInformation_address']  = $address_field[0]->id . '.1';
					$feed['billingInformation_address2'] = $address_field[0]->id . '.2';
					$feed['billingInformation_city']     = $address_field[0]->id . '.3';
					$feed['billingInformation_state']    = $address_field[0]->id . '.4';
					$feed['billingInformation_zip']      = $address_field[0]->id . '.5';
					$feed['billingInformation_country']  = $address_field[0]->id . '.6';
				}

				GFAPI::add_feed( $field->formId, $feed, $this->get_slug() );
			}
		}
	}

	/**
	 * Target of gform_before_delete_field hook. Sets relevant payment feeds to inactive when the PayPal field is deleted.
	 *
	 * @since 1.0
	 *
	 * @param int $form_id ID of the form being edited.
	 * @param int $field_id ID of the field being deleted.
	 */
	public function before_delete_field( $form_id, $field_id ) {
		parent::before_delete_field( $form_id, $field_id );

		$form = GFAPI::get_form( $form_id );
		if ( $this->has_paypal_field( $form ) ) {
			$field = $this->get_paypal_field( $form );

			if ( is_object( $field ) && $field->id == $field_id ) {
				$feeds = $this->get_feeds( $form_id );
				foreach ( $feeds as $feed ) {
					if ( $feed['is_active'] ) {
						$this->update_feed_active( $feed['id'], 0 );
					}
				}
			}
		}
	}

	/**
	 * Get disabled funding sources.
	 *
	 * @since 1.0
	 *
	 * @param array $disabled_funding The disabled funding sources.
	 *
	 * @return string
	 */
	public static function get_disable_funding( $disabled_funding = array() ) {
		/**
		 * Get disabled funding sources.
		 *
		 * @since 1.0
		 *
		 * @param array $funding The disabled funding sources.
		 *
		 * @return array
		 */
		return implode( ',', apply_filters( 'gform_ppcp_disable_funding', $disabled_funding ) );
	}

	/**
	 * Get seller info.
	 *
	 * @since 1.0
	 *
	 * @param string      $environment The environment.
	 * @param GF_PPCP_API $ppcp        The API classe.
	 *
	 * @return array
	 */
	private function get_seller_info( $environment, $ppcp ) {
		$settings = $this->get_plugin_setting( $environment );

		// Get seller from cache first.
		if ( false !== $seller = get_transient( 'gform_ppcp_seller_info_' . $environment ) ) {
			// If it's not in the current environment, there may not be the seller_onboarded mark for it, return the cache directly.
			if ( rgar( $settings, 'seller_onboarded' ) || ( $environment !== $this->get_environment() && ! rgar( $settings, 'seller_onboarded' ) ) ) {
				return $seller;
			}
		}

		$seller = $ppcp->get_seller_info( rgar( $settings, 'partner_merchant_id' ), rgar( $settings, 'merchant_id' ) );

		if ( rgar( $settings, 'seller_onboarded' ) ) {
			set_transient( 'gform_ppcp_seller_info_' . $environment, $seller, 60 * 60 * 24 );
		}

		return $seller;
	}

}
