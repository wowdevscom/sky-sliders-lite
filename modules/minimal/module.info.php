<?php

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

return [
	'title'              => esc_html__( 'Minimal', 'sky-sliders-lite'),
	'required'           => true,
	'default_activation' => true,
	'has_script'         => true,
];
