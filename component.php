<?php
/**
 * A generic ACF Blocks render callback to handle basic block features.
 *
 * @package WP-Theme-Components
 * @subpackage render-acf-blocks-with-template-part
 * @author Cameron Jones
 * @version 1.0.0
 */

namespace WP_Theme_Components\Render_ACF_Blocks_With_Template_Part;

/**
 * Bail if accessed directly
 *
 * @since 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	die();
}

/**
 * Block Callback Function.
 *
 * @since 1.0.0
 * @param array  $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool   $is_preview True during AJAX preview.
 * @param int    $post_id The post ID this block is saved to.
 */
function render_acf_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	$path = get_template_path();
	$tag  = get_block_tag();
	$name = str_replace( '/', '-', $block['name'] );
	$attr = array(
		'class' => array(
			'wp-block-' . $name,
		),
	);

	if ( isset( $block['anchor'] ) && ! empty( $block['anchor'] ) ) {
		$attr['id'] = $block['anchor'];
	}

	if ( isset( $block['className'] ) && ! empty( $block['className'] ) ) {
		$attr['class'][] = $block['className'];
	}

	if ( isset( $block['align'] ) && ! empty( $block['align'] ) ) {
		$attr['class'][] = 'align' . $block['align'];
	}

	$atts = get_attributes( $attr, $block );

	$attr['class'] = implode( ' ', $attr['class'] );

	printf(
		'<%1$s',
		esc_attr( $tag )
	);

	foreach ( $attr as $att => $val ) {
		printf(
			' %1$s="%2$s"',
			esc_attr( $att ),
			esc_attr( $val )
		);
	}

	echo '>';

	if ( locate_template( $path . $name . '.php' ) ) {
		get_template_part( $path . $name );
	} else {
		printf(
			'Template for %1$s block not found',
			esc_html( $block['name'] )
		);
	}

	printf(
		'</%1$s>',
		esc_attr( $tag )
	);
}

/**
 * Get the path the block templates are located
 *
 * @since 1.0.0
 * @return string
 */
function get_template_path() {
	return apply_filters( 'wp_theme_components/template_path', 'template-parts/acf-blocks/' );
}

/**
 * Get the tag to wrap blocks with
 *
 * @since 1.0.0
 * @return string
 */
function get_block_tag() {
	return apply_filters( 'wp_theme_components/block_tag', 'div' );
}

/**
 * Filter the block's attributes
 *
 * @param array $attributes Array of attributes.
 * @param array $block The block settings and attributes.
 * @return array
 */
function get_attributes( $attributes, $block ) {
	return apply_filters( 'wp_theme_components/block_attributes', $attributes, $block );
}
