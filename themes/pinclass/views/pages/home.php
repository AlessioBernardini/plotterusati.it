<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pwa/_alert')?>

<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if(Theme::get('homepage_slider')!='1'):?>
    <div class="flicker-slider">
        <ul>
            <li data-background="<?=Theme::get('homepage_slider_image_1')?>">
                <h1><?=Theme::get('homepage_slider_title_1')?></h1>
                <h3><?=Theme::get('homepage_slider_subtitle_1')?></h3>
            </li>
            <li data-background="<?=Theme::get('homepage_slider_image_2')?>">
                <h2 class="h1"><?=Theme::get('homepage_slider_title_2')?></h2>
                <h3><?=Theme::get('homepage_slider_subtitle_2')?></h3>
            </li>
            <li data-background="<?=Theme::get('homepage_slider_image_3')?>">
                <h2 class="h1"><?=Theme::get('homepage_slider_title_3')?></h2>
                <h3><?=Theme::get('homepage_slider_subtitle_3')?></h3>
            </li>
        </ul>
    </div>
    <script src="../themes/pinclass/js/hammer-v2.0.3.js"></script>
    <script src="../themes/pinclass/js/flickerplate.js"></script>
    <script>
    new flickerplate({
        selector: '.flicker-slider'
    });
</script>
<?endif?>

<?if(Theme::get('categories_on_homepage')!='0'):?>
<section class="categories">
    <div class="row">
        <ul>
        <?$i=0; foreach($categs as $c):?>
            <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                <li class="col-xs-12 col-sm-6 col-md-2">
                    <div class="category">
                        <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                        <? $icon_src = new Model_Category($c['id_category']); $icon_src = $icon_src->get_icon(); if(( $icon_src )!==FALSE ):?>
                        <img src="<?=$icon_src?>" alt="<?=HTML::chars($c['translate_name'])?>">
                        <?elseif (file_exists(DOCROOT.'images/categories/'.$c['seoname'].'_icon.png')):?>
                            <img src="<?=URL::base().'images/categories/'.$c['seoname'].'_icon.png'?>" alt="<?=HTML::chars($c['translate_name'])?>">
                        <?endif?>
                        <h5 id="test"><?=$c['translate_name'];?></h5>
                        <?if (Theme::get('category_badge')!=1) : ?>
                            <span class="badge"><?=number_format($c['count'])?> <?=_e('ads')?></span>
                        <?endif?>
                        </a>
                    </div>
                </li>
            <? $i++; if ($i%6 == 0) echo '<div class="clear"></div>'; endif?>
        <?endforeach?>
        </ul>
    </div>
</section>
<?endif?>
<?if (Core::Config('appearance.map_active')):?>
    <section class="categories clearfix">
        <h2><?=_e('Map')?></h2>
        <?=Core::Config('appearance.map_jscode')?>
    </section>
<?endif?>

