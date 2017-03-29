<?php

if (! defined('ABSPATH')) {
    exit;
}

class wp_schema_plugin_Settings
{

    /**
     * The single instance of wp_schema_plugin_Settings.
     * @var 	object
     * @access  private
     * @since 	1.0.0
     */
    private static $_instance = null;

    /**
     * The main plugin object.
     * @var 	object
     * @access  public
     * @since 	1.0.0
     */
    public $parent = null;

    /**
     * Prefix for plugin settings.
     * @var     string
     * @access  public
     * @since   1.0.0
     */
    public $base = '';

    /**
     * Available settings for plugin.
     * @var     array
     * @access  public
     * @since   1.0.0
     */
    public $settings = array();

    public function __construct($parent)
    {
        $this->parent = $parent;

        $this->base = 'wsp_';

        // Initialise settings
        add_action('init', array( $this, 'init_settings' ), 11);

        // Register plugin settings
        add_action('admin_init', array( $this, 'register_settings' ));

        // Add settings page to menu
        add_action('admin_menu', array( $this, 'add_menu_item' ));

        // Add settings link to plugins page
        add_filter('plugin_action_links_' . plugin_basename($this->parent->file), array( $this, 'add_settings_link' ));
    }

    /**
     * Initialise settings
     * @return void
     */
    public function init_settings()
    {
        $this->settings = $this->settings_fields();
    }

    /**
     * Add settings page to admin menu
     * @return void
     */
    public function add_menu_item()
    {
      $page = add_menu_page(
				__('Schema Settings','wp-schema-plugin'), 								// page title
				__('Schema Settings','wp-schema-plugin'),  								// menu title
				'manage_options', $this->parent->_token . '_settings', 		// capability
				array( $this, 'settings_page' ),													// menu slug
				'dashicons-welcome-view-site', 														// icon url
				69 // position
			);
      add_action(
				'admin_print_styles-' . $page,
				array( $this, 'settings_assets' )
			);
    }

    /**
     * Load settings JS & CSS
     * @return void
     */
    public function settings_assets()
    {

        // We're including the farbtastic script & styles here because they're needed for the colour picker
        // If you're not including a colour picker field then you can leave these calls out as well as the farbtastic dependency for the wpt-admin-js script below
        wp_enqueue_style('farbtastic');
        wp_enqueue_script('farbtastic');

        // We're including the WP media scripts here because they're needed for the image upload field
        // If you're not including an image upload then you can leave this function call out
        wp_enqueue_media();

        wp_register_script($this->parent->_token . '-settings-js', $this->parent->assets_url . 'js/settings' . $this->parent->script_suffix . '.js', array( 'farbtastic', 'jquery' ), '1.0.0');
        wp_enqueue_script($this->parent->_token . '-settings-js');
    }

    /**
     * Add settings link to plugin list table
     * @param  array $links Existing links
     * @return array 		Modified links
     */
    public function add_settings_link($links)
    {
        $settings_link = '<a href="options-general.php?page=' . $this->parent->_token . '_settings">' . __('Settings', 'wp-schema-plugin') . '</a>';
        array_push($links, $settings_link);
        return $links;
    }

