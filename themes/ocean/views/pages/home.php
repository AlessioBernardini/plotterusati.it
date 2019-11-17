<?php defined('SYSPATH') or die('No direct script access.');?>

<?=View::factory('pwa/_alert')?>

<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if( (core::config('advertisement.ads_in_home') != 3 AND $user_location === NULL) OR
(core::config('advertisement.ads_in_home') != 3 AND $user_location !== NULL AND core::count($ads) > 0)):?>
    <section class="well featured-posts">
        <h3>
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
        </h3>
        <div class="row">
            <?if (core::count($ads)>0):?>
                <div id="slider-fixed-products" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="active item">
                            <?$i=0; foreach ($ads as $ad):?>
                                <?if ($i%4==0 AND $i!=0):?></div><div class="item"><?endif?>
                                <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                                    <div class="thumbnail latest_ads">
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" class="min-h">
                                            <?if($ad->get_first_image()!== NULL):?>
                                                <?=HTML::picture($ad->get_first_image('image'), ['w' => 179, 'h' => 179], ['1200px' => ['w' => '169', 'h' => '169'], '992px' => ['w' => '132', 'h' => '132'], '768px' => ['w' => '138', 'h' => '138'], '480px' => ['w' => '324', 'h' => '324'], '320px' => ['w' => '180', 'h' => '180']], ['alt' => HTML::chars($ad->title)])?>
                                            <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                                <?=HTML::picture($icon_src, ['w' => 179, 'h' => 179], ['1200px' => ['w' => '169', 'h' => '169'], '992px' => ['w' => '132', 'h' => '132'], '768px' => ['w' => '138', 'h' => '138'], '480px' => ['w' => '324', 'h' => '324'], '320px' => ['w' => '180', 'h' => '180']], ['alt' => HTML::chars($ad->title)])?>
                                            <?else:?>
                                                <img data-src="holder.js/179x179?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                            <?endif?>
                                        </a>
                                        <div class="caption">
                                            <h5><a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=$ad->title?></a></h5>
                                            <p><?=Text::limit_chars(Text::removebbcode($ad->description), 30, NULL, TRUE)?></p>
                                        </div>
                                    </div>
                                </div>
                            <?$i++; endforeach?>
                        </div>
                    </div>
                    <a class="left carousel-control" href="#slider-fixed-products" data-slide="prev">
                        <span class="glyphicon glyphicon-chevron-left"></span>
                    </a>
                    <a class="right carousel-control" href="#slider-fixed-products" data-slide="next">
                        <span class="glyphicon glyphicon-chevron-right"></span>
                    </a>
                </div>
                <div class="clearfix"></div>
            <?else:?>
                <div class="col-md-3">
                    <div class="thumbnail latest_ads">
                        <a class="min-h" href="<?=Route::url('default')?>">
                            <img alt="Laptop for Sale" src="//i0.wp.com/yclas.nyc3.digitaloceanspaces.com/themes/default/img/sample-ads/thumb_laptop-for-sale_1.jpg">
                        </a>
                        <div class="caption">
                            <h5><a href="<?=Route::url('default')?>">Laptop for Sale</a></h5>
                            <p><This laptop is for sale on <?=core::config('general.site_name')?>.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="thumbnail latest_ads">
                        <a class="min-h" href="<?=Route::url('default')?>">
                            <img alt="Analog Cameras for Sale" src="//i0.wp.com/yclas.nyc3.digitaloceanspaces.com/themes/default/img/sample-ads/thumb_analog-cameras-for-sale_1.jpg">
                        </a>
                        <div class="caption">
                            <h5><a href="<?=Route::url('default')?>">Analog Cameras for Sale</a></h5>
                            <p><These cameras are for sale on <?=core::config('general.site_name')?>.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="thumbnail latest_ads">
                        <a class="min-h" href="<?=Route::url('default')?>">
                            <img alt="<?=__('Mustang for Sale')?>" src="//i0.wp.com/yclas.nyc3.digitaloceanspaces.com/themes/default/img/sample-ads/thumb_mustang-for-sale_1.jpg">
                        </a>
                        <div class="caption">
                            <h5><a href="<?=Route::url('default')?>">Mustang for Sale</a></h5>
                            <p><Mustang car for sale on <?=core::config('general.site_name')?>.</p>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="thumbnail latest_ads">
                        <a class="min-h" href="<?=Route::url('default')?>">
                            <img alt="Old Car for Sale" src="//i0.wp.com/yclas.nyc3.digitaloceanspaces.com/themes/default/img/sample-ads/thumb_old-car-for-sale_1.jpg">
                        </a>
                        <div class="caption">
                            <h5><a href="<?=Route::url('default')?>">Old Car for Sale</a></h5>
                            <p>Old car for sale on <?=core::config('general.site_name')?>.</p>
                        </div>
                    </div>
                </div>
            <?endif?>
        </div>
    </section>
<?endif?>
<?if (Core::Config('appearance.map_active')):?>
    <div class='well'>
        <?=Core::Config('appearance.map_jscode')?>
    </div>
<?endif?>
<div class='well'>
    <h3>
        <?=_e("Categories")?>
        <?if ($user_location) :?>
            <small><?=$user_location->translate_name() ?></small>
        <?endif?>
    </h3>
    <div class="row">
        <?$i=0; foreach($categs as $c):?>
            <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                <div class="col-md-4">
                    <div class="panel panel-home-categories">
                        <div class="panel-heading">
                            <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon(); if(( $icon_src )!==FALSE ):?>
                                <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                    <img src="<?=Core::imagefly($icon_src,20,20)?>" alt="<?=HTML::chars($c['translate_name'])?>">
                                </a>
                            <?endif?>
                            <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                <?= $category->get_icon_font() ?> <?= $c['translate_name'] ?>
                            </a>
                        </div>
                        <div class="panel-body">
                            <ul class="list-group">
                                <?$ci=0; foreach($categs as $chi):?>
                                    <?if($chi['id_category_parent'] == $c['id_category'] AND ! in_array($chi['id_category'], $hide_categories)):?>
                                        <?if ($ci < 15):?>
                                            <li class="list-group-item">
                                                <a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=$chi['translate_name'];?>
                                                    <?if (Theme::get('category_badge')!=1) : ?>
                                                        <span class="pull-right badge badge-success"><?=number_format($chi['count'])?></span>
                                                    <?endif?>
                                                </a>
                                            </li>
                                        <?endif?>
                                        <?$ci++; if ($ci == 15):?>
                                            <li class="list-group-item">
                                                <a role="button"
                                                    class="show-all-categories"
                                                    data-cat-id="<?=$c['id_category']?>">
                                                    <?=_e("See all categories")?> <span class="glyphicon glyphicon-chevron-right pull-right"></span>
                                                </a>
                                            </li>
                                        <?endif?>
                                    <?endif?>
                                <?endforeach?>
                            </ul>
                        </div>
                    </div>
                </div>
                <? $i++; if ($i%3 == 0) echo '<div class="clear"></div>';?>
            <?endif?>
        <?endforeach?>
    </div>
</div>

<?if(core::config('advertisement.homepage_map') == 2):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<div id="modalAllCategories" class="modal fade" tabindex="-1" data-apiurl="<?=Route::url('api', array('version'=>'v1', 'format'=>'json', 'controller'=>'categories'))?>">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            </div>
            <div class="modal-body">
                <div class="list-group">
                </div>
            </div>
        </div>
    </div>
</div>
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
