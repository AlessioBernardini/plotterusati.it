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

                'theme' => array(	       'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Change the color theme'),
                                            'options'   => array(   'default'   => 'Blue',
                                                                    'green'     => 'Green',
                                                                    'orange'    => 'Orange',
                                                                ),
                                            'default'   => 'default',
                                            'required'  => TRUE,
                                            'category'  => __('Color'),
                ),
                'theme_color' => array(    'type'      => 'text',
                                            'display'   => 'color',
                                            'label'     => __('Select the color that styles the mobile browser interface.'),
                                            'default'   => '',
                                            'category'  => __('Color')),

                /*'admin_theme' => array(     'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Change the admin color theme'),
                                            'options'   => array(   'bootstrap' => 'Original',
                                                                    'cerulean'  => 'Dark Blue',
                                                                    'cosmo'     => 'Metro Style',
                                                                    'spacelab'  => 'Nice Grey',
                                                                    'united'    => 'Purple / Orange',
                                                                ),
                                            'default'   => 'bootstrap',
                                            'required'  => TRUE),*/

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
                                            'category'  => __('Typography'),),

                'breadcrumb' => array(   'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Display breadcrumb'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '1',
                                            'required'  => TRUE,
                                            'category'  => __('Layout')),

                'fixed_toolbar' => array(   'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Header tool bar gets fixed in the top'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '1',
                                            'required'  => TRUE,
                                            'category'  => __('Layout')),

                'logo_url' => array(   'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your Logo. Recommended size 250px x 40px and file format PNG. Leave blank for none.'),
                                            'default'   => '',
                                            'category'  => __('General'),),

                'favicon_url' => array(     'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your favicon. Leave blank for none.'),
                                            'default'   => '',
                                            'category'  => __('General'),),

                'apple-touch-icon' => array( 'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your apple-touch-icon. Recommended size 57px x 57px. Leave blank for none.'),
                                            'default'   => '',
                                            'category'  => __('General'),),

                'default_profile_image' => array(   'type'      => 'text',
                                            'display'   => 'logo',
                                            'label'     => __('Upload your default profile image.'),
                                            'default'   => '',
                                            'category'  => __('General')),

                'num_home_latest_ads' => array(   'type'      => 'text',
                                            'display'   => 'text',
                                            'label'     => __('Numbers of ads to display in home slider'),
                                            'default'   => 21,
                                            'required'  => TRUE,
                                            'category'  => __('Homepage')),

                'sidebar_position' => array(   'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Where you want the sidebar to appear'),
                                            'options'   => array(   'none' => __('None'),
                                                                    'right' => __('Right side'),
                                                                    'left'  => __('Left side'),
                                                                ),
                                            'default'   => 'right',
                                            'required'  => TRUE,
                                            'category'  => __('Layout')),

                'listing_slider' => array(   'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Display slider in listing'),
                                            'options'   => array(
                                                                    '0'  => __('None'),
                                                                    '1' => __('Default'),
                                                                    '2'  => __('Featured'),
                                                                    '3' => __('Featured Random')
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
                                            'category'  => __('Listing')),
                'listgrid' => array(   'type'      => 'text',
                                        'display'   => 'select',
                                        'label'     => __('Default state for list/grid in listing'),
                                        'options'   => array(
                                                                '0'  => __('Grid'),
                                                                '1' => __('List'),
                                                                ),
                                            'default'   => '1',
                                            'required'  => TRUE,
                                            'category'  => __('Listing')),
                'minimal_list' => array('type'      => 'text',
                                        'display'   => 'select',
                                        'label'     => __('Enable minimal list option in listing'),
                                        'options'   => array('0' => __('No'),
                                                             '1' => __('Yes'),
                                                            ),
                                        'default'   => '0',
                                        'required'  => TRUE,
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

                'category_badge' => array(  'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Disable category counter badge'),
                                            'options'   => array(
                                                                    '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
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

                'header_ad' => array(       'type'      => 'text',
                                            'display'   => 'textarea',
                                            'label'     => __('Header banner, allows HTML'),
                                            'default'   => '',
                                            'category'  => __('General')),
                'footer_ad' => array(       'type'      => 'text',
                                            'display'   => 'textarea',
                                            'label'     => __('Footer banner, allows HTML'),
                                            'default'   => '',
                                            'category'  => __('General')),
                'listing_ad' => array(       'type'      => 'text',
                                            'display'   => 'textarea',
                                            'label'     => __('Listing random position banner, allows HTML'),
                                            'default'   => '',
                                            'category'  => __('Listing')),
                'homepage_html' => array(   'type'      => 'text',
                                            'display'   => 'textarea',
                                            'label'     => __('Homepage Only Header, allows HTML'),
                                            'default'   => '',
                                            'category'  => __('Homepage')),
                'rtl' => array(             'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Content shift right to left'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
                                            'category'  => __('General')),
                'cdn_files' => array(       'type'      => 'text',
                                            'display'   => 'select',
                                            'label'     => __('Uses CDN for CSS/JS'),
                                            'options'   => array(   '1' => __('Yes'),
                                                                    '0'  => __('No'),
                                                                ),
                                            'default'   => '0',
                                            'required'  => TRUE,
                                            'category'  => __('General')),
                'hide_description_icon' => array(   'type'      => 'text',
                                                    'display'   => 'select',
                                                    'label'     => __('Hide icon on category/location description'),
                                                    'options'   => array(   '1' => __('Yes'),
                                                                            '0' => __('No'),
                                                                        ),
                                                    'default'   => '0',
                                                    'required'  => TRUE,
                                                    'category'  => __('Listing')),

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