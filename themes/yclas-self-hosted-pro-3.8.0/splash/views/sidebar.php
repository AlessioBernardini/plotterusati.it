<?php defined('SYSPATH') or die('No direct script access.');?>
<?if (Theme::get('sidebar_position') != 'hidden') :?>
	<div class="col-md-3 col-sm-12 col-xs-12 <?=(Theme::get('sidebar_position')=='left')?'col-md-pull-9':NULL?>"> 
	<?=method_exists('Core','yclas_url') ? View::factory('banners/sidebar') : NULL?>
	<?foreach ( Widgets::render('sidebar') as $widget):?>
	    <div class="category_box_title custom_box"></div>
	    <div class="well custom_box_content" >
	        <?=$widget?>
	    </div>
	<?endforeach?>
	</div>
<?endif?>