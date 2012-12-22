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
// $Id: products.post.php 8049 2009-10-02 10:24:55Z lexa $
//

if (!defined('AREA')) { die('Access denied'); }

if ($mode == 'view') {
	$product_id = empty($_REQUEST['product_id']) ? 0 : $_REQUEST['product_id'];

	if ($product_id) {
		/*$ids = db_get_fields('SELECT an.slave_id FROM ?:addon_product_analogues as an LEFT JOIN ?:products ON an.slave_id = ?:products.product_id WHERE an.master_id = ?i AND ?:products.status != ?s', $product_id, 'D');*/
		$view->assign('analogues_display_template', Registry::get('addons.1clue_product_analogues.display_template'));
	}
}

?>