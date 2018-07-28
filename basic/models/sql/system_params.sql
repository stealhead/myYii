
/*
********************** 1、初始化活动商品 ----- 开始 *********************
*/
create temporary table tmp__system_params
as
select a.param_key, a.value
from system_params as a
where 1 = 2
union select '2018_06_18_EXHIBITION_BEIOU', '[{"name":"客厅","icon":"","products":[{"product_id":"4703","tags":[]},{"product_id":"4714","tags":[]},{"product_id":"3660","tags":[]},{"product_id":"4030","tags":[]},{"product_id":"4609","tags":[]},{"product_id":"4610","tags":[]},{"product_id":"3110","tags":[]},{"product_id":"3027","tags":[]},{"product_id":"4594","tags":[]},{"product_id":"4596","tags":[]},{"product_id":"4611","tags":[]},{"product_id":"4619","tags":[]},{"product_id":"4597","tags":[]},{"product_id":"4599","tags":[]},{"product_id":"4600","tags":[]},{"product_id":"4601","tags":[]},{"product_id":"4653","tags":[]},{"product_id":"4698","tags":[]},{"product_id":"4704","tags":[]},{"product_id":"4715","tags":[]},{"product_id":"4639","tags":[]},{"product_id":"4708","tags":[]},{"product_id":"4706","tags":[]},{"product_id":"4707","tags":[]},{"product_id":"4709","tags":[]},{"product_id":"4711","tags":[]},{"product_id":"4712","tags":[]},{"product_id":"4713","tags":[]},{"product_id":"4705","tags":[]},{"product_id":"3039","tags":[]},{"product_id":"3413","tags":[]},{"product_id":"3042","tags":[]},{"product_id":"3038","tags":[]},{"product_id":"3049","tags":[]},{"product_id":"3109","tags":[]},{"product_id":"2427","tags":[]},{"product_id":"2376","tags":[]},{"product_id":"4213","tags":[]},{"product_id":"4212","tags":[]},{"product_id":"3011","tags":[]},{"product_id":"3276","tags":[]},{"product_id":"3661","tags":[]},{"product_id":"3273","tags":[]},{"product_id":"3275","tags":[]},{"product_id":"3274","tags":[]},{"product_id":"4011","tags":[]},{"product_id":"4427","tags":[]}]},{"name":"餐厅","icon":"","products":[{"product_id":"4617","tags":[]},{"product_id":"4642","tags":[]},{"product_id":"4618","tags":[]},{"product_id":"4629","tags":[]},{"product_id":"4633","tags":[]},{"product_id":"4636","tags":[]},{"product_id":"4638","tags":[]},{"product_id":"4640","tags":[]},{"product_id":"4643","tags":[]},{"product_id":"4651","tags":[]},{"product_id":"4694","tags":[]},{"product_id":"3111","tags":[]},{"product_id":"3012","tags":[]},{"product_id":"3272","tags":[]},{"product_id":"3423","tags":[]},{"product_id":"3271","tags":[]},{"product_id":"3270","tags":[]}]},{"name":"卧室","icon":"","products":[{"product_id":"4646","tags":[]},{"product_id":"4214","tags":[]},{"product_id":"4216","tags":[]},{"product_id":"4612","tags":[]},{"product_id":"4613","tags":[]},{"product_id":"4614","tags":[]},{"product_id":"4615","tags":[]},{"product_id":"4620","tags":[]},{"product_id":"4621","tags":[]},{"product_id":"4647","tags":[]},{"product_id":"4648","tags":[]},{"product_id":"4649","tags":[]},{"product_id":"4650","tags":[]},{"product_id":"3051","tags":[]},{"product_id":"4067","tags":[]},{"product_id":"3053","tags":[]},{"product_id":"3395","tags":[]},{"product_id":"3040","tags":[]},{"product_id":"3399","tags":[]},{"product_id":"2332","tags":[]},{"product_id":"3427","tags":[]},{"product_id":"3278","tags":[]},{"product_id":"3277","tags":[]}]}]'
;

update system_params as a
join tmp__system_params as b on b.param_key = a.param_key
set a.value = b.value, a.updated_at = unix_timestamp(), a.updated_by = 'wanggang'

;

insert into system_params(param_key, value, created_at, created_by, updated_at, updated_by)
select a.param_key, a.value, unix_timestamp(), 'wanggang', unix_timestamp(), 'wanggang'
from tmp__system_params as a
left join system_params as b on b.param_key = a.param_key
where b.id is null
;

drop table tmp__system_params;

select * from system_params;

/*
********************** 初始化活动商品 ----- 结束 *********************
*/