<?if(core::config('advertisement.ads_in_home') != 3):?>
    <?if (core::count($ads)>0):?>
        <section class="featured-posts">
            <h2>
                <?if(core::config('advertisement.ads_in_home') == 0):?>
                    <?=_e('Latest Ads')?>
                <?elseif(core::config('advertisement.ads_in_home') == 1 OR core::config('advertisement.ads_in_home') == 4):?>
                    <?=_e('Featured Ads')?>
                <?elseif(core::config('advertisement.ads_in_home') == 2):?>
                    <?=_e('Popular Ads last month')?>
                <?endif?>
                <?if ($user_location) :?>
                    <small><?=$user_location->translate_name() ?></small>
                <?endif?>
            </h2>
                <ul class="grid">
                <li class="grid-sizer"></li>
                <?$i=0; foreach ($ads as $ad):?>
                    <?if ($i%3==0 AND $i!=0):?><?endif?>
                    <li class="grid-item">
                        <div class="latest_ads pull-left <?if(Theme::get('dark_listing')!='0'):?>dark_listing<?endif?>">
                            <?if(Theme::get('listing_clickable')!='0'):?><a class="more-link-full" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"></a><?endif?>
                            <?if(Theme::get('listing_display')=='title-in-ad'):?>
                                <?if($ad->get_first_image()!== NULL):?>
                                    <figure class="effect-sadie image_holder">
                                        <?=HTML::picture($ad->get_first_image('image'), ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '225', 'h' => '225'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '230', 'h' => '230'], '320px' => ['w' => '200', 'h' => '200']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                        <figcaption>
                                            <h2><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                            <p><i class="fa fa-search"></i><?=_e('Read more')?></p>
                                            <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"></a>
                                        </figcaption>
                                    </figure>
                                <?else:?>
                                    <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                        <figure class="effect-sadie image_holder">
                                        	<?=HTML::picture($icon_src, ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '225', 'h' => '225'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '230', 'h' => '230'], '320px' => ['w' => '200', 'h' => '200']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                            <figcaption>
                                                <h2><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                                <p><i class="fa fa-search"></i><?=_e('Read more')?></p>
                                                <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"></a>
                                            </figcaption>
                                        </figure>
                                    <?else:?>
                                        <figure class="effect-sadie image_holder holderjs" data-background-src="?holder.js/275x275?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=14&amp;auto=yes">
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
                                <figure class="effect-zoe">
                                    <?=HTML::picture($ad->get_first_image('image'), ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '225', 'h' => '225'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '230', 'h' => '230'], '320px' => ['w' => '200', 'h' => '200']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                    <figcaption>
                                        <p><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="fa fa-search"></i><?=_e('Read more')?></a></p>
                                    </figcaption>
                                </figure>
                                <?else:?>
                                    <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                        <figure class="effect-zoe image_holder">
                                            <?=HTML::picture($icon_src, ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '225', 'h' => '225'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '230', 'h' => '230'], '320px' => ['w' => '200', 'h' => '200']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                            <figcaption>
                                                <p><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="fa fa-search"></i><?=_e('Read more')?></a></p>
                                            </figcaption>
                                        </figure>
                                    <?else:?>
                                        <figure class="effect-zoe image_holder holderjs">
                                            <img data-src="holder.js/275x275?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=14&amp;auto=yes" alt="<?=HTML::chars($ad->title)?>">
                                            <figcaption>
                                                <p><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="fa fa-search"></i><?=_e('Read more')?></a></p>
                                            </figcaption>
                                        </figure>
                                    <?endif?>
                                <?endif?>
                            <?elseif(Theme::get('listing_display')=='title-below-ad'):?>
                                <?if($ad->get_first_image()!== NULL):?>
                                    <figure class="effect-katy">
                                        <?=HTML::picture($ad->get_first_image('image'), ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '225', 'h' => '225'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '230', 'h' => '230'], '320px' => ['w' => '200', 'h' => '200']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                        <figcaption>
                                            <h5><i class="fa fa-search"></i><?=_e('Read more')?></h5>
                                            <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">View more</a>
                                        </figcaption>
                                    </figure>
                                    <h2 class="title-below"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                <?else:?>
                                    <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                        <figure class="effect-katy image_holder">
                                            <?=HTML::picture($icon_src, ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '225', 'h' => '225'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '230', 'h' => '230'], '320px' => ['w' => '200', 'h' => '200']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                            <figcaption>
                                                <h5><i class="fa fa-search"></i><?=_e('Read more')?></h5>
                                                <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">View more</a>
                                            </figcaption>
                                        </figure>
                                        <h2 class="title-below"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                    <?else:?>
                                        <figure class="effect-katy image_holder holderjs">
                                            <img data-src="holder.js/275x275?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=14&amp;auto=yes" alt="<?=HTML::chars($ad->title)?>">
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
                                <?if(core::config('advertisement.description')!=FALSE):?>
                                    <p><?=Text::limit_chars(Text::removebbcode($ad->description), 125, NULL, TRUE)?></p>
                                <?endif?>
                                <a class="btn btn-sm visible-xs" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="fa fa-search"></i><?=_e('Read more')?></a>
                            </div>
                            <div class="extra_info">
                                <div class="col-xs-12 col-md-6 text-center price">
                                    <?if ($ad->price!=0){?>
                                        <?=i18n::money_format( $ad->price, $ad->currency())?>
                                    <?}?>
                                    <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                                        <?=_e('Free');?>
                                    <?}?>
                                </div>
                                <div class="col-xs-12 col-md-6 text-center location">
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
                <?$i++; endforeach?>
                </ul>

        </section>
    <?endif?>
<?endif?>

<?if(core::config('advertisement.homepage_map') == 2):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if(core::config('general.auto_locate') AND ! Cookie::get('user_location') AND Core::is_HTTPS()):?>
    <input type="hidden" name="auto_locate" value="<?=core::config('general.auto_locate')?>">
    <?if(core::count($auto_locats) > 0):?>
        <div class="modal fade" id="auto-locations" tabindex="-1" role="dialog" aria-labelledby="autoLocations" aria-hidden="true">
            <div class="modal-dialog	modal-sm">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 id="autoLocations" class="modal-title text-center"><?=_e('Please choose your closest location')?></h4>
                    </div>
                    <div class="modal-body">
                        <div class="list-group">
                            <?foreach($auto_locats as $loc):?>
                                <a href="<?=Route::url('default')?>" class="list-group-item" data-id="<?=$loc->id_location?>"><span class="pull-right"><span class="glyphicon glyphicon-chevron-right"></span></span> <?=$loc->name?> (<?=i18n::format_measurement($loc->distance)?>)</a>
                            <?endforeach?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?endif?>
<?endif?>
