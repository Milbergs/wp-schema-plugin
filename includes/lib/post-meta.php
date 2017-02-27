<?php

/* Meta box setup function. */
function meta_schema_setup() {

  /* Add meta boxes on the 'add_meta_boxes' hook. */
  add_action( 'add_meta_boxes', 'meta_schema_add' );

  /* Save post meta on the 'save_post' hook. */
  add_action( 'save_post', 'smashing_save_post_class_meta', 10, 2 );
}

/* Create one or more meta boxes to be displayed on the post editor screen. */
function meta_schema_add() {

  add_meta_box(
    'schema_stars',                           // Unique ID
    esc_html__( 'Post Schema settings', 'wp-schema-plugin' ),    // Title
    'schema_stars_meta_box',                  // Callback function
    ['bustr_testimonials'],                         // Admin page (or post type)
    'normal',                                 // Context
    'default'                                 // Priority
  );
}

/* Display the post meta box. */
function schema_stars_meta_box( $object, $box ) { ?>

  <?php wp_nonce_field( basename( __FILE__ ), 'schema_stars_nonce' ); ?>

  <p>
    <?php /* <input type="text" value="<?php echo esc_attr( get_post_meta( $object->ID, 'schema_stars', true ) ); ?>"> Enable Schema stars<br> */ ?>

    <label for="schema_stars">
        <input type="checkbox" name="schema_stars" id="schema_stars" value="yes" <?php if ( get_post_meta( $object->ID, 'schema_stars', true) ) checked( get_post_meta( $object->ID, 'schema_stars', true), 'yes' ); ?> />
        <?php _e( 'Enable Schema Star Rating', 'wp-schema-plugin' )?>
    </label>

  </p>

<?php }


/* Save the meta box's post metadata. */
function smashing_save_post_class_meta( $post_id, $post ) {

  /* Verify the nonce before proceeding. */
  if ( !isset( $_POST['schema_stars_nonce'] ) || !wp_verify_nonce( $_POST['schema_stars_nonce'], basename( __FILE__ ) ) )
    return $post_id;

  /* Get the post type object. */
  $post_type = get_post_type_object( $post->post_type );

  /* Check if the current user has permission to edit the post. */
  if ( !current_user_can( $post_type->cap->edit_post, $post_id ) )
    return $post_id;

    if( isset( $_POST[ 'schema_stars' ] ) ) {
        update_post_meta( $post_id, 'schema_stars', 'yes' );
    } else {
        update_post_meta( $post_id, 'schema_stars', '' );
    }

  // /* Get the posted data and sanitize it for use as an HTML class. */
  // $new_meta_value = ( isset( $_POST['schema_stars'] ) ? sanitize_html_class( $_POST['schema_stars'] ) : '' );
  //
  // /* Get the meta key. */
  // $meta_key = 'schema_stars';
  //
  // /* Get the meta value of the custom field key. */
  // $meta_value = get_post_meta( $post_id, $meta_key, true );
  //
  // /* If a new meta value was added and there was no previous value, add it. */
  // if ( $new_meta_value && '' == $meta_value ){
  //   add_post_meta( $post_id, $meta_key, $new_meta_value, true );
  // }
  //
  // /* If the new meta value does not match the old value, update it. */
  // elseif ( $new_meta_value && $new_meta_value != $meta_value ){
  //   update_post_meta( $post_id, $meta_key, $new_meta_value );
  // }
  //
  // /* If there is no new meta value but an old value exists, delete it. */
  // elseif ( '' == $new_meta_value && $meta_value ){
  //   delete_post_meta( $post_id, $meta_key, $meta_value );
  // }
}

meta_schema_setup();


add_filter('the_content','my_post_footer',99);
function my_post_footer($content){
   global $post;
   $allowed = get_post_meta($post->ID,'schema_stars',true);
   if ($allowed == 'yes'){
      $content .= '* * * * *';
   } else {
      $content .= 'disallowed';
   }
   return $content;
}

?>
