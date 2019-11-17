<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pwa/_alert')?>

<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if(core::config('advertisement.ads_in_home') != 3):?>
    <?if (core::count($ads)>0):?>
        <h4>
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
        </h4>
        <div id="slides">
            <?$i=0;foreach ($ads as $ad):?>

                <a class="text-center" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                    <h3 class="slide_title"><?=$ad->title?></h3>
                    <?if($ad->get_first_image()!== NULL):?>
                        <?=HTML::picture($ad->get_first_image('image'), ['h' => 367], ['1200px' => ['h' => '367'],'992px' => ['h' => '367'], '768px' => ['h' => '367'], '480px' => ['h' => '367'], '320px' => ['h' => '367']], ['alt' => HTML::chars($ad->title)])?>
                    <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                        <?=HTML::picture($icon_src, ['h' => 367], ['1200px' => ['h' => '367'],'992px' => ['h' => '367'], '768px' => ['h' => '367'], '480px' => ['h' => '367'], '320px' => ['h' => '367']], ['alt' => HTML::chars($ad->title)])?>
                    <?else:?>
                        <img data-src="holder.js/800x357?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                    <?endif?>
                </a>
            <?$i++;endforeach?>
            <a href="#" class="slidesjs-previous slidesjs-navigation"><span class="glyphicon glyphicon-chevron-left"></span></a>
            <a href="#" class="slidesjs-next slidesjs-navigation"><span class="glyphicon glyphicon-chevron-right"></span></a>
        </div>
    <?endif?>
<?endif?>

<?if (Core::Config('appearance.map_active')):?>
    <h4><?=_e('Map')?></h4>
    <?=Core::Config('appearance.map_jscode')?>
<?endif?>

<h4>
    <?=_e("Categories")?>
    <?if ($user_location) :?>
        <small><?=$user_location->translate_name() ?></small>
    <?endif?>
</h4>
<div class="row selected-classifieds">
    <?$i=0;?>
    <?foreach($categs as $c):?>
        <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12">
                <div class="thumbnail">
                    <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                        <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon(); if(( $icon_src )!==FALSE ):?>
                            <?=HTML::picture($icon_src, ['w' => 179, 'h' => 150], ['1200px' => ['w' => '179', 'h' => '150'],'992px' => ['w' => '141', 'h' => '150'], '768px' => ['w' => '147', 'h' => '150'], '480px' => ['w' => '147', 'h' => '150'], '320px' => ['w' => '156', 'h' => '150']], array('class' => 'center-block', 'alt' => HTML::chars($c['translate_name'])))?>
                        <?elseif($category->get_icon_font()):?>
                            <div class="text-center h2"><?= $category->get_icon_font() ?></div>
                        <?else:?>
                            <img data-src="holder.js/100px150?<?=str_replace('+', ' ', http_build_query(array('text' => $c['translate_name'], 'size' => 14)))?>" alt="<?=HTML::chars($c['translate_name'])?>">
                        <?endif?>
                    </a>
                    <div class="caption">
                        <h5>
                            <a title="<?=HTML::chars($c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                <?=$c['translate_name']?>
                            </a>
                        </h5>
                        <div class="custom_box_content">
                            <ul class="nav nav-list">
                                <?$ci=0; foreach($categs as $chi):?>
                                    <?if($chi['id_category_parent'] == $c['id_category'] AND ! in_array($chi['id_category'], $hide_categories)):?>
                                        <?if ($ci < 15):?>
                                            <li class="cat_list_home"><a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=$chi['translate_name'];?> </a></li>
                                        <?endif?>
                                        <?$ci++; if ($ci == 15):?>
                                            <li class="cat_list_home"><a class="show-all-categories" title="<?=HTML::chars($chi['translate_name'])?>" href="#" data-cat-id="<?=$c['id_category']?>"><?=_e('See all categories')?></a></li>
                                        <?endif?>
                                    <?endif?>
                                 <?endforeach?>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <?$i++;?>
            <?if ($i%4 == 0):?><div class="clearfix"></div><br> <?endif?>
        <?endif?>
    <?endforeach?>
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
