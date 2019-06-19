<?php
/**
 * @package     cdk
 * @copyright   Copyright (C) 2019 Zorca, Dima Minka, CDK. All rights reserved.
 * @license     See LICENSE file for details.
 */

/** Add Page Number to Title and Meta Description for SEO **/
if (!function_exists('multipage_metadesc')) {
    function multipage_metadesc($s)
    {
        global $page;
        $paged = get_query_var('paged') ? get_query_var('paged') : 1;
        !empty($page) && 1 < $page && $paged = $page;
        $paged > 1 && $s .= ' - ' . sprintf(__('Page %s'), $paged);
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
