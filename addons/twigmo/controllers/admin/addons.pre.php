<?php
/***************************************************************************
*                                                                          *
*   (c) 2004 Vladimir V. Kalynyak, Alexey V. Vinokurov, Ilya M. Shalnev    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/


if ( !defined('AREA') )	{ die('Access denied');	}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($mode == 'tw_connect') {
		if (Registry::get('addons.twigmo.access_id')) {
			fn_set_notification('E', fn_get_lang_var('error'), fn_get_lang_var('access_denied'));
			return array(CONTROLLER_STATUS_REDIRECT, 'addons.manage');
		}
		
		// svd
		// get license text [6661]
		$method = 'GET';
		$url = (defined('HTTPS') ? 'https' : 'http').'://twigmo.com/download/license_'.strtolower(CART_LANGUAGE).'.js?';
		$resp = fn_https_request($method, $url);
		$license = str_replace('twigmo_license_text =', '', $resp[1]);
		$license = preg_replace("/'С/", "С", $license);
		$license = str_replace('\\n\\', '', $license);
		$license = str_replace("\\'", "'", $license);
		$license = str_replace("'Twigmo", "Twigmo", $license);
		$license = preg_replace("/';$/", "", $license);
		$view->assign('twigmo_license', $license);
		// /svd

		$tw_register = $_REQUEST['tw_register'];
		if ($tw_register['password1'] != $tw_register['password2']) {
			fn_set_notification('E', fn_get_lang_var('error'), fn_get_lang_var('error_passwords_dont_match'));
			return array(CONTROLLER_STATUS_REDIRECT, 'addons.manage');
		}

		$twigmo = fn_connect_to_twigmo(DEFAULT_ADMIN_EMAIL == $tw_register['email'] ? 'special' : $tw_register['email'], $tw_register['password1'], $auth['user_id']);

		if (!empty($twigmo->response_data['access_id'])) {
			$view->assign('addons', Registry::get('addons'));

			fn_set_notification('N', fn_get_lang_var('notice'), fn_get_lang_var('twgadmin_text_store_connected'));
			
			// Save default settings
			$settings = array('use_mobile_frontend' => 'both_tablet_and_phone',
							'home_page_content' => 'home_page_blocks',
							'selected_skin' => 'default',
							'only_req_profile_fields' => 'N',
							'url_for_facebook' => '',
							'url_for_twitter' => '');
			fn_update_twigmo_options($settings);
			return array(CONTROLLER_STATUS_REDIRECT, 'addons.update&addon=twigmo');
		}

		if (defined('AJAX_REQUEST')) {
			$tw_register['version'] = TWIGMO_VERSION;
			$view->assign('tw_register', $tw_register);
			$view->display('addons/twigmo/settings/connect.tpl');
			$view->display('addons/twigmo/settings/settings.tpl');
			exit;

		} else {
			return array(CONTROLLER_STATUS_REDIRECT, 'addons.update&addon=twigmo');

		}
	}

	if ($mode == 'update' && $_REQUEST['addon'] == 'twigmo' && !empty($_REQUEST['tw_settings'])) {
		fn_update_twigmo_options($_REQUEST['tw_settings']);
	}
} elseif ($mode == 'update') {
	if ($_REQUEST['addon'] == 'twigmo') {
		if (!empty($_REQUEST['selected_section']) and $_REQUEST['selected_section'] == 'twigmo_addon') {
			fn_delete_notification('twigmo_upgrade');
		}
		if (!fn_twigmo_is_updated()) {
			fn_set_notification('W', fn_get_lang_var('notice'),  fn_get_lang_var('twgadmin_reinstall'));
		}
		$view->assign('default_logo', fn_twigmo_get_defauld_logo_url());
		$view->assign('favicon', fn_twigmo_get_favicon_url());
		$tw_register['version'] = TWIGMO_VERSION;
		$view->assign('tw_register', $tw_register);
		$view->assign('next_version_info', fn_twigmo_get_next_version_info());

	}
}

?>