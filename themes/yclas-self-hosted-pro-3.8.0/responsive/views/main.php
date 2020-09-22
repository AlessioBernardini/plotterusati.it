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
            body,h1,h2,h3,h4,h5,h6, .navbar-default .navbar-brand {
                font-family: <?=explode('|', Theme::get('body_font'))[1]?>, sans-serif;
            }
        <?endif?>
        <?if(Theme::get('background_color')):?>
            body{
                background-color: <?=Theme::get('background_color')?>
            }
        <?endif?>
    </style>
</head>

  <body class="<?=(Theme::get('fixed_toolbar')==1)?'body-fixed':''?>">
    <?=View::factory('alert_terms')?>
	<?=$header?>

    <div class="container" id="main">
        <div class="alert alert-warning off-line" style="display:none;"><strong><?=_e('Warning')?>!</strong> <?=_e('We detected you are currently off-line, please connect to gain full experience.')?></div>
        <div class="row">
            <?if(Controller::$full_width):?>
                <div class="col-md-12" id="page">
                    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
                    <?=Alert::show()?>
                    <?=(Theme::get('header_ad')!='')?Theme::get('header_ad'):''?>
                    <div id="main-content">
                        <?=$content?>
                    </div>
                </div>
            <?else:?>
                <div class="<?=(Theme::get('sidebar_position')!='none')?'col-md-9':'col-md-12'?> <?=(Theme::get('sidebar_position')=='left')?'col-md-push-3':''?>" id="page">
                    <?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
                    <br>
                    <?=Alert::show()?>

                    <div class="row">
                        <?if (Theme::landing_single_ad() == FALSE):?>
                            <?foreach ( Widgets::render('header') as $widget):?>
                                <div class="col-md-3">
                                    <?=$widget?>
                                </div>
                            <?endforeach?>
                        <?endif?>
                    </div>

                    <?=(Theme::get('header_ad')!='')?Theme::get('header_ad'):''?>
                    <div id="main-content">
                        <?=$content?>
                    </div>
                </div>

                <?if(Theme::get('sidebar_position')!='none'):?>
                    <?=View::fragment('sidebar_front','sidebar')?>
                <?endif?>
            <?endif?>

            <div class="container">
                <?if (Theme::landing_single_ad() == FALSE):?>
                    <?foreach ( Widgets::render('footer') as $widget):?>
                        <div class="col-md-3">
                            <?=$widget?>
                        </div>
                    <?endforeach?>
                <?endif?>
            </div>

            <?=$footer?>
        </div>
    </div><!--/.fluid-container-->


	<?=Theme::scripts($scripts,'footer')?>
    <?=Theme::scripts($scripts,'async_defer', 'default', ['async' => '', 'defer' => ''])?>
	<?=core::config('general.html_footer')?>


  <?=(Kohana::$environment === Kohana::DEVELOPMENT)? View::factory('profiler'):''?>
  </body>
</html>