<?php
$preset_activities = $attributes['presetActivities'] ?? [];
$preset_facilities = $attributes['presetFacilities'] ?? [];
$preset_locations = $attributes['presetLocations'] ?? [];
$hide_filter = $attributes['hideFilter'] ?? false;

$activities = get_terms(['taxonomy' => 'activity', 'hide_empty' => false]);
$facilities = get_terms(['taxonomy' => 'facility', 'hide_empty' => false]);
$locations = get_terms(['taxonomy' => 'location', 'hide_empty' => false]);

if ($hide_filter) {
	// Hidden filter with presets
	?>
	<div <?php echo get_block_wrapper_attributes(['class' => 'park-taxonomy-filter hidden-filter']); ?> 
		data-preset-activities="<?php echo esc_attr(json_encode($preset_activities)); ?>"
		data-preset-facilities="<?php echo esc_attr(json_encode($preset_facilities)); ?>"
		data-preset-locations="<?php echo esc_attr(json_encode($preset_locations)); ?>">
	</div>
	<?php
	return;
}
?>
<div <?php echo get_block_wrapper_attributes(['class' => 'park-taxonomy-filter']); ?>>
	<div class="filter-group">
		<button class="filter-toggle" type="button" data-filter="activity"><span class="filter-icon">☰</span> <?php _e('Activity', 'my-parks'); ?></button>
		<div class="filter-dropdown" data-filter="activity" style="display: none;">
			<div class="filter-dialog">
				<button class="filter-close" type="button">×</button>
				<div class="filter-content">
					<div class="filter-checkboxes">
						<?php foreach ($activities as $term) : ?>
							<label>
								<input type="checkbox" name="activity" value="<?php echo esc_attr($term->slug); ?>" 
									<?php checked(in_array($term->slug, $preset_activities)); ?>>
								<?php echo esc_html($term->name); ?>
							</label>
						<?php endforeach; ?>
					</div>
					<button class="apply-filter" type="button"><?php _e('Apply', 'my-parks'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div class="filter-group">
		<button class="filter-toggle" type="button" data-filter="facility"><span class="filter-icon">☰</span> <?php _e('Facility', 'my-parks'); ?></button>
		<div class="filter-dropdown" data-filter="facility" style="display: none;">
			<div class="filter-dialog">
				<button class="filter-close" type="button">×</button>
				<div class="filter-content">
					<div class="filter-checkboxes">
						<?php foreach ($facilities as $term) : ?>
							<label>
								<input type="checkbox" name="facility" value="<?php echo esc_attr($term->slug); ?>"
									<?php checked(in_array($term->slug, $preset_facilities)); ?>>
								<?php echo esc_html($term->name); ?>
							</label>
						<?php endforeach; ?>
					</div>
					<button class="apply-filter" type="button"><?php _e('Apply', 'my-parks'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<div class="filter-group">
		<button class="filter-toggle" type="button" data-filter="location"><span class="filter-icon">☰</span> <?php _e('Location', 'my-parks'); ?></button>
		<div class="filter-dropdown" data-filter="location" style="display: none;">
			<div class="filter-dialog">
				<button class="filter-close" type="button">×</button>
				<div class="filter-content">
					<div class="filter-checkboxes">
						<?php foreach ($locations as $term) : ?>
							<label>
								<input type="checkbox" name="location" value="<?php echo esc_attr($term->slug); ?>"
									<?php checked(in_array($term->slug, $preset_locations)); ?>>
								<?php echo esc_html($term->name); ?>
							</label>
						<?php endforeach; ?>
					</div>
					<button class="apply-filter" type="button"><?php _e('Apply', 'my-parks'); ?></button>
				</div>
			</div>
		</div>
	</div>
	<button class="clear-filters" type="button" style="display: none;"><?php _e('Clear Filters', 'my-parks'); ?></button>
</div>
