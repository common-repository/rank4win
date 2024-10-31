<?php 
	wp_update_plugins();
	$action = 'upgrade-plugin';
	$slug = 'rank4win/rank4win.php';
	$url_update_nonces = wp_nonce_url(
	    add_query_arg(
	        array(
	            'action' => $action,
	            'plugin' => $slug
	        ),
	        admin_url( 'update.php' )
	    ),
	    $action.'_'.$slug
	);
	$ctd->set("url_update", $url_update_nonces);
