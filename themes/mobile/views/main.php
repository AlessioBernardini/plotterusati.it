<?php defined('SYSPATH') or die('No direct script access.');?>
<!DOCTYPE html>
<head>
<?=View::factory('header_metas',array('title'             => $title,
                                      'meta_keywords'     => $meta_keywords,
                                      'meta_description'  => $meta_description,
                                      'meta_copyright'    => $meta_copyright,))?> 
    <?=Theme::styles($styles)?> 
    <?=Theme::scripts($scripts)?>
    <?=core::config('general.html_head')?>
    <?=View::factory('analytics')?>
</head>

  <!-- Start of first page: #landing -->
    <div data-role="page" id="landing" class="ui-page-header-fixed">
	<?=$header?>
    <!-- end header-->
    <div data-role="content">
        <?if (Theme::get('logo_url')!=''):?>
        <a id="logo" href="<?=Route::url('default')?>"><img class="logo_img" src="<?=Theme::get('logo_url')?>"></a>
        <?endif?>
    <?=Alert::show()?>
    <div class="alert alert-warning off-line" style="display:none;"><strong><?=__('Warning')?>!</strong> <?=__('We detected you are currently off-line, please connect to gain full experience.')?></div>
    <?=(Theme::get('header_ad')!='')?Theme::get('header_ad'):''?>
    <?=$content?>
    <?=(Theme::get('footer_ad')!='')?Theme::get('footer_ad'):''?>
    </div><!-- end content -->
    <?=$footer?>
   

</div>
	<?=Theme::scripts($scripts,'footer')?>
  <?=Theme::scripts($scripts,'async_defer', 'default', ['async' => '', 'defer' => ''])?>
	<?=core::config('general.html_footer')?>
	
    
  <?//=(Kohana::$environment === Kohana::DEVELOPMENT)? View::factory('profiler'):''?>
  </body>
</html>