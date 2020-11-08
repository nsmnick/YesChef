<?php

defined( 'ABSPATH' ) || die();

/**
 * Gravity Forms PayPal Commerce Platform API Library.
 *
 * @since     1.0
 * @package   GravityForms
 * @author    Rocketgenius
 * @copyright Copyright (c) 2020, Rocketgenius
 */
class GF_PPCP_API {

	/**
	 * PayPal Commerce Platform API key.
	 *
	 * @since  1.0
	 *
	 * @var    array $credentials PayPal Commerce Platform API credentials.
	 */
	protected $credentials;

	/**
	 * PayPal Commerce Platform API URL.
	 *
	 * @since  1.0
	 *
	 * @var    string $api_url PayPal Commerce Platform API URL.
	 */
	protected $api_url = 'https://api.paypal.com/';

	/**
	 * PayPal Commerce Platform environment.
	 *
	 * @since  1.0
	 * @access protected
	 * @var    string $environment PayPal Commerce Platform environment.
	 */
	protected $environment;

	/**
	 * Initialize PayPal Commerce Platform API library.
	 *
	 * @since 1.0
	 *
	 * @param array|null $credentials PayPal Commerce Platform API credentials.
	 * @param string     $environment PayPal Commerce Platform environment.
	 */
	public function __construct( $credentials = null, $environment = 'sandbox' ) {

		$this->credentials = $credentials;
		$this->environment = $environment;

		if ( $this->environment === 'sandbox' ) {
			$this->api_url = 'https://api.sandbox.paypal.com/';
		}

	}

	/**
	 * Make API request.
	 *
	 * @since  1.0
	 *
	 * @param string $action        Request action.
	 * @param array  $options       Request options.
	 * @param string $method        HTTP method. Defaults to GET.
	 * @param int    $response_code Expected HTTP response code. Defaults to 200.
	 *
	 * @return array|string|WP_Error
	 */
	private function make_request( $action, $options = array(), $method = 'GET', $response_code = 200 ) {

		// Prepare request URL.
		$request_url = $this->api_url . $action;

		// Default headers.
		$headers = array(
			'Content-Type'                  => 'application/json',
			'PayPal-Partner-Attribution-Id' => 'RocketGenius_PCP',
		);

		// Add Authorization header if credentials are set.
		if ( ! empty( $this->credentials ) ) {
			$headers['Authorization'] = 'Basic ' . base64_encode( rgar( $this->credentials, 'client_id' ) . ':' . rgar( $this->credentials, 'client_secret' ) );
		}

		// Get body and headers if set in $options.
		$headers = rgar( $options, 'headers' ) ? wp_parse_args( $options['headers'], $headers ) : $headers;
		$body    = rgar( $options, 'body' ) ? $options['body'] : $options;

		// Add query parameters.
		if ( 'GET' === $method ) {
			$request_url = add_query_arg( $options, $request_url );
		}

		// Build request arguments.
		$args = array(
			'method'    => $method,
			'headers'   => $headers,
			/**
			 * Filters if SSL verification should occur.
			 *
			 * @since 1.0
			 *
			 * @param bool false If the SSL certificate should be verified. Defalts to false.
			 *
			 * @return bool
			 */
			'sslverify' => apply_filters( 'https_local_ssl_verify', false ),
			/**
			 * Sets the HTTP timeout, in seconds, for the request.
			 *
			 * @since 1.0
			 *
			 * @param int    30           The timeout limit, in seconds. Defaults to 30.
			 * @param string $request_url The request URL.
			 *
			 * @return int
			 */
			'timeout'   => apply_filters( 'http_request_timeout', 30, $request_url ),
		);

		// Add body to non-GET requests.
		if ( 'GET' !== $method && ! empty( $body ) ) {
			$args['body'] = ( $args['headers']['Content-Type'] === 'application/json' ) ? json_encode( $body ) : $body;
		}

		// Execute API request.
		$result = wp_remote_request( $request_url, $args );

		// If API request returns a WordPress error, return.
		if ( is_wp_error( $result ) ) {
			return $result;
		}

		// Convert JSON response to array.
		$result_body = wp_remote_retrieve_body( $result );
		if ( ! empty( $result_body ) ) {
			$result_body = gf_ppcp()->maybe_decode_json( $result_body );
		} else {
			$result_body = array();
		}
		$debug_id                       = wp_remote_retrieve_header( $result, 'Paypal-Debug-Id' );
		$result_body['PayPal-Debug-Id'] = $debug_id;

		// If result response code is not the expected response code, return error.
		if ( wp_remote_retrieve_response_code( $result ) !== $response_code ) {
			// Use the error description in the body if available (it's usually more human readable messages).
			$error = rgar( $result_body, 'message' ) ? $result_body['message'] : wp_remote_retrieve_response_message( $result );
			// Add the debug ID to the error message.
			$error .= '; PayPal Debug ID: ' . $debug_id;

			// Add the debug ID as the WP Error data, in case we won't display the error message directly
			// (messages displayed in UI needs to be translatable).
			$error_data = rgar( $result_body, 'details' ) ? array_merge( $result_body['details'], array( 'PayPal-Debug-Id' => $debug_id ) ) : $debug_id;

			return new WP_Error( wp_remote_retrieve_response_code( $result ), $error, $error_data );
		}

		return $result_body;

	}

	/**
	 * Generate a client token.
	 *
	 * @since 1.0
	 */
	public function generate_token() {
		static $token;

		if ( ! isset( $token ) ) {
			$token = $this->make_request( 'v1/identity/generate-token', array(), 'POST' );
		}

		return $token;
	}

