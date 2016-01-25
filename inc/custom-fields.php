<?php
/**
 * Custom ACF functionality for this theme
 *
 * @package UnderBoiler
 */

// 1. customize ACF path
add_filter('acf/settings/path', 'underboiler_acf_settings_path');

function underboiler_acf_settings_path( $path ) {

    // update path
    $path = get_stylesheet_directory() . '/inc/acf/';

    // return
    return $path;

}


// 2. customize ACF dir
add_filter('acf/settings/dir', 'underboiler_acf_settings_dir');

function underboiler_acf_settings_dir( $dir ) {

    // update path
    $dir = get_stylesheet_directory_uri() . '/inc/acf/';

    // return
    return $dir;

}

// 3. Hide ACF field group menu item
add_filter('acf/settings/show_admin', '__return_false');

// 4. Include ACF
include_once( get_stylesheet_directory() . '/inc/acf/acf.php' );

// Function to set the options for the right side post type select field in the Aside post format.
function acf_aside_select_post_types( $field ) {

	// reset choices
	$field['choices'] = array();

	$args = array(
	   'public'   => true,
	   'publicly_queryable' => true
	);

	$output = 'objects'; // names or objects, note names is the default
	$operator = 'and'; // 'and' or 'or'

	$post_types = get_post_types( $args, $output, $operator );

	// loop through array and add to field 'choices'
	if( is_array($post_types) ) {

		foreach( $post_types as $post_type ) {

			$post_label = $post_type->labels;

			$field['choices'][ $post_type->name ] = $post_label->name;

		}

	}

	ksort($field['choices']);

	// return the field
	return $field;

}

add_filter('acf/load_field/name=right_side_post_type', 'acf_aside_select_post_types');

if( function_exists('acf_add_options_page') ) {
	acf_add_options_page( 'Social Links' );
}

?>
