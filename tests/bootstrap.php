<?php

$_SERVER['SERVER_PROTOCOL'] = 'HTTP/1.1';
$_SERVER['SERVER_NAME']     = '';
$PHP_SELF                   = $GLOBALS['PHP_SELF'] = $_SERVER['PHP_SELF'] = '/index.php';

define( 'GIVE_USE_PHP_SESSIONS', false );

$_tests_dir = getenv( 'WP_TESTS_DIR' );
if ( ! $_tests_dir ) {
	$_tests_dir = '/tmp/wordpress-tests-lib';
}

require_once $_tests_dir . '/includes/functions.php';

function _manually_load_plugin() {
	require dirname( __FILE__ ) . '/../give.php';
}

tests_add_filter( 'muplugins_loaded', '_manually_load_plugin' );

require $_tests_dir . '/includes/bootstrap.php';

activate_plugin( 'give/give.php' );

echo "Installing Give...\n";

// Install Give
give_install();

global $current_user, $give_options;

$give_options = get_option( 'give_settings' );

$current_user = new WP_User( 1 );
$current_user->set_role( 'administrator' );

// Include helpers
require_once 'helpers/shims.php';
require_once 'helpers/class-helper-form.php';
require_once 'helpers/class-helper-payment.php';