	/**
	 * Get the seller access token.
	 *
	 * @since 1.0
	 *
	 * @param array  $settings    The add-on settings.
	 * @param string $environment The environment.
	 *
	 * @return string|WP_Error
	 */
	public function get_access_token( $settings, $environment = 'sandbox' ) {
		$this->environment = $environment;

		$args = array(
			'headers' => array(
				'Authorization' => 'Basic ' . base64_encode( $settings['shared_id'] . ':' ),
				'Content-Type'  => 'application/x-www-form-urlencoded',
			),
			'body'    => array(
				'grant_type'    => 'authorization_code',
				'code'          => $settings['auth_code'],
				'code_verifier' => rgar( $settings, 'seller_nonce' ),
			),
		);

		$result = $this->make_request( 'v1/oauth2/token', $args, 'POST' );

		if ( ! is_wp_error( $result ) ) {
			return rgar( $result, 'access_token' );
		}

		return $result;
	}

	/**
	 * Get the seller's credentials.
	 *
	 * @since 1.0
	 *
	 * @param string $partner_merchant_id  The partner merchant ID.
	 * @param string $access_token         The access token of the seller.
	 * @param string $environment          The environment.
	 *
	 * @return array|WP_Error
	 */
	public function get_credentials( $partner_merchant_id, $access_token, $environment = 'sandbox' ) {
		$this->environment = $environment;

		$args = array(
			'headers' => array(
				'Authorization' => 'Bearer ' . $access_token,
			),
		);

		return $this->make_request( 'v1/customer/partners/' . $partner_merchant_id . '/merchant-integrations/credentials/', $args );
	}

	/**
	 * Create webhooks.
	 *
	 * @since 1.0
	 *
	 * @param array  $settings    The add-on settings.
	 * @param string $environment The environment.
	 *
	 * @return string|WP_Error
	 */
	public function create_webhooks( $settings, $environment = 'sandbox' ) {
		$this->environment = $environment;
		$this->credentials = $settings['credentials'];

		$args = array(
			'url'         => gf_ppcp()->get_webhook_url(),
			'event_types' => array(
				array(
					'name' => '*',
				),
			),
		);

		$result = $this->make_request( 'v1/notifications/webhooks', $args, 'POST', 201 );

		if ( ! is_wp_error( $result ) ) {
			return rgar( $result, 'id' );
		}

		return $result;
	}

	/**
	 * Verify the webhook signature.
	 *
	 * @since 1.0
	 *
	 * @param array $data The webhook notification data.
	 *
	 * @return array|WP_Error
	 */
	public function verify_webhook( $data ) {
		return $this->make_request( 'v1/notifications/verify-webhook-signature', $data, 'POST' );
	}

	/**
	 * Delete the webhook.
	 *
	 * @since 1.0
	 *
	 * @param string $id The webhook id.
	 *
	 * @return null|WP_Error
	 */
	public function delete_webhook( $id ) {
		return $this->make_request( 'v1/notifications/webhooks/' . $id, array(), 'DELETE', 204 );
	}

	/**
	 * Get seller information.
	 *
	 * @since 1.0
	 *
	 * @param string $partner_merchant_id The partner merchant ID.
	 * @param string $merchant_id         The merchant ID.
	 *
	 * @return array|string|WP_Error
	 */
	public function get_seller_info( $partner_merchant_id, $merchant_id ) {
		static $seller;

		if ( ! isset( $seller[ $this->environment ] ) ) {
			$seller[ $this->environment ] = $this->make_request( 'v1/customer/partners/' . $partner_merchant_id . '/merchant-integrations/' . $merchant_id );
		}

		return $seller[ $this->environment ];
	}

	/**
	 * Create a new order.
	 *
	 * @since 1.0
	 *
	 * @param array $data The data to create the order.
	 *
	 * @return array|string|WP_Error
	 */
	public function create_order( $data ) {
		return $this->make_request( 'v2/checkout/orders', $data, 'POST', 201 );
	}

	/**
	 * Get an order details by ID.
	 *
	 * @since 1.0
	 *
	 * @param string $order_id The order ID.
	 *
	 * @return array|WP_Error
	 */
	public function get_order( $order_id ) {
		return $this->make_request( 'v2/checkout/orders/' . $order_id );
	}

	/**
	 * Update the purchase unit in an order.
	 *
	 * @since 1.0
	 *
	 * @param string $order_id  The order ID.
	 * @param string $operation The operation, can be 'replace', 'add' or 'remove'.
	 * @param string $field     The field to be updated.
	 * @param string $value     The value to be added or updated.
	 *
	 * @return string|WP_Error
	 */
	public function update_order( $order_id, $operation, $field, $value ) {
		$args = array(
			array(
				'op'    => $operation,
				'path'  => "/purchase_units/@reference_id=='default'/{$field}",
				'value' => $value,
			),
		);

		return $this->make_request( 'v2/checkout/orders/' . $order_id, $args, 'PATCH', 204 );
	}

	/**
	 * Authorize payment for an order.
	 *
	 * @since 1.0
	 *
	 * @param string $order_id The order ID.
	 *
	 * @return array|WP_Error
	 */
	public function authorize( $order_id ) {
		return $this->make_request( 'v2/checkout/orders/' . $order_id . '/authorize', array(), 'POST', 201 );
	}

	/**
	 * Capture an order.
	 *
	 * @since 1.0
	 *
	 * @param string $order_id The order ID.
	 *
	 * @return array|WP_Error
	 */
	public function capture( $order_id ) {
		return $this->make_request( 'v2/checkout/orders/' . $order_id . '/capture', array(), 'POST', 201 );
	}
}
