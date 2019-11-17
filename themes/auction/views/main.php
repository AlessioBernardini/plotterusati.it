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

    <body data-spy="scroll" data-target=".subnav" data-offset="50" class="<?=(strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1)?'body_fixed':''?>">
        <?=View::factory('alert_terms')?>
        <?=$header?>
        <?=Alert::show()?>
        <div class="container">
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
        <div class="row">
            <?if (Theme::landing_single_ad() == FALSE):?>
                <?foreach ( Widgets::render('header') as $widget):?>
                    <div class="panel-header col-lg-3 col-md-3 col-sm-3 col-xs-12">
                        <?=$widget?>
                    </div>
                <?endforeach?>
            <?endif?>
        </div>
        <?if(Theme::get('header_search')==1):?><?=View::factory('header_search')?><?endif?>
		<?if(Controller::$full_width):?>
			<div class="col-xs-12">
				<?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
        		<?=$content?>
        	</div>
        <?else:?>
			<div class="<?=(Theme::get('sidebar_position')!='none')?'col-lg-9 col-md-9 col-sm-12 col-xs-12':'col-xs-12'?> <?=(Theme::get('sidebar_position')=='left')?'pull-right':'pull-left'?>">
        		<?=(Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE)?Breadcrumbs::render('breadcrumbs'):''?>
        		<?=$content?>
        	</div>
            <?if(Theme::get('sidebar_position')!='none'):?>
                <?=(Theme::get('sidebar_position')=='left')?View::fragment('sidebar_front','sidebar'):''?>
                <?=(Theme::get('sidebar_position')=='right')?View::fragment('sidebar_front','sidebar'):''?>
            <?endif?>
        <?endif?>
        </div>
        <?=$footer?>
        <?=Theme::scripts($scripts,'footer')?>
        <?=Theme::scripts($scripts,'async_defer', 'default', ['async' => '', 'defer' => ''])?>
        <?=core::config('general.html_footer')?>
    </body>
</html>
