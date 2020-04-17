<?php defined( 'ABSPATH' ) OR die( 'This script cannot be accessed directly.' );

/**
 * Shortcode: vc_tta_tabs
 *
 * Overloaded by UpSolution custom implementation.
 *
 * Dev note: if you want to change some of the default values or acceptable attributes, overload the shortcodes config.
 *
 * @var $shortcode      string Current shortcode name
 * @var $shortcode_base string The original called shortcode name (differs if called an alias)
 * @var $content        string Shortcode's inner content
 * @var $classes        string Extend class names
 *
 * @var $toggle         bool {@for [vc_tta_accordion]} Act as toggle?
 * @var $c_align        string {@for [vc_tta_accordion], [vc_tta_tour]} Text alignment: 'left' / 'center' / 'right'
 * @var $c_icon         string {@for [vc_tta_accordion]} Icon: '' / 'chevron' / 'plus' / 'triangle'
 * @var $c_position     string {@for [vc_tta_accordion]} Icon position: 'left' / 'right'
 * @var $title_tag      string Title HTML tag (inherited from wrapping vc_tta_tabs shortcode): 'div' / 'h2'/ 'h3'/ 'h4'/ 'h5'/ 'h6'/ 'p'
 * @var $title_size     string Title Size
 * @var $layout         string {@for [vc_tta_tabs]} Tabs layout: 'default' / 'modern' / 'trendy' / 'timeline'
 * @var $stretch        bool {@for [vc_tta_tabs]} Stretch tabs to the full available width
 * @var $tab_position   string {@for [vc_tta_tour]} Tabs position: 'left' / 'right'
 * @var $controls_size  string {@for [vc_tta_tour]} Tabs size: 'auto' / '10' / '20' / '30' / '40' / '50'
 * @var $el_id          string element ID
 * @var $el_class       string {@for [vc_tta_accordion], [vc_tta_tabs], [vc_tta_tour]} Extra class
 * @var $css            string Custom CSS
 */

// Backward compatibility
if ( $shortcode_base == 'vc_tour' ) {
	$shortcode_base = 'vc_tta_tour';
} elseif ( $shortcode_base == 'vc_accordion' ) {
	$shortcode_base = 'vc_tta_accordion';
} elseif ( $shortcode_base == 'vc_tabs' ) {
	$shortcode_base = 'vc_tta_tabs';
}

$classes = isset( $classes ) ? $classes : '';
$classes .= $list_classes = $list_inline_css = $el_id_string = '';

// Extract tab attributes for future html preparations
global $us_tabs_atts;
preg_match_all( '/\[vc_tta_section([^\]]*?)\]/i', $content, $matches, PREG_OFFSET_CAPTURE );
$us_tabs_atts = isset( $matches[0] ) ? $matches[0] : array();
$active_tab_indexes = array();
foreach ( $us_tabs_atts as $index => $tab_atts ) {
	$us_tabs_atts[ $index ] = shortcode_parse_atts( '[' . rtrim( $tab_atts[0], '[]' ) . ' ]' );
	if ( isset( $us_tabs_atts[ $index ]['active'] ) AND $us_tabs_atts[ $index ]['active'] ) {
		$active_tab_indexes[] = $index;
		$us_tabs_atts[ $index ]['defined_active'] = 1;
	}
	// If a unique identifier is not set, then we generate automatically for the normal operation of tabs and sections
	if ( empty( $us_tabs_atts[ $index ]['tab_id'] ) ) {
		$us_tabs_atts[ $index ]['tab_id'] = uniqid();
	}
}

// If none of the tabs is active, the first one will be
if ( empty( $active_tab_indexes ) AND $shortcode_base != 'vc_tta_accordion' ) {
	$active_tab_indexes[] = 0;
	$us_tabs_atts[0]['active'] = 'yes';
}

if ( ! ( $shortcode_base == 'vc_tta_accordion' AND $toggle ) AND count( $active_tab_indexes ) > 1 ) {
	foreach ( array_slice( $active_tab_indexes, 1 ) as $index ) {
		$us_tabs_atts[ $index ]['active'] = 0;
		$us_tabs_atts[ $index ]['defined_active'] = 0;
	}
}

// Inheriging some of the attributes to the sections
if ( isset( $c_position ) ) {
	foreach ( $us_tabs_atts as $index => $tab_atts ) {
		$us_tabs_atts[ $index ]['c_position'] = $c_position;
	}
}

// Inheriging some of the attributes to the sections
if ( isset( $title_tag ) ) {
	foreach ( $us_tabs_atts as $index => $tab_atts ) {
		$us_tabs_atts[ $index ]['title_tag'] = $title_tag;
	}
}

