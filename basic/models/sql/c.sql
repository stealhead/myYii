insert into activity_product
(`activity_info_id`,`sku_id`,`sku_count`, `sku_icon`, `floor_price`,`cut_down_threshold`,`cycle`,`created_at`,`created_by`,`updated_at`,`updated_by`)
select
c.id as activity_info_id, a.sku_id, a.sku_count, b.image as sku_icon, a.floor_price, a.cut_down_threshold, a.cycle, a.created_at, a.created_by, a.updated_at, a.updated_by from tmp_sku a
left join product_sku b on a.sku_id=b.id
left join activity_info c on a.activity_info_code=c.activity_code
;