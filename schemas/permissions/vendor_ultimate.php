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

$schema = array (
	'default_permission' => true,
	'controllers' => array (
		'companies' => array (
			'modes' => array (
				'add' => array (
					'permissions' => false
				),
			),
		),
		'localizations' => array (
			'permissions' => false
		),
		'upgrade_center' => array (
			'permissions' => false
		),
		'database' => array (
			'permissions' => false
		),
		'logs' => array (
			'permissions' => false
		),
		'countries' => array (
			'modes' => array(
				'manage' => array(
					'permissions' => array ('GET' => true, 'POST' => false),
				),
			),
			'permissions' => false,
		),
		'taxes' => array (
			'modes' => array(
				'manage' => array(
					'permissions' => array ('GET' => true, 'POST' => false),
				),
				'update' => array(
					'permissions' => array ('GET' => true, 'POST' => false),
				),
			),
			'permissions' => false,
		),
		'shippings' => array (
			'permissions' => true,
		),
		'destinations' => array (
			'modes' => array(
				'manage' => array(
					'permissions' => array ('GET' => true, 'POST' => false),
				),
				'update' => array(
					'permissions' => array ('GET' => true, 'POST' => false),
				),
			),
			'permissions' => false,
		),
		'statuses' => array (
			'modes' => array(
				'manage' => array(
					'permissions' => array ('GET' => true, 'POST' => false),
				),
				'update' => array(
					'permissions' => array ('GET' => true, 'POST' => false),
				),
			),
			'permissions' => false,
		),
		'states' => array (
			'modes' => array(
				'manage' => array(
					'permissions' => true,
				),
				'update' => false,
			),
			
			'permissions' => false,
		),
		'profile_fields' => array (
			'modes' => array (
				'manage' => array (
					'permissions' => array ('GET' => true, 'POST' => false),
				),
				'update' => array (
					'permissions' => array ('GET' => true, 'POST' => false),
				),
			),
			'permissions' => false,
		),
		'profiles' => array (
			'modes' => array (
				'manage' => array (
					'param_permissions' => array(
						'extra' => array(
							'user_type=A' => false,
						),
					),
				),
			),
		),
		'usergroups' => array (
			'modes' => array (
				'manage' => array (
					'permissions' => array ('GET' => true, 'POST' => false),
				),
			),
			'permissions' => false,
		),
		'currencies' => array (
			'modes' => array (
				'delete' => array (
					'permissions' => false,
				),
			),
			'permissions' => true,
		),
		'languages' => array (
			'modes' => array (
				'delete_language' => array (
					'permissions' => false,
				),
			),
			'permissions' => true,
		),
		'payments' => array (
			'permissions' => true,
		),
	),
	'addons' => array (),
	'export' => array (),
	'import' => array (),
		
);

?>