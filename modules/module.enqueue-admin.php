<?php
/* enqueue admin scripts */
add_action('admin_enqueue_scripts', 'wpleads_admin_enqueuescripts');
function wpleads_admin_enqueuescripts($hook) {
	global $post;

	$post_type = isset($post) ? get_post_type( $post ) : null;

	$screen = get_current_screen();

	/*  /edit-tags.php?taxonomy=wplead_list_category&post_type=wp-lead page */
	if ( $screen->id === 'edit-wplead_list_category') {
		wp_enqueue_script('wpleads-list-page', WPL_URLPATH.'/js/wpl.list-page.js', array('jquery'));
		wp_enqueue_style('wpleads-list-page-css', WPL_URLPATH.'/css/wpl.list-page.css');
		return;
	}
	// Global Settings Screen
	if ( $screen->id === 'wp-lead_page_wpleads_global_settings') {
	wp_enqueue_script('wpleads-list-page', WPL_URLPATH.'/js/wpl.global-settings.js', array('jquery'));
	}
	wp_enqueue_style('wpleads-global-backend-css', WPL_URLPATH.'/css/wpl.global-backend.css');

	if ((isset($_GET['post_type'])&&$_GET['post_type']=='wp-lead')||(isset($post->post_type)&&$post->post_type=='wp-lead')) {
		if ( $hook == 'post.php' ) {
			wp_enqueue_script('wpleads-edit', WPL_URLPATH.'/js/wpl.admin.edit.js', array('jquery'));
			wp_enqueue_script('tinysort', WPL_URLPATH.'/js/jquery.tinysort.js', array('jquery'));
			wp_enqueue_script('tag-cloud', WPL_URLPATH.'/js/jquery.tagcloud.js', array('jquery'));
			wp_localize_script( 'wpleads-edit', 'wp_lead_map', array( 'ajaxurl' => admin_url( 'admin-ajax.php' ), 'wp_lead_map_nonce' => wp_create_nonce('wp-lead-map-nonce') ) );

			if (isset($_GET['small_lead_preview'])) {
				wp_enqueue_style('wpleads-popup-css', WPL_URLPATH.'/css/wpl.popup.css');
				wp_enqueue_script('wpleads-popup-js', WPL_URLPATH.'/js/wpl.popup.js', array('jquery'));
			}

			wp_enqueue_style('wpleads-admin-edit-css', WPL_URLPATH.'/css/wpl.edit-lead.css');
		}

		//Tool tip js
		wp_enqueue_script('jquery-qtip', WPL_URLPATH . '/js/jquery-qtip/jquery.qtip.min.js', array('jquery'));
		wp_enqueue_script('wpl-load-qtip', WPL_URLPATH . '/js/jquery-qtip/load.qtip.js', array('jquery'));
		wp_enqueue_style('qtip-css', WPL_URLPATH . '/css/jquery.qtip.min.css'); //Tool tip css
		wp_enqueue_style('wpleads-admin-css', WPL_URLPATH.'/css/wpl.admin.css');


		// Leads list management js
		wp_enqueue_script('wpleads-list', WPL_URLPATH . '/js/wpl.leads-list.js', array('jquery'));
		wp_enqueue_style('wpleads-list-css', WPL_URLPATH.'/css/wpl.leads-list.css');


		if ( $hook == 'post-new.php' ) {
			wp_enqueue_script('wpleads-create-new-lead', WPL_URLPATH . '/js/wpl.add-new.js', array('jquery'));
		}

		if ( $hook == 'post.php' ) {
			if (isset($_GET['small_lead_preview'])) {
				wp_enqueue_style('wpleads-popup-css', WPL_URLPATH.'/css/wpl.popup.css');
			}
			wp_enqueue_style('wpleads-admin-edit-css', WPL_URLPATH.'/css/wpl.edit-lead.css');
		}


	}

	if ((isset($_GET['post_type'])&&$_GET['post_type']=='list')||(isset($post->post_type)&&$post->post_type=='list')) {
		wp_enqueue_style('wpleads-list-css', WPL_URLPATH.'/css/wpl.leads-list.css');
		wp_enqueue_script('lls-edit-list-cpt', WPL_URLPATH . '/js/wpl.admin.cpt.list.js', array('jquery'));
	}

	/* do enqueues for global settings */
	if (isset($_GET['page'])&&$_GET['page']=='wpleads_global_settings') {
		wp_enqueue_style('wpl_manage_lead_css', WPL_URLPATH . '/css/wpl.admin-global-settings.css');
	}


	/* do enqueue for post type rule */
	if ((isset($post)&&$post->post_type=='automation')||(isset($_REQUEST['post_type'])&&$_REQUEST['post_type']=='automation')) {
		wp_enqueue_script('jquery-qtip', WPL_URLPATH . '/js/jquery-qtip/jquery.qtip.min.js', array('jquery'));
		wp_enqueue_script('rules-load-qtip', WPL_URLPATH . '/js/jquery-qtip/load.qtip.js', array('jquery'));

		if (isset($post)) {
			wp_enqueue_script('automation-js', WPL_URLPATH . '/js/admin.rules-management.js', array('jquery'));
			wp_localize_script( 'automation-js' , 'automation_rule', array( 'automation_id' => $post->ID , 'admin_url' => admin_url('admin-ajax.php')));

			wp_enqueue_style('automation-management-css', WPL_URLPATH.'/css/admin.rules-management.css');
		}
	}

}