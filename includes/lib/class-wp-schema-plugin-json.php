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
      return wp_schema_plugin_json::get_businessLogo();
    }
  }

  // prepare the json-ld
  function prepare_json(){
    $array = [
      "@context" => "http://www.schema.org",
      "@type" => get_option('wsp_LocalBusinessType'),
      "name" => get_option('wsp_BusinessName'),
      "url" => get_bloginfo('wpurl'),
      "logo" => wp_schema_plugin_json::get_businessLogo(),
      "image" => wp_schema_plugin_json::get_businessImage(),
      "description" => get_option('wsp_Description'),
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
      "openingHours" => wp_schema_plugin_json::get_businessTimes(),
      "contactPoint" => [
        "@type" => "ContactPoint",
        "telephone" => wp_schema_plugin_json::get_businessPhone(),
        "contactType" => "customer service"
      ],
      "aggregateRating" => [
        "@type" => "AggregateRating",
        "ratingValue" => "3.8",
        "reviewCount" => "20"
      ]
    ];

    return json_encode($array);
  }
}
// Add hook for admin <head></head>
// add_action('admin_head', 'my_custom_js');
// Add hook for front-end <head></head>
// add_action('wp_head', 'my_custom_js');


function get_json() {
    ?>
      <script type='application/ld+json'>
        <?php echo wp_schema_plugin_json::prepare_json(); ?>
      </script>
    <?php
}

add_action('wp_head', 'get_json');
?>
