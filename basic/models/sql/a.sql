insert into activity_info
(`activity_code`,`activity_name`,`activity_type`,`start_time`,`end_time`,`created_at`,`created_by`,`updated_at`,`updated_by`)
values
('2018_11_1','第一波','cut_price', unix_timestamp('2018-07-26'), unix_timestamp('2018-07-29'), unix_timestamp(),'wanggang',unix_timestamp(),'wanggang'),
('2018_11_2','第二波','cut_price', unix_timestamp('2018-07-29'), unix_timestamp('2018-08-01'), unix_timestamp(),'wanggang',unix_timestamp(),'wanggang'),
('2018_11_3','第三波','cut_price', unix_timestamp('2018-08-01'), unix_timestamp('2018-08-04'), unix_timestamp(),'wanggang',unix_timestamp(),'wanggang'),
('2018_11_4','第四波','cut_price', unix_timestamp('2018-08-04'), unix_timestamp('2018-08-07'), unix_timestamp(),'wanggang',unix_timestamp(),'wanggang'),
('2018_11_5','第五波','cut_price', unix_timestamp('2018-08-07'), unix_timestamp('2018-08-10'), unix_timestamp(),'wanggang',unix_timestamp(),'wanggang')
;