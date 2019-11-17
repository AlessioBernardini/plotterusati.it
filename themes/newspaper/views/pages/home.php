<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pwa/_alert')?>

<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if(core::config('advertisement.ads_in_home') != 3):?>
    <?if(core::count($ads)>0):?>
        <h2 class="item-title">
            <?if(core::config('advertisement.ads_in_home') == 0): ?>
                <?=_e('Latest Ads')?>
            <?elseif(core::config('advertisement.ads_in_home') == 1 OR core::config('advertisement.ads_in_home') == 4): ?>
                <?=_e('Featured Ads')?>
            <?elseif(core::config('advertisement.ads_in_home') == 2): ?>
                <?=_e('Popular Ads last month')?>
            <?endif;?>
            <?if ($user_location) :?>
                <small><?=$user_location->translate_name() ?></small>
            <?endif?>
        </h2>
        <div class="row directory">
            <div class="col-xs-12">
                <div class="directory-block col-sm-12 col-xs-12">
                    <div class="row">
                        <?$i=0; $n=core::count($ads);?>
                        <?foreach ($ads as $ad):?>
                            <div class="col-sm-6 col-xs-12">
                                <div class="row">
                                    <div class="col-sm-4 col-xs-4">
                                        <a class="thumbnail" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                            <?if($ad->get_first_image()!== NULL):?>
                                                <img src="<?=Core::imagefly($ad->get_first_image('image'),200,200)?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive"/>
                                            <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                                <img src="<?=Core::imagefly($icon_src,200,200)?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive"/>
                                            <?else:?>
                                                <img data-src="holder.js/200x200?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 24, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                            <?endif?>
                                        </a>
                                    </div>
                                    <div class="col-sm-8 col-xs-8">
                                        <p><a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></p>
                                        <p><?=Text::limit_chars(Text::removebbcode($ad->description), 60, NULL, TRUE)?></p>
                                    </div>
                                </div>
                            </div>
                            <?$i++;?>
                            <?if($i%2 == 0 and $i < $n) : ?>
                                    </div>
                                </div>
                                <div class="directory-block col-sm-12 col-xs-12">
                                    <div class="row">
                            <? endif; ?>
                        <? endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    <? endif; ?>
<? endif; ?>

<?if (Core::Config('appearance.map_active')):?>
    <div class="row">
        <div class="col-xs-12">
            <h2 class="item-title"><?=_e("Map")?></h2>
            <?=Core::Config('appearance.map_jscode')?>
        </div>
    </div>
<?endif?>

<h1 class="item-title">
    <?=_e("Categories")?>
    <?if ($user_location) :?>
        <small><?=$user_location->translate_name() ?></small>
    <?endif?>
</h1>
<div class="row directory">
    <div class="col-xs-12">
        <div class="directory-block col-sm-12 col-xs-6">
            <div class="row">
                <? $i=0; ?>
                <? foreach($categs as $c): ?>
                    <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                        <div class="col-sm-2">
                            <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon(); if(( $icon_src )!==FALSE ):?>
                                <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                    <img src="<?=Core::imagefly($icon_src,64,64)?>" alt="<?=HTML::chars($c['translate_name'])?>" />
                                </a>
                            <?elseif($category->get_icon_font()):?>
                                <div class="h4"><?= $category->get_icon_font() ?></div>
                            <?elseif (file_exists(DOCROOT.'images/categories/'.$c['seoname'].'_icon.png')):?>
                                <a class="pull-left" title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                    <img src="<?=Core::imagefly(URL::base().'images/categories/'.$c['seoname'].'_icon.png',64,64)?>" alt="<?=HTML::chars($c['natranslate_nameme'])?>" />
                                </a>
                            <?endif?>
                            <h4>
                            <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=$c['translate_name']?></a></h4>
                        </div>
                        <div class="col-sm-4">
                            <ul>
                                <?$ci=0; foreach($categs as $chi):?>
                                    <?if($chi['id_category_parent'] == $c['id_category'] AND ! in_array($chi['id_category'], $hide_categories)):?>
                                        <?if ($ci < 15):?>
                                            <li><a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=$chi['translate_name'];?></a></li>
                                        <?endif?>
                                        <?$ci++; if ($ci == 15):?>
                                            <li><a class="show-all-categories" href="#" data-cat-id="<?=$c['id_category']?>"><?=_e('See all categories')?></a></li>
                                        <?endif?>
                                    <? endif; ?>
                                <? endforeach; ?>
                            </ul>
                        </div>
                        <? $i++; ?>
                        <? if ($i%2 == 0) : ?>
                                </div>
                            </div>
                            <div class="directory-block col-sm-12 col-xs-6">
                                <div class="row">
                        <? endif; ?>
                    <? endif; ?>
                <? endforeach; ?>
            </div>
        </div>
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
    </div>
</div>
<?if(Theme::get('locations_home')==1):?>
<h1 class="item-title"><?=_e("Locations")?></h1>
<div class="row directory">
    <div class="col-xs-12">
        <div class="directory-block col-sm-12 col-xs-6">
            <div class="row">
                <? $i=0; ?>
                <?if(core::count($locats = Model_Location::get_location_count()) > 1):?>
                    <? foreach($locats as $l): ?>
                        <? if(isset($l['id_location_parent']) AND $l['id_location_parent'] == 1 AND $l['id_location'] != 1): ?>

                            <div class="col-sm-2">
                                <h4><a title="<?=HTML::chars($l['translate_name'])?>" href="<?=Route::url('list', array('location'=>$l['seoname']))?>"><?=$l['translate_name']?></a></h4>
                            </div>
                            <div class="col-sm-4">
                                <ul>
                                    <? foreach($locats as $lhi): ?>

                                        <? if($lhi['id_location_parent'] == $l['id_location']): ?>
                                            <li><a title="<?=HTML::chars($lhi['translate_name'])?>" href="<?=Route::url('list', array('location'=>$lhi['seoname']))?>"><?=$lhi['translate_name'];?></a></li>
                                        <? endif; ?>
                                    <? endforeach; ?>
                                </ul>
                            </div>
                            <? $i++; ?>
                            <? if ($i%2 == 0) : ?>
                                    </div>
                                </div>
                                <div class="directory-block col-sm-12 col-xs-6">
                                    <div class="row">
                            <? endif; ?>
                        <? endif; ?>
                    <? endforeach; ?>
                <?endif?>
            </div>
        </div>
    </div>
</div>
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
