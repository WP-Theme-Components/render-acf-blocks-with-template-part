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
	$name = ltrim( $block['name'], 'acf/' );
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
 * Set the default render callback for all blocks
 *
 * @since 1.0.0
 * @param array $args Block attributes.
 * @return array
 */
function set_default_render_callback( $args ) {
	$args['render_callback'] = __NAMESPACE__ . '\\render_acf_block';
	return $args;
}

add_filter( 'acf/register_block_type_args', __NAMESPACE__ . '\\' );

/**
 * Get the path the block templates are located
 *
 * @since 1.0.0
 * @return string
 */
function get_template_path() {
	return apply_filters( 'wp_theme_components/render_acf_blocks_with_template_part/template_path', 'template-parts/acf-blocks/' );
}

/**
 * Get the tag to wrap blocks with
 *
 * @since 1.0.0
 * @return string
 */
function get_block_tag() {
	return apply_filters( 'wp_theme_components/render_acf_blocks_with_template_part/block_tag', 'div' );
}

/**
 * Filter the block's attributes
 *
 * @param array $attributes Array of attributes.
 * @param array $block The block settings and attributes.
 * @return array
 */
function get_attributes( $attributes, $block ) {
	return apply_filters( 'wp_theme_components/render_acf_blocks_with_template_part/block_attributes', $attributes, $block );
}