    /**
     * Build settings fields
     * @return array Fields to be displayed on settings page
     */
    private function settings_fields()
    {
        $indent = '&nbsp;&nbsp;';
        $settings['localBusiness'] = array(
            'title'                  => __('Local Business', 'wp-schema-plugin'),
            'description'            => __('Be as precise as possible', 'wp-schema-plugin'),
            'fields'                 => array(
                array(
                    'id'             => 'LocalBusinessType',
                    'label'          => __('Local Business Type', 'wp-schema-plugin'),
                    'description'    => __('A local business select box.', 'wp-schema-plugin'),
                    'type'           => 'select',
                    'options'        => array(
                      'ProfessionalService' => 'ProfessionalService',
                        'LocalBusiness' => $indent . 'LocalBusiness',
                        'AnimalShelter' => $indent . 'AnimalShelter',
                        'AutomotiveBusiness' => $indent . 'AutomotiveBusiness',
                          'AutoBodyShop' => 'AutoBodyShop',
                          'AutoDealer' => $indent . $indent .'AutoDealer',
                          'AutoPartsStore' => $indent . $indent .'AutoPartsStore',
                          'AutoRental' => $indent . $indent .'AutoRental',
                          'AutoRepair' => $indent . $indent .'AutoRepair',
                          'AutoWash' => $indent . $indent .'AutoWash',
                          'GasStation' => $indent . $indent .'GasStation',
                          'MotorcycleDealer' => $indent . $indent .'MotorcycleDealer',
                          'MotorcycleRepair' => $indent . $indent .'MotorcycleRepair',
                          'ChildCare' => $indent . 'ChildCare',
                          'Dentist' => $indent . 'Dentist',
                          'DryCleaningOrLaundry' => $indent . 'DryCleaningOrLaundry',
                          'EmergencyService' => $indent . $indent . 'EmergencyService',
                            'FireStation' => $indent . $indent . 'FireStation',
                            'Hospital' => $indent . $indent . 'Hospital',
                            'PoliceStation' => $indent . $indent . 'PoliceStation',
                          'EmploymentAgency' => $indent . 'EmploymentAgency',
                          'EntertainmentBusiness' => $indent . 'EntertainmentBusiness',
                            'AdultEntertainment' => $indent . $indent . 'AdultEntertainment',
                            'AmusementPark' => $indent . $indent . 'AmusementPark',
                            'ArtGallery' => $indent . $indent . 'ArtGallery',
                            'Casino' => $indent . $indent . 'Casino',
                            'ComedyClub' => $indent . $indent . 'ComedyClub',
                            'MovieTheater' => $indent . $indent . 'MovieTheater',
                            'NightClub' => $indent . $indent . 'NightClub',
                          'FinancialService' => $indent . 'FinancialService',
                            'AccountingService' => $indent . $indent . 'AccountingService',
                            'AutomatedTeller' => $indent . $indent . 'AutomatedTeller',
                            'BankOrCreditUnion' => $indent . $indent . 'BankOrCreditUnion',
                            'InsuranceAgency' => $indent . $indent . 'InsuranceAgency',
                          'FoodEstablishment' => $indent . $indent . 'FoodEstablishment',
                            'Bakery' => $indent . $indent . 'Bakery',
                            'BarOrPub' => $indent . $indent . 'BarOrPub',
                            'Brewery' => $indent . $indent . 'Brewery',
                            'CafeOrCoffeeShop' => $indent . $indent . 'CafeOrCoffeeShop',
                            'FastFoodRestaurant' => $indent . $indent . 'FastFoodRestaurant',
                            'IceCreamShop' => $indent . $indent . 'IceCreamShop',
                            'Restaurant' => $indent . $indent . 'Restaurant',
                            'Winery' => $indent . $indent . 'Winery',
                          'GovernmentOffice' => $indent . 'GovernmentOffice',
                            'PostOffice' => $indent . $indent . 'PostOffice',
                          'HealthAndBeautyBusiness' => $indent . 'HealthAndBeautyBusiness',
                            'BeautySalon' => $indent . $indent . 'BeautySalon',
                            'DaySpa' => $indent . $indent . 'DaySpa',
                            'HairSalon' => $indent . $indent . 'HairSalon',
                            'HealthClub' => $indent . $indent . 'HealthClub',
                            'NailSalon' => $indent . $indent . 'NailSalon',
                            'TattooParlor' => $indent . $indent . 'TattooParlor',
                          'HomeAndConstructionBusiness' => $indent . 'HomeAndConstructionBusiness',
                            'Electrician' => $indent . $indent . 'Electrician',
                            'GeneralContractor' => $indent . $indent . 'GeneralContractor',
                            'HVACBusiness' => $indent . $indent . 'HVACBusiness',
                            'HousePainter' => $indent . $indent . 'HousePainter',
                            'Locksmith' => $indent . $indent . 'Locksmith',
                            'MovingCompany' => $indent . $indent . 'MovingCompany',
                            'Plumber' => $indent . $indent . 'Plumber',
                            'RoofingContractor' => $indent . $indent . 'RoofingContractor',
                          'InternetCafe' => $indent . 'InternetCafe',
                          'LegalService' => $indent . 'LegalService',
                            'Attorney' => $indent . $indent . 'Attorney',
                            'Notary' => $indent . $indent . 'Notary',
                            'Library' => $indent . $indent . 'Library',
                          'LodgingBusiness' => $indent . 'LodgingBusiness',
                            'BedAndBreakfast' => $indent . $indent . 'BedAndBreakfast',
                            'Campground' => $indent . $indent . 'Campground',
                            'Hostel' => $indent . $indent . 'Hostel',
                            'Hotel' => $indent . $indent . 'Hotel',
                            'Motel' => $indent . $indent . 'Motel',
                            'Resort' => $indent . $indent . 'Resort',
                          'ProfessionalService' => $indent . 'ProfessionalService',
                          'RadioStation' => $indent . 'RadioStation',
                          'RealEstateAgent' => $indent . 'RealEstateAgent',
                          'RecyclingCenter' => $indent . 'RecyclingCenter',
                          'SelfStorage' => $indent . 'SelfStorage',
                          'ShoppingCenter' => $indent . 'ShoppingCenter',
                          'SportsActivityLocation' => $indent . 'SportsActivityLocation',
                            'BowlingAlley' => $indent . $indent . 'BowlingAlley',
                            'ExerciseGym' => $indent . $indent . 'ExerciseGym',
                            'GolfCourse' => $indent . $indent . 'GolfCourse',
                            'HealthClub' => $indent . $indent . 'HealthClub',
                            'PublicSwimmingPool' => $indent . $indent . 'PublicSwimmingPool',
                            'SkiResort' => $indent . $indent . 'SkiResort',
                            'SportsClub' => $indent . $indent . 'SportsClub',
                            'StadiumOrArena' => $indent . $indent . 'StadiumOrArena',
                            'TennisComplex' => $indent . $indent . 'TennisComplex',
                          'Store' => $indent . 'Store',
                            'AutoPartsStore' => $indent . $indent . 'AutoPartsStore',
                            'BikeStore' => $indent . $indent . 'BikeStore',
                            'BookStore' => $indent . $indent . 'BookStore',
                            'ClothingStore' => $indent . $indent . 'ClothingStore',
                            'ComputerStore' => $indent . $indent . 'ComputerStore',
                            'ConvenienceStore' => $indent . $indent . 'ConvenienceStore',
                            'DepartmentStore' => $indent . $indent . 'DepartmentStore',
                            'ElectronicsStore' => $indent . $indent . 'ElectronicsStore',
                            'Florist' => $indent . $indent . 'Florist',
                            'FurnitureStore' => $indent . $indent . 'FurnitureStore',
                            'GardenStore' => $indent . $indent . 'GardenStore',
                            'GroceryStore' => $indent . $indent . 'GroceryStore',
                            'HardwareStore' => $indent . $indent . 'HardwareStore',
                            'HobbyShop' => $indent . $indent . 'HobbyShop',
                            'HomeGoodsStore' => $indent . $indent . 'HomeGoodsStore',
                            'JewelryStore' => $indent . $indent . 'JewelryStore',
                            'LiquorStore' => $indent . $indent . 'LiquorStore',
                            'MensClothingStore' => $indent . $indent . 'MensClothingStore',
                            'MobilePhoneStore' => $indent . $indent . 'MobilePhoneStore',
                            'MovieRentalStore' => $indent . $indent . 'MovieRentalStore',
                            'MusicStore' => $indent . $indent . 'MusicStore',
                            'OfficeEquipmentStore' => $indent . $indent . 'OfficeEquipmentStore',
                            'OutletStore' => $indent . $indent . 'OutletStore',
                            'PawnShop' => $indent . $indent . 'PawnShop',
                            'PetStore' => $indent . $indent . 'PetStore',
                            'ShoeStore' => $indent . $indent . 'ShoeStore',
                            'SportingGoodsStore' => $indent . $indent . 'SportingGoodsStore',
                            'TireShop' => $indent . $indent . 'TireShop',
                            'ToyStore' => $indent . $indent . 'ToyStore',
                            'WholesaleStore' => $indent . $indent . 'WholesaleStore',
                          'TelevisionStation' => $indent . 'TelevisionStation',
                          'TouristInformationCenter' => $indent . 'TouristInformationCenter',
                          'TravelAgency' => $indent . 'TravelAgency',
                    )
                ),
                array(
                    'id'             => 'BusinessName',
                    'label'          => __('BusinessName', 'wp-schema-plugin'),
                    'description'    => __('Recommended to be in site title', 'wp-schema-plugin'),
                    'type'           => 'text',
                    'default'        => get_bloginfo('name'),
                    'placeholder'    => __('', 'wp-schema-plugin')
                ),
								array(
										'id'             => 'BusinessLogo',
										'label'          => __('Business Logo', 'wp-schema-plugin'),
										'description'    => __('recommended at least 160x90 pixels and at most 1920x1080 pixels', 'wp-schema-plugin'),
										'type'           => 'image',
										'default'        => '',
										'placeholder'    => ''
								),
								array(
										'id'             => 'BusinessImage',
										'label'          => __('Business Image', 'wp-schema-plugin'),
										'description'    => __('must be at least 160x90 pixels and at most 1920x1080 pixels', 'wp-schema-plugin'),
										'type'           => 'image',
										'default'        => '',
										'placeholder'    => ''
								),
								array(
										'id'             => 'Description',
										'label'          => __('Description', 'wp-schema-plugin'),
										'description'    => __('Description of the business', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => get_bloginfo('description'),
										'placeholder'    => __('', 'wp-schema-plugin')
								),
								array(
										'id'             => 'Address',
										'label'          => __('Physical Address', 'wp-schema-plugin'),
										'description'    => __('Use main business address', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => '',
										'placeholder'    => __('', 'wp-schema-plugin')
								),
								array(
										'id'             => 'City',
										'label'          => __('City', 'wp-schema-plugin'),
										'description'    => __('', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => '',
										'placeholder'    => __('', 'wp-schema-plugin')
								),
								array(
										'id'             => 'StateRegion',
										'label'          => __('State/Region', 'wp-schema-plugin'),
										'description'    => __('', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => '',
										'placeholder'    => __('', 'wp-schema-plugin')
								),
								array(
										'id'             => 'PostalCode',
										'label'          => __('Postal Code', 'wp-schema-plugin'),
										'description'    => __('', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => '',
										'placeholder'    => __('', 'wp-schema-plugin')
								),
								array(
										'id'             => 'Country',
										'label'          => __('Country', 'wp-schema-plugin'),
										'description'    => __('The 2-letter <a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2" target="_blank">ISO 3166-1 alpha-2 country code</a>', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => '',
										'placeholder'    => __('', 'wp-schema-plugin')
								),
								array(
										'id'             => 'Lattitude',
										'label'          => __('Lattitude', 'wp-schema-plugin'),
										'description'    => __('At least 5 decimal places, <a href="http://www.latlong.net/convert-address-to-lat-long.html" target="_blank">use this service</a>', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => '',
										'placeholder'    => __('', 'wp-schema-plugin')
								),
								array(
										'id'             => 'Longtitude',
										'label'          => __('Longtitude', 'wp-schema-plugin'),
										'description'    => __('At least 5 decimal places', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => '',
										'placeholder'    => __('', 'wp-schema-plugin')
								),
								array(
										'id'             => 'BusinessDays',
										'label'          => __('Business Days', 'wp-schema-plugin'),
										'description'    => __('', 'wp-schema-plugin'),
										'type'           => 'checkbox_multi',
										'options'        => array( 'Mo' => 'Monday<br>', 'Tu' => 'Tuesday<br>', 'We' => 'Wednesday<br>', 'Th' => 'Thursday<br>', 'Fr' => 'Friday<br>', 'Sa' => 'Saturday<br>', 'Su' => 'Sunday<br>' ),
										'default'        => array( 'circle', 'triangle' )
								),
								array(
										'id'             => 'BusinessHoursOpening',
										'label'          => __('Business Hours Opening', 'wp-schema-plugin'),
										'description'    => __('', 'wp-schema-plugin'),
										'type'           => 'select',
										'options'				 => array('01:00' => '00:00', '01:00' => '00:30', '01:00' => '01:00', '01:30' => '01:30', '02:00' => '02:00', '02:30' => '02:30', '03:00' => '03:00', '03:30' => '03:30', '04:00' => '04:00', '04:30' => '04:30', '05:00' => '05:00', '05:30' => '05:30', '06:00' => '06:00', '06:30' => '06:30', '07:00' => '07:00', '07:30' => '07:30', '08:00' => '08:00', '08:30' => '08:30', '09:00' => '09:00', '09:30' => '09:30', '10:00' => '10:00', '10:30' => '10:30', '11:00' => '11:00', '11:30' => '11:30', '12:00' => '12:00', '12:30' => '12:30', '13:00' => '13:00', '13:30' => '13:30', '14:00' => '14:00', '14:30' => '14:30', '15:00' => '15:00', '15:30' => '15:30', '16:00' => '16:00', '16:30' => '16:30', '17:00' => '17:00', '17:30' => '17:30', '18:00' => '18:00', '18:30' => '18:30', '19:00' => '19:00', '19:30' => '19:30', '20:00' => '20:00', '20:30' => '20:30', '21:00' => '21:00', '21:30' => '21:30', '22:00' => '22:00', '22:30' => '22:30', '23:00' => '23:00', '23:30' => '23:30'),
										'default'        => array( 'circle', 'triangle' )
								),
								array(
										'id'             => 'BusinessHoursClosing',
										'label'          => __('Business Hours Closing', 'wp-schema-plugin'),
										'description'    => __('', 'wp-schema-plugin'),
										'type'           => 'select',
										'options'				 => array('01:00' => '00:00', '01:00' => '00:30', '01:00' => '01:00', '01:30' => '01:30', '02:00' => '02:00', '02:30' => '02:30', '03:00' => '03:00', '03:30' => '03:30', '04:00' => '04:00', '04:30' => '04:30', '05:00' => '05:00', '05:30' => '05:30', '06:00' => '06:00', '06:30' => '06:30', '07:00' => '07:00', '07:30' => '07:30', '08:00' => '08:00', '08:30' => '08:30', '09:00' => '09:00', '09:30' => '09:30', '10:00' => '10:00', '10:30' => '10:30', '11:00' => '11:00', '11:30' => '11:30', '12:00' => '12:00', '12:30' => '12:30', '13:00' => '13:00', '13:30' => '13:30', '14:00' => '14:00', '14:30' => '14:30', '15:00' => '15:00', '15:30' => '15:30', '16:00' => '16:00', '16:30' => '16:30', '17:00' => '17:00', '17:30' => '17:30', '18:00' => '18:00', '18:30' => '18:30', '19:00' => '19:00', '19:30' => '19:30', '20:00' => '20:00', '20:30' => '20:30', '21:00' => '21:00', '21:30' => '21:30', '22:00' => '22:00', '22:30' => '22:30', '23:00' => '23:00', '23:30' => '23:30'),
										'default'        => array( 'circle', 'triangle' )
								),
								array(
										'id'             => 'BusinessPhone',
										'label'          => __('Business Phone', 'wp-schema-plugin'),
										'description'    => __('example: (555)555-555', 'wp-schema-plugin'),
										'type'           => 'text',
										'default'        => '',
										'placeholder'    => __('', 'wp-schema-plugin')
								),
                array(
                    'id'             => 'PriceRange',
                    'label'          => __('Price Range ($-$$$$)', 'wp-schema-plugin'),
                    'description'    => __('$ = Inexpensive / $$ = Moderately expensive / $$$ = Expensive / $$$$ = Very Expensive or just \'$50 - $500\'', 'wp-schema-plugin'),
                    'type'           => 'text',
                    'default'        => '',
                    'placeholder'    => __('', 'wp-schema-plugin')
                )
            )
        );
          $settings['AggregateRating'] = array(
            'title'                  => __('Aggregate Rating', 'wp-schema-plugin'),
            'description'            => __('Aggregate Rating Generator - seup Rating or make it automatic', 'wp-schema-plugin'),
            'fields'                 => array(
              array(
                  'id'             => 'ToggleAutomatic',
                  'label'          => __('Automatic Reviews (off/on)', 'wp-schema-plugin'),
                  'description'    => __('Reviews will be gathered from Testimonial post type (Recommended)', 'wp-schema-plugin'),
                  'type'           => 'checkbox',
                  'default'        => ''
              ),
							array(
									'id'             => 'ManualRating',
									'label'          => __('Rating', 'wp-schema-plugin'),
									'description'    => __('Scale from 1 - 5', 'wp-schema-plugin'),
									'type'           => 'text',
									'default'        => '',
									'placeholder'    => __('', 'wp-schema-plugin')
							),
							array(
									'id'             => 'ManualReviews',
									'label'          => __('Reviews', 'wp-schema-plugin'),
									'description'    => __('be reasonable', 'wp-schema-plugin'),
									'type'           => 'number',
									'default'        => '',
									'placeholder'    => __('', 'wp-schema-plugin')
							)
            )
				);
        $settings['SocialProfiles'] = array(
            'title'                  => __('Social Profiles', 'wp-schema-plugin'),
            'description'            => __('Social profiles for even richer Google Rich Snippets. Starred (*) networks are Google approved, others are for information purposes only. Provide only full links to the profile', 'wp-schema-plugin'),
            'fields'                 => array(
              array(
                  'id'             => 'social_facebook',
                  'label'          => __('Facebook *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://facebook.com/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_twitter',
                  'label'          => __('Twitter *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('htts://twitter.com/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_google-plus',
                  'label'          => __('Google+ *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://plus.google.com/+', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_instagram',
                  'label'          => __('Instagram *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://instagram.com/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_youtube',
                  'label'          => __('YouTube *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://youtube.com/user/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_linkedin',
                  'label'          => __('LinkedIn *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://www.linkedin.com/in/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_myspace',
                  'label'          => __('Myspace *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://myspace.com/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_pinterest',
                  'label'          => __('Pinterest *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://pinterest.com/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_soundcloud',
                  'label'          => __('Soundcloud *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://soundcloud.com/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_tumblr',
                  'label'          => __('Tumblr *', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('https://username.tumblr.com/', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_avvo',
                  'label'          => __('Avvo', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('', 'wp-schema-plugin')
              ),
              array(
                  'id'             => 'social_yelp',
                  'label'          => __('Yelp', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'text',
                  'default'        => '',
                  'placeholder'    => __('', 'wp-schema-plugin')
              )
            )
        );
        // $settings['Navigation'] = array(
        //   'title'                  => __('Navigation', 'wp-schema-plugin'),
        //   'description'            => __('Navigation', 'wp-schema-plugin'),
        //   'fields'                 => array(
        //     array(
        //         'id'             => 'navsnip1',
        //         'label'          => __('Navigation snippet #1', 'wp-schema-plugin'),
        //         'description'    => __('', 'wp-schema-plugin'),
        //         'type'           => 'articles'
        //     ),
        //     array(
        //         'id'             => 'navsnip2',
        //         'label'          => __('Navigation snippet #2', 'wp-schema-plugin'),
        //         'description'    => __('', 'wp-schema-plugin'),
        //         'type'           => 'articles'
        //     ),
        //     array(
        //         'id'             => 'navsnip3',
        //         'label'          => __('Navigation snippet #3', 'wp-schema-plugin'),
        //         'description'    => __('', 'wp-schema-plugin'),
        //         'type'           => 'articles'
        //     ),
        //     array(
        //         'id'             => 'navsnip4',
        //         'label'          => __('Navigation snippet #4', 'wp-schema-plugin'),
        //         'description'    => __('', 'wp-schema-plugin'),
        //         'type'           => 'articles'
        //     ),
        //     array(
        //         'id'             => 'navsnip5',
        //         'label'          => __('Navigation snippet #5', 'wp-schema-plugin'),
        //         'description'    => __('', 'wp-schema-plugin'),
        //         'type'           => 'articles'
        //     ),
        //     array(
        //         'id'             => 'navsnip6',
        //         'label'          => __('Navigation snippet #6', 'wp-schema-plugin'),
        //         'description'    => __('', 'wp-schema-plugin'),
        //         'type'           => 'articles'
        //     )
        //   )
        // );
        $settings['Breadcrumbs'] = array(
            'title'                  => __('Breadcrumbs', 'wp-schema-plugin'),
            'description'            => __('Breadcrumbs', 'wp-schema-plugin'),
            'fields'                 => array(
              array(
                  'id'             => 'Breadcrumbs',
                  'label'          => __('Breadcrumbs (off/on)', 'wp-schema-plugin'),
                  'description'    => __('Will allow breadcrumbs (Recommended)', 'wp-schema-plugin'),
                  'type'           => 'checkbox',
                  'default'        => ''
              ),
              array(
                  'id'             => 'BreadcrumbSpacing',
                  'label'          => __('Breadcrumb Spacing', 'wp-schema-plugin'),
                  'description'    => __('', 'wp-schema-plugin'),
                  'type'           => 'select',
                  'options'        => array(
                    '' => '',
                    '&#47' => ' &#47 ',
                    '&#92 ' => ' &#92 ',
                    '&#62' => ' &#62 ',
                    '&rsaquo;' => ' &rsaquo; ',
                    '&raquo;' => ' &raquo; ',
                    'nothing' => 'nothing'
                  )
                )
              )
          );

        // /* I want all of this repeat when client adds extra department; */
        // $settings['Departments'] = array(
        //     'title'                  => __('Departments', 'wp-schema-plugin'),
        //     'description'            => __('Aggregate Rating Generator - seup Rating or make it automatic', 'wp-schema-plugin'),
        //     'fields'                 => array(
        //
        //       array(
        //           'id'             => 'DepartmentName',
        //           'label'          => __('Department Name', 'wp-schema-plugin'),
        //           'description'    => __('Typically "Gotham office"', 'wp-schema-plugin'),
        //           'type'           => 'text',
        //           'default'        => '',
        //           'placeholder'    => __(get_bloginfo('name') . ' Example city', 'wp-schema-plugin')
        //       ),
        //         array(
        //             'id'             => 'DepartmentImage',
        //             'label'          => __('Department image', 'wp-schema-plugin'),
        //             'description'    => __('must be at least 160x90 pixels and at most 1920x1080 pixels, will default to main image/logo', 'wp-schema-plugin'),
        //             'type'           => 'image',
        //             'default'        => wp_get_attachment_image_src(get_option('wsp_BusinessLogo'))[0],
        //             'placeholder'    => ''
        //         ),
        //         array(
        //             'id'             => 'DepartmentPhone',
        //             'label'          => __('Department Phone', 'wp-schema-plugin'),
        //             'description'    => __('', 'wp-schema-plugin'),
        //             'type'           => 'text',
        //             'default'        => '',
        //             'placeholder'    => __('', 'wp-schema-plugin')
        //         ),
        //         array(
        //             'id'             => 'DepartmentAddress',
        //             'label'          => __('Department Physical Address', 'wp-schema-plugin'),
        //             'description'    => __('Department address', 'wp-schema-plugin'),
        //             'type'           => 'text',
        //             'default'        => '',
        //             'placeholder'    => __('', 'wp-schema-plugin')
        //         ),
        //         array(
        //             'id'             => 'DepartmentCity',
        //             'label'          => __('Department City', 'wp-schema-plugin'),
        //             'description'    => __('', 'wp-schema-plugin'),
        //             'type'           => 'text',
        //             'default'        => '',
        //             'placeholder'    => __('', 'wp-schema-plugin')
        //         ),
        //         array(
        //             'id'             => 'DepartmentStateRegion',
        //             'label'          => __('Department State/Region', 'wp-schema-plugin'),
        //             'description'    => __('', 'wp-schema-plugin'),
        //             'type'           => 'text',
        //             'default'        => '',
        //             'placeholder'    => __('', 'wp-schema-plugin')
        //         ),
        //         array(
        //             'id'             => 'DepartmentPostalCode',
        //             'label'          => __('Department Postal Code', 'wp-schema-plugin'),
        //             'description'    => __('', 'wp-schema-plugin'),
        //             'type'           => 'text',
        //             'default'        => '',
        //             'placeholder'    => __('', 'wp-schema-plugin')
        //         ),
        //         array(
        //             'id'             => 'DepartmentCountry',
        //             'label'          => __('Department Country', 'wp-schema-plugin'),
        //             'description'    => __('The 2-letter <a href="https://en.wikipedia.org/wiki/ISO_3166-1_alpha-2" target="_blank">ISO 3166-1 alpha-2 country code</a>, will default to main country', 'wp-schema-plugin'),
        //             'type'           => 'text',
        //             'default'        => get_option('wsp_Country'),
        //             'placeholder'    => __('', 'wp-schema-plugin')
        //         ),
        //         array(
        //             'id'             => 'DepartmentBusinessDays',
        //             'label'          => __('Department Business Days', 'wp-schema-plugin'),
        //             'description'    => __('', 'wp-schema-plugin'),
        //             'type'           => 'checkbox_multi',
        //             'options'        => array( 'Mo' => 'Monday<br>', 'Tu' => 'Tuesday<br>', 'We' => 'Wednesday<br>', 'Th' => 'Thursday<br>', 'Fr' => 'Friday<br>', 'Sa' => 'Saturday<br>', 'Su' => 'Sunday<br>' ),
        //             'default'        => array( 'circle', 'triangle' )
        //         ),
        //         array(
        //             'id'             => 'DepartmentBusinessHoursOpening',
        //             'label'          => __('Department Business Hours Opening', 'wp-schema-plugin'),
        //             'description'    => __('', 'wp-schema-plugin'),
        //             'type'           => 'select',
        //             'options'				 => array('01:00' => '00:00', '01:00' => '00:30', '01:00' => '01:00', '01:30' => '01:30', '02:00' => '02:00', '02:30' => '02:30', '03:00' => '03:00', '03:30' => '03:30', '04:00' => '04:00', '04:30' => '04:30', '05:00' => '05:00', '05:30' => '05:30', '06:00' => '06:00', '06:30' => '06:30', '07:00' => '07:00', '07:30' => '07:30', '08:00' => '08:00', '08:30' => '08:30', '09:00' => '09:00', '09:30' => '09:30', '10:00' => '10:00', '10:30' => '10:30', '11:00' => '11:00', '11:30' => '11:30', '12:00' => '12:00', '12:30' => '12:30', '13:00' => '13:00', '13:30' => '13:30', '14:00' => '14:00', '14:30' => '14:30', '15:00' => '15:00', '15:30' => '15:30', '16:00' => '16:00', '16:30' => '16:30', '17:00' => '17:00', '17:30' => '17:30', '18:00' => '18:00', '18:30' => '18:30', '19:00' => '19:00', '19:30' => '19:30', '20:00' => '20:00', '20:30' => '20:30', '21:00' => '21:00', '21:30' => '21:30', '22:00' => '22:00', '22:30' => '22:30', '23:00' => '23:00', '23:30' => '23:30'),
        //             'default'        => array( 'circle', 'triangle' )
        //         ),
        //         array(
        //             'id'             => 'DepartmentBusinessHoursClosing',
        //             'label'          => __('Department Business Hours Closing', 'wp-schema-plugin'),
        //             'description'    => __('', 'wp-schema-plugin'),
        //             'type'           => 'select',
        //             'options'				 => array('01:00' => '00:00', '01:00' => '00:30', '01:00' => '01:00', '01:30' => '01:30', '02:00' => '02:00', '02:30' => '02:30', '03:00' => '03:00', '03:30' => '03:30', '04:00' => '04:00', '04:30' => '04:30', '05:00' => '05:00', '05:30' => '05:30', '06:00' => '06:00', '06:30' => '06:30', '07:00' => '07:00', '07:30' => '07:30', '08:00' => '08:00', '08:30' => '08:30', '09:00' => '09:00', '09:30' => '09:30', '10:00' => '10:00', '10:30' => '10:30', '11:00' => '11:00', '11:30' => '11:30', '12:00' => '12:00', '12:30' => '12:30', '13:00' => '13:00', '13:30' => '13:30', '14:00' => '14:00', '14:30' => '14:30', '15:00' => '15:00', '15:30' => '15:30', '16:00' => '16:00', '16:30' => '16:30', '17:00' => '17:00', '17:30' => '17:30', '18:00' => '18:00', '18:30' => '18:30', '19:00' => '19:00', '19:30' => '19:30', '20:00' => '20:00', '20:30' => '20:30', '21:00' => '21:00', '21:30' => '21:30', '22:00' => '22:00', '22:30' => '22:30', '23:00' => '23:00', '23:30' => '23:30'),
        //             'default'        => array( 'circle', 'triangle' )
        //         ),
        //         array(
        //             'id'             => 'DepartmentBusinessPhone',
        //             'label'          => __('Department Business Phone', 'wp-schema-plugin'),
        //             'description'    => __('example: (555)555-555', 'wp-schema-plugin'),
        //             'type'           => 'text',
        //             'default'        => '',
        //             'placeholder'    => __('', 'wp-schema-plugin')
        //         )
        //     )
        // );

        $settings = apply_filters($this->parent->_token . '_settings_fields', $settings);

        return $settings;
    }

    /**
     * Register plugin settings
     * @return void
     */
    public function register_settings()
    {
        if (is_array($this->settings)) {

            // Check posted/selected tab
            $current_section = '';
            if (isset($_POST['tab']) && $_POST['tab']) {
                $current_section = $_POST['tab'];
            } else {
                if (isset($_GET['tab']) && $_GET['tab']) {
                    $current_section = $_GET['tab'];
                }
            }

            foreach ($this->settings as $section => $data) {
                if ($current_section && $current_section != $section) {
                    continue;
                }

                // Add section to page
                add_settings_section($section, $data['title'], array( $this, 'settings_section' ), $this->parent->_token . '_settings');

                foreach ($data['fields'] as $field) {

                    // Validation callback for field
                    $validation = '';
                    if (isset($field['callback'])) {
                        $validation = $field['callback'];
                    }

                    // Register field
                    $option_name = $this->base . $field['id'];
                    register_setting($this->parent->_token . '_settings', $option_name, $validation);

                    // Add field to page
                    add_settings_field($field['id'], $field['label'], array( $this->parent->admin, 'display_field' ), $this->parent->_token . '_settings', $section, array( 'field' => $field, 'prefix' => $this->base ));
                }

                if (! $current_section) {
                    break;
                }
            }
        }
    }

    public function settings_section($section)
    {
        $html = '<p> ' . $this->settings[ $section['id'] ]['description'] . '</p>' . "\n";
        echo $html;
    }

    /**
     * Load settings page content
     * @return void
     */
    public function settings_page()
    {

        // Build page HTML
        $html = '<div class="wrap" id="' . $this->parent->_token . '_settings">' . "\n";
        $html .= '<h2>' . __('Schema Settings', 'wp-schema-plugin') . '</h2>' . "\n";

        $tab = '';
        if (isset($_GET['tab']) && $_GET['tab']) {
            $tab .= $_GET['tab'];
        }

            // Show page tabs
            if (is_array($this->settings) && 1 < count($this->settings)) {
                $html .= '<h2 class="nav-tab-wrapper">' . "\n";

                $c = 0;
                foreach ($this->settings as $section => $data) {

                    // Set tab class
                    $class = 'nav-tab';
                    if (! isset($_GET['tab'])) {
                        if (0 == $c) {
                            $class .= ' nav-tab-active';
                        }
                    } else {
                        if (isset($_GET['tab']) && $section == $_GET['tab']) {
                            $class .= ' nav-tab-active';
                        }
                    }

                    // Set tab link
                    $tab_link = add_query_arg(array( 'tab' => $section ));
                    if (isset($_GET['settings-updated'])) {
                        $tab_link = remove_query_arg('settings-updated', $tab_link);
                    }

                    // Output tab
                    $html .= '<a href="' . $tab_link . '" class="' . esc_attr($class) . '">' . esc_html($data['title']) . '</a>' . "\n";

                    ++$c;
                }

                $html .= '</h2>' . "\n";
            }

        $html .= '<form method="post" action="options.php" enctype="multipart/form-data">' . "\n";

                // Get settings fields
                ob_start();
        settings_fields($this->parent->_token . '_settings');
        do_settings_sections($this->parent->_token . '_settings');
        $html .= ob_get_clean();

        $html .= '<p class="submit">' . "\n";
        $html .= '<input type="hidden" name="tab" value="' . esc_attr($tab) . '" />' . "\n";
        $html .= '<input name="Submit" type="submit" class="button-primary" value="' . esc_attr(__('Save Settings', 'wp-schema-plugin')) . '" />' . "\n";
        $html .= '</p>' . "\n";
        $html .= '</form>' . "\n";
        $html .= '</div>' . "\n";

        echo $html;
    }

    /**
     * Main wp_schema_plugin_Settings Instance
     *
     * Ensures only one instance of wp_schema_plugin_Settings is loaded or can be loaded.
     *
     * @since 1.0.0
     * @static
     * @see wp_schema_plugin()
     * @return Main wp_schema_plugin_Settings instance
     */
    public static function instance($parent)
    {
        if (is_null(self::$_instance)) {
            self::$_instance = new self($parent);
        }
        return self::$_instance;
    } // End instance()

    /**
     * Cloning is forbidden.
     *
     * @since 1.0.0
     */
    public function __clone()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->parent->_version);
    } // End __clone()

    /**
     * Unserializing instances of this class is forbidden.
     *
     * @since 1.0.0
     */
    public function __wakeup()
    {
        _doing_it_wrong(__FUNCTION__, __('Cheatin&#8217; huh?'), $this->parent->_version);
    } // End __wakeup()
}
