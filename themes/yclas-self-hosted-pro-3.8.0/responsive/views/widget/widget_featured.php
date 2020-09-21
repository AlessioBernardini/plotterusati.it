<?php defined('SYSPATH') or die('No direct script access.');?>
<?if ($widget->featured_title!=''):?>
    <div class="panel-heading">
        <h3 class="panel-title"><?=$widget->featured_title?></h3>
    </div>
<?endif?>

<div class="panel-body">
    <? foreach($widget->ads as $ad):?>
        <div class="row">
            <?if($widget->placeholder=='sidebar' OR $widget->placeholder=='publish_new'):?>
            <div class="col-sm-4">
            <?else:?>
            <div class="col-sm-12">
            <?endif?>
                <?if ($ad->get_first_image() !== NULL):?>
                        <a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <img class="img-responsive img-rounded" src="<?=Core::imagefly($ad->get_first_image('image'),200,200)?>" alt="<?=HTML::chars($ad->title)?>">
                        </a>
                <? else: ?>
                        <a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <img data-src="holder.js/<?=core::config('image.width_thumb')?>x<?=core::config('image.height_thumb')?>?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive img-rounded">
                        </a>
                <?endif?>
            </div>
            <div class="<?=($widget->placeholder=='sidebar' OR $widget->placeholder=='publish_new') ? 'col-sm-8' : 'col-sm-12'?>">
                <p><a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></p>
                <p><?=Text::limit_chars(Text::removebbcode($ad->description), 60, NULL, TRUE)?></p>
            </div>
        </div>
        </br>
    <? endforeach; ?>
</div>
