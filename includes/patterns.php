<?php
register_block_pattern(
    'my-parks/park-grid',
    array(
        'title'       => __('Park Grid', 'my-parks'),
        'description' => __('A grid of park flip cards', 'my-parks'),
        'categories'  => array('my-park-blocks'),
        'content'     => '<!-- wp:group {"layout":{"type":"constrained"}} -->
<div class="wp-block-group"><!-- wp:my-parks/park-search-filter /-->

<!-- wp:group {"layout":{"type":"flex","flexWrap":"wrap"}} -->
<div class="wp-block-group"><!-- wp:my-parks/park-taxonomy-filter /--></div>
<!-- /wp:group -->

<!-- wp:query {"queryId":1,"query":{"perPage":100,"pages":0,"offset":0,"postType":"park","order":"desc","orderBy":"date","author":"","search":"","exclude":[],"sticky":"","inherit":false},"layout":{"type":"default"}} -->
<div class="wp-block-query"><!-- wp:post-template {"layout":{"type":"grid","columnCount":3}} -->
<!-- wp:my-parks/park-flip-card /-->
<!-- /wp:post-template -->

<!-- wp:query-no-results -->
<!-- wp:paragraph -->
<p>No parks found.</p>
<!-- /wp:paragraph -->
<!-- /wp:query-no-results --></div>
<!-- /wp:query --></div>
<!-- /wp:group -->'
    )
);

register_block_pattern(
    'my-parks/camping-booking',
    array(
        'title'       => __('Camping Booking Button', 'my-parks'),
        'description' => __('Shows only for parks with camping', 'my-parks'),
        'categories'  => array('my-park-blocks'),
        'content'     => '<!-- wp:group {"className":"camping-booking"} -->
<div class="wp-block-group camping-booking"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">Book Camping</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    )
);

add_filter( 'render_block', 'my_parks_conditional_camping_block', 10, 2 );
function my_parks_conditional_camping_block( $block_content, $block ) {
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'camping-booking' ) !== false ) {
        if ( ! my_parks_has_camping() ) {
            return '';
        }
    }
    return $block_content;
}

register_block_pattern(
    'my-parks/cabin-booking',
    array(
        'title'       => __('Cabin Booking Button', 'my-parks'),
        'description' => __('Shows only for parks with cabins', 'my-parks'),
        'categories'  => array('my-park-blocks'),
        'content'     => '<!-- wp:group {"className":"cabin-booking"} -->
<div class="wp-block-group cabin-booking"><!-- wp:buttons -->
<div class="wp-block-buttons"><!-- wp:button -->
<div class="wp-block-button"><a class="wp-block-button__link wp-element-button" href="#">Book Cabins</a></div>
<!-- /wp:button --></div>
<!-- /wp:buttons --></div>
<!-- /wp:group -->',
    )
);

add_filter( 'render_block', 'my_parks_conditional_cabin_block', 10, 2 );
function my_parks_conditional_cabin_block( $block_content, $block ) {
    if ( isset( $block['attrs']['className'] ) && strpos( $block['attrs']['className'], 'cabin-booking' ) !== false ) {
        if ( ! my_parks_has_cabin() ) {
            return '';
        }
        $cabin_url = get_post_meta( get_the_ID(), 'cabin_booking_url', true );
        if ( $cabin_url ) {
            $block_content = str_replace( 'href="#"', 'href="' . esc_url( $cabin_url ) . '"', $block_content );
        }
    }
    return $block_content;
}