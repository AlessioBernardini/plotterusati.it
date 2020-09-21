<?php defined('SYSPATH') or die('No direct access allowed.');
/**
  * Theme Name: Kamaleon
  * Description: The Kamaleon theme owes its name to the 22 different styles/color schemes that are offered with it. This makes the theme a real kamaleon and suitable for almost everyone. The possibilities for the feel and look of our classifieds site are endless with this theme. Looking at the technical side; infinite scroll, RTL and multiple configuration options are supported. This all together makes the Kamaleon theme fit every kind of classifieds website that you want to develop.
  * Tags: HTML5, Responsive, Mobile, Premium, Admin Themes, Advanced Confiuration, prettyPhoto, Slider.
  * Version: 3.8.0
  * Author: Chema <chema@open-classifieds.com>, Slobodan <slobodan@open-classifieds.com>
  * License: Commercial
  * Parent Theme: default
  * Skins: amelia,cerulean,cosmo,cyborg,flatly,journal,readable,simplex,slate,spacelab,united,yeti,bootstrap,cupid,lumen,darkly,shamrock,pinkiepie,superhero,sandstone,paper,oc
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
    elseif (Cookie::get('skin_kamaleon')!=='')
    {
        Theme::$skin = Cookie::get('skin_kamaleon');
    }

    //checking the skin they want to use actually exists...
    if (!in_array(Theme::$skin, array_keys(Theme::$options['theme']['options'])))
        Theme::$skin = Theme::get('theme');

    //we save the cookie for next time
    if (method_exists('Core','yclas_url'))
    {
        Cookie::set('skin_kamaleon', Theme::$skin, 10*60);
    }
    else{
        Cookie::set('skin_kamaleon', Theme::$skin, Core::config('auth.lifetime'));
    }
}

// d(Theme::$skin);
//local files

if (Theme::get('cdn_files') == FALSE AND ! method_exists('Core','yclas_url'))
{
    if (Theme::$skin!='bootstrap' AND Theme::$skin!='')
    {

        $theme_css = array( 'css/'.Theme::$skin.'-bootstrap.min.css' => 'screen');
    }
    //default theme
    else
    {
        $theme_css = array('css/bootstrap.min.css' => 'screen');
    }

    if(Theme::get('rtl'))
    $theme_css = array_merge($theme_css, array('css/bootstrap-rtl.min.css' => 'screen','css/rtl-style.css' => 'screen'));

    $common_css =  array('css/fontawesome-all.css' => 'screen',
                        'css/fontawesome-v4-shims.css' => 'screen',
                        'css/datepicker.css' => 'screen',
                        'css/prettyPhoto.css' => 'screen',
                        'css/select2.min.css' => 'screen',
                        'css/slider.css' => 'screen',
                        'css/zocial.css' => 'screen',
                        'css/blueimp-gallery.min.css' => 'screen',
                        'css/style.css?v='.Core::VERSION => 'screen',
                        'css/templates/'.Theme::$skin.'-style.css?v='.Core::VERSION => 'screen'
                        );

    if ($body_font = explode('|', Theme::get('body_font'))[0])
    $common_css = $common_css + [$body_font => 'screen'];

    Theme::$styles = array_merge($theme_css,$common_css);


    Theme::$scripts['footer']   = array('js/jquery.min.js',
                                        'js/bootstrap.min.js',
                                        'js/bootstrap-slider.js',
                                        'js/jquery.prettyPhoto.js',
                                        'js/bootstrap-datepicker.js',
                                        'js/select2.min.js',
                                        'js/holder.min.js',
                                        'js/jquery.blueimp-gallery.min.js',
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'select2')),
                                        'js/jquery.validate.min.js',
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'validate')),
                                        'js/search.js',
                                        'js/favico.min.js',
                                        'js/curry.js',
                                        'js/default.init.js?v='.Core::VERSION,
                                        'js/theme.init.js?v='.Core::VERSION,
                                        );
}
else
{
    if (Theme::$skin!='bootstrap' AND Theme::$skin!='oc' AND Theme::$skin!='')
    {
        $theme_css = array( '//cdn.jsdelivr.net/npm/bootswatch@3.4.0/'.Theme::$skin.'/bootstrap.min.css' => 'screen');
    }
    elseif (Theme::$skin=='oc')
    {
        $theme_css = array( 'css/oc-bootstrap.min.css' => 'screen');
    }
    //default theme
    else
    {
        $theme_css = array('//cdn.jsdelivr.net/npm/bootstrap@3.4.0/dist/css/bootstrap.min.css' => 'screen');
    }

    if(Theme::get('rtl'))
    $theme_css = array_merge($theme_css, array('css/bootstrap-rtl.min.css' => 'screen','css/rtl-style.css' => 'screen'));

    $common_css =  array(   '//cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css' => 'screen',
                            '//cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css' => 'screen',
                            '//cdn.jsdelivr.net/prettyphoto/3.1.5/css/prettyPhoto.css' => 'screen',
                            '//use.fontawesome.com/releases/v5.9.0/css/all.css' => 'screen',
                            '//use.fontawesome.com/releases/v5.9.0/css/v4-shims.css' => 'screen',
                            '//cdn.jsdelivr.net/blueimp-gallery/2.15.0/css/blueimp-gallery.min.css' => 'screen',
                            'css/slider.css' => 'screen',
                            'css/zocial.css' => 'screen',
                            'css/style.css?v='.Core::VERSION => 'screen',
                            'css/templates/'.Theme::$skin.'-style.css?v='.Core::VERSION => 'screen',
                            );

    if ($body_font = explode('|', Theme::get('body_font'))[0])
        $common_css = $common_css + [$body_font => 'screen'];

    Theme::$styles = array_merge($theme_css,$common_css);


    Theme::$scripts['footer'] = array(  '//cdn.jsdelivr.net/combine/npm/jquery@1.12.4,npm/bootstrap@3.4.0/dist/js/bootstrap.min.js,npm/select2@4.0.3,npm/holderjs@2.9.3,npm/jquery-validation@1.15.0',
                                        '//cdn.jsdelivr.net/blueimp-gallery/2.15.0/js/jquery.blueimp-gallery.min.js',
                                        '//cdn.jsdelivr.net/g/prettyphoto@3.1.5',
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'chosen')),
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'select2')),
                                        'js/bootstrap-slider.js',
                                        'js/favico.min.js',
                                        'js/curry.js',
                                        'js/bootstrap-datepicker.js',
                                        'js/search.js?v='.Core::VERSION,
                                        'js/default.init.js?v='.Core::VERSION,
                                        'js/theme.init.js?v='.Core::VERSION,
                                        );
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
Form::$errors_tpl   = '<div class="alert alert-danger"><a class="close" data-dismiss="alert">×</a>
                        <h4 class="alert-heading">%s</h4>
                        <ul>%s</ul></div>';

Form::$error_tpl    = '<div class="alert"><a class="close" data-dismiss="alert">×</a>%s</div>';


Alert::$tpl     =   '<div class="alert alert-%s">
                    <a class="close" data-dismiss="alert" href="#">×</a>
                    <h4 class="alert-heading">%s</h4>%s
                    </div>';
