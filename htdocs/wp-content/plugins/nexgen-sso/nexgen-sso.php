<?php
/**
 * Plugin Name: Nexgen SSO
 * Description: Single Sign-On integration with NexgenWebz.
 * Version: 1.1
 * Author: Shubham
 * Text Domain: nexgen-sso
 */

// Prevent direct access
if ( ! defined( 'WPINC' ) ) {
    die;
}

// Register REST route for SSO login
add_action( 'rest_api_init', function () {
    register_rest_route( 'nexgen-sso/v1', '/login', [
        'methods'             => 'GET',
        'callback'            => 'nexgen_sso_login_callback',
        'permission_callback' => '__return_true',
        'args'                => [
            'token' => [
                'required'          => true,
                'sanitize_callback' => 'sanitize_text_field',
                'validate_callback' => function( $param ) {
                    return is_string( $param ) && ! empty( $param );
                },
            ],
        ],
    ] );
} );

/**
 * Handle the SSO login callback and redirect.
 *
 * @param WP_REST_Request $request
 */
function nexgen_sso_login_callback( WP_REST_Request $request ) {
    $token = $request->get_param( 'token' );

    // TODO: Validate token and map to a user ID
    $user_id = 1;

    // Log in the user
    wp_set_auth_cookie( $user_id, true );

    // Redirect to dashboard
    wp_redirect( admin_url() );
    exit;
}
