<?php
/*
where all the magic happens
*/
class wsp_localbusiness {

  public function construct()  {
    // JSON for localbusiness
    $localBusiness['@context'] = 'http://schema.org';
    $localBusiness['@type'] = get_option('wsp_LocalBusinessType');
    $localBusiness['@id'] = '#LocalBusiness';
    $localBusiness['name'] = get_option('wsp_BusinessName');
    $localBusiness['description'] = get_option('wsp_Description');
    $localBusiness['telephone'] = get_option('wsp_BusinessPhone');
    $localBusiness['url'] = get_bloginfo('wpurl');
    $localBusiness['logo'] = self::businessLogo();
    $localBusiness['image'] = self::businessImage();
    $localBusiness['address'] = self::address();
    $localBusiness['geo'] = self::geo();
    $localBusiness['openingHours'] = self::openingHours();
    $localBusiness['contactPoint'] = self::contactPoint();
    // $this->departments = self::departments();
    $localBusiness['priceRange'] = self::priceRange();
    $localBusiness['sameAs'] = self::sameAs();
    $localBusiness['aggregateRating'] = self::aggregateRating();

    $localBusiness['review'] = self::review();

    $localBusiness = array_filter($localBusiness);

    // $json = json_encode($localBusiness, JSON_UNESCAPED_SLASHES);

    return (object) $localBusiness;
  }


  /*
  * get business logo or do nothing
  */
  public function businessLogo(){
    $logoObject = get_option('wsp_BusinessLogo');
    if($logoObject){
      $logoSrc = wp_get_attachment_image_src($logoObject);
      $logoUrl = $logoSrc[0];
      return $logoUrl;
    }
  }

  /*
  * get business image or use business logo
  */
  public function businessImage(){

    $businessImage = get_option('wsp_BusinessImage');

    if($businessImage) {
      $imageSrc = wp_get_attachment_image_src($businessImage);
      $imageUrl = $imageSrc[0];
      return $imageUrl;
    } else {
      return self::businessLogo();
    }
  }

  /*
  * returns the main address
  */
  public function address(){
    $address = array(
      "@type" => "PostalAddress",
      "streetAddress" => get_option('wsp_Address'),
      "addressLocality" => get_option('wsp_City'),
      "addressRegion" => get_option('wsp_StateRegion'),
      "postalCode" => get_option('wsp_PostalCode'),
      "addressCountry" => get_option('wsp_Country')
    );

    return $address;
  } // address

  /*
  * returns geographic coordinates
  */
  public function geo(){
    $geo =  array(
      "@type" => "GeoCoordinates",
      "latitude" => get_option('wsp_Lattitude'),
      "longitude" => get_option('wsp_Longtitude')
    );

    return $geo;
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
    $contactPoint = array(
      "@type" => "ContactPoint",
      "telephone" => '+1' . get_option('wsp_BusinessPhone'),
      "contactType" => "customer service"
    );

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
  * price range
  */
  public function priceRange(){
    $priceRange = get_option('wsp_PriceRange');

    if(isset($priceRange)){
      return $priceRange;
    }
  } // price range

  /*
  * return social profiles
  */
  public function sameAs(){
    $sameAs = array(
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
    );

    $sameAs = array_filter($sameAs);

    return array_values($sameAs);
  } // sameAs

  /*
  * AggregateRating
  */
  public function aggregateRating(){

    // determine if automatic or manly
    $mode = get_option('wsp_Startype');


    switch ($mode) {
      case 'automatic':
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

        $rating = array(
          "@type" => "AggregateRating",
          "ratingValue" => $ratingValue,
          "reviewCount" => $reviewCount
        );

        break;

      case 'manual':
        $ratingValue = get_option('wsp_ManualRating');
        $reviewCount = get_option('wsp_ManualReviews');

        $rating = array(
          "@type" => "AggregateRating",
          "ratingValue" => $ratingValue,
          "reviewCount" => $reviewCount
        );

        break;

      default:
        # code...
        break;
    }
    return $rating;

  }// Aggregate Rating

  /*
  * return review
  */
  public function review(){
    // determine if automatic or manly
    $mode = get_option('wsp_Startype');

    if($mode == 'automatic'){
      global $wpdb;
      $testimonials = $wpdb->get_results( "SELECT ID, post_title, post_content, post_date FROM wp_posts WHERE post_type = 'wsp_testimonials' AND post_status = 'publish'", ARRAY_A );

      if($testimonials){
        foreach($testimonials as $testimonial){
          $id = $testimonial['ID'];
          $name = $testimonial['post_title'];
          $content = $testimonial['post_content'];
          $date = $testimonial['post_date'];
          $stars = get_post_meta($id, '_wsp_stars', true);

          $review[] = array(
            "@type" => "Review",
            "author" => array(
              "@type" => "Person",
              "name" => $name,
            ),
            "datePublished" => $date,
            "description" => $content,
            "inLanguage" => "en",
            "reviewRating" => array(
              "@type" => "Rating",
              "ratingValue" => $stars
            )
          );
        }
      } else {
        $review = false;
      }
      return $review;
    }
  } // rating
} // class professionalService

/*
* breadcrumbs
*/
class wsp_breadcrumbs {
  public function construct(){
    $breadCrumbs['@context'] = "http://schema.org";
    $breadCrumbs['@type'] = "BreadcrumbList";
    $breadCrumbs['itemListElement'] = self::breadcrumbs_json();

    // $json = json_encode($breadCrumbs, JSON_UNESCAPED_SLASHES);

    return (object) $breadCrumbs;
  }

