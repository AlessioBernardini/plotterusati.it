<?php defined('SYSPATH') or die('No direct script access.');?>
<h4 class="h3"><?=$widget->featured_title?></h4>

<?foreach($widget->ads as $ad):?>
<div class="well <?=(get_class($widget)=='Widget_Featured')?'featured-custom-box':''?>" >
	<div class="featured-sidebar-box">
		<?if($ad->get_first_image() !== NULL):?>

			<div class="picture">
				<a title="<?=HTML::chars($ad->title);?>" alt="<?=HTML::chars($ad->title);?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
					<figure>
						<img src="<?=Core::imagefly($ad->get_first_image('image'),640,640)?>" class="img-responsive">
					</figure>
				</a>
			</div>
		<?else:?>
			<div class="picture">
				<a title="<?=HTML::chars($ad->title);?>" alt="<?=HTML::chars($ad->title);?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
					<figure>
						<img data-src="holder.js/<?=core::config('image.width_thumb')?>x<?=core::config('image.height_thumb')?>?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14)))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive">
					</figure>
				</a>
			</div>
		<?endif?>
		<div class="featured-sidebar-box-header">
			<a href="<?=Route::url('ad',array('seotitle'=>$ad->seotitle,'category'=>$ad->category->seoname))?>" title="<?=HTML::chars($ad->title)?>">
				<span class='f-box-header'><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></span>
	        </a>
	    </div>
		<div class="f-description">
			<p><?=Text::limit_chars(Text::removebbcode($ad->description), 30, NULL, TRUE)?></p>
		</div>
		<div class="clearfix"></div>
	</div>
</div>
<?endforeach?>
