<?php defined('SYSPATH') or die('No direct script access.');?>
<h4><?=$widget->locations_title?></h4>
<div class="list-group categories">
	<?if($widget->loc_breadcrumb !== NULL):?>

			<?if($widget->loc_breadcrumb['id_parent'] != 0):?>
				<a class="list-group-item active" href="<?=Route::url('list',array('location'=>$widget->loc_breadcrumb['parent_seoname'],'category'=>$widget->cat_seoname))?>" title="<?=HTML::chars($widget->loc_breadcrumb['parent_translate_name'])?>"><?=$widget->loc_breadcrumb['parent_translate_name']?> / <span class="glyphicon glyphicon-chevron-left"></span><?=$widget->loc_breadcrumb['translate_name']?></a>
			<?else:?>
				<a class="list-group-item active" href="<?=Route::url('list',array('location'=>$widget->loc_breadcrumb['parent_seoname'],'category'=>$widget->cat_seoname))?>" title="<?=HTML::chars($widget->loc_breadcrumb['parent_translate_name'])?>"><?=_e('Home')?> / <span class="glyphicon glyphicon-chevron-left"></span>
				<?if($widget->loc_breadcrumb['id'] != 1):?>
					<?=$widget->loc_breadcrumb['translate_name']?>
				<?endif?>
				</a>
			<?endif?>

	<?endif?>

	<?foreach($widget->loc_items as $loc):?>
	    	<a class="list-group-item" href="<?=Route::url('list',array('location'=>$loc->seoname,'category'=>$widget->cat_seoname))?>" title="<?=HTML::chars($loc->translate_name())?>">
	        <?=$loc->translate_name()?><span class="glyphicon glyphicon-chevron-right"></span></a>
	<?endforeach?>
</div>
