REPLACE INTO ?:banners (banner_id, url, status, type, target, timestamp) VALUES ('2', 'index.php?dispatch=promotions.list', 'D', 'G', 'T', '1184702400');
REPLACE INTO ?:banners (banner_id, url, status, type, target, timestamp) VALUES ('3', 'index.php?dispatch=categories.view&category_id=191', 'A', 'G', 'T', '1328040000');
REPLACE INTO ?:banners (banner_id, url, status, type, target, timestamp) VALUES ('4', 'index.php?dispatch=categories.view&category_id=212', 'A', 'G', 'T', '1328040000');
REPLACE INTO ?:banners (banner_id, url, status, type, target, timestamp) VALUES ('5', 'index.php?dispatch=categories.view&category_id=165', 'A', 'G', 'T', '1328040000');


UPDATE ?:banners SET company_id = 1;
UPDATE ?:banners SET company_id = 2 WHERE banner_id = 4;
REPLACE INTO `?:ult_objects_sharing` (`share_company_id`, `share_object_id`, `share_object_type`) VALUES (1, '2', 'banners');
REPLACE INTO `?:ult_objects_sharing` (`share_company_id`, `share_object_id`, `share_object_type`) VALUES (2, '2', 'banners');
REPLACE INTO `?:ult_objects_sharing` (`share_company_id`, `share_object_id`, `share_object_type`) VALUES (1, '3', 'banners');
REPLACE INTO `?:ult_objects_sharing` (`share_company_id`, `share_object_id`, `share_object_type`) VALUES (2, '4', 'banners');
REPLACE INTO `?:ult_objects_sharing` (`share_company_id`, `share_object_id`, `share_object_type`) VALUES (1, '5', 'banners');


