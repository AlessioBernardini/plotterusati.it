<?php defined('SYSPATH') or die('No direct script access.');?>
<?if ($widget->featured_title!=''):?>
    <div class="panel-heading">
        <h3 class="panel-title"><?=$widget->featured_title?></h3>
    </div>
<?endif?>

<div id="widget_featured" class="panel-body">
    <? foreach($widget->ads as $ad):?>
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-4">
                    <a class="thumbnail" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                        <? if($ad->get_first_image()!== NULL): ?>
                            <img src="<?=Core::imagefly($ad->get_first_image('image'),200,200)?>" alt="<?=HTML::chars($ad->title)?>"/>
                        <? else: ?>
                            <img data-src="holder.js/200x200?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                        <? endif; ?>
                    </a>
                </div>
                <div class="col-sm-8">
                    <p><a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></p>
                    <p><?=Text::limit_chars(Text::removebbcode($ad->description), 60, NULL, TRUE)?></p>
                </div>
            </div>
        </div>
    <? endforeach; ?>
</div>
