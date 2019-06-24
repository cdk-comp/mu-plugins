<?php
/*
Plugin Name: Yoast Helpers
Description: Pagination meta override
Author: Zorca, Dima Minka, CDK
Version: 1.0
Author URI: https://dima.mk
*/

/** Add Page Number to Title and Meta Description for SEO **/
if (!function_exists('multipage_metadesc')) {
    function multipage_metadesc($s)
    {
        global $page;
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        !empty($page) && 1 < $page && $paged = $page;
        $site_title = !$s ? get_bloginfo() . '&nbsp;' : '';
        $paged > 1 && $s = $site_title . $s . ' - ' . sprintf(__('Page %s'), $paged);
        return $s;
    }
    add_filter('wpseo_metadesc', 'multipage_metadesc', 100, 1);
}

if (!function_exists('multipage_title')) {
    function multipage_title($title)
    {
        global $page;
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        !empty($page) && 1 < $page && $paged = $page;
        $paged > 1 && $title .= ' - ' . sprintf(__('Page %s'), $paged);
        return $title;
    }
    add_filter('wpseo_title', 'multipage_title', 100, 1);
}

/** Make the last item of breadcrumbs a link */
if ( ! function_exists( 'wpseo_convert_current_page_to_link' ) ) {
	/**
	 * @param $link_output
	 * @param $link
	 *
	 * @return string|string[]|null
	 */
	function wpseo_convert_current_page_to_link( $link_output, $link ) {
		$result = $link_output;

		if ( stripos( $link_output, 'breadcrumb_last' ) !== false ) {

			$a_attributes = [
				'href'         => esc_url( $link['url'] ),
				'class'        => 'breadcrumb_last',
				'aria-current' => 'page',
			];

			if ( isset( $link['title'] ) ) {
				$a_attributes['title'] = esc_attr( $link['title'] );
			}

			$a_atr_str = '';
			foreach ( $a_attributes as $attr_name => $attr_value ) {
				$a_atr_str .= " $attr_name=\"$attr_value\"";
			}

			$link        = "<a$a_atr_str>{$link['text']}</a>";
			$wrapper     = WPSEO_Options::get( 'breadcrumbs-boldlast' ) === true ? 'strong' : 'span';
			$preg_result = preg_replace( "/<$wrapper.*>.+<\/$wrapper>/U", $link, $link_output );
			if ( ! empty( $preg_result ) ) {
				$result = $preg_result;
			}
		}

		return $result;
	}

	add_filter( 'wpseo_breadcrumb_single_link', 'wpseo_convert_current_page_to_link', 10, 2 );
}
