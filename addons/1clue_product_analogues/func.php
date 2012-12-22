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
// $Id: func.php $
//

if ( !defined('AREA') ) { die('Access denied'); }


function fn_1clue_product_analogues_delete_product($product_id)
{
	db_query("DELETE FROM ?:addon_product_analogues WHERE master_id = ?i OR slave_id = ?i", $product_id, $product_id);

	return true;
}

function fn_1clue_product_analogues_get_products(&$params, &$fields, &$sortings, &$condition, &$join, &$sorting, &$group_by, $lang_code)
{
	if (!empty($params['analogues'])) {
		$join .=  " LEFT JOIN ?:addon_product_analogues ON products.product_id = ?:addon_product_analogues.slave_id";
		$condition .= db_quote(" AND ?:addon_product_analogues.master_id = ?i", $params['analogues']);
	}
	
	return true;
}
function fn_1clue_product_analogues_get_product_data_post(&$product, $auth, $preview)
{
	if (!empty($product['product_id'])) {
		list($analogues) = fn_get_products(array ('analogues' => $product['product_id'], 'type' => 'extended', 'page' => (int) $_REQUEST['page'], 'disable_searchanise' => true), Registry::get('settings.Appearance.products_per_page'));
		
		fn_gather_additional_products_data($analogues, array('get_icon' => true, 'get_detailed' => true, 'get_options' => true, 'get_discounts' => true, 'get_features' => false));

			$product['analogues'] = $analogues;
	}
}

?>