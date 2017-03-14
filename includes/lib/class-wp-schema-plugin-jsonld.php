<?php
/*
where all the magic happens
*/

class wp_schema_plugin_json {

  public function construct()  {
    $jsonld['@context'] = 'http://www.schema.org';
    $jsonld['@type'] = get_option('wsp_LocalBusinessType');
    $jsonld['@id'] = get_bloginfo('wpurl');
    $jsonld['name'] = get_option('wsp_BusinessName');
    $jsonld['description'] = get_option('wsp_Description');
    $jsonld['telephone'] = '+1' . get_option('wsp_BusinessPhone');
    $jsonld['url'] = get_bloginfo('wpurl');
    $jsonld['logo'] = wp_get_attachment_image_src(get_option('wsp_BusinessLogo'))[0];
    $jsonld['image'] = wp_get_attachment_image_src(get_option('wsp_BusinessLogo'))[0];
    $jsonld['address'] = self::address();
    $jsonld['geo'] = self::geo();
    $jsonld['openingHours'] = self::openingHours();
    $jsonld['contactPoint'] = self::contactPoint();
    // $this->departments = self::departments();
    $jsonld['sameAs'] = self::sameAs();
    $jsonld['aggregateRating'] = self::aggregateRating();
    $jsonld['review'] = self::review();

    $jsonld = array_filter($jsonld);

    return json_encode($jsonld);
  }

  /*
  * returns the main address
  */
  public function address(){
    $address = [
      "@type" => "PostalAddress",
      "streetAddress" => get_option('wsp_Address'),
      "addressLocality" => get_option('wsp_City'),
      "addressRegion" => get_option('wsp_StateRegion'),
      "postalCode" => get_option('wsp_PostalCode'),
      "addressCountry" => get_option('wsp_Country')
    ];

    return (object) $address;
  } // address

  /*
  * returns geographic coordinates
  */
  public function geo(){
    $geo =  [
      "@type" => "GeoCoordinates",
      "latitude" => get_option('wsp_Lattitude'),
      "longitude" => get_option('wsp_Longtitude')
    ];

    return (object) $geo;
  } // geo

  /*
  * return opening Hours
  */
  public function openingHours(){
    $days = get_option('wsp_BusinessDays');
    if($days){
      foreach($days as $day){
        $workingDays[] = $day;
      }
      $days = implode(', ', $days);
    } else {
      $workingDays[] = null;
    }


    $openingHours = get_option('wsp_BusinessHoursOpening');
    $closingHours = get_option('wsp_BusinessHoursClosing');

    return "$days $openingHours-$closingHours";
  } //openingHours

  // return contact information
  public function contactPoint(){
    $contactPoint = [
      "@type" => "ContactPoint",
      "telephone" => '+1' . get_option('wsp_BusinessPhone'),
      "contactType" => "customer service"
    ];

    return $contactPoint;
  } // contact Point

  /*
  * list all departments
  */
  // public function departments(){
  //   $departments = [
  //     "@type" => get_option('wsp_LocalBusinessType'),
  //     "image" => "http://www.example.com/deptTwo.jpg",
  //     "name" => "Dave's Pharmacy",
  //     "telephone" => "+14088719385",
  //     "openingHoursSpecification" => [
  //       [
  //         "@type" => "OpeningHoursSpecification",
  //         "dayOfWeek" => [
  //           "Monday",
  //           "Tuesday",
  //           "Wednesday",
  //           "Thursday",
  //           "Friday"
  //         ],
  //         "opens" => "09:00",
  //         "closes" => "19:00"
  //       ],
  //       [
  //         "@type" => "OpeningHoursSpecification",
  //         "dayOfWeek" => "Saturday",
  //         "opens" => "09:00",
  //         "closes" => "17:00"
  //       ],
  //       [
  //         "@type" => "OpeningHoursSpecification",
  //         "dayOfWeek" => "Sunday",
  //         "opens" => "11:00",
  //         "closes" => "17:00"
  //       ]
  //     ]
  //   ];
  //   return (object) $departments;
  // } // departments

  /*
  * return social profiles
  */
  public function sameAs(){
    $sameAs = [
      "Facebook" => get_option('wsp_social_facebook'),
      "Twitter" => get_option('wsp_social_twitter'),
      "Google+" => get_option('wsp_social_google-plus'),
      "Instagram" => get_option('wsp_social_instagram'),
      "YouTube" => get_option('wsp_social_youtube'),
      "LinkedIn" => get_option('wsp_social_linkedin'),
      "Myspace" => get_option('wsp_social_myspace'),
      "Pinterest" => get_option('wsp_social_pinterest'),
      "Soundcloud" => get_option('wsp_social_soundcloud'),
      "Tumblr" => get_option('wsp_social_tumblr')
    ];

    return array_values($sameAs);
  } // sameAs

  /*
  * return review
  */
  public function review(){

    // determine if automatic or manly
    $mode = get_option('wsp_ToggleAutomatic');

    if($mode == 'on'){
      global $wpdb;
      $testimonials = $wpdb->get_results( "SELECT ID, post_title, post_content, post_date FROM wp_posts WHERE post_type = 'wsp_testimonials' AND post_status = 'publish'", ARRAY_A );

      if($testimonials){
        foreach($testimonials as $testimonial){
          $id = $testimonial['ID'];
          $name = $testimonial['post_title'];
          $content = $testimonial['post_content'];
          $date = $testimonial['post_date'];
          $stars = get_post_meta($id, '_wsp_stars', true);

          $review[] = [
            "@type" => "Review",
            "author" => [
              "@type" => "Person",
              "name" => $name,
            ],
            "datePublished" => $date,
            "description" => $content,
            "inLanguage" => "en",
            "reviewRating" => [
              "@type" => "Rating",
              "ratingValue" => $stars
            ]
          ];
        }
      } else {
        $review[] = false;
      }
    } else {
      $review[] = false;
    }

    return $review;

  } // rating


  /*
  * AggregateRating
  */
  public function aggregateRating(){

    // determine if automatic or manly
    $mode = get_option('wsp_ToggleAutomatic');

    // if automatic ... else ...
    if($mode == 'on'){
      global $wpdb;
      $results = $wpdb->get_results( "SELECT meta_value FROM wp_postmeta WHERE meta_key = '_wsp_stars'", ARRAY_A );

      if($results){
        foreach($results as $result){
          $scores[] = $result['meta_value'];
        }

        $reviewCount = count($scores);
        $ratingValue = array_sum($scores) / $reviewCount;

      } else {
        $reviewCount = false;
        $ratingValue = false;
      }
    } else {
      $ratingValue = get_option('wsp_ManualRating');
      $reviewCount = get_option('wsp_ManualReviews');
    }

    $rating = [
      "@type" => "AggregateRating",
      "ratingValue" => $ratingValue,
      "reviewCount" => $reviewCount
    ];

    return $rating;
  }
}




function wsp_json() {
  $jsonld = new wp_schema_plugin_json;
  $jsonld = $jsonld->construct();

  echo "<script type='application/ld+json'>";
  echo $jsonld;
  echo "</script>";
}

add_action('wp_head', 'wsp_json');

?>
