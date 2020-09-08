<?php defined('SYSPATH') or die('No direct script access.');?>
<?=View::factory('pwa/_alert')?>

<?=(Theme::get('homepage_html')!='')?Theme::get('homepage_html'):''?>

<?if(core::config('advertisement.homepage_map') == 1):?>
    <?=View::factory('pages/map/home')?>
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
            <?php
        	$annunci = new Model_Ad();
        	$annunci->where('status', '=', Model_Ad::STATUS_PUBLISHED);
        	$annunci = $annunci->find_all();
        	?>
            <div class="row"> <a class="home vedi-tutti" href="/all">Vedi tutti <span class="count_ads">(<?=core::count($annunci)?>)</span></a>
                <?$i=0;foreach ($ads as $ad):?>
                	<?if($i%3 == 0 OR $i==0):?><div class="row"><?endif?>
                    <div class="col-lg-4 col-md-6 col-sm-12 col-xs-12">
                        <div class="latest_ads">
                            <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                <?if($ad->get_first_image()!== NULL):?>
                                    <?=HTML::picture($ad->get_first_image('image'), ['w' => 360, 'h' => 200], ['1200px' => ['w' => '360', 'h' => '200'], '992px' => ['w' => '455', 'h' => '252'], '768px' => ['w' => '720', 'h' => '400'], '480px' => ['w' => '738', 'h' => '410'], '320px' => ['w' => '450', 'h' => '250']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                                <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                    <?=HTML::picture($icon_src, ['w' => 360, 'h' => 200], ['1200px' => ['w' => '360', 'h' => '200'], '992px' => ['w' => '455', 'h' => '252'], '768px' => ['w' => '720', 'h' => '400'], '480px' => ['w' => '738', 'h' => '410'], '320px' => ['w' => '450', 'h' => '250']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                                <?else:?>
                                    <img data-src="holder.js/360x200?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="center-block img-responsive" alt="<?=HTML::chars($ad->title)?>">
                                <?endif?>
                            </a>
                            <?if (Core::config('advertisement.reviews')==1):?>
                                <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                    <span class="glyphicon glyphicon-star"></span>
                                <?endfor?>
                            <?endif?>
                            <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <div class="extra_info">
                                <?if ($ad->price!=0){?>
                                    <div class="price pull-left">
                                        <i class="fa fa-money"></i><?=i18n::money_format( $ad->price, $ad->currency())?>
                                    </div>
                                <?}?>
                                <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                                    <div class="price pull-left">
                                        <i class="fa fa-money"></i><?=_e('Free');?>
                                    </div>
                                <?}?>
                                <div class="location pull-left">
                                    <?if(Theme::get('listing_extra_info')=='views'):?>
                                        <i class="fa fa-eye"></i><?=$ad->count_ad_hit()?>
                                    <?elseif(Theme::get('listing_extra_info')=='location'):?>
                                        <i class="fa fa-map-marker"></i><?=$ad->location->translate_name() ?>
                                    <?elseif(Theme::get('listing_extra_info')=='user'):?>
                                        <a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><i class="fa fa-user"></i><?=$ad->user->name?></a>
                                    <?endif?>
                                </div>
                                <?php /*<a class="more-link pull-right hvr-icon-forward" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=_e('more')?></a> */?>
                            	<div class="date pull-right"><?if ($ad->published!=0){?> <?= Date::format($ad->published, core::config('general.date_format'))?><? }?></div>
                            </div></a>
                            <div class="caption">
                                <h5><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></h5>
                                <a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                <p><?=Text::limit_chars(Text::removebbcode($ad->description), 100, NULL, TRUE)?></p>
                                </a>
                                <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                    <?if($value=='checkbox_1'):?>
                                    	<a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                        <p class="aggiunto"><b><?=$name?></b>: <i class="fa fa-check"></i></p>
                                        </a>
                                    <?elseif($value=='checkbox_0'):?>
                                    	<a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                        <p class="aggiunto"><b><?=$name?></b>: <i class="fa fa-times"></i></p>
                                        </a>
                                    <?else:?>
                                        <?if(is_string($name)):?>
                                        	<a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                            <p class="aggiunto"><b><?=$name?></b>: <?=$value?></p>
                                            </a>
                                        <?else:?>
                                        	<a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                            <p class="aggiunto"><?=$value?></p>
                                            </a>
                                        <?endif?>
                                    <?endif?>
                                <?endforeach?>
                                <p class="provenienza-home"><b>Provenienza</b>: <?if ($ad->id_location != 1):?><a href="/all/<?=strtolower($ad->location->translate_name())?>"><?=$ad->location->translate_name()?></a><?endif?></p>
                            </div>
                        </div>
                    </div>
                    <?$i++;?>
                    <?if($i%3 == 0):?></div><?endif?>
                <?endforeach?>
                <?if($i%3 != 0):?></div><?endif?>
            </div>
        </section>
    <?endif?>
<?endif?>

<section class="categories">
    <h2>
        <?=_e("Categories")?>
        <?if ($user_location) :?>
            <small><?=$user_location->translate_name() ?></small>
        <?endif?>
    </h2>
    <div class="row">
        <ul>
            <?$i=0; foreach($categs as $c):?>
                <?if($c['id_category_parent'] == 1 AND $c['id_category'] != 1 AND ! in_array($c['id_category'], $hide_categories)):?>
                    <li class="col-md-3">
                        <div class="category">
                            <a title="<?=HTML::chars((strip_tags($c['description'])!=='')?strip_tags($c['description']):$c['translate_name'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'], 'location'=>$user_location ? $user_location->seoname : NULL))?>">
                                <? $category = new Model_Category($c['id_category']); $icon_src = $category->get_icon(); if(( $icon_src )!==FALSE ):?>
                                    <img src="<?=Core::imagefly($icon_src,50,50)?>" alt="<?=HTML::chars($c['translate_name'])?>">
                                <?elseif($category->get_icon_font()):?>
                                    <div><span class="h4"><?= $category->get_icon_font() ?></span></div>
                                <?elseif (file_exists(DOCROOT.'images/categories/'.$c['seoname'].'_icon.png')):?>
                                    <img src="<?=Core::imagefly(URL::base().'images/categories/'.$c['seoname'].'_icon.png',50,50)?>" alt="<?=HTML::chars($c['translate_name'])?>">
                                <?endif?>
                                <h5 id="test"><?=($c['translate_name']);?></h5>
                                <? if (Theme::get('category_badge')!=1) : ?>
                                    <span class="badge"><?=number_format($c['count'])?> <?=_e('ads')?></span>
                                <?endif?>
                            </a>
                        </div>
                    </li>
                    <? $i++; if ($i%4 == 0) echo '<div class="clear"></div>'; endif?>
            <?endforeach?>
        </ul>
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
