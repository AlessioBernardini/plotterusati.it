<?php defined('SYSPATH') or die('No direct script access.');?>
<!doctype html>
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
    <!-- Le HTML5 shim, for IE6-8 support of HTML elements -->
    <!--[if lt IE 9]>
      <script type="text/javascript" src="//cdn.jsdelivr.net/html5shiv/3.7.2/html5shiv.min.js"></script>
    <![endif]-->
    <?=Theme::styles($styles)?>
    <?=Theme::scripts($scripts)?>
    <?=core::config('general.html_head')?>
    <?=View::factory('analytics')?>
    <style type="text/css">
        <?if (Theme::get('body_font')) :?>
            body,h1,h2,h3,h4,h5,h6, .mattblackmenu li a, .ddsubmenustyle li a {
                font-family: <?=explode('|', Theme::get('body_font'))[1]?>, sans-serif !important;
            }
        <?endif?>
    </style>
</head>

<body>
    <?=View::factory('alert_terms')?>
    <?=$header?>
    <?=((strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1) AND Theme::landing_single_ad() == FALSE)?'<div class="mt-74">':''?>
    <?=View::factory('landing')?>
    <div class="container">
            <div class="alert alert-warning off-line" style="display:none;"><strong><?=_e('Warning')?>!</strong> <?=_e('We detected you are currently off-line, please connect to gain full experience.')?></div>
            <div class="row">
                <div class="col-lg-12">
                    <?=Alert::show()?>
                    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
                </div>
                <?if (Controller::$full_width OR Request::current()->controller() == 'Home'):?>
                    <div class="col-lg-12">
                        <?=(Theme::get('header_ad')!='')?Theme::get('header_ad'):''?>
                        <div id="main-content">
                            <?=$content?>
                        </div>
                    </div>
                <?else:?>
                    <div class="<?=(Theme::get('sidebar_position')!='none')?'col-lg-9 col-md-9 col-sm-12 col-xs-12':'col-lg-12'?> <?=(Theme::get('sidebar_position')=='left')?'pull-right':'pull-left'?>">
                        <?if (Theme::landing_single_ad() == FALSE):?>
                            <?foreach ( Widgets::render('header') as $widget):?>
                                <div class="panel widget-header">
                                    <?=$widget?>
                                </div>
                            <?endforeach?>
                        <?endif?>
                        <?=(Theme::get('header_ad')!='')?Theme::get('header_ad'):''?>
                        <div id="main-content">
                            <?=$content?>
                        </div>
                    </div>
                    <?if(Theme::get('sidebar_position')!='none'):?>
                        <?=(Theme::get('sidebar_position')=='left')?View::fragment('sidebar_front','sidebar'):''?>
                        <?=(Theme::get('sidebar_position')=='right')?View::fragment('sidebar_front','sidebar'):''?>
                    <?endif?>
                <?endif?>
            </div>
        </div>
    </div>

    <span class="totop" style="display: block;"><a href="#"><i class="fa fa-chevron-up"></i></a></span>
    <?=$footer?>
    <?=Theme::scripts($scripts,'footer')?>
    <?=Theme::scripts($scripts,'async_defer', 'default', ['async' => '', 'defer' => ''])?>
    <?=core::config('general.html_footer')?>

    <?if(Theme::get('rtl')==1):?>
        <script type="text/javascript">
            $(window).load(function(){
                $('select').each(function(){
                    $(this).chosen({
                        no_results_text: getChosenLocalization("no_results_text"),
                        placeholder_text_multiple: getChosenLocalization("placeholder_text_multiple"),
                        placeholder_text_single: getChosenLocalization("placeholder_text_single")
                    });
                    $(this).chosen('destroy');
                });
                $('select').change(function() {
                    $('select').each(function(){
                        $(this).chosen({
                            no_results_text: getChosenLocalization("no_results_text"),
                            placeholder_text_multiple: getChosenLocalization("placeholder_text_multiple"),
                            placeholder_text_single: getChosenLocalization("placeholder_text_single")
                        });
                        $(this).chosen('destroy');
                    });
                });
            });
        </script>
    <?endif?>

  <?=(Kohana::$environment === Kohana::DEVELOPMENT OR OC_DEBUG==TRUE)? View::factory('profiler'):''?>
</body>

</html>
