<div <?php echo get_block_wrapper_attributes(); ?>>
	<form method="get" action="" class="park-search-filter">
		<input 
			type="search" 
			name="park_search" 
			placeholder="<?php esc_attr_e('Search parks...', 'my-parks'); ?>"
			value="<?php echo esc_attr($_GET['park_search'] ?? ''); ?>"
			style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;"
		/>
		<button type="submit" style="display: none;">Search</button>
	</form>
</div>
