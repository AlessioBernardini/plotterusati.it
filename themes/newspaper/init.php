<?php defined('SYSPATH') or die('No direct access allowed.');
/**
  * Theme Name: Newspaper
  * Description: The newspaper theme is a theme with a modern and fresh look. The design is clean and suitable for any time of classifieds website. Ten different color schemes are included and make it possible to adapt the website easily to the prefered image. The width of the site can be changed from the admin panel, giving more customization options.
  * Tags: HTML5, Newspaper, Responsive, Premium
  * Version: 3.7.0
  * Author: Oliver <oliver@open-classifieds.com>
  * License: Commercial
  * Parent Theme: default
  * Skins: default,blue,brown,dark-gray,denim,green,orange,purple,red,turquoise
  */


/**
 * placeholders for this theme
 */
Widgets::$theme_placeholders = array('header','footer', 'sidebar', 'publish_new');

/**
 * custom options for the theme
 * @var array
 */
Theme::$options = Theme::get_options();

/**
 * load theme options
 */
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
    elseif (Cookie::get('skin_newspaper')!=='')
    {
        Theme::$skin = Cookie::get('skin_newspaper');
    }

    //checking the skin they want to use actually exists...
    if (!in_array(Theme::$skin, array_keys(Theme::$options['theme']['options'])))
        Theme::$skin = Theme::get('theme');

    //we save the cookie for next time
    if (method_exists('Core','yclas_url'))
    {
        Cookie::set('skin_newspaper', Theme::$skin, 10*60);
    }
    else{
        Cookie::set('skin_newspaper', Theme::$skin, Core::config('auth.lifetime'));
    }
}

/**
 * styles and themes, loaded in this order
 */

if (Theme::get('cdn_files') == FALSE AND ! method_exists('Core','yclas_url'))
{
    $theme_styles = array(  'css/fonts.css' => 'screen',
                            'css/bootstrap.min.css' => 'screen',
                            'css/fontawesome-all.css' => 'screen',
                            'css/fontawesome-v4-shims.css' => 'screen',
                            'css/blueimp-gallery.min.css' => 'screen',
                            'css/datepicker.css' => 'screen',
                            'css/select2.min.css' => 'screen',
                            'css/slider.css' => 'screen',
                            'css/zocial.css' => 'screen',
                            'css/styles.css?v='.Core::VERSION => 'screen'
                            );
    if ($body_font = explode('|', Theme::get('body_font'))[0])
    $theme_styles = $theme_styles + [$body_font => 'screen'];
}
else
{
    $theme_styles = array(  '//fonts.googleapis.com/css?family=PT+Sans:400,700' => 'screen',
                            '//fonts.googleapis.com/css?family=Open+Sans:400,700' => 'screen',
                            '//cdn.jsdelivr.net/npm/bootstrap@3.4.0/dist/css/bootstrap.min.css' => 'screen',
                            '//use.fontawesome.com/releases/v5.9.0/css/all.css' => 'screen',
                            '//use.fontawesome.com/releases/v5.9.0/css/v4-shims.css' => 'screen',
                            '//cdn.jsdelivr.net/blueimp-gallery/2.15.0/css/blueimp-gallery.min.css' => 'screen',
                            '//cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css' => 'screen',
                            '//cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css' => 'screen',
                            'css/slider.css' => 'screen',
                            'css/zocial.css' => 'screen',
                            'css/styles.css?v='.Core::VERSION => 'screen'
                  );
    if ($body_font = explode('|', Theme::get('body_font'))[0])
    $theme_styles = $theme_styles + [$body_font => 'screen'];
}

if (Theme::get('options')!='default')
{
	Theme::$styles = array_merge($theme_styles, array('css/colors/'.Theme::$skin.'.css' => 'screen'));
}
else {
	Theme::$styles = $theme_styles;
}

Theme::$scripts['footer'] = array(  '//cdn.jsdelivr.net/combine/npm/jquery@1.12.4,npm/bootstrap@3.4.0/dist/js/bootstrap.min.js,npm/select2@4.0.3,npm/holderjs@2.9.3,npm/jquery-validation@1.15.0',
                                    '//cdn.jsdelivr.net/blueimp-gallery/2.15.0/js/jquery.blueimp-gallery.min.js',
                                    Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'select2')),
                                    Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'validate')),
                                    'js/bootstrap-slider.js',
                                    'js/favico.min.js',
                                    'js/curry.js',
                                    'js/bootstrap-datepicker.js',
                                    'js/search.js?v='.Core::VERSION,
                                    'js/default.init.js?v='.Core::VERSION,
                                    'js/theme.init.js?v='.Core::VERSION,
);

if (Theme::get('rtl'))
{
    Theme::$styles['css/bootstrap-rtl.min.css'] = 'screen';
    Theme::$styles['css/rtl-style.css'] = 'screen';
}

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
Form::$errors_tpl = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>
			       		<h4 class="alert-heading">%s</h4>
			        	<ul>%s</ul></div>';

Form::$error_tpl = '<div class="alert "><a class="close" data-dismiss="alert">×</a>%s</div>';


Alert::$tpl = '<div class="alert alert-%s">
					<a class="close" data-dismiss="alert" href="#">×</a>
					<h4 class="alert-heading">%s</h4>%s
					</div>';
