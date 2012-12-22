<?php
/***************************************************************************
*                                                                          *
*    Copyright (c) 2004 Simbirsk Technologies Ltd. All rights reserved.    *
*                                                                          *
* This  is  commercial  software,  only  users  who have purchased a valid *
* license  and  accept  to the terms of the  License Agreement can install *
* and use this program.                                                    *
*                                                                          *
****************************************************************************
* PLEASE READ THE FULL TEXT  OF THE SOFTWARE  LICENSE   AGREEMENT  IN  THE *
* "copyright.txt" FILE PROVIDED WITH THIS DISTRIBUTION PACKAGE.            *
****************************************************************************/


//
// $Id: send_to_friend.php 10229 2010-07-27 14:21:39Z 2tl $
//

if ( !defined('AREA') ) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

	if ($mode == 'send') {
		if (Registry::get('addons.1clue_product_inquiry.use_image_verification') == 'Y' && fn_image_verification('product_inquiry', empty($_REQUEST['verification_answer']) ? '' : $_REQUEST['verification_answer']) == false) {
			fn_save_post_data();

			return array(CONTROLLER_STATUS_REDIRECT);
		}

		$department_email = (Registry::get('addons.1clue_product_inquiry.email_address')) ? Registry::get('addons.1clue_product_inquiry.email_address') : Registry::get('settings.Company.company_support_department');
		if (!empty($department_email)) {
			$view_mail->assign('send_data', $_REQUEST['inquiry_data']);
			if (fn_send_mail($department_email, Registry::get('settings.Company.company_orders_department'), 'addons/1clue_product_inquiry/mail_subj.tpl', 'addons/1clue_product_inquiry/mail.tpl', '', CART_LANGUAGE, $_REQUEST['inquiry_data']['from_email'])) {
				fn_set_notification('N', fn_get_lang_var('notice'), fn_get_lang_var('text_email_sent'));
			}
		} else {
			fn_set_notification('E', fn_get_lang_var('error'), fn_get_lang_var('error_no_recipient_address'));
		}

		return array(CONTROLLER_STATUS_REDIRECT);
	}
}

?>