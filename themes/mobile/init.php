<?php defined('SYSPATH') or die('No direct access allowed.');
/**
  * Theme Name: Mobile
  * Description: The Mobile theme is especially designed for mobile devices like smartphones. It works great on Android, iPhone and BlackBerry. This theme is designed for those that want to offer a classifieds website that has to be viewed on a mobile device. The minimalistic design provide a clear site that is practical in use and fast to load.
  * Tags: Mobile,HTML5, Admin, Premium
  * Version: 3.7.0
  * Author: Oliver <oliver@open-classifieds.com>
  * License: Commercial
  * Mobile: TRUE
  * Parent Theme: default
  */


/**
 * custom options for the theme
 * @var array
 */
Theme::$options = Theme::get_options();


//we load earlier the theme since we need some info
Theme::load();
$theme_css = array();
if (Theme::get('rtl'))
{
  $jquery_mobile['css'] = ['css/rtl.jquery.mobile-1.4.0.css'=>'screen'];
  $jquery_mobile['js'] = 'js/rtl.jquery.mobile-1.4.0.js';
}
else
{
  $jquery_mobile['css'] = ['//code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.css'=>'screen'];
  $jquery_mobile['js'] = '//code.jquery.com/mobile/1.4.0/jquery.mobile-1.4.0.min.js';
}
if (Theme::get('theme_color_main')=='colorama')
{
    $theme_css = array( 'css/colorama.css?v='.Core::VERSION => 'screen');
}

if (Theme::get('cdn_files') == FALSE AND ! method_exists('Core','yclas_url'))
{
    $common_css =  array(  'css/bootstrap.min.css' => 'screen',
                           '//use.fontawesome.com/releases/v5.9.0/css/all.css' => 'screen',
                           '//use.fontawesome.com/releases/v5.9.0/css/v4-shims.css' => 'screen',
                           'css/datepicker.css' => 'screen',
                           '//cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css' => 'screen',
                           'css/flexslider.css'=>'screen',
                           'css/zocial.css'    => 'screen',
                           'css/styles.css?v='.Core::VERSION=>'screen');

    Theme::$styles = array_merge($jquery_mobile['css'], $common_css, $theme_css);


    Theme::$scripts['footer'] = array(  '//cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js',
                                        $jquery_mobile['js'],
                                        '//cdn.jsdelivr.net/g/flexslider@2.1,jquery.validation@1.15.0',
                                        '//cdn.jsdelivr.net/npm/bootstrap@3.4.0/dist/js/bootstrap.min.js',
                                        'js/bootstrap-datepicker.js',
                                        '//cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js',
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'select2')),
                                        'js/search.js?v='.Core::VERSION,
                                        '//www.google.com/jsapi',
                                        Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'validate')),
                                        'js/theme.init.js?v='.Core::VERSION,);
}
else
{
    $common_css =  array('//cdn.jsdelivr.net/select2/4.0.3/css/select2.min.css' => 'screen',
                           '//use.fontawesome.com/releases/v5.9.0/css/all.css' => 'screen',
                           '//use.fontawesome.com/releases/v5.9.0/css/v4-shims.css' => 'screen',
                           '//cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css' => 'screen',
                           'css/bootstrap.min.css' => 'screen',
                           'css/flexslider.css'=>'screen',
                           'css/zocial.css'    => 'screen',
                           'css/styles.css?v='.Core::VERSION=>'screen');

    Theme::$styles = array_merge($jquery_mobile['css'], $common_css, $theme_css);

    Theme::$scripts['footer'] = array( '//cdn.jsdelivr.net/jquery/1.12.4/jquery.min.js',
                                    $jquery_mobile['js'],
                                    '//cdn.jsdelivr.net/npm/bootstrap@3.4.0/dist/js/bootstrap.min.js',
                                    '//cdn.jsdelivr.net/g/flexslider@2.1,jquery.validation@1.15.0',
                                    '//cdn.jsdelivr.net/select2/4.0.3/js/select2.min.js',
                                    'js/bootstrap-datepicker.js',
                                    Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'select2')),
                                    'js/search.js?v='.Core::VERSION,
                                    '//www.google.com/jsapi',
                                    '//cdn.jsdelivr.net/bootstrap.datepicker/0.1/css/datepicker.css' => 'screen',
                                    Route::url('jslocalization', array('controller'=>'jslocalization', 'action'=>'validate')),
                                    'js/theme.init.js?v='.Core::VERSION,);
}

if (Core::config('general.pusher_notifications')){
    Theme::$styles['//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css'] = 'screen';
    Theme::$scripts['footer'][] = '//cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js';
    Theme::$scripts['footer'][] = '//js.pusher.com/4.0/pusher.min.js';
}

/**
 * custom error alerts
 */
Form::$errors_tpl   = '<div class="alert alert-error" >
                      <a href="#" data-rel="back"  data-icon="delete" data-iconpos="notext" class="ui-btn-right close">Close</a>
                      <h4 class="alert-heading">%s</h4>
                      <ul>%s</ul></div>';

Form::$error_tpl  = '<div class="alert">
                    <a href="#" data-rel="back"  data-icon="delete" data-iconpos="notext" class="ui-btn-right close">Close</a>
                    <ul><li>%s</li></ul></div>';


Alert::$tpl   =   '<div class="alert alert-%s">
                    <a href="#" data-rel="back"  data-icon="delete" data-iconpos="notext" class="ui-btn-right close">Close</a>
          <h4 class="alert-heading">%s</h4><ul><li>%s</li></ul>
          </div>';
