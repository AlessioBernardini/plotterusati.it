<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="latest-module">
	<h3 class="h3"><?=$widget->ads_title?></h3>
	<ul>
	<?foreach($widget->ads as $ad):?>
	    <li>
			<a href="<?=Route::url('ad',array('seotitle'=>$ad->seotitle,'category'=>$ad->category->seoname))?>" title="<?=HTML::chars($ad->title)?>">
				<?if($ad->get_first_image()!== NULL):?>
	                <img src="<?=Core::imagefly($ad->get_first_image('image'),260,260)?>" alt="<?=HTML::chars($ad->title)?>">
	            <?else:?>
	                <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                        <img src="<?=$icon_src?>" alt="<?=HTML::chars($ad->title)?>" >
	                <?elseif(( $icon_src = $ad->location->get_icon() )!==FALSE ):?>
                        <img src="<?=$icon_src?>" alt="<?=HTML::chars($ad->title)?>" >
                    <?else:?>
                        <img data-src="holder.js/<?=core::config('image.width_thumb')?>x<?=core::config('image.height_thumb')?>?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                    <?endif?>
	            <?endif?>
				<div class="text">
					<p>
						<?=Text::limit_chars(Text::removebbcode($ad->title), 25, NULL, TRUE)?>
					</p>
					<span><?=Text::limit_chars(Text::removebbcode($ad->description), 25, NULL, TRUE)?></span>
				</div>
				<div class="overlay latest-module-overlay"></div>
			</a>
	    </li>
	<?endforeach?>
	</ul>
</div>