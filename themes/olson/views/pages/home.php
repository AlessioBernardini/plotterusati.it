<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pwa/_alert')?>

<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if (Theme::get('home_hero_title') OR Theme::get('home_hero_desc')) : ?>
    <div class="hero">
        <div class="row">
            <div class="col-md-12">
                <?if (Theme::get('home_hero_title')) : ?>
                    <h3><?=Theme::get('home_hero_title')?></h3>
                <?endif?>
                <?if (Theme::get('home_hero_desc')) : ?>
                    <p><?=Theme::get('home_hero_desc')?></p>
                <?endif?>
            </div>
        </div>
        <div class="sep-bor"></div>
    </div>
<?endif?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if (core::config('advertisement.ads_in_home') != 3 AND core::count($ads) > 0):?>
    <div class="row">
        <div class="col-md-12 blocky">
            <div class="recent-posts">
                <div class="section-title">
                    <h4>
                        <i class="fa fa-desktop color"></i> &nbsp;
                        <?if(core::config('advertisement.ads_in_home') == 0):?>
                            <?=_e("Latest Ads")?>
                        <?elseif(core::config('advertisement.ads_in_home') == 1 OR core::config('advertisement.ads_in_home') == 4):?>
                            <?=_e('Featured Ads')?>
                        <?elseif(core::config('advertisement.ads_in_home') == 2):?>
                            <?=_e('Popular Ads last month')?>
                        <?endif?>
                        <?if ($user_location) :?>
                            <small><?=$user_location->translate_name() ?></small>
                        <?endif?>
                    </h4>
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
                                            <div class="s-item">
                                                <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                                    <?if($ad->get_first_image()!== NULL):?>
                                                        <?=HTML::picture($ad->get_first_image(), ['w' => 150, 'h' => 150], ['992px' => ['w' => '150', 'h' => '150'], '320px' => ['w' => '150', 'h' => '150']], ['alt' => HTML::chars($ad->title)])?>
                                                    <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                                        <?=HTML::picture($icon_src, ['w' => 150, 'h' => 150], ['992px' => ['w' => '150', 'h' => '150'], '320px' => ['w' => '150', 'h' => '150']], ['alt' => HTML::chars($ad->title)])?>
                                                    <?else:?>
                                                        <img data-src="holder.js/150x150?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
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
                    <!-- Controls -->
                    <a class="left c-control" href="#item-carousel" data-slide="prev">
                        <i class="fa fa-chevron-left"></i>
                    </a>
                    <a class="right c-control" href="#item-carousel" data-slide="next">
                        <i class="fa fa-chevron-right"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?endif?>

<?if (Core::Config('appearance.map_active')):?>
    <div class="row">
        <div class="col-md-12 blocky">
            <div class="section-title">
                <h4><i class="fa fa-globe color"></i> <?=_e("Map")?></h4>
            </div>
            <?=Core::Config('appearance.map_jscode')?>
        </div>
    </div>
<?endif?>

<div class="row">
    <div class="col-md-12 blocky home-categories">
        <div class="section-title">
            <h4>
                <i class="fa fa-folder-o color"></i> <?=_e("Categories")?>
                <?if ($user_location) :?>
                    <small><?=$user_location->translate_name() ?></small>
                <?endif?>
            </h4>
        </div>
        <div class="row">
            <?$i=0; foreach($categs as $c):?>
                <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                    <div class="col-md-4">
                        <div class="c-item">
                            <ul class="list-unstyled">
                                <li class="cathead">
                                    <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon(); if(( $icon_src )!==FALSE ):?>
                                        <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                            <img src="<?=Core::imagefly($icon_src,30,30)?>" alt="<?=HTML::chars($c['translate_name'])?>">
                                        </a>
                                    <?elseif (file_exists(DOCROOT.'images/categories/'.$c['seoname'].'_icon.png')):?>
                                        <a class="pull-left" title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                            <img src="<?=Core::imagefly(URL::base().'images/categories/'.$c['seoname'].'_icon.png',30,30)?>" alt="<?=HTML::chars($c['translate_name'])?>">
                                        </a>
                                    <?endif?>
                                    <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                        <?if (Theme::get('category_badge')!=1) : ?>
                                            <span class="badge badge-success pull-right"><?=number_format($c['count'])?></span>
                                        <?endif?>
                                        <?= $category->get_icon_font() ?> <?=($c['translate_name']);?>
                                    </a>
                                    <hr/>
                                </li>

                                <?$ci=0; foreach($categs as $chi):?>
                                    <?if($chi['id_category_parent'] == $c['id_category'] AND ! in_array($chi['id_category'], $hide_categories)):?>
                                        <?if ($ci < 15):?>
                                            <li>
                                                <a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                                    <?if (Theme::get('category_badge')!=1) : ?>
                                                        <span class="badge pull-right"><?=number_format($chi['count'])?></span>
                                                    <?endif?>
                                                    <?=$chi['translate_name'];?>
                                                </a>
                                            </li>
                                        <?endif?>
                                        <?$ci++; if ($ci == 15):?>
                                            <li>
                                                <a role="button"
                                                    class="show-all-categories"
                                                    data-cat-id="<?=$c['id_category']?>">
                                                    <?=_e("See all categories")?>
                                                </a>
                                            </li>
                                        <?endif?>
                                    <?endif?>
                                <?endforeach?>
                            </ul>
                        </div>
                    </div>
                    <? $i++; if ($i%3 == 0) echo '<div class="clearfix"></div>';?>
                <?endif?>
            <?endforeach?>
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
</div>

<?if (Theme::get('home_cta_title') OR Theme::get('home_cta_btn1_anchor') OR Theme::get('home_cta_btn2_anchor')) : ?>
    <div class="row">
        <div class="col-md-12 blocky">
            <div class="cta">
                <div class="row">
                    <?if (Theme::get('home_cta_title')) :?>
                        <div class="col-md-8 col-sm-8">
                            <h5><i class="fa fa-angle-right"></i> <?=Theme::get('home_cta_title')?></h5>
                        </div>
                    <?endif?>
                    <?if (Theme::get('home_cta_btn1_anchor') OR Theme::get('home_cta_btn2_anchor')) :?>
                        <div class="col-md-4 col-sm-4">
                            <div class="cta-buttons pull-right">
                                <?if (Theme::get('home_cta_btn1_anchor')) :?>
                                    <a class="btn btn-info btn-lg" href="<?=Theme::get('home_cta_btn1_url')?>"><?=Theme::get('home_cta_btn1_anchor')?></a>
                                &nbsp;
                                <?endif?>
                                <?if (Theme::get('home_cta_btn2_anchor')) :?>
                                    <a class="btn btn-danger btn-lg" href="<?=Theme::get('home_cta_btn2_url')?>"><?=Theme::get('home_cta_btn2_anchor')?></a>
                                <?endif?>
                            </div>
                        </div>
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
