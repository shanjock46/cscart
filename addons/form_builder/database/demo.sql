REPLACE INTO ?:pages (page_id, parent_id, id_path, status, page_type, position, timestamp, new_window, related_ids) VALUES ('30', '0', '30', 'A', 'F', '0', '1208808000', '0', NULL);

REPLACE INTO ?:form_options (`element_id`, `page_id`, `parent_id`, `element_type`, `value`, `position`, `required`, `status`) VALUES ('1', '30', '0', 'I', '', '3', 'Y', 'A');
REPLACE INTO ?:form_options (`element_id`, `page_id`, `parent_id`, `element_type`, `value`, `position`, `required`, `status`) VALUES ('2', '30', '0', 'Y', '', '1', 'Y', 'A');
REPLACE INTO ?:form_options (`element_id`, `page_id`, `parent_id`, `element_type`, `value`, `position`, `required`, `status`) VALUES ('3', '30', '0', 'T', '', '20', 'Y', 'A');
REPLACE INTO ?:form_options (`element_id`, `page_id`, `parent_id`, `element_type`, `value`, `position`, `required`, `status`) VALUES ('4', '30', '0', 'L', '', '0', 'N', 'A');
REPLACE INTO ?:form_options (`element_id`, `page_id`, `parent_id`, `element_type`, `value`, `position`, `required`, `status`) VALUES ('5', '30', '0', 'J', 'no-reply@cs-cart.com', '0', 'N', 'A');
REPLACE INTO ?:form_options (`element_id`, `page_id`, `parent_id`, `element_type`, `value`, `position`, `required`, `status`) VALUES ('6', '30', '0', 'U', 'N', '0', 'N', 'A');


UPDATE ?:pages SET company_id = 1 WHERE page_id =30;
REPLACE INTO `?:ult_objects_sharing` (`share_company_id`, `share_object_id`, `share_object_type`) VALUES (1, '30', 'pages');
REPLACE INTO `?:ult_objects_sharing` (`share_company_id`, `share_object_id`, `share_object_type`) VALUES (2, '30', 'pages');
