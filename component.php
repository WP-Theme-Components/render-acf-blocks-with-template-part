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
 * @param array $block The block settings and attributes.
 * @param string $content The block inner HTML (empty).
 * @param bool $is_preview True during AJAX preview.
 * @param (int|string) $post_id The post ID this block is saved to.
 */
function render_acf_block( $block, $content = '', $is_preview = false, $post_id = 0 ) {
	$path = get_template_path();
	$tag  = get_block_tag();
	$attr = array();

	// Create id attribute allowing for custom "anchor" value.
	$id = 'testimonial-' . $block['id'];
	if ( ! empty( $block['anchor'] ) ) {
		$id = $block['anchor'];
	}

	// Create class attribute allowing for custom "css_class" and "align" values.
	$css_class = 'testimonial';
	if ( !empty($block['className'] ) ) {
		$css_class .= ' ' . $block['className'];
	}
	if ( !empty($block['align'] ) ) {
		$css_class .= ' align' . $block['align'];
	}

	printf(
		'<%1$s id="%2$s" class="%3$s">',
		$tag,
		$id,
		$css_class
	);

	get_template_part( $path . $block['name'] . '.php' );

	printf(
		'</%1$s>',
		$tag
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
