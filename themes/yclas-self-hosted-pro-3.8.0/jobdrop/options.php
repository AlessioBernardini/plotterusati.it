<?php defined('SYSPATH') or die('No direct access allowed.');


/**
 * custom options for the theme
 * @var array
 */
return array(   'premium' => array( 'type'      => 'numeric',
                                                'display'   => 'hidden',
                                                'default'   => 1,
                                                'required'  => TRUE,
                                                'category'  => __('General')),
                'theme_config' => array(  'type'      => 'numeric',
                                                'display'   => 'hidden',
                                                'default'   => 0,
                                                'required'  => TRUE,
                                                'category'  => __('General')),
                'theme' => array(   'type'      => 'text',
                                    'display'   => 'select',
                                    'label'     => __('Change the color scheme and style of the theme'),
                                    'options'   => array(   'oc'        => 'OC',
                                    						'red'        => 'Red',
                                    						'blue'        => 'Blue',
                                    						'amber'        => 'Amber',
                                    						'orange'        => 'Orange',
                                    						'teal'        => 'Teal',
                                                        ),
                                    'default'   => 'oc',
                                    'required'  => TRUE,
                                    'category'  => __('Color')),
                'theme_color' => array(    'type'      => 'text',
                                            'display'   => 'color',
                                            'label'     => __('Select the color that styles the mobile browser interface.'),
                                            'default'   => '',
                                            'category'  => __('Color')),

                'body_font' => array(       'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Body Font'),
                                            'options'   => array(   '' => 'Default',
                                                    '//fonts.googleapis.com/css?family=Open+Sans:400,700|Open Sans' => 'Open Sans',
                                                    '//fonts.googleapis.com/css?family=Roboto:400,700|Roboto' => 'Roboto',
                                                    '//fonts.googleapis.com/css?family=Lato:400,700|Lato' => 'Lato',
                                                    '//fonts.googleapis.com/css?family=Slabo+27px:400,700|Slabo 27px' => 'Slabo 27px',
                                                    '//fonts.googleapis.com/css?family=Oswald:400,700|Oswald' => 'Oswald',
                                                    '//fonts.googleapis.com/css?family=Roboto+Condensed:400,700|Roboto Condensed' => 'Roboto Condensed',
                                                    '//fonts.googleapis.com/css?family=Source+Sans+Pro:400,700|Source Sans Pro' => 'Source Sans Pro',
                                                    '//fonts.googleapis.com/css?family=Montserrat:400,700|Montserrat' => 'Montserrat',
                                                    '//fonts.googleapis.com/css?family=Lora:400,700|Lora' => 'Lora',
                                                    '//fonts.googleapis.com/css?family=PT+Sans:400,700|PT Sans' => 'PT Sans',
                                                    '//fonts.googleapis.com/css?family=Raleway:400,700|Raleway' => 'Raleway',
                                                    '//fonts.googleapis.com/css?family=Open+Sans+Condensed:400,700|Open Sans Condensed' => 'Open Sans Condensed',
                                                    '//fonts.googleapis.com/css?family=Droid+Sans:400,700|Droid Sans' => 'Droid Sans',
                                                    '//fonts.googleapis.com/css?family=Ubuntu:400,700|Ubuntu' => 'Ubuntu',
                                                    '//fonts.googleapis.com/css?family=Droid+Serif:400,700|Droid Serif' => 'Droid Serif',
                                                    '//fonts.googleapis.com/css?family=Roboto+Slab:400,700|Roboto Slab' => 'Roboto Slab',
                                                    '//fonts.googleapis.com/css?family=Merriweather:400,700|Merriweather' => 'Merriweather',
                                                    '//fonts.googleapis.com/css?family=Arimo:400,700|Arimo' => 'Arimo',
                                                    '//fonts.googleapis.com/css?family=PT+Sans+Narrow:400,700|PT Sans Narrow' => 'PT Sans Narrow',
                                                    '//fonts.googleapis.com/css?family=Noto+Sans:400,700|Noto Sans' => 'Noto Sans'
                                                                ),
                                            'default'   => '',
                                            'category'  => __('Typography')),

                'breadcrumb' => array(      'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Display breadcrumb'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
                                            'category'  => __('Layout')),

                'logo_url' => array(        'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your logo. Recommended size 250px x 40px and file format PNG. Leave blank for none.'),
                                            'default'   => '',
                                            'category'  => __('General')),
                'favicon_url' => array(     'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your favicon. Leave blank for none.'),
                                            'default'   => '',
                                            'category'  => __('General')),

                'apple-touch-icon' => array( 'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your apple-touch-icon. Recommended size 57px x 57px. Leave blank for none.'),
                                            'default'   => '',
                                            'category'  => __('General')),

                'default_profile_image' => array(   'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your default profile image.'),
                                            'default'   => '',
                                            'category'  => __('General')),

                'top-banner' => array(      'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Display top banner'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
                                            'category'  => __('Layout')),
                'banner_bg_url' => array(        'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your top banner image if enabled'),
                                            'default'   => '',
                                            'category'  => __('Layout')),
                'banner-title'  => array(   'type'      => 'text',
                                            'display'   => 'text',
                                            'label'     => __('Set the title for the banner'),
                                            'default'   => '',
                                            'category'  => __('Layout')),
                'banner-subtitle' => array( 'type'      => 'text',
                                            'display'   => 'text',
                                            'label'     => __('Set the subtitle for the banner'),
                                            'default'   => '',
                                            'category'  => __('Layout')),

                'sidebar_position' => array('type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Where you want the sidebar to appear'),
                                            'options'   => array(   'none' => __('None'),
                                                                    'right' => __('Right side'),
                                                                ),
                                            'default'   => 'none',
                                            'required'  => TRUE,
                                            'category'  => __('Layout')),

                'listgrid' => array(        'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Default state for list/grid in listing'),
                                            'options'   => array(
                                                                '0'  => __('Grid'),
                                                                '1' => __('List'),
                                                                ),
                                            'default'   => '1',
                                            'required'  => TRUE,
                                            'category'  => __('Listing')),

                'date_listing' => array(    'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Show date on list view'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '1',
                                            'required'  => TRUE,
                                            'category'  => __('Listing')),
                'location_listing' => array(    'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Show location on list view'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '1',
                                            'required'  => TRUE,
                                            'category'  => __('Listing')),
                'companyname_listing' => array(    'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Show company name on list view'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '1',
                                            'required'  => TRUE,
                                            'category'  => __('Listing')),

                'header_ad_possible' => array(  'type'      => 'text',
                                            'display'   => 'textarea',
                                            'label'     => __('Header banner, allows HTML'),
                                            'default'   => '',
                                            'category'  => __('General')),
                'footer_ad_possible' => array(       'type'      => 'text',
                                            'display'   => 'textarea',
                                            'label'     => __('Footer banner, allows HTML'),
                                            'default'   => '',
                                            'category'  => __('General')),
                'listing_ad_possible' => array(       'type'      => 'text',
                                            'display'   => 'textarea',
                                            'label'     => __('Listing random position banner, allows HTML'),
                                            'default'   => '',
                                            'category'  => __('Listing')),

                 'infinite_scroll' => array(   'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Infinite scroll'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
                                            'category'  => __('Listing')),

                'footer-visual' => array(   'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Display footer visual'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '1',
                                            'required'  => TRUE,
                                            'category'  => __('Layout')),

                'footer_visual_bg_url' => array(        'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your footer visual image if enabled'),
                                            'default'   => '',
                                            'category'  => __('Layout')),

                'landing_single_ad' =>array('type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Hide header and footer on single ad, user profile page and guest checkout page'),
                                            'options'   => array(
                                                                    '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
                                            'category'  => __('Layout')),

                'cdn_files' => array(       'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Uses CDN for CSS/JS'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
                                            'category'  => __('General')),

                'amp_top_bar_color' => array(    'type'      => 'text',
                                            'display'   => 'color',
                                            'label'     => __('Select the color that styles the top bar of the AMP pages.'),
                                            'default'   => '',
                                            'category'  => __('Color')),

                'amp_custom_color' => array(    'type'      => 'text',
                                            'display'   => 'color',
                                            'label'     => __('Select the color of the AMP pages.'),
                                            'default'   => '',
                                            'category'  => __('Color')),
);