  /*
  * Breadcrumbs
  */
  public function get_breadcrumbs(){

    // Include Home breadcrumb
    $crumbs[] = array(
      'url' => get_bloginfo('wpurl'),
      'title' => __('Home', 'wp-schema-plugin')
    );

    // blog articles
    if(is_single()){

      $current_category = get_the_category(get_the_ID());
      $current_category_id = $current_category[0]->cat_ID;
      $current_category_link = get_category_link($current_category_id);
      $current_category_title = get_cat_name($current_category_id);
      $current_ancestors = get_ancestors($current_category_id, 'category');
      $current_ancestors = array_reverse($current_ancestors);
      foreach($current_ancestors as $key => $ancestor){
        $crumbs[] = array(
          'url' => get_category_link($ancestor),
          'title' => get_cat_name($ancestor)
        );
      }
      // for current category
       $crumbs[] = array(
         'url' => $current_category_link,
         'title' => $current_category_title
       );

      // for current post
      $crumbs[] = array(
        'url' => get_permalink(),
        'title' => get_the_title()
      );
    }
    // is pages
    elseif(is_page()){
      $current_ancestors = get_post_ancestors(get_the_ID());
      $current_ancestors = array_reverse($current_ancestors);

      foreach($current_ancestors as $key => $ancestor){
        $crumbs[] = array(
          'url' => get_permalink($ancestor),
          'title' => get_the_title($ancestor)
        );
      }
    }
    // categories
    elseif(is_category()){
      $current_category = get_category( get_query_var( 'cat' ) );
      $current_category_id = $current_category->cat_ID;
      $current_category_link = get_category_link($current_category_id);
      $current_category_title = get_cat_name($current_category_id);
      $current_ancestors = get_ancestors($current_category_id, 'category');
      $current_ancestors = array_reverse($current_ancestors);

      foreach($current_ancestors as $key => $ancestor){
        $crumbs[] = array(
          'url' => get_category_link($ancestor),
          'title' => get_cat_name($ancestor)
        );
      }

      $crumbs[] = array(
        'url' => $current_category_link,
        'title' => $current_category_title
      );

    }

    $crumbs[] = array(
      'url' => get_permalink(get_permalink()),
      'title' => get_the_title(get_the_title())
    );

    $crumbs = array_filter(array_map('array_filter', $crumbs));

    return $crumbs;
  } // end of get_crumbs

  /*
  * Breadcrums in HTML
  */
  public function breadcrumbs_html(){
    $crumbs = self::get_breadcrumbs();
    $separator = get_option('wsp_BreadcrumbSpacing');
    $count = count($crumbs) - 1;
    $bread = null;

    if($separator){
      if($separator == 'nothing'){
        $separator = '';
      } else {
        $separator = ' ' . $separator . ' ';
      }
    } else {
      $separator = ' / ';
    }

    foreach($crumbs as $key => $crumb){
      // make link
      $slice = '<a class="wsp wsp-crumb wsp-crumb-' . $key . '" href="' . $crumb['url'] . '" title="' . $crumb['title'] . '">' . $crumb['title'] . '</a>';

      // if is not last, add separator
      if($count > $key){
        $slice .= '<span class="wsp wsp-crumb-separator">' . $separator . '</span>';
      }

      // add slice to bread
      $bread .= $slice;
    }

    return $bread;
  } // end breadcrumb_html

  /*
  * Breadcrumbs in JSON
  */
  public function breadcrumbs_json(){
    $status = get_option('wsp_Breadcrumbs');
    $crumbs = self::get_breadcrumbs();

    if($status == 'on'){
      $count = 0;

      foreach($crumbs as $crumb){
        $count += 1;
        $slices[] = array(
          "@type" => "ListItem",
          "position" => $count,
          "item" => array(
            "@id" => $crumb['url'],
            "name" => $crumb['title']
          )
        );
      }

      return $slices;
    }
  }// breadcrumb json
} // class breadcrumb

class wsp_person {
  public function construct(){
    $person["@context"] = "http://schema.org";
    $person["@type"] = "Person";
    $person["name"] = get_option('wsp_PersonName');
    $person["jobTitle"] = get_option('wsp_PersonJobTitle');
    // $person["affiliation"] = get_bloginfo('name');
    $person["url"] = '#person';
    $person["address"] = array(
      "@type" => "PostalAddress",
      "streetAddress" => get_option('wsp_Address'),
      "addressLocality" => get_option('wsp_City'),
      "addressRegion" => get_option('wsp_StateRegion'),
      "postalCode" => get_option('wsp_PostalCode'),
      "addressCountry" => get_option('wsp_Country')
    );

    return (object) $person;
  }
}

function wsp_json() {
  $html = '<script type="application/ld+json">';

  $local_business = new wsp_localbusiness;
  $local_business = $local_business->construct();
  $json[] = $local_business;

  if(get_option('wsp_Breadcrumbs')){
    $breadcrumbs = new wsp_breadcrumbs;
    $breadcrumbs = $breadcrumbs->construct();
    $json[] = $breadcrumbs;
  }
  if(get_option('wsp_PersonName')){
    $person = new wsp_person;
    $person = $person->construct();
    $json[] = $person;
  }
  $html .= json_encode($json);
  $html .= '</script>' . "\n";

  echo $html;
}

add_action('wp_head', 'wsp_json');

?>
