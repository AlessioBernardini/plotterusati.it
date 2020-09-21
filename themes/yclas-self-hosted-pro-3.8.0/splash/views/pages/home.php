<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pwa/_alert')?>

<section id="slider-homepage" <?=(Theme::get('home_bg_image')!='')? 'style="background-image: url(\''.Theme::get('home_bg_image').'\')"':NULL?>>
    <div class="container">
        <h1 class="slider-h1"><?=Theme::get('home_slogan')?></h1>
        <h2 class="slider-h2"><?=Theme::get('home_description')?></h2>
        <?if(Core::config('general.algolia_search') == 1):?>
            <?=View::factory('pages/algolia/autocomplete')?>
        <?else:?>
            <?= FORM::open(Route::url('search'), array('class'=>'search-frm', 'method'=>'GET', 'action'=>''))?>
                <input type="text" name="title" class="form-control search-input"  placeholder="<?=__('Enter keyword...')?>">
                <button type="submit" class="primary-btn color-primary btn"><?=_e('Search')?> <i class="fa fa-search"></i></button>
            <?= FORM::close()?>
        <?endif?>
    </div>
    <?if(Theme::get('home_bg_image_overlay')!=0):?><div class="overlay slider-overlay"></div><?endif?>
</section>

<?=Alert::show()?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<section id="main" class="categories">
    <div class="container no-gutter">
        <div class="row">
            <?if (Theme::get('homepage_html')!=''):?>
                <div class="col-xs-12 text-center">
                    <?=Theme::get('homepage_html')?>
                </div>
            <?endif?>
            <div class="col-xs-12 col-sm-12 <?=(Theme::get('sidebar_position')=='hidden')?'col-md-12':'col-md-9'?> <?=(Theme::get('sidebar_position')=='left')?'col-md-push-3':NULL?>">
                <?if (Core::Config('appearance.map_active')):?>
                    <div class="row">
                        <div class="col-xs-12">
                            <h2 class="item-title"><?=_e("Map")?></h2>
                            <?=Core::Config('appearance.map_jscode')?>
                        </div>
                    </div>
                    <br><br>
                <?endif?>
                <h3 class="h2">
                    <?=_e("Categories")?>
                    <?if ($user_location) :?>
                        <small><?=$user_location->translate_name() ?></small>
                    <?endif?>
                </h3>
                <div class="row">
                    <?$i=0;?>
                    <?foreach($categs as $c):?>
                    <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                    <div class="col-xs-12 col-sm-4">
                        <div class="categorie">
                            <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon(); if(( $icon_src )!==FALSE ):?>
                                <img src="<?=Core::imagefly($icon_src,70,70)?>" title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" class="icon img-responsive" alt="<?=HTML::chars($c['translate_name'])?>">
                            <?elseif($category->get_icon_font()):?>
                                <div class="icon"><span class="h4"><?= $category->get_icon_font() ?></span></div>
                            <?elseif (file_exists(DOCROOT.'images/categories/'.$c['seoname'].'_icon.png')):?>
                                <img src="<?=Core::imagefly(URL::base().'images/categories/'.$c['seoname'].'_icon.png',70,70)?>" title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" class="icon" alt="<?=HTML::chars($c['translate_name'])?>">
                            <?endif?>
                            <h3 class="h3"><a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=mb_strtoupper($c['translate_name']);?></a></h3>
                            <ul>
                                <?$ci=0; foreach($categs as $chi):?>
                                    <?if($chi['id_category_parent'] == $c['id_category'] AND ! in_array($chi['id_category'], $hide_categories)):?>
                                        <?if ($ci < 15):?>
                                            <li><a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=$chi['translate_name'];?>
                                            <?if (Theme::get('category_badge')!=1) : ?>
                                                <span>(<?=number_format($chi['count'])?>)</span></a></li>
                                            <?endif?>
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
                    <?
                        $i++;
                        if ($i%3 == 0) echo '<div class="clear"></div>';
                    ?>
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
            <aside><?=View::fragment('sidebar_front','sidebar')?></aside>
        </div>
    </div>
</section>
<?if(core::config('advertisement.ads_in_home') != 3):?>
    <section id="related">
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
        <div class="no-gutter">
            <ul>
                <?$i=0;
                foreach($ads as $ad):?>
                <li class="col-xs-4 col-sm-3 col-md-4 col-lg-2">
                    <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                        <?if($ad->get_first_image()!== NULL):?>
                            <?=HTML::picture($ad->get_first_image('image'), ['w' => 341, 'h' => 299], ['1200px' => ['w' => '218', 'h' => '175'], '992px' => ['w' => '341', 'h' => '299'], '768px' => ['w' => '248', 'h' => '131'], '480px' => ['w' => '259', 'h' => '175'], '320px' => ['w' => '218', 'h' => '200']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                        <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                            <?=HTML::picture($icon_src, ['w' => 341, 'h' => 299], ['1200px' => ['w' => '218', 'h' => '175'], '992px' => ['w' => '341', 'h' => '299'], '768px' => ['w' => '248', 'h' => '131'], '480px' => ['w' => '259', 'h' => '175'], '320px' => ['w' => '218', 'h' => '200']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                        <?else:?>
                            <img data-src="holder.js/218x200?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="center-block img-responsive" alt="<?=HTML::chars($ad->title)?>">
                        <?endif?>
                        <div class="text">
                            <p><?=$ad->title?></p>
                            <span><?=$ad->category->translate_name() ?></span>
                        </div>
                        <div class="overlay overlay-related"></div>
                    </a>
                </li>
                <?endforeach?>
                <li class="col-xs-4 col-sm-3 col-md-4 col-lg-2">
                    <a href="<?=Route::url('list',array('controller'=>'ad','action'=>'listing'))?>"><?=_e('More ads')?><br /><i class="fa fa-arrow-right"></i></a>
                </li>
            </ul>
        </div>
    </section>
<?endif?>

<?if(core::config('advertisement.homepage_map') == 2):?>
    <?=View::factory('pages/map/home')?>
<?endif?>

<?if(core::config('general.auto_locate') AND ! Cookie::get('user_location') AND Core::is_HTTPS()):?>
    <input type="hidden" name="auto_locate" value="<?=core::config('general.auto_locate')?>">
    <?if(core::count($auto_locats) > 0):?>
        <div class="modal fade" id="auto-locations" tabindex="-1" role="dialog" aria-labelledby="autoLocations" aria-hidden="true">
            <div class="modal-dialog    modal-sm">
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