// Inheriging some of the attributes to the sections
if ( isset( $title_size ) ) {
	foreach ( $us_tabs_atts as $index => $tab_atts ) {
		$us_tabs_atts[ $index ]['title_size'] = $title_size;
	}
}

if ( $shortcode_base == 'vc_tta_tabs' ) {
	$classes .= ' layout_hor';
	$list_classes .= ' hidden';
} elseif ( $shortcode_base == 'vc_tta_tour' ) {
	$classes .= ' layout_ver';
	$classes .= ' navpos_' . $tab_position;
	$classes .= ' navwidth_' . $controls_size;
	$classes .= ' title_at' . $c_align;
}

if ( empty( $layout ) ) {
	$layout = 'default';
}
if ( $layout == 'timeline2' ) {
	$classes .= ' style_timeline zephyr';
} else {
	$classes .= ' style_' . $layout;
}
$classes .= ' switch_' . $switch_sections;
$list_classes .= ' items_' . count( $us_tabs_atts );
$list_classes .= ( $stretch ) ? ' stretch' : '';

// Accordion-specific settings
if ( $shortcode_base == 'vc_tta_accordion' ) {
	$classes .= ' accordion';
	if ( $toggle ) {
		$classes .= ' type_togglable';
	}
	if ( $remove_indents ) {
		$classes .= ' remove_indents';
	}
	$classes .= ' title_at' . $c_align;
	if ( ! empty( $c_icon ) ) {
		$classes .= ' icon_' . $c_icon . ' iconpos_' . $c_position;
	} else {
		$classes .= ' icon_none';
	}
} else {
	// For accordion state of tabs
	$classes .= ' icon_chevron iconpos_right';
}

if ( ! empty( $el_class ) ) {
	$classes .= ' ' . $el_class;
}

if ( $el_id != '' ) {
	$el_id_string = ' id="' . esc_attr( $el_id ) . '"';
}

// Generate inline styles for Tabs & Tour
if ( $shortcode_base != 'vc_tta_accordion' ) {
	$list_inline_css .= us_prepare_inline_css(
		array(
			'font-family' => $title_font,
			'font-weight' => $title_weight,
			'text-transform' => $title_transform,
			'font-size' => $title_size,
			'line-height' => $title_lineheight,
		)
	);
}

// Output the element
$output = '<div class="w-tabs' . $classes . ' "' . $el_id_string . '>';

// Add tabs items
if ( $shortcode_base != 'vc_tta_accordion' ) {
	$output .= '<div class="w-tabs-list' . $list_classes . '"' . $list_inline_css . '>';
	$output .= '<div class="w-tabs-list-h">';

	foreach ( $us_tabs_atts as $index => $tab_atts ) {
		$tab_atts['title'] = isset( $tab_atts['title'] ) ? us_replace_comment_count_var( $tab_atts['title'] ) : '';
		$tab_atts['title'] = wptexturize( $tab_atts['title'] );
		$tab_atts['i_position'] = isset( $tab_atts['i_position'] ) ? $tab_atts['i_position'] : 'left';

		$item_class = isset( $tab_atts['el_class'] ) ? ' ' . $tab_atts['el_class'] : '';
		$item_class .= ( isset( $tab_atts['active'] ) AND $tab_atts['active'] ) ? ' active' : '';
		$item_class .= ( isset( $tab_atts['defined_active'] ) AND $tab_atts['defined_active'] ) ? ' defined-active' : '';
		$item_class .= isset( $tab_atts['icon'] ) ? ' with_icon' : '';

		// Check if the relevant section has a link
		if ( isset( $tab_atts['tab_link'] ) ) {
			$item_link_atts = us_generate_link_atts( $tab_atts['tab_link'] );
		} else {
			$item_link_atts = ' href="javascript:void(0);"';
		}

		$output .= '<a ' . $item_link_atts . ' class="w-tabs-item' . $item_class . '" aria-controls="content-' . $tab_atts['tab_id'] . '">';
		if ( isset( $tab_atts['icon'] ) AND $tab_atts['i_position'] == 'left' ) {
			$output .= us_prepare_icon_tag( $tab_atts['icon'] );
		}
		$output .= '<span class="w-tabs-item-title">' . $tab_atts['title'] . '</span>';
		if ( isset( $tab_atts['icon'] ) AND $tab_atts['i_position'] == 'right' ) {
			$output .= us_prepare_icon_tag( $tab_atts['icon'] );
		}
		$output .= '</a>';
	}

	$output .= '</div></div>';
}

// Handling inner tabs
global $us_tab_index;
$us_tab_index = 0;

$output .= '<div class="w-tabs-sections"><div class="w-tabs-sections-h">' . do_shortcode( $content ) . '</div></div></div>';

echo $output;
