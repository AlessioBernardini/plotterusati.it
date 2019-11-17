<?php defined('SYSPATH') or die('No direct script access.');?>
<?if ($widget->featured_title!=''):?>
    <div class="panel-heading">
        <h3 class="panel-title"><?=$widget->featured_title?></h3>
    </div>
<?endif?>

<div class="panel-body">
    <div class="row">
        <?foreach($widget->ads as $ad):?>
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-4">
                        <a class="thumbnail" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <? if($ad->get_first_image()!== NULL): ?>
                                <img src="<?=$ad->get_first_image()?>" alt="<?=HTML::chars($ad->title)?>">
                            <? else: ?>
                                <img data-src="holder.js/<?=core::config('image.width_thumb')?>x<?=core::config('image.height_thumb')?>?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                            <? endif; ?>
                        </a>
                    </div>
                    <div class="col-sm-8">
                        <?if($widget->placeholder!='header'):?>
                            <p><a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></p>
                            <p><?=Text::limit_chars(Text::removebbcode($ad->description), 30, NULL, TRUE)?></p>
                        <?else:?>
                            <p><a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 45, NULL, TRUE)?></a></p>
                            <p><?=Text::limit_chars(Text::removebbcode($ad->description), 150, NULL, TRUE)?></p>
                        <?endif?>
                    </div>
                </div>
            </div>
        <?endforeach?>
    </div>
</div>
