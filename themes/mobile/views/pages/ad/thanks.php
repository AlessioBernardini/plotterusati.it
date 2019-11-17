<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <?if ($page->loaded()):?>
        <h1><?=$page->title?></h1>
        <div class="text-description"><?=$page->description?></div>
    <?else:?>
        <h2 class="help-block"><?=_e('Thanks for submitting your advertisement')?></h2>
    <?endif?>
</div>

<p class="text-center">
    <?if(core::config('general.moderation') == Model_Ad::POST_DIRECTLY) :?>
        <a class="btn btn-success color-white" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=_e('Go to Your Ad')?></a>
    <?endif?>
</p>
<p class="text-center">
    <?if(core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql()):?>
        <a class="btn btn-primary color-white" type="button" href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>">
            <?=_e('Go Featured!')?> <?=i18n::format_currency(Model_Order::get_featured_price(),core::config('payment.paypal_currency'))?>
        </a>
    <?endif?>
</p>