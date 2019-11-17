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
    <body data-spy="scroll" data-target=".subnav" data-offset="50" class="<?=(((Request::current()->controller()!=='faq') AND Theme::get('fixed_toolbar')==1) OR Theme::landing_single_ad() == TRUE)?'':'body_fixed'?>">
    <?=View::factory('alert_terms')?>
	<?=$header?>
	<?if(Theme::get('top-banner')==1 AND Theme::landing_single_ad() == FALSE):?>
	<section class="hidden-xs" id="top-banner" <?=(Theme::get('banner_bg_url')!='')? 'style="background-image: url(\''.Theme::get('banner_bg_url').'\')"':NULL?>>
		<div class="container">
			<div class="row">
				<div class="col-lg-12">
					<h1><?=(Theme::get('banner-title')!='')?Theme::get('banner-title'):''?></h1>
					<h3><?=(Theme::get('banner-subtitle')!='')?Theme::get('banner-subtitle'):''?></h3>
				</div>
			</div>
		</div>
	</section>
    <?endif?>
    <div class="alert alert-warning off-line" style="display:none;"><strong><?=_e('Warning')?>!</strong> <?=_e('We detected you are currently off-line, please connect to gain full experience.')?></div>
    <?=$content?>
    <?=$footer?>
	<?=Theme::scripts($scripts,'footer')?>
  <?=Theme::scripts($scripts,'async_defer', 'default', ['async' => '', 'defer' => ''])?>
	<?=core::config('general.html_footer')?>
  	<?=(Kohana::$environment === Kohana::DEVELOPMENT)? View::factory('profiler'):''?>
  </body>
</html>
