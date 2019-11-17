<?php defined('SYSPATH') or die('No direct script access.');?>
<? if(core::count($ads)):?>
    <div class="recent-posts blocky">
        <div class="section-title">
            <h4><i class="fa fa-desktop color"></i> &nbsp; <?=_e('Related ads')?></h4>
        </div>
        <div id="item-carousel" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
                <?$i=0; foreach ($ads as $ad):?>
                    <?if ($i == 0) :?>
                        <div class="item active"><div class="row">
                    <?elseif ($i % 4 == 0) :?>
                        <div class="item"><div class="row">
                    <?endif?>
                            <div class="col-md-3 col-sm-6">
                                <? if($ad->featured >= Date::unix2mysql(time())): ?>
                                    <div class="s-icon">
                                        <span><?= _e('Featured'); ?></span>
                                    </div>
                                <?endif?>
                                <div class="s-item <?=core::count($ads) < 5 ? 'no-controls' : NULL?>">
                                    <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                        <?if($ad->get_first_image('image') != NULL):?>
                                            <img class="media-object img-responsive" src="<?=Core::imagefly($ad->get_first_image('image'),200,200)?>" alt="<?= HTML::chars($ad->title)?>">
                                        <?else:?>
                                            <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                                <img class="media-object img-responsive" src="<?=Core::imagefly($icon_src,200,200)?>" alt="<?= HTML::chars($ad->title)?>">
                                            <?else:?>
                                                <img data-src="holder.js/150x150?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                            <?endif?>
                                        <?endif?>
                                    </a>
                                    <div class="s-caption">
                                        <h4><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></h4>
                                        <p><?=Text::limit_chars(Text::removebbcode($ad->description), 30, NULL, TRUE)?></p>
                                    </div>
                                </div>
                            </div>
                        <?$i++; if ($i % 4 == 0) :?>
                            </div></div>
                        <?endif?>
                    <?endforeach?>
                    <?if ($i % 4 != 0):?>
                        </div></div>
                    <?endif?>
            </div>
            <?if (core::count($ads) > 4) :?>
                <!-- Controls -->
                <a class="left c-control" href="#item-carousel" data-slide="prev">
                    <i class="fa fa-chevron-left"></i>
                </a>
                <a class="right c-control" href="#item-carousel" data-slide="next">
                    <i class="fa fa-chevron-right"></i>
                </a>
            <?endif?>
        </div>
    </div>
<? endif?>
