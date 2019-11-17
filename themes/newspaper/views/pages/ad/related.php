<?php defined('SYSPATH') or die('No direct script access.');?>
<? if(core::count($ads)):?>
    <h2 class="listings-title"><span><?=_e('Related ads')?></span></h2>
    <div class="row listings">
        <div class="col-xs-12">
            <?foreach($ads as $ad ):?>
                <? if($ad->featured >= Date::unix2mysql(time())): ?>
                    <div class="row premium listing-row">
                        <div class="ribbon-wrapper-red">
                            <div class="ribbon-red">&nbsp;<span><?= _e('Featured'); ?></span></div>
                        </div>
                <? else: ?>
                    <div class="row listing-row">
                <? endif; ?>
                    <div class="col-sm-2">
                        <a class="thumbnail" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <?if($ad->get_first_image() !== NULL):?>
                                <img class="media-object" src="<?=Core::imagefly($ad->get_first_image('image'),200,200)?>" alt="<?=HTML::chars($ad->title)?>">
                            <?else:?>
                                <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                    <img src="<?=$icon_src?>" alt="<?=HTML::chars($ad->title);?>" style="width: 100%; height: 100%;">
                                <?else:?>
                                    <img data-src="holder.js/<?=core::config('image.width_thumb')?>x<?=core::config('image.height_thumb')?>?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                <?endif?>
                            <?endif?>
                        </a>
                    </div>
                    <div class="col-sm-10">
                        <h3>
                            <a title="<?=HTML::chars($ad->title)?>" href="<?= Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?= $ad->title; ?>
                                <? if(core::config('advertisement.price')): ?>
                                    <? if ($ad->price!=0) : ?>
                                        - <strong><?= i18n::money_format($ad->price, $ad->currency()) ?></strong>
                                    <? endif; ?>
                                <? endif; ?>
                            </a>
                        </h3>
                        <? if (core::config('advertisement.location')): ?>
                            <? if ($ad->id_location != 1 AND $ad->location->loaded()) : ?>
                                <p class="muted">
                                    <?= _e('Location'); ?>:
                                    <a href="<?= Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=HTML::chars($ad->location->translate_name())?>">
                                        <?= $ad->location->translate_name() ?>
                                    </a>
                                </p>
                            <? endif; ?>
                        <? endif; ?>
                        <p class="muted"><?= _e('Publish Date'); ?> <?= Date::format($ad->published, core::config('general.date_format')) ?> / <strong><?= $ad->category->translate_name() ?></strong></p>
                        <p><?= Text::limit_chars(Text::removebbcode($ad->description), 225, NULL, TRUE); ?></p>
                    </div>
                </div>
            <? endforeach?>
        </div>
    </div>
<? endif?>
