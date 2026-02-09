<div <?php echo get_block_wrapper_attributes(); ?>>
	<form class="park-search-filter" onsubmit="return false;">
		<input 
			type="search" 
			name="park_search" 
			placeholder="<?php esc_attr_e('Search parks...', 'my-parks'); ?>"
			style="width: 100%; padding: 0.75rem; border: 1px solid #ddd; border-radius: 4px;"
		/>
	</form>
</div>
