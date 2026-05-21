<?php
$park_maps = get_field( 'park_maps', $block->context['postId'] ?? get_the_ID() );
$show_heading = $attributes['showHeading'] ?? true;
$heading = $attributes['heading'] ?? __( 'Park Maps', 'my-parks' );

if ( empty( $park_maps ) ) {
	return '';
}
?>
<div <?php echo get_block_wrapper_attributes( array( 'id' => 'park-maps' ) ); ?>>
	<?php if ( $show_heading && $heading ) : ?>
		<h2 class="park-maps-heading"><?php echo esc_html( $heading ); ?></h2>
	<?php endif; ?>
	<ul class="park-maps-list">
		<?php foreach ( $park_maps as $map ) :
			$label = $map['label'] ?? '';
			$file  = $map['file'] ?? null;

			if ( empty( $label ) || empty( $file ) ) {
				continue;
			}

			$url      = is_array( $file ) ? ( $file['url'] ?? '' ) : $file;
			$filename = is_array( $file ) ? ( $file['filename'] ?? '' ) : '';
			$type     = is_array( $file ) ? ( $file['mime_type'] ?? '' ) : '';
			$is_pdf   = strpos( $type, 'pdf' ) !== false;

			if ( empty( $url ) ) {
				continue;
			}
		?>
		<li class="park-maps-item">
			<a
				href="<?php echo esc_url( $url ); ?>"
				class="park-maps-link<?php echo $is_pdf ? ' park-maps-link--pdf' : ''; ?>"
				target="_blank"
				rel="noopener noreferrer"
				<?php if ( $is_pdf ) : ?>download<?php endif; ?>
			>
				<span class="park-maps-icon" aria-hidden="true">
					<?php if ( $is_pdf ) : ?>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
							<path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8l-6-6zm4 18H6V4h7v5h5v11zM8 15h2v2H8v-2zm0-4h8v2H8v-2zm4 8h4v-2h-4v2z"/>
						</svg>
					<?php else : ?>
						<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="20" height="20" fill="currentColor" aria-hidden="true">
							<path d="M19 9h-4V3H9v6H5l7 7 7-7zM5 18v2h14v-2H5z"/>
						</svg>
					<?php endif; ?>
				</span>
				<span class="park-maps-label"><?php echo esc_html( $label ); ?></span>
			</a>
		</li>
		<?php endforeach; ?>
	</ul>
</div>
