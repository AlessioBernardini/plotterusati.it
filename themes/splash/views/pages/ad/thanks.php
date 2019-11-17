<?php defined('SYSPATH') or die('No direct script access.');?>
<section id="page-header">
    <div class="container no-gutter">	
        <div class="row">		
            <div class="col-sm-8">
                <?if ($page->loaded()):?>
                    <h1 class="h1"><?=$page->title?></h1>
                <?else:?>
                    <h2 class="h2"><?=_e('Thanks for submitting your advertisement')?></h2>
                <?endif?>
            </div>
            <?if (Theme::get('breadcrumb')==1):?>
                <div class="col-sm-4 breadcrumbs">
                    <?=Breadcrumbs::render('breadcrumbs')?>
                </div>
            <?endif?>
        </div>
    </div>
    <div class="overlay"></div>
</section>

<section id="main">
    <div class="container no-gutter">
        <div class="row">				
            <div class="col-xs-12 col-sm-12 col-md-12">
                <?=Alert::show()?>
                <?=$page->description?>
                <p class="text-center">
                    <?if(core::config('general.moderation') == Model_Ad::POST_DIRECTLY) :?>
                        <a class="btn btn-success" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=_e('Go to Your Ad')?></a>
                    <?endif?>

                    <?if(core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql()):?>
                        <a class="btn btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>">
                            <?=_e('Go Featured!')?> <?=i18n::format_currency(Model_Order::get_featured_price(),core::config('payment.paypal_currency'))?>
                        </a>
                    <?endif?>
                </p>
            </div>
        </div>
    </div>        
</section>