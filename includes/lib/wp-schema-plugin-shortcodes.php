<?php

/*
* returns stars for individual Testimonial
*/
function wsp_rating() {

	$data = get_post_meta( get_the_ID(), '_wsp_stars', true );
  $star = '<span class="dashicons dashicons-star-filled"></span>';

  if($data){
    $stars = str_repeat($star, $data);

    $output = '<span class="wsp wsp-stars wsp-stars-' . get_the_ID() .'">' .  $stars . '</span>';
  } else {

    $output = null;
  }

  echo $output;
}


/*
*	returns formatted testimonial loop
*/
function wsp_testimonials( /*$atts, $content = null*/ ) {
    // $a = shortcode_atts( array(
    //     'attr_1' => 'attribute 1 default',
    //     'attr_2' => 'attribute 2 default',
    //     // ...etc
    // ), $atts );

		// loop
		$args = array( 'post_type' => 'wsp_testimonials', 'post_status' => 'publish' );
		$loop = new WP_Query( $args );
		while ( $loop->have_posts() ) : $loop->the_post(); ?>

			<div class="wsp wsp-review wsp-review-<?php echo get_the_ID(); ?>">
				<p class="wsp wsp-review-content"><?php the_content(); ?></p>
				<p class="wsp wsp-review-rating"><?php do_shortcode('[wsp_rating]'); ?></p>
				<p class="wsp wsp-review-name"><?php the_title(); ?></p>
			</div>
			<hr>
		<?php
		endwhile;
}


/*
*	returns breadcrumbs
*/
function wsp_breadcrumbs() {
	$crumbs = new wp_schema_plugin_json();
	$html = $crumbs->breadcrumbs_html();

	echo $html;
}

/*
*	Now bring them to life
*/
add_shortcode( 'wsp_rating', 'wsp_rating' );
add_shortcode( 'wsp_testimonials', 'wsp_testimonials' );
add_shortcode( 'wsp_breadcrumbs', 'wsp_breadcrumbs' );

?>
