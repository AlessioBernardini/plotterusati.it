<?php defined('SYSPATH') or die('No direct script access.');?>
<!doctype html>
 <meta name="viewport" content="width=device-width,initial-scale=1,minimum-scale=1,maximum-scale=1,user-scalable=no">
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
                font-family: <?=explode('|', Theme::get('body_font'))[1]?>, sans-serif;
            }
        <?endif?>
        <?if (Theme::get('custom_color') AND Theme::get('custom_color_hover')) :?>
            a, .footer-copyright a.active,.footer-copyright a:focus,.footer-copyright a:hover,.hvr-icon-forward:before,.latest_ads .extra_info .more-link i,.list-group .caption h3 a:focus,.list-group .caption h3 a:hover,.listing_ads .extra_info .more-link i,.navbar-nav>li>a:focus,.navbar-nav>li>a:hover,.pagination li a,.pagination li span,.panel-sidebar .panel-body ul a.active,.panel-sidebar .panel-body ul a:focus,.panel-sidebar .panel-body ul a:hover,.tabbed ul li button.active,.tabbed ul li button:focus,.tabbed ul li button:hover,footer a.active,footer a:focus,footer a:hover, .wizard li.active span.round-tab i{color:<?=Theme::get('custom_color')?>;}::selection{background-color:<?=Theme::get('custom_color')?>;}::-moz-selection{background-color:<?=Theme::get('custom_color')?>;}.btn-primary,h1:after,h2:after,h3:before,h4:before,h5:before,h6:before, .bannergroup,.category a.active,.category a:focus,.category a:hover,.pagination .active a,.single .extra_info .price, .filter .active,.filter .active:focus,.filter .active:hover{background-color:<?=Theme::get('custom_color')?>;}.btn-primary, .featured-ads .extra_info, .featured-item .extra_info,.featured-ads .image_holder,.featured-item .image_holder,.filter #sort,.pagination .active a,.single #gallery .thumbnail.active,.single #gallery .thumbnail:focus,.single #gallery .thumbnail:hover,.tabbed-content, .filter .active,.filter .active:focus,.filter .active:hover, .wizard li.active span.round-tab{border-color:<?=Theme::get('custom_color')?>;}a.active,a:focus,a:hover{color:<?=Theme::get('custom_color_hover')?>;}.btn-primary:active,.btn-primary:focus,.btn-primary:active:focus,.btn-primary:hover,.open>.dropdown-toggle.btn-primary,.open>.dropdown-toggle.btn-primary:focus,.open>.dropdown-toggle.btn-primary:hover{background-color:<?=Theme::get('custom_color_hover')?>;border-color:<?=Theme::get('custom_color_hover')?>;}
        <?endif?>
    </style>
</head>
    <body data-spy="scroll" data-target=".subnav" data-offset="50" class="<?=(strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1)?'':'body_fixed'?>">
    <?=View::factory('alert_terms')?>
    <div id="outer-wrap">
    <div id="inner-wrap">
	<?=$header?>
    <div class="container" id="main">
        <div class="alert alert-warning off-line" style="display:none;"><strong><?=_e('Warning')?>!</strong> <?=_e('We detected you are currently off-line, please connect to gain full experience.')?></div>
        <div class="row">
            <?if(Controller::$full_width):?>
                <section class="col-lg-12">
                    <?=Alert::show()?>
                    <?=(Theme::get('header_ad')!='')?Theme::get('header_ad'):''?>
                    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
                    <div id="main-content">
                        <?=$content?>
                    </div>
                </section>
            <?else:?>
                <section class="<?=(Theme::get('sidebar_position')!='none')?'col-lg-10 col-md-10 col-sm-12 col-xs-12':'col-lg-12'?> <?=(Theme::get('sidebar_position')=='left')?'pull-right':'pull-left'?>" id="page">
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
                    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
                    <div id="main-content">
                        <?=$content?>
                    </div>
                </section>
                <?if(Theme::get('sidebar_position')!='none'):?>
                    <?=(Theme::get('sidebar_position')=='left')?View::fragment('sidebar_front','sidebar'):''?>
                    <?=(Theme::get('sidebar_position')=='right')?View::fragment('sidebar_front','sidebar'):''?>
                <?endif?>
            <?endif?>
        </div>
    </div><!--/.fluid-container-->
    <?=$footer?>
    </div><!--/#inner-wrap-->
    </div><!--/#outer-wrap-->
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
  <?=(Kohana::$environment === Kohana::DEVELOPMENT)? View::factory('profiler'):''?>
  </body>
</html>
