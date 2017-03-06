<?php

// doesnt work yet

function wsp_ratingStars( $atts, $content ) {
  $a = shortcode_atts( array(
    'attr_1' => 'attribute 1 default',
    'attr_2' => 'attribute 2 default',
  ), $atts );

  $jsonld = new wp_schema_plugin_json;
  $stars = $jsonld->aggregateRating();

  return $stars;
}


  add_shortcode( 'wsp_ratingStars', 'wsp_ratingStars' );

?>
