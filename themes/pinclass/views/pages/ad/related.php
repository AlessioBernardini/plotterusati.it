<?php defined('SYSPATH') or die('No direct script access.');?>

<?if(core::count($ads)):?>
    <h2><?=_e('Related ads')?></h2>
    <div class="row">
        <ul class="grid grid-related">
        <li class="grid-sizer"></li>
        <?foreach($ads as $ad ):?>
            <li class="grid-item">
                <div class="latest_ads pull-left <?=($ad->featured >= Date::unix2mysql(time()))?'featured-item':''?> <?if(Theme::get('dark_listing')!='0'):?>dark_listing<?endif?>">
                    <?if($ad->featured >= Date::unix2mysql(time())):?>
                        <div class="triangle-top-left">
                            <p class="featured-text"><?=_e('Featured')?></p>
                        </div>
                    <?endif?>
                    <?if(Theme::get('listing_display')=='title-in-ad'):?>
                        <?if($ad->get_first_image()!== NULL):?>
                            <figure class="effect-sadie image_holder">
                                <?=HTML::picture($ad->get_first_image('image'), ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'],'992px' => ['w' => '320', 'h' => '320'], '768px' => ['w' => '250', 'h' => '250'], '480px' => ['w' => '380', 'h' => '380'], '320px' => ['w' => '230', 'h' => '230']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                    <figcaption>
                                        <h2><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                        <p><i class="fa fa-search"></i><?=_e('Read more')?></p>
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"></a>
                                    </figcaption>
                            </figure>
                        <?else:?>
                            <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                <figure class="effect-sadie image_holder" style="background-image: url('<?=$icon_src?>')">
                                    <figcaption>
                                        <h2><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                        <p><i class="fa fa-search"></i><?=_e('Read more')?></p>
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"></a>
                                    </figcaption>
                                </figure>
                            <?else:?>
                                <figure class="effect-sadie image_holder holderjs" data-background-src="?holder.js/400x250?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=14&amp;auto=yes">
                                    <figcaption>
                                        <h2><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                        <p><i class="fa fa-search"></i><?=_e('Read more')?></p>
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"></a>
                                    </figcaption>
                                </figure>
                            <?endif?>
                        <?endif?>
                    <?elseif(Theme::get('listing_display')=='title-above-ad'):?>
                        <h2 class="title-above"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                        <?if($ad->get_first_image()!== NULL):?>
                        <figure class="effect-zoe image_holder">
                            <?=HTML::picture($ad->get_first_image('image'), ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'],'992px' => ['w' => '320', 'h' => '320'], '768px' => ['w' => '250', 'h' => '250'], '480px' => ['w' => '380', 'h' => '380'], '320px' => ['w' => '230', 'h' => '230']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                            <figcaption>
                                <p><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="fa fa-search"></i><?=_e('Read more')?></a></p>
                            </figcaption>
                        </figure>
                        <?else:?>
                            <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                <figure class="effect-zoe image_holder" style="background-image: url('<?=$icon_src?>')">
                                    <figcaption>
                                        <p><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="fa fa-search"></i><?=_e('Read more')?></a></p>
                                    </figcaption>
                                </figure>
                            <?else:?>
                                <figure class="effect-zoe image_holder holderjs" data-background-src="?holder.js/400x250?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=14&amp;auto=yes">
                                    <figcaption>
                                        <p><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="fa fa-search"></i><?=_e('Read more')?></a></p>
                                    </figcaption>
                                </figure>
                            <?endif?>
                        <?endif?>
                    <?elseif(Theme::get('listing_display')=='title-below-ad'):?>
                        <?if($ad->get_first_image()!== NULL):?>
                            <figure class="effect-katy image_holder">
                                <?=HTML::picture($ad->get_first_image('image'), ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'],'992px' => ['w' => '320', 'h' => '320'], '768px' => ['w' => '250', 'h' => '250'], '480px' => ['w' => '380', 'h' => '380'], '320px' => ['w' => '230', 'h' => '230']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                <figcaption>
                                    <h5><i class="fa fa-search"></i><?=_e('Read more')?></h5>
                                    <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">View more</a>
                                </figcaption>
                            </figure>
                            <h2 class="title-below"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                        <?else:?>
                            <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                <figure class="effect-katy image_holder" style="background-image: url('<?=$icon_src?>')">
                                    <figcaption>
                                        <h5><i class="fa fa-search"></i><?=_e('Read more')?></h5>
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">View more</a>
                                    </figcaption>
                                </figure>
                                <h2 class="title-below"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                            <?else:?>
                                <figure class="effect-katy image_holder holderjs" data-background-src="?holder.js/400x250?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=14&amp;auto=yes">
                                    <figcaption>
                                        <h5><i class="fa fa-search"></i><?=_e('Read more')?></h5>
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">View more</a>
                                    </figcaption>
                                </figure>
                                <h2 class="title-below"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                            <?endif?>
                        <?endif?>
                    <?endif?>
                    <div class="caption">
                        <p><?=Text::limit_chars(Text::removebbcode($ad->description), 50, NULL, TRUE)?></p>
                        <a class="btn btn-sm visible-xs" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="fa fa-search"></i><?=_e('Read more')?></a>
                    </div>
                    <div class="extra_info">
                        <?if ($ad->price!=0){?>
                        	<div class="col-xs-12 col-sm-6 text-center price">
                                <i class="fa fa-money"></i><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                        	</div>
                        <?}?>
                        <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                        	<div class="col-xs-12 col-sm-6 text-center price">
                                <i class="fa fa-money"></i><?=_e('Free');?>
                        	</div>
                        <?}?>
                        <div class="col-xs-12 col-sm-6 text-center location">
                            <?if(Theme::get('listing_extra_info')=='views'):?>
                                <i class="fa fa-eye"></i><?=$ad->count_ad_hit()?>
                            <?elseif(Theme::get('listing_extra_info')=='location'):?>
                                <?if (core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()):?>
                                    <?if(Theme::get('boxed_layout')==1):?>
                                        <i class="fa fa-map-marker hidden-xs hidden-sm hidden-md"></i>
                                    <?endif?>
                                    <?=$ad->location->translate_name() ?>
                                <?endif?>
                            <?elseif(Theme::get('listing_extra_info')=='user'):?>
                                <a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><i class="fa fa-user"></i><?=$ad->user->name?></a>
                            <?endif?>
                        </div>
                    </div>
                </div>
            </li>
        <?endforeach?>
        </ul>
    </div>
<?endif?>
