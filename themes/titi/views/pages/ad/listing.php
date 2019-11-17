<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="container">
    <?=Breadcrumbs::render('breadcrumbs')?>
    <?if (Request::current()->controller()=='Ad' AND Request::current()->action()!='advanced_search') :?>
        <div class="page-header text-center">
            <?if ($category!==NULL):?>
               <h1><?=$category->translate_name() ?></h1>
            <?elseif ($location!==NULL):?>
               <h1><?=$location->translate_name() ?></h1>
            <?else:?>
               <h1><?=_e('Listings')?></h1>
            <?endif?>
        </div>
    <?endif?>

    <?if ($category!==NULL AND $category->translate_description()):?>
        <p><?=$category->translate_description() ?></p>
    <?elseif ($location!==NULL AND $location->translate_description()):?>
        <p><?=$location->translate_description() ?></p>
    <?endif?>

    <?if(core::count($ads)):?>
                        <div class="pull-right">
                            <?if(core::config('general.auto_locate')):?>
                                <button
                                    class="btn btn-default btn-sm <?=core::request('userpos') == 1 ? 'active' : NULL?>"
                                    id="myLocationBtn"
                                    type="button"
                                    data-toggle="modal"
                                    data-target="#myLocation"
                                    data-marker-title="<?=__('My Location')?>"
                                    data-marker-error="<?=__('Cannot determine address at this location.')?>"
                                    data-href="?<?=http_build_query(['userpos' => 1] + Request::current()->query())?>">
                                    <i class="glyphicon glyphicon-map-marker"></i> <?=sprintf(__('%s from you'), i18n::format_measurement(Core::config('advertisement.auto_locate_distance', 1)))?>
                                </button>
                            <?endif?>
                            <?if (core::config('advertisement.map')==1):?>
                                <a href="<?=Route::url('map')?>?category=<?=Model_Category::current()->loaded()?Model_Category::current()->seoname:NULL?>&location=<?=Model_Location::current()->loaded()?Model_Location::current()->seoname:NULL?>" class="btn btn-default btn-sm">
                                    <span class="glyphicon glyphicon-globe"></span> <?=_e('Map')?>
                                </a>
                            <?endif?>
                            <div class="btn-group">
                                <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <?=_e('Show').' '.core::request('items_per_page').' '._e('items per page')?> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu dropdown-menu-right" role="menu" id="show-list">
                                    <li><a href="?<?=http_build_query(['items_per_page' => '5'] + Request::current()->query())?>">  5 <?=__('per page')?></a></li>
                                    <li><a href="?<?=http_build_query(['items_per_page' => '10'] + Request::current()->query())?>"> 10 <?=__('per page')?></a></li>
                                    <li><a href="?<?=http_build_query(['items_per_page' => '20'] + Request::current()->query())?>"> 20 <?=__('per page')?></a></li>
                                    <li><a href="?<?=http_build_query(['items_per_page' => '50'] + Request::current()->query())?>"> 50 <?=__('per page')?></a></li>
                                    <li><a href="?<?=http_build_query(['items_per_page' => '100'] + Request::current()->query())?>">100 <?=__('per page')?></a></li>
                                </ul>
                            </div>
                            <div class="btn-group">
                                <button type="button" id="sort" data-sort="<?=HTML::chars(core::request('sort',core::config('advertisement.sort_by')))?>" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown">
                                    <span class="glyphicon glyphicon-list-alt"></span> <?=_e('Sort')?> <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu" role="menu" id="sort-list">
                                    <?if (Core::config('advertisement.reviews')==1):?>
                                        <li><a href="?<?=http_build_query(['sort' => 'rating'] + Request::current()->query())?>"><?=_e('Rating')?></a></li>
                                    <?endif?>
                                    <li><a href="?<?=http_build_query(['sort' => 'title-asc'] + Request::current()->query())?>"><?=_e('Name (A-Z)')?></a></li>
                                    <li><a href="?<?=http_build_query(['sort' => 'title-desc'] + Request::current()->query())?>"><?=_e('Name (Z-A)')?></a></li>
                                    <?if(core::config('advertisement.price')!=FALSE):?>
                                        <li><a href="?<?=http_build_query(['sort' => 'price-asc'] + Request::current()->query())?>"><?=_e('Price (Low)')?></a></li>
                                        <li><a href="?<?=http_build_query(['sort' => 'price-desc'] + Request::current()->query())?>"><?=_e('Price (High)')?></a></li>
                                    <?endif?>
                                    <?if(core::config('general.auto_locate')):?>
                                        <li><a href="?<?=http_build_query(['sort' => 'distance'] + Request::current()->query())?>" id="sort-distance"><?=_e('Distance')?></a></li>
                                    <?endif?>
                                    <li><a href="?<?=http_build_query(['sort' => 'featured'] + Request::current()->query())?>"><?=_e('Featured')?></a></li>
                                    <li><a href="?<?=http_build_query(['sort' => 'favorited'] + Request::current()->query())?>"><?=_e('Favorited')?></a></li>
                                    <li><a href="?<?=http_build_query(['sort' => 'published-desc'] + Request::current()->query())?>"><?=_e('Newest')?></a></li>
                                    <li><a href="?<?=http_build_query(['sort' => 'published-asc'] + Request::current()->query())?>"><?=_e('Oldest')?></a></li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <br>
    <?endif?>

    <div class="row">
        <div class="<?= (Theme::get('sidebar_position')!='none') ? 'col-md-9' : 'col-md-12' ?> <?= (Theme::get('sidebar_position')=='left') ? 'col-md-push-3' : '' ?>">
            <?if(core::count($ads)):
                //random ad
                $position = NULL;
                $i = 0;
                if (strlen(Theme::get('listing_ad'))>0)
                    $position = rand(0,core::count($ads));
            ?>
                <div>
                    <div>
                        <div class="row" data-masonry='{ "itemSelector": ".grid-item" }'>
                            <?foreach($ads as $ad):?>
                                <div class="col-xs-12 col-sm-4 col-md-4 grid-item">
                                    <div class="box-card box-item-card">
                                        <?if($ad->featured >= Date::unix2mysql(time())):?>
                                            <div class="ribbon"><span><?=_e('Featured')?></span></div>
                                        <?endif?>
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                            <div class="box-card-header">
                                                <img src="<?=$ad->user->get_profile_image()?>" class="profile img-thumbnail">
                                                <?if (isset($ad->user->cf_verified) AND $ad->user->cf_verified) :?>
                                                    <span class="text-verified"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                                                <?endif?>
                                                <?=$ad->user->name?>
                                            </div>
                                            <div class="box-card-images">
                                                <?if($ad->get_first_image()!== NULL):?>
                                                    <img width="1067" height="1067" src="<?=$ad->get_first_image()?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?else:?>
                                                    <img width="1067" height="1067" data-src="holder.js/179x179?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 12, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                                <?endif?>
                                            </div>
                                            <div class="box-card-footer">
                                                <div class="box-card-footer-title">
                                                    <div class="box-card-footer-title-wrapper">
                                                        <div class="headline">
                                                            <h4>
                                                                <?if (isset($ad->cf_verified) AND $ad->cf_verified) :?>
                                                                    <span class="text-verified"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                                                                <?endif?>
                                                                <?=$ad->title?>
                                                            </h4>
                                                        </div>
                                                        <div class="excerpt">
                                                            <p>
                                                                <?if ($ad->price!=0):?>
                                                                    <span class="price"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                                                                <?endif?>
                                                                <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                                                                    <span class="label label-danger"><?=_e('Free');?></span>
                                                                <?endif?>
                                                                <?=Text::truncate_html(Text::removebbcode($ad->description, TRUE), 255, NULL)?>
                                                            </p>
                                                            <?if(core::config('advertisement.location') AND $ad->id_location != 1):?>
                                                                <p><?=_e('Location')?>: <?=$ad->location->translate_name() ?></p>
                                                            <?endif?>
                                                            <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                                                <?if($value=='checkbox_1'):?>
                                                                    <p><?=$name?>: <i class="fa fa-check"></i></p>
                                                                <?elseif($value=='checkbox_0'):?>
                                                                    <p><?=$name?>: <i class="fa fa-times"></i></p>
                                                                <?else:?>
                                                                    <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                                                        <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?endif?>
                                                                    <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                                                        <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?endif?>
                                                                    <?else:?>
                                                                        <?if(is_string($name)):?>
                                                                            <p><?=$name?>: <?=$value?></p>
                                                                        <?else:?>
                                                                            <p><?=$value?></p>
                                                                        <?endif?>
                                                                    <?endif?>
                                                                <?endif?>
                                                            <?endforeach?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </a>
                                    </div>
                                </div>
                                <?if($i===$position):?>
                                    <div class="col-xs-12 grid-item">
                                        <div>
                                            <?=Theme::get('listing_ad')?>
                                        </div>
                                    </div>
                                <?endif?>
                                <?$i++?>
                            <?endforeach?>
                        </div>
                        <div class="home-section-footer">
                            <?=$pagination?>
                        </div>
                    </div>
                </div>
            <?elseif (core::count($ads) == 0):?>
                <?if(core::config('general.auto_locate') AND core::request('userpos') == 1):?>
                    <div class="btn-group pull-right">
                        <button
                            class="btn btn-sm btn-default <?=core::request('userpos') == 1 ? 'active' : NULL?>"
                            id="myLocationBtn"
                            type="button"
                            data-toggle="modal"
                            data-target="#myLocation"
                            data-href="?<?=http_build_query(['userpos' => 1] + Request::current()->query())?>">
                            <i class="glyphicon glyphicon-map-marker"></i> <?=sprintf(__('%s from you'), i18n::format_measurement(Core::config('advertisement.auto_locate_distance', 1)))?>
                        </button>
                    </div>
                    <div class="clearfix"></div>
                <?endif?>
                <!-- Case when we dont have ads for specific category / location -->
                <div class="page-header">
                    <h3><?=_e('We do not have any advertisements in this category')?></h3>
                </div>
            <?endif?>
            <?if(core::config('general.auto_locate')):?>
                <div class="modal fade" id="myLocation" tabindex="-1" role="dialog" aria-labelledby="myLocationLabel">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                            <div class="modal-body">
                                <div class="input-group">
                                    <input type="hidden" name="latitude" id="myLatitude" value="" disabled>
                                    <input type="hidden" name="longitude" id="myLongitude" value="" disabled>
                                    <?=FORM::input('myAddress', Request::current()->post('address'), array('class'=>'form-control', 'id'=>'myAddress', 'placeholder'=>__('Where do you want to search?')))?>
                                    <span class="input-group-btn">
                                        <button id="setMyLocation" class="btn btn-default" type="button"><?=_e('Ok')?></button>
                                    </span>
                                </div>
                                <br>
                                <div id="mapCanvas"></div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-default" data-dismiss="modal"><?=__('Close')?></button>
                                <?if (core::request('userpos') == 1) :?>
                                    <a class="btn btn-danger" href="?<?=http_build_query(['userpos' => NULL] + Request::current()->query())?>"><?=_e('Remove')?></a>
                                <?endif?>
                            </div>
                        </div>
                    </div>
                </div>
            <?endif?>
        </div>
        <?if(Theme::get('sidebar_position')!='none'):?>
            <div class="col-md-3 <?= (Theme::get('sidebar_position') == 'left') ? 'col-md-pull-9' : '' ?>">
                <?foreach ( Widgets::render('listing') as $widget):?>
                    <div class="panel panel-default <?=get_class($widget->widget)?>">
                        <?=$widget?>
                    </div>
                <?endforeach?>
            </div>
        <?endif?>
    </div>
</div>
