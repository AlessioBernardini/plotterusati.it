<?php defined('SYSPATH') or die('No direct script access.');?>
<!DOCTYPE html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="<?=i18n::html_lang()?>"> <![endif]-->
<!--[if IE 7]>    <html class="no-js ie7 oldie" lang="<?=i18n::html_lang()?>"> <![endif]-->
<!--[if IE 8]>    <html class="no-js ie8 oldie" lang="<?=i18n::html_lang()?>"> <![endif]-->
<!--[if gt IE 8]><!--> <html class="no-js" lang="<?=i18n::html_lang()?>"> <!--<![endif]-->
<head>
<?=View::factory('header_metas',array('title'             => $title,
                                      'meta_keywords'     => $meta_keywords,
                                      'meta_description'  => $meta_description,
                                      'meta_copyright'    => $meta_copyright,
                                      'amphtml'           => $amphtml,))?>

    <?=Theme::styles($styles)?>
    <?=Theme::scripts($scripts)?>
    <?=core::config('general.html_head')?>
    <?=View::factory('analytics')?>
    <style type="text/css">
        <?if (Theme::get('body_font')) :?>
            body,h1,h2,h3,h4,h5,h6 {
                font-family: <?=explode('|', Theme::get('body_font'))[1]?>, sans-serif;
            }
        <?endif?>
    </style>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
      <script src="//oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
      <script src="//oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

    <body>
        <?=View::factory('alert_terms')?>
        <?=$header?>
        <div>
        <div class="alert alert-warning off-line" style="display:none;"><strong><?=_e('Warning')?>!</strong> <?=_e('We detected you are currently off-line, please connect to gain full experience.')?></div>
        <?if(Theme::get('header_ad')!=''):?>
            <div class="container no-gutter">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <?=Theme::get('header_ad')?>
                    </div>
                </div>
            </div>
        <?endif?>
        <?=Alert::show()?>
        <?=Form::errors()?>
        <?=$content?>
        <?if(Theme::get('footer_ad')!=''):?>
            <div class="container no-gutter">
                <div class="row">
                    <div class="col-xs-12 text-center">
                        <?=Theme::get('footer_ad')?>
                    </div>
                </div>
            </div>
        <?endif?>
        <?=$footer?>
        </div>
        <?=Theme::scripts($scripts,'footer')?>
        <?=Theme::scripts($scripts,'async_defer', 'default', ['async' => '', 'defer' => ''])?>
        <?=core::config('general.html_footer')?>
        <?=(Kohana::$environment === Kohana::DEVELOPMENT)? View::factory('profiler'):''?>
    </body>
</html>
