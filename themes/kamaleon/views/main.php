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
            body,h1,h2,h3,h4,h5,h6 {
                font-family: <?=explode('|', Theme::get('body_font'))[1]?>, sans-serif !important;
            }
        <?endif?>
    </style>
</head>

    <body data-spy="scroll" data-target=".subnav" data-offset="50" class="<?=(strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1)?'body_fixed':''?>">
    <?=View::factory('alert_terms')?>
	<?=$header?>

    <div class="container" id="main">
        <div class="alert alert-warning off-line" style="display:none;"><strong><?=_e('Warning')?>!</strong> <?=_e('We detected you are currently off-line, please connect to gain full experience.')?></div>
        <div class="row">
            <?if(Controller::$full_width):?>
                <section class="col-lg-12">
                    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
                    <?=Alert::show()?>
                    <?=(Theme::get('header_ad')!='')?Theme::get('header_ad'):''?>
                    <div id="main-content">
                        <?=$content?>
                    </div>
                </section>
            <?else:?>
                <section class="<?=(Theme::get('sidebar_position')!='none')?'col-lg-9 col-md-9 col-sm-12 col-xs-12':'col-lg-12'?> <?=(Theme::get('sidebar_position')=='left')?'pull-right':'pull-left'?>" id="page">
                    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
                    <?=Alert::show()?>

                    <div class="row">
                        <?if (Theme::landing_single_ad() == FALSE):?>
                        <?foreach ( Widgets::render('header') as $widget):?>
                            <div class="<?=(Theme::get('sidebar_position')!='none')?'col-lg-12 col-md-12 col-sm-12 col-xs-12':'col-lg-12'?>">
                                <?=$widget?>
                            </div>
                        <?endforeach?>
                        <?endif?>
                    </div>

                    <?=(Theme::get('header_ad')!='')?Theme::get('header_ad'):''?>
                    <div id="main-content">
                        <?=$content?>
                    </div>
                </section>

                <?if(Theme::get('sidebar_position')!='none'):?>
                    <?=(Theme::get('sidebar_position')=='left')?View::fragment('sidebar_front','sidebar'):''?>
                    <?=(Theme::get('sidebar_position')=='right')?View::fragment('sidebar_front','sidebar'):''?>
                <?endif?>
            <?endif?>

            <?if (core::count(Widgets::render('footer')) > 0 AND Theme::landing_single_ad() == FALSE) :?>
                <div class="clearfix"></div>
                <div class="col-lg-12">
                    <div class="row">
                        <?foreach ( Widgets::render('footer') as $widget):?>
                            <div class="col-lg-3 col-md-3">
                                <?=$widget?>
                            </div>
                        <?endforeach?>
                    </div>
                </div>
            <?endif?>
            <?=$footer?>
        </div>
    </div><!--/.fluid-container-->


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
