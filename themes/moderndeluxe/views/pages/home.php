<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pwa/_alert')?>

<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
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
            <div class="row">
                <div id="slider-fixed-products" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="active item">
                            <?$i=0; foreach ($ads as $ad):?>
                                <?if ($i%3==0 AND $i!=0):?></div><div class="item"><?endif?>
                                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-6">
                                    <div class="thumbnail latest_ads">
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" class="min-h">
                                            <?if($ad->get_first_image()!== NULL):?>
                                                <?=HTML::picture($ad->get_first_image('image'), ['w' => 250, 'h' => 250], ['1200px' => ['w' => '250', 'h' => '250'],'992px' => ['w' => '200', 'h' => '200'], '768px' => ['w' => '278', 'h' => '278']], ['alt' => HTML::chars($ad->title)])?>
                                            <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                                <?=HTML::picture($icon_src, ['w' => 250, 'h' => 250], ['1200px' => ['w' => '250', 'h' => '250'],'992px' => ['w' => '200', 'h' => '200'], '768px' => ['w' => '278', 'h' => '278']], ['alt' => HTML::chars($ad->title)])?>
                                            <?else:?>
                                                <img data-src="holder.js/250x250?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
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
            </div>
        </section>
    <?endif?>
<?endif?>
<?if (Core::Config('appearance.map_active')):?>
    <?=Core::Config('appearance.map_jscode')?>
<?endif?>
<section class="categories">
	<h2>
        <?=_e("Categories")?>
        <?if ($user_location) :?>
            <small><?=$user_location->translate_name() ?></small>
        <?endif?>
    </h2>
	<div class="row">
	    <?$i=0; foreach($categs as $c):?>
	        <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
	            <div class="col-md-4">
	                <div class="panel panel-home-categories category-container">
	                    <div class="panel-heading">
	                        <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon(); if(( $icon_src )!==FALSE ):?>
                                <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                    <img src="<?=Core::imagefly($icon_src,30,30)?>" alt="<?=HTML::chars($c['translate_name'])?>" />
                                </a>
                            <?elseif($category->get_icon_font()):?>
                                <div class="h4"><?= $category->get_icon_font() ?></div>
                            <?elseif (file_exists(DOCROOT.'images/categories/'.$c['seoname'].'_icon.png')):?>
                                <a class="pull-left" title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?> href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                    <img src="<?=Core::imagefly(URL::base().'images/categories/'.$c['seoname'].'_icon.png',30,30)?>" alt="<?=HTML::chars($c['translate_name'])?>" />
                                </a>
                            <?endif?>
			                <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=($c['translate_name']);?>
			                    <?if (Theme::get('category_badge')!=1) : ?>
			                        <span class="badge badge-success pull-right"><?=number_format($c['count'])?></span>
			                    <?endif?>
			                </a>
	                    </div>
	                    <div class="panel-body">
	                        <ul class="list-group">
	                            <?$ci=0; foreach($categs as $chi):?>
	                                <?if($chi['id_category_parent'] == $c['id_category'] AND ! in_array($chi['id_category'], $hide_categories)):?>
                                        <?if ($ci < 15):?>
    	                                    <li>
    	                                        <a title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>"><?=$chi['translate_name'];?>
    	                                            <?if (Theme::get('category_badge')!=1) : ?>
    	                                                <span class="pull-right badge"><?=number_format($chi['count'])?></span>
    	                                            <?endif?>
    	                                        </a>
    	                                    </li>
                                        <?endif?>
                                        <?$ci++; if ($ci == 15):?>
                                            <li>
                                                <a class="show-all-categories" href="#" data-cat-id="<?=$c['id_category']?>">
                                                    <?=_e('See all categories')?>
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
</section>

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
