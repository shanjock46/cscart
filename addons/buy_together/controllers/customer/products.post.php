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


if ( !defined('AREA') ) { die('Access denied'); }

if ($mode == 'view') {
	$is_restricted = false;
	$show_notices = false;
			
	fn_set_hook('buy_together_restricted_product', $_REQUEST['product_id'], $auth, $is_restricted, $show_notices);
	
	if (!$is_restricted) {
		$params['product_id'] = $_REQUEST['product_id'];
		$params['status'] = 'A';
		$params['full_info'] = true;
		$params['date'] = true;
		
		$chains = fn_buy_together_get_chains($params, $auth);

		$view->assign('chains', $chains);
	}
}

?>