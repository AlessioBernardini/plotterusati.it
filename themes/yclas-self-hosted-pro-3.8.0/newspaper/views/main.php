<?php defined('SYSPATH') or die('No direct script access.');?>
<!doctype html>
<!--[if lt IE 7]> <html class="no-js ie6 oldie" lang="<?=i18n::html_lang()?>"> <![endif]-->
<!--[if IE 7]> <html class="no-js ie7 oldie" lang="<?=i18n::html_lang()?>"> <![endif]-->
<!--[if IE 8]> <html class="no-js ie8 oldie" lang="<?=i18n::html_lang()?>"> <![endif]-->
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
        .container {
            max-width: <?=(is_numeric(Theme::get('fixed_width')))?Theme::get('fixed_width'):'960'?>px;
        }
        <?if (Theme::get('body_font')) :?>
            body,h1,h2,h3,h4,h5,h6 {
                font-family: <?=explode('|', Theme::get('body_font'))[1]?>, sans-serif !important;
            }
        <?endif?>
    </style>
</head>
<body data-spy="scroll" data-target=".subnav" data-offset="50">

<?=View::factory('alert_terms')?>

<div class="container inner-wrapper">
    <?=$header?>
    <div class="alert alert-warning off-line" style="display:none;"><strong><?=_e('Warning')?>!</strong> <?=_e('We detected you are currently off-line, please connect to gain full experience.')?></div>
    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
    <? if(core::count(widgets::get('header'))>0 AND Theme::landing_single_ad() == FALSE):?>
        <div class="row">
            <div class="col-md-12 header">
                <div class="row">
                    <? foreach ( widgets::get('header') as $widget):?>
                        <div class="col-md-3">
                            <div class="panel panel-sidebar">
                                <?=$widget->render()?>
                            </div>
                        </div>
                    <? endforeach?>
                </div>
            </div>
        </div>
    <? endif; ?>
    <div class="row">
        <?if(Controller::$full_width):?>
            <div class="col-md-12">
                <?=Alert::show()?>
                <?=$content?>
            </div>
        <?else:?>
            <?$container=(Theme::get('sidebar_position')!='none')?'col-md-8':'col-md-12'?>
            <? if (Theme::get('sidebar_position')!='right'):?>
                <div class="col-xs-12 <?=(Theme::get('sidebar_single')!=NULL AND !Theme::get('sidebar_single') AND Request::current()->action()=='view')?'col-md-12':$container?> pull-right" id="content">
            <? else:?>
                <div class="col-xs-12 <?=(Theme::get('sidebar_single')!=NULL AND !Theme::get('sidebar_single') AND Request::current()->action()=='view')?'col-md-12':$container?>" id="content">
            <? endif?>
                <?=Alert::show()?>
                <?=$content?>
            </div>

            <?if(Theme::get('sidebar_position')!='none'):?>
                <?if (Theme::get('sidebar_single')!=NULL AND !Theme::get('sidebar_single')):?>
                    <?if(Request::current()->action()!='view'): ?>
                    <?=View::fragment('sidebar_front','sidebar')?>
                    <?endif?>
                <?else:?>
                    <?=View::fragment('sidebar_front','sidebar')?>
                <?endif?>
            <?endif?>
        <?endif?>
    </div>
    <? if(core::count(Widgets::render('footer'))>0 AND Theme::landing_single_ad() == FALSE):?>
        <div class="row">
            <div class="col-md-12 footer">
                <div class="row">
                    <? foreach ( Widgets::render('footer') as $widget):?>
                        <div class="col-md-3">
                            <div class="panel panel-sidebar">
                                <?=$widget?>
                            </div>
                        </div>
                    <? endforeach?>
                </div>
            </div>
        </div>
    <? endif; ?>
    <? if(Theme::get('footer_banner')!=''):?>
        <div class="footer-banner"><?=Theme::get('footer_banner')?></div>
    <? endif?>
</div>
<?=$footer?>
<?=Theme::scripts($scripts,'footer')?>
<?=Theme::scripts($scripts,'async_defer', 'default', ['async' => '', 'defer' => ''])?>
<?=core::config('general.html_footer')?>
<?=(Kohana::$environment === Kohana::DEVELOPMENT OR OC_DEBUG==TRUE)? View::factory('profiler'):''?>
</body>
</html>
