<?php
/***************************************************************************
*                                                                          *
*    Copyright (c) 2009 Simbirsk Technologies Ltd. All rights reserved.    *
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
// $Id: products.post.php 7502 2009-05-19 14:54:59Z zeke $
//

if (!defined('AREA')) { die('Access denied'); }

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	//
	// Update required products
	//

	if ($mode == 'update') {

		if (!empty($_REQUEST['product_id'])) {
			db_query('DELETE FROM ?:addon_product_analogues WHERE master_id = ?i OR slave_id= ?i', $_REQUEST['product_id'], $_REQUEST['product_id']);

			if (!empty($_REQUEST['analogues'])) {
				$analogues = explode(',', $_REQUEST['analogues']);
				// Cross linked 
				if (Registry::get('addons.1clue_product_analogues.link_type') == 'cross_linked') {
					array_push($analogues, $_REQUEST['product_id']);
					$entry = array();
					foreach ($analogues as $entry['master_id']) {
						foreach ($analogues as $entry['slave_id']) {
							if (empty($entry['slave_id']) || ($entry['slave_id'] == $entry['master_id'])) {
								continue;
							}
							db_query('REPLACE INTO ?:addon_product_analogues ?e', $entry);
	/*
							// Duplicate each record in order to increase search for analgues at frontend
							$_entry = array('master_id' => $entry['slave_id'], 'slave_id' => $entry['master_id']);
							db_query('INSERT INTO ?:addon_product_analogues ?e', $_entry);*/
						}
					}

				//Bi-directional links
				} else {
					$entry = array (
						'master_id' => $_REQUEST['product_id']
					);

					foreach ($analogues as $entry['slave_id']) {
						if (empty($entry['slave_id']) || ($entry['slave_id'] == $entry['master_id'])) {
							continue;
						}

						db_query('INSERT INTO ?:addon_product_analogues ?e', $entry);

						// Duplicate each record in order to increase search for analgues at frontend
						$_entry = array('master_id' => $entry['slave_id'], 'slave_id' => $entry['master_id']);
						db_query('INSERT INTO ?:addon_product_analogues ?e', $_entry);
					}
				}
			}
		}
	}
}

if ($mode == 'update') {
	$product_id = empty($_REQUEST['product_id']) ? 0 : intval($_REQUEST['product_id']);

	Registry::set('navigation.tabs.product_analogues', array (
		'title' => fn_get_lang_var('product_analogues'),
		'js' => true
	));

	$analogues = db_get_fields('SELECT slave_id FROM ?:addon_product_analogues WHERE master_id = ?i', $product_id);
	$view->assign('analogues', $analogues);
}

?>