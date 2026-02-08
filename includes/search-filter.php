<?php
add_action('pre_get_posts', 'my_parks_filter_query');
add_filter('redirect_canonical', 'my_parks_disable_redirect_on_search', 10, 2);
add_action('parse_request', 'my_parks_fix_parks_page_query');

function my_parks_filter_query($query) {
	if (!is_admin() && $query->is_main_query() && isset($_GET['park_search']) && !empty($_GET['park_search'])) {
		$query->set('s', sanitize_text_field($_GET['park_search']));
	}
}

function my_parks_disable_redirect_on_search($redirect_url, $requested_url) {
	if (isset($_GET['park_search'])) {
		return false;
	}
	return $redirect_url;
}

function my_parks_fix_parks_page_query($wp) {
	if (isset($_GET['park_search']) && isset($wp->query_vars['pagename']) && $wp->query_vars['pagename'] === 'parks') {
		$wp->query_vars['post_type'] = 'page';
		$wp->query_vars['name'] = 'parks';
		unset($wp->query_vars['pagename']);
	}
}
