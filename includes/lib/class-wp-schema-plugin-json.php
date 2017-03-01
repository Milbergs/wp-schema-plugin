<?php

class wp_schema_plugin_json{

  // format business times correctly
  // @output: Mo, Tu, We, Th 07:00-17:00
  function get_businessTimes(){

    $days = get_option('wsp_BusinessDays');
    foreach($days as $day){
      $workingDays[] = $day;
    }

    $days = implode(', ', $days);

    $openingHours = get_option('wsp_BusinessHoursOpening');
    $closingHours = get_option('wsp_BusinessHoursClosing');

    return "$days $openingHours-$closingHours";
  }

  // format phone number correctly (country code + full phone number)
  // @output: +15555555555
  function get_businessPhone(){
    $countryCode = 1;
    $phone = '+' . $countryCode . get_option('wsp_BusinessPhone');

    return $phone;
  }

  function get_businessLogo(){
    $logo = wp_get_attachment_image_src(get_option('wsp_BusinessLogo'))[0];

    return $logo;
  }

  function get_businessImage(){
    $image = wp_get_attachment_image_src(get_option('wsp_BusinessImage'))[0];

    if($image == true){
      return $image;
    } else {
      return self::get_businessLogo();
    }
  }

  // automatic rating must collect all testimonials
  function automaticRating(){

    // collect all testimonials
    $queryTestimonials = query_posts('post_type=bustr_testimonials');
    foreach($queryTestimonials as $testimonial){
      if($testimonial->post_status == 'publish'){
        $id = $testimonial->ID;
        $name = $testimonial->post_title;
        $content = $testimonial->post_content;
        $date = $testimonial->post_date;
        $rating = get_post_meta($id, '_wsp_stars')[0];

        $allRatings[] = $rating;

        $reviews["review"][] = [
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
            "ratingValue" => $rating
          ]
        ];
      }
    }

    $ratingCount = count($allRatings);
    $ratingValue = array_sum($allRatings) / $ratingCount;
    $ratingValue = number_format($ratingValue, 1);

    $aggregateRating = [
      "aggregateRating" => [
        "@type" => "AggregateRating",
        "ratingValue" => $ratingValue,
        "ratingCount" => $ratingCount
      ]
    ];

    // reset the query
    wp_reset_query();

    $output = array_merge($aggregateRating, $reviews);
    return $output;
  }

  // manual rating must gather only the numbers
  function manualRating(){
    $manual = [
      "aggregateRating" => [
        "@type" => "AggregateRating",
        "ratingValue" => get_option('wsp_ManualRating'),
        "reviewCount" => get_option('wsp_ManualReviews')
      ]
    ];

    return $manual;
  }

  // prepare the json-ld
  function prepare_json(){
    $array = [
      "@context" => "http://www.schema.org",
      "@type" => get_option('wsp_LocalBusinessType'),
      "name" => get_option('wsp_BusinessName'),
      "url" => get_bloginfo('wpurl'),
      "logo" => self::get_businessLogo(),
      "image" => self::get_businessImage(),
      "description" => get_option('wsp_Description'),
      "telephone" => self::get_businessPhone(),
      "address" => [
        "@type" => "PostalAddress",
        "streetAddress" => get_option('wsp_Address'),
        "addressLocality" => get_option('wsp_City'),
        "addressRegion" => get_option('wsp_StateRegion'),
        "postalCode" => get_option('wsp_PostalCode'),
        "addressCountry" => get_option('wsp_Country')
      ],
      "geo" => [
        "@type" => "GeoCoordinates",
        "latitude" => get_option('wsp_Lattitude'),
        "longitude" => get_option('wsp_Longtitude')
      ],
      "openingHours" => self::get_businessTimes(),
      "contactPoint" => [
        "@type" => "ContactPoint",
        "telephone" => self::get_businessPhone(),
        "contactType" => "customer service"
      ]
    ];

    if(get_option('wsp_ToggleAutomatic') == 'on'){
      $aggregateRating = self::automaticRating();

      $array = array_merge($array, $aggregateRating);
    } else {
      $aggregateRating = self::manualRating();

      $array = array_merge($array, $aggregateRating);
    }

    return json_encode($array);
  }
}


function get_json() {
  $jsonld = new wp_schema_plugin_json();
  $jsonld = $jsonld->prepare_json();
    ?>
      <script type='application/ld+json'>
        <?php
          echo $jsonld;
        ?>
      </script>
    <?php
}

add_action('wp_head', 'get_json');
?>
