<?php

add_filter('manage_product_posts_columns', 'custom_remove_product_columns', 999);

function custom_remove_product_columns($columns)
{
	unset($columns['sku']);
	unset($columns['is_in_stock']);
	unset($columns['product_tag']);
	unset($columns['featured']);

	return $columns;
}
