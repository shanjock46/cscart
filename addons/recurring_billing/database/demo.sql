REPLACE INTO ?:recurring_plans (`plan_id`, `price`, `product_ids`, `period`, `by_period`, `pay_day`, `duration`, `start_price`, `start_duration`, `start_duration_type`, `allow_change_duration`, `allow_unsubscribe`, `allow_free_buy`, `status`) VALUES ('1', 'a:2:{s:4:\"type\";s:13:\"to_percentage\";s:5:\"value\";s:2:\"80\";}', '110,112', 'W', '0', '2', '3', 'a:2:{s:4:\"type\";s:13:\"to_percentage\";s:5:\"value\";s:2:\"70\";}', '1', 'M', 'Y', 'Y', 'Y', 'A');

UPDATE ?:recurring_plans SET company_id = 1;
