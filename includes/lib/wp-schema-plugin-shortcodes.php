<?php
	/*
	* this file contains all shortcode functions and definitions for wp-schema-plugin
	*/


	/*
	*	returns formatted testimonial loop
	*/
	function wsp_testimonials( $atts ) {
	    $a = shortcode_atts( array(
				'mode' => 'html',
	      'id' => false,
				'limit' => -1, // -1 removes post limit, 0 uses max posts
				'hr' => false
	    ), $atts );

			/*
			* get single testimonial if id is given,
			* else return array of testimonials
			*/
			if ($a['id']){

				// get post by id
				$get_testimonial = get_post($a['id']);

				// check if post is testimonial and return testimonial or notification
				if($get_testimonial->post_type == 'wsp_testimonials' && $get_testimonial->post_status == 'publish'){
					$testimonial = array(
						'ID' => $get_testimonial->ID,
						'date' => $get_testimonial->post_date,
						'content' => $get_testimonial->post_content,
						'title' => $get_testimonial->post_title,
						'stars' => get_post_meta( $a['id'], '_wsp_stars', true )
					);

						$output = (object) array($testimonial);

				} else {
					$output = _e('Not a testimonial', 'wp_schema_plugin');
				}
			} else {
				$args = array(
					'post_type' => 'wsp_testimonials',
					'post_status' => 'publish',
					'numberposts' => $a['limit']
				);
				$testimonials = get_posts( $args );

				foreach ( $testimonials as $testimonial ){
					$output[] = (object) array(
						'ID' => $testimonial->ID,
						'date' => $testimonial->post_date,
						'content' => $testimonial->post_content,
						'title' => $testimonial->post_title,
						'stars' => get_post_meta( $testimonial->ID, '_wsp_stars', true )
					);
				}
				wp_reset_postdata();
			}

			if($a['mode'] == 'raw'){
				return $output;
			} else {
				$star = '<span class="dashicons dashicons-star-filled"></span>';

				foreach($output as $html): ?>

				<div class="wsp wsp-review wsp-review-<?php echo $html->ID; ?>">
					<p class="wsp wsp-review-content"><?php echo $html->content; ?></p>
					<?php if($html->stars):?>
						<p class="wsp wsp-review-rating">
							<span class="wsp wsp-stars wsp-stars-<?php $html->ID ?>">
								<?php echo str_repeat($star, $html->stars); ?>
							</span>
						</p>
					<?php endif; ?>
					<p class="wsp wsp-review-name"><?php echo $html->title; ?></p>
				</div>
				<?php if($a['hr']): ?>
					<hr class="wsp-hr">
				<?php endif; ?>

				<?php endforeach;
				wp_reset_postdata();

			}
	}


	/*
	*	returns breadcrumbs
	*/
	function wsp_breadcrumbs() {
		$crumbs = new wsp_breadcrumbs();
		$html = $crumbs->breadcrumbs_html();

		echo $html;
	}

	/*
	* Socials
	*/
	function wsp_social( $atts ){
		$a = shortcode_atts( array(
			'raw' => false
		), $atts );

 		if($a['id'] == false){
			$socials = array(
				"facebook" => get_option('wsp_social_facebook'),
				"twitter" => get_option('wsp_social_twitter'),
				"google-plus" => get_option('wsp_social_google-plus'),
				"instagram" => get_option('wsp_social_instagram'),
				"youtube" => get_option('wsp_social_youtube'),
				"linkedin" => get_option('wsp_social_linkedin'),
				"myspace" => get_option('wsp_social_myspace'),
				"pinterest" => get_option('wsp_social_pinterest'),
				"soundcloud" => get_option('wsp_social_soundcloud'),
				"tumblr" => get_option('wsp_social_tumblr'),
				"avvo" => get_option('wsp_social_avvo'),
				"yelp" => get_option('wsp_social_yelp')
			);
		} else {
			$socials = array(
				$a['id'] => get_option('wsp_social_' . $a['id'])
			);
		}

		$socials = array_filter($socials);

		if ( $a['raw'] == true ){
			return $socials;
		} else {
			$html = '<div class="wsp wsp-social-wrapper">';
			foreach ( $socials as $key => $val){
				$html .= '<a class="wsp wsp-social wsp-social-'.$key.'" href="'. $val .'" title="'.$key.'" target="_blank">';
				$html .= '<i class="fa fa-'.$key.' wsp-social-icon" aria-hidden="true"></i>';
				$html .= '</a>';
			}
			$html .= "</div>";
			echo $html;
		}
	}

	/*
	*	Just return what is asked
	*/
	function wsp_info( $arg ){
		switch ($arg[0]) {
			case 'address':
				$a = new wsp_person;
				$output = $a->address;
				break;
			case 'name':
				$output = get_option('wsp_PersonName');
				break;
			case 'phone':
				$output = get_option('wsp_BusinessPhone');
				break;
			case 'facebook':
				$output = get_option('wsp_social_facebook');
				break;
			case 'twitter':
				$output = get_option('wsp_social_twitter');
				break;
			case 'google-plus':
			 	$output = get_option('wsp_social_google-plus');
				break;
			case 'instagram':
				$output = get_option('wsp_social_instagram');
				break;
			case 'youtube':
				$output = get_option('wsp_social_youtube');
				break;
			case 'linkedin':
				$output = get_option('wsp_social_linkedin');
				break;
			case 'myspace':
				$output = get_option('wsp_social_myspace');
				break;
			case 'pinterest':
				$output = get_option('wsp_social_pinterest');
				break;
			case 'soundcloud':
				$output = get_option('wsp_social_soundcloud');
				break;
			case 'tumblr':
				$output = get_option('wsp_social_tumblr');
				break;
			case 'yelp':
				$output = get_option('wsp_social_yelp');
				break;
			case 'avvo':
				$output = get_option('wsp_social_avvo');
				break;
			default:
				$output = _e('Nothing to output');
				break;
		}
		return $output;
	};

	/*
	*	Now bring them to life
	*/
	add_shortcode( 'wsp_testimonials', 'wsp_testimonials' );
	add_shortcode( 'wsp_breadcrumbs', 'wsp_breadcrumbs' );
	add_shortcode( 'wsp_social', 'wsp_social' );
	add_shortcode( 'wsp_info', 'wsp_info' );
?>
