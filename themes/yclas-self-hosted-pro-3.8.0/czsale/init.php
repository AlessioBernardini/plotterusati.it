<?php defined('SYSPATH') or die('No direct access allowed.');
/**
  * Theme Name: CZ sale
  * Description: The CZSale theme is a fully responsive theme that was developed with the Bootstrap framework. This makes the theme great for those that want to make their classifieds website available for both mobile devices and desktop computers or laptops. The responsive design will give the user the optimal user experience on every platform.  Included are 7 different color schemes that allow you to adapt the looks. Infinite scroll, right-to-left and all other premium features are supported.
  * Tags: HTML5, Responsive, Mobile, Premium, Admin Themes, Advanced Confiuration, prettyPhoto, Slider.
  * Version: 3.8.0
  * Author: Slobodan <slobodan@open-classifieds.com>
  * License: Commercial
  * Parent Theme: default
  * Skins: original,cosmo,cyborg,readable,superhero,paper,sandstone
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
    elseif (Cookie::get('skin_czsale')!=='')
    {
        Theme::$skin = Cookie::get('skin_czsale');
    }

    //checking the skin they want to use actually exists...
    if (!in_array(Theme::$skin, array_keys(Theme::$options['theme']['options'])))
        Theme::$skin = Theme::get('theme');

    //we save the cookie for next time
    if (method_exists('Core','yclas_url'))
    {
        Cookie::set('skin_czsale', Theme::$skin, 10*60);
    }
    else{
        Cookie::set('skin_czsale', Theme::$skin, Core::config('auth.lifetime'));
    }
}

//local files

if (Theme::get('cdn_files') == FALSE AND ! method_exists('Core','yclas_url'))
{
    if (Theme::$skin!='bootstrap' AND Theme::$skin!='')
    {
        $theme_css = array( 'css/'.Theme::$skin.'-bootstrap.min.css' => 'screen',);
    }
    //default theme
    else
    {
        $theme_css = array('css/bootstrap.min.css' => 'screen',);
    }

    if(Theme::get('rtl'))
        $theme_css = array_merge($theme_css, array(
                                                'css/bootstrap-rtl.min.css' => 'screen',
                                                'css/rtl-style.css' => 'screen'
                                                ));

        $common_css = Theme::$styles =  array(
                                                'css/fontawesome-all.css' => 'screen',
                                                'css/fontawesome-v4-shims.css' => 'screen',
                                                'css/select2.min.css' => 'screen',
                                                'css/datepicker.css' => 'screen',
                                                'css/czsale-carousel.css' => 'screen',
                                                'css/czsale-responsive.css' => 'screen',
                                                'css/zocial.css' => 'screen',
                                                'css/slider.css' => 'screen',
                                                'css/blueimp-gallery.min.css' => 'screen',
                                                'css/bootstrap-image-gallery.min.css' => 'screen',
                                                'css/style.css?v='.Core::VERSION => 'screen',
                                                'css/templates/'.Theme::$skin.'-style.css?v='.Core::VERSION => 'screen'
                                                );

        if ($body_font = explode('|', Theme::get('body_font'))[0])
        $common_css = $common_css + [$body_font => 'screen'];

        Theme::$styles = array_merge($theme_css,$common_css);

        Theme::$scripts['footer']   = array('js/jquery.min.js',
                                        'js/bootstrap.min.js',
                                        'js/bootstrap-datepicker.js',
                                        'js/select2.min.js',
                                        'js/holder.min.js',
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'select2')),
                                        'js/jquery.validate.min.js',
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'validate')),
                                        'js/jquery.blueimp-gallery.min.js',
                                        'js/search.js',
                                        'js/respond.min.js',
                                        'js/jquery.slides.min.js',
                                        'js/bootstrap-slider.js',
                                        'js/favico.min.js',
                                        'js/curry.js',
                                        'js/default.init.js?v='.Core::VERSION,
                                        'js/theme.init.js?v='.Core::VERSION,
                                        );
}
else
{
    if (Theme::$skin!='bootstrap' AND Theme::$skin!='')
    {
        $theme_css = array( 'css/'.Theme::$skin.'-bootstrap.min.css' => 'screen',);
    }
    //default theme
    else
    {
        $theme_css = array('//cdn.jsdelivr.net/npm/bootstrap@3.4.0/dist/css/bootstrap.min.css' => 'screen', );
    }

    if(Theme::get('rtl'))
    $theme_css = array_merge($theme_css, array('css/bootstrap-rtl.min.css' => 'screen'));

    $common_css = Theme::$styles =  array(  '//cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css' => 'screen',
                                            '//cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css' => 'screen',
                                            '//use.fontawesome.com/releases/v5.9.0/css/all.css' => 'screen',
                                            '//use.fontawesome.com/releases/v5.9.0/css/v4-shims.css' => 'screen',
                                            '//cdn.jsdelivr.net/blueimp-gallery/2.15.0/css/blueimp-gallery.min.css' => 'screen',
                                            'css/czsale-carousel.css' => 'screen',
                                            'css/czsale-responsive.css' => 'screen',
                                            'css/zocial.css' => 'screen',
                                            'css/slider.css' => 'screen',
                                            'css/style.css?v='.Core::VERSION => 'screen',
                                            'css/templates/'.Theme::$skin.'-style.css?v='.Core::VERSION => 'screen',
                                            );

    if ($body_font = explode('|', Theme::get('body_font'))[0])
        $common_css = $common_css + [$body_font => 'screen'];

    Theme::$styles = array_merge($theme_css,$common_css);

    Theme::$scripts['footer']   = array('//cdn.jsdelivr.net/combine/npm/jquery@1.12.4,npm/bootstrap@3.4.0/dist/js/bootstrap.min.js,npm/select2@4.0.3,npm/holderjs@2.9.3,npm/jquery-validation@1.15.0,npm/respond.js@1.4.2/dest/respond.min.js',
                                        '//cdn.jsdelivr.net/blueimp-gallery/2.15.0/js/jquery.blueimp-gallery.min.js',
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'select2')),
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'validate')),
                                        'js/jquery.slides.min.js',
                                        'js/bootstrap-slider.js',
                                        'js/favico.min.js',
                                        'js/curry.js',
                                        'js/bootstrap-datepicker.js',
                                        'js/search.js?v='.Core::VERSION,
                                        'js/default.init.js?v='.Core::VERSION,
                                        'js/theme.init.js?v='.Core::VERSION,
                                        );
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
 * custom error alerts
 */
Form::$errors_tpl   = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>
                        <h4 class="alert-heading">%s</h4>
                        <ul>%s</ul></div>';

Form::$error_tpl    = '<div class="alert"><a class="close" data-dismiss="alert">×</a>%s</div>';


Alert::$tpl     =   '<div class="alert alert-%s">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading">%s</h4>%s
                    </div>';
