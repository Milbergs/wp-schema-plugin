<?php
/**
 * Adds a box to the main column on the Post add/edit screens.
 */
function wsp_add_meta_box() {

        add_meta_box(
                'wsp_sectionid', 'User rating', 'wsp_meta_box_callback', 'wsp_testimonials', 'side', 'high'
        ); //you can change the 4th paramter i.e. post to custom post type name, if you want it for something else

}

add_action( 'add_meta_boxes', 'wsp_add_meta_box' );

/**
 * Prints the box content.
 *
 * @param WP_Post $post The object for the current post/page.
 */

function wsp_meta_stars($rating, $star){
  if($star <= $rating){
    return '<span class="dashicons dashicons-star-filled"></span>';
  } else {
    return '<span class="dashicons dashicons-star-empty"></span>';
  }
}

function wsp_meta_box_callback( $post ) {

        // Add an nonce field so we can check for it later.
        wp_nonce_field( 'wsp_meta_box', 'wsp_meta_box_nonce' );

        /*
         * Use get_post_meta() to retrieve an existing value
         * from the database and use the value for the form.
         */
        $value = get_post_meta( $post->ID, '_wsp_stars', true ); //my_key is a meta_key. Change it to whatever you want

        ?>
        <span class="rating-star"> <input type="radio" name="wsp_stars" value="1" <?php checked( $value, '1' ); ?> > <?php echo wsp_meta_stars($value, 1); ?> </span>
        <span class="rating-star"> <input type="radio" name="wsp_stars" value="2" <?php checked( $value, '2' ); ?> > <?php echo wsp_meta_stars($value, 2); ?> </span>
        <span class="rating-star"> <input type="radio" name="wsp_stars" value="3" <?php checked( $value, '3' ); ?> > <?php echo wsp_meta_stars($value, 3); ?> </span>
        <span class="rating-star"> <input type="radio" name="wsp_stars" value="4" <?php checked( $value, '4' ); ?> > <?php echo wsp_meta_stars($value, 4); ?> </span>
        <span class="rating-star"> <input type="radio" name="wsp_stars" value="5" <?php checked( $value, '5' ); ?> > <?php echo wsp_meta_stars($value, 5); ?> </span>
        <?php

}

/**
 * When the post is saved, saves our custom data.
 *
 * @param int $post_id The ID of the post being saved.
 */
function wsp_save_meta_box_data( $post_id ) {

        /*
         * We need to verify this came from our screen and with proper authorization,
         * because the save_post action can be triggered at other times.
         */

        // Check if our nonce is set.
        if ( !isset( $_POST['wsp_meta_box_nonce'] ) ) {
                return;
        }

        // Verify that the nonce is valid.
        if ( !wp_verify_nonce( $_POST['wsp_meta_box_nonce'], 'wsp_meta_box' ) ) {
                return;
        }

        // If this is an autosave, our form has not been submitted, so we don't want to do anything.
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
                return;
        }

        // Check the user's permissions.
        if ( !current_user_can( 'edit_post', $post_id ) ) {
                return;
        }


        // Sanitize user input.
        $new_meta_value = ( isset( $_POST['wsp_stars'] ) ? sanitize_html_class( $_POST['wsp_stars'] ) : '' );

        // Update the meta field in the database.
        update_post_meta( $post_id, '_wsp_stars', $new_meta_value );

}

add_action( 'save_post', 'wsp_save_meta_box_data' );
