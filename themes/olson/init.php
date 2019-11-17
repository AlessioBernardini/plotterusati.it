<?php defined('SYSPATH') or die('No direct access allowed.');
/**
  * Theme Name: Olson
  * Description: The Olson theme is a neatly designed theme with an organized, clear and fresh look. It comes together with 3 different color schemes, which make it possible to change the look and feel of your classifieds website. Infinite scroll and all other premium features are supported with this theme.
  * Tags: HTML5, Responsive, Mobile, Premium, Bootstrap, Admin Themes.
  * Version: 3.7.0
  * Author: Chema <chema@open-classifieds.com> and Oliver <oliver@open-classifieds.com>
  * License: Commercial
  * Parent Theme: default
  * Skins: original,wedding,happy
  */


/**
 * placeholders & widgets for this theme
 */
Widgets::$theme_placeholders    = array('header','sidebar','footer','publish_new');


/**
 * custom options for the theme
 * @var array
 */
Theme::$options = Theme::get_options();

//we load earlier the theme since we need some info
Theme::load();

/**
 * styles and themes, loaded in this order
 */
Theme::$skin = Theme::get('theme');

//if we allow the user to select the theme/skin, perfect for the demo

if (Core::config('appearance.allow_query_theme')=='1')
{
    if (Core::get('skin')!==NULL)
    {
        Theme::$skin = Core::get('skin');
    }
    elseif (Cookie::get('skin_olson')!=='')
    {
        Theme::$skin = Cookie::get('skin_olson');
    }

    //checking the skin they want to use actually exists...
    if (!in_array(Theme::$skin, array_keys(Theme::$options['theme']['options'])))
        Theme::$skin = Theme::get('theme');

    //we save the cookie for next time
    if (method_exists('Core','yclas_url'))
    {
        Cookie::set('skin_olson', Theme::$skin, 10*60);
    }
    else{
        Cookie::set('skin_olson', Theme::$skin, Core::config('auth.lifetime'));
    }
}
$theme_css = array( '//cdn.jsdelivr.net/npm/bootstrap@3.4.0/dist/css/bootstrap.min.css' => 'screen',
                        '//cdn.jsdelivr.net/blueimp-gallery/2.15.0/css/blueimp-gallery.min.css' => 'screen',
                        'css/animate.min.css' => 'screen',
                        'css/ddlevelsmenu-base.css' => 'screen',
                        'css/ddlevelsmenu-topbar.css' => 'screen',
                        'css/jquery.countdown.css' => 'screen',
                        'css/prettyPhoto.css' => 'screen',
                        'css/zocial.css' => 'screen',
                        'css/slider.css' => 'screen',
                        '//cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css' => 'screen',
                        '//use.fontawesome.com/releases/v5.9.0/css/all.css' => 'screen',
                        '//use.fontawesome.com/releases/v5.9.0/css/v4-shims.css' => 'screen',
                        '//cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css' => 'screen',
                        'css/style-original.css?v='.Core::VERSION => 'screen',
                        'css/style-'.Theme::$skin.'.css?v='.Core::VERSION => 'screen',
                        'css/style.css?v='.Core::VERSION => 'screen',
                        );

if ($body_font = explode('|', Theme::get('body_font'))[0])
    $theme_css = $theme_css + [$body_font => 'screen'];

if(Theme::get('rtl'))
    $theme_css = array_merge($theme_css, array('css/bootstrap-rtl.min.css' => 'screen'));

    Theme::$styles = $theme_css;


Theme::$scripts['footer']   = array('//cdn.jsdelivr.net/g/jquery@1.12.4,respond@1.4.2,jquery.validation@1.15.0,prettyphoto@3.1.5,select2@4.0.3,holder@2.9.3,caroufredsel@6.2.1,countdown@1.6.1',
                                    '//cdn.jsdelivr.net/npm/bootstrap@3.4.0/dist/js/bootstrap.min.js',
                                    '//cdn.jsdelivr.net/blueimp-gallery/2.15.0/js/jquery.blueimp-gallery.min.js',
                                    Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'select2')),
                                    Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'validate')),
                                    'js/bootstrap-slider.js',
                                    'js/ddlevelsmenu.js',
                                    'js/filter.js',
                                    'js/favico.min.js',
                                    'js/curry.js',
                                    'js/bootstrap-datepicker.js?v='.Core::VERSION,
                                    'js/jquery.navgoco.min.js',
                                    'js/search.js?v='.Core::VERSION,
                                    'js/default.init.js?v='.Core::VERSION,
                                    'js/theme.init.js?v='.Core::VERSION,
                                    );

if (Auth::instance()->logged_in() AND
    (Auth::instance()->get_user()->is_admin() OR
        Auth::instance()->get_user()->is_moderator() OR
        Auth::instance()->get_user()->is_translator()))
{
    Theme::$styles['css/bootstrap-editable.css'] = 'screen';
    Theme::$scripts['footer'][] = 'js/bootstrap-editable.min.js';
    Theme::$scripts['footer'][] = 'js/oc-panel/live-translator.js';
}

if (Core::config('general.pusher_notifications')){
    Theme::$styles['//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css'] = 'screen';
    Theme::$scripts['footer'][] = '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js';
    Theme::$scripts['footer'][] = '//js.pusher.com/4.0/pusher.min.js';
}

if (Core::config('general.algolia_search')){
    Theme::$styles['css/algolia/algolia-autocomplete.css'] = 'screen';
    Theme::$scripts['footer'][] = '//cdn.jsdelivr.net/algoliasearch/3/algoliasearch.min.js';
    Theme::$scripts['footer'][] = '//cdn.jsdelivr.net/autocomplete.js/0/autocomplete.jquery.min.js';
}

if (Core::config('general.sms_auth')){
    Theme::$styles['css/intlTelInput.css'] = 'screen';
    Theme::$scripts['footer'][] = 'js/intlTelInput.min.js';
    Theme::$scripts['footer'][] = 'js/utils.js';
    Theme::$scripts['footer'][] = 'js/phone-auth.js';
}

if (core::config('general.carquery'))
{
    Theme::$scripts['footer'][] = '//www.carqueryapi.com/js/carquery.0.3.4.js';
}

/**
* load assets for yclas top bar
*/
if (method_exists('Core','yclas_url') AND Model_Domain::current()->id_domain != '1' AND Auth::instance()->logged_in() AND Auth::instance()->get_user()->is_admin())
{
    Theme::$styles['css/yclas-topbar.css'] = 'screen';
    Theme::$scripts['footer'][] = (Core::is_HTTPS() ? 'https://' : 'http://').Model_Domain::get_sub_domain().'/panel/site/bar/'.Model_Domain::current()->id_domain;
    Theme::$scripts['footer'][] = 'js/yclas-topbar.js?v='.Core::VERSION;
}

/**
 * custom error alerts
 */
Form::$errors_tpl 	= '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>
			       		<h4 class="alert-heading">%s</h4>
			        	<ul>%s</ul></div>';

Form::$error_tpl 	= '<div class="alert"><a class="close" data-dismiss="alert">×</a>%s</div>';


Alert::$tpl 	= 	'<div class="alert alert-%s">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading">%s</h4>%s
					</div>';
