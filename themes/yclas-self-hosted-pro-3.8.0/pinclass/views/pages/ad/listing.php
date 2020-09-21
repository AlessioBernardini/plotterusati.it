<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="listing-overview">
    <?if ($category!==NULL):?>
        <h1><?=$category->translate_name() ?></h1>
    <?elseif ($location!==NULL):?>
        <h1><?=$location->translate_name() ?></h1>
    <?else:?>
        <h1><?=_e('Listings')?></h1>
    <?endif?>
    <? if (Core::config('advertisement.only_admin_post') != 1
        AND (core::config('advertisement.parent_category') == 1
            OR (core::config('advertisement.parent_category') != 1
                AND $category !== NULL
                AND ! $category->is_parent()))):?>
       <a title="<?=__('New Advertisement')?>" class="btn btn-primary btn-publish pull-right" href="<?=Route::url('post_new')?>?category=<?=($category!==NULL)?$category->seoname:''?>&amp;location=<?=($location!==NULL)?$location->seoname:''?>"><i class="fa fa-pencil"></i> <?=_e('Publish new advertisement')?></a>
    <?endif?>

    <?$slider_ads = ($featured != NULL)? $featured: $ads?>

    <?if (core::count($slider_ads)>0 AND Theme::get('listing_slider')!=0 AND strtolower(Request::current()->action()) != 'advanced_search'):?>
    <section class="featured-posts hidden-xs hidden-sm hidden-md listing-slider">
          <div id="slider-fixed-products" class="carousel slide">
            <div class="carousel-inner">
                <div class="active item">
                    <ul class="thumbnails">
                    <?$i=0;
                    foreach ($slider_ads as $ad):?>
                    <?if ($i%4==0 AND $i!=0):?></ul></div><div class="item"><ul class="thumbnails"><?endif?>
                    <li class="col-lg-3 col-md-6 col-sm-12 col-xs-12">
                        <div class="latest_ads">
                            <?if($ad->get_first_image()!== NULL):?>
                                <div class="image_holder img-responsive" style="background-image: url('<?=$ad->get_first_image()?>')"></div>
                            <?else:?>
								<?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                    <figure class="image_holder">
                                        <?=HTML::picture($icon_src, ['w' => 200, 'h' => 200], ['1200px' => ['w' => '200', 'h' => '200'],'992px' => ['w' => '305', 'h' => '305'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '240', 'h' => '240'], '320px' => ['w' => '215', 'h' => '215']], array('class' => 'img-responsive', 'alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                    </figure>
                                <?else:?>
                                    <figure class="image_holder holderjs <?=(Theme::get('boxed_layout')?'boxed':'wide')?>" data-background-src="?holder.js/275x275?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=10&amp;auto=yes" alt="<?=HTML::chars($ad->title)?>">
                                    </figure>
                                <?endif?>
                            <?endif?>
                            <div class="caption">
                                <h5><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></h5>
                                <p><?=Text::limit_chars(Text::removebbcode($ad->description), 120, NULL, TRUE)?></p>
                            </div>
                            <div class="extra_info">
                                <?if ($ad->price!=0){?>
                                <div class="col-xs-12 col-sm-4 text-center price price-curry">
                                    <?=i18n::money_format( $ad->price, $ad->currency())?>
                                </div>
                                <?}?>
                                <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                                <div class="col-xs-12 col-sm-4 text-center price">
                                    <?=_e('Free');?>
                                </div>
                                <?}?>
                                <div class="col-xs-12 col-sm-4 text-center location pull-left">
                                    <?if(Theme::get('listing_extra_info')=='views'):?>
                                        <i class="fa fa-eye"></i><?=$ad->count_ad_hit()?>
                                    <?elseif(Theme::get('listing_extra_info')=='location'):?>
                                        <i class="fa fa-map-marker"></i><?=$ad->location->translate_name() ?>
                                    <?elseif(Theme::get('listing_extra_info')=='user'):?>
                                        <a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><i class="fa fa-user"></i><?=$ad->user->name?></a>
                                    <?endif?>
                                </div>
                                <a class="col-xs-12 col-sm-4 text-center more-link hvr-icon-forward" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=_e('more')?></a>
                            </div>
                        </div>
                    </li>
                    <?$i++;
                    endforeach?>
                </ul>
              </div>
            </div>
            <a class="left carousel-control" href="#slider-fixed-products" data-slide="prev">
                <span class="glyphicon glyphicon-chevron-left"></span>
            </a>
            <a class="right carousel-control" href="#slider-fixed-products" data-slide="next">
                <span class="glyphicon glyphicon-chevron-right"></span>
            </a>
          </div>
    </section>
    <?endif?>

    <section class="post-section clearfix" id="post-details">
        <?if(core::count($ads)):
            //random ad
            $position = NULL;
            $i = 0;
            if (strlen(Theme::get('listing_ad'))>0)
                $position = rand(0,core::count($ads));
        ?>
            <div class="filter row blog-description">
                <?if (Controller::$image!==NULL AND Theme::get('hide_description_icon')!=1):?>
                    <img src="<?=Controller::$image?>" class="img-responsive" alt="<?=($category!==NULL) ? HTML::chars($category->translate_name()) : (($location!==NULL AND $category===NULL) ? HTML::chars($location->translate_name()) : NULL)?>">
                <?endif?>
                <p class="pull-left col-xs-12">
                    <?if ($category!==NULL):?>
                        <?=$category->translate_description() ?>
                    <?elseif ($location!==NULL):?>
                        <?=$location->translate_description()?>
                    <?endif?>
                </p>
                <div class="btn-group col-xs-12 pull-right" id="listgrid" data-default="<?=Theme::get('listgrid')?>">
                    <button type="button" id="sort" data-sort="<?=HTML::chars(core::request('sort',core::config('advertisement.sort_by')))?>" class="btn btn-info pull-right dropdown-toggle" data-toggle="dropdown">
                        <?=_e('Sort')?> <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu" id="sort-list">
                        <?if((New Model_Field())->get('eventdate')):?>
                            <li><a href="?<?=http_build_query(['sort' => 'event-date'] + Request::current()->query())?>"><?=_e('Event date')?></a></li>
                        <?endif?>
                        <?if (Core::config('advertisement.reviews')==1):?>
                            <li><a href="?<?=http_build_query(['sort' => 'rating'] + Request::current()->query())?>">&nbsp;<?=_e('Rating')?></a></li>
                        <?endif?>
                        <li><a href="?<?=http_build_query(['sort' => 'title-asc'] + Request::current()->query())?>">&nbsp;<?=_e('Name (A-Z)')?></a></li>
                        <li><a href="?<?=http_build_query(['sort' => 'title-desc'] + Request::current()->query())?>">&nbsp;<?=_e('Name (Z-A)')?></a></li>
                        <?if(core::config('advertisement.price')!=FALSE):?>
                            <li><a href="?<?=http_build_query(['sort' => 'price-asc'] + Request::current()->query())?>">&nbsp;<?=_e('Price (Low)')?></a></li>
                            <li><a href="?<?=http_build_query(['sort' => 'price-desc'] + Request::current()->query())?>">&nbsp;<?=_e('Price (High)')?></a></li>
                        <?endif?>
                        <li><a href="?<?=http_build_query(['sort' => 'featured'] + Request::current()->query())?>">&nbsp;<?=_e('Featured')?></a></li>
                        <li><a href="?<?=http_build_query(['sort' => 'favorited'] + Request::current()->query())?>">&nbsp;<?=_e('Favorited')?></a></li>
                        <?if(core::config('general.auto_locate')):?>
                            <li><a href="?<?=http_build_query(['sort' => 'distance'] + Request::current()->query())?>" id="sort-distance">&nbsp;<?=_e('Distance')?></a></li>
                        <?endif?>
                        <li><a href="?<?=http_build_query(['sort' => 'published-desc'] + Request::current()->query())?>">&nbsp;<?=_e('Newest')?></a></li>
                        <li><a href="?<?=http_build_query(['sort' => 'published-asc'] + Request::current()->query())?>">&nbsp;<?=_e('Oldest')?></a></li>
                    </ul>
                    <div class="btn-group pull-right">
                        <button class="btn btn btn-info pull-right dropdown-toggle" id="sort" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <?=_e('Show').' '.HTML::chars(core::request('items_per_page')).' '._e('items per page')?> <span class="caret"></span>&nbsp;
                        </button>
                        <ul class="dropdown-menu dropdown-menu-right" role="menu" id="show-list">
                            <li><a href="?<?=http_build_query(['items_per_page' => '5'] + Request::current()->query())?>">  5 <?=_e('per page')?></a></li>
                            <li><a href="?<?=http_build_query(['items_per_page' => '10'] + Request::current()->query())?>"> 10 <?=_e('per page')?></a></li>
                            <li><a href="?<?=http_build_query(['items_per_page' => '20'] + Request::current()->query())?>"> 20 <?=_e('per page')?></a></li>
                            <li><a href="?<?=http_build_query(['items_per_page' => '50'] + Request::current()->query())?>"> 50 <?=_e('per page')?></a></li>
                            <li><a href="?<?=http_build_query(['items_per_page' => '100'] + Request::current()->query())?>">100 <?=_e('per page')?></a></li>
                        </ul>
                    </div>
                    <a href="#" id="grid" class="btn btn-default pull-right <?=(core::cookie('list/grid')==0)?'active':''?>">
                        <span class="glyphicon glyphicon-th"></span>
                    </a>
                    <a href="#" id="list" class="btn btn-default pull-right <?=(core::cookie('list/grid')==1)?'active':''?>">
                        <span class="glyphicon glyphicon-th-list"></span>
                    </a>
                    <? if((New Model_Field())->get('eventdate')): ?>
                        <a href="<?= Route::url('calendar') ?>" class="btn btn-default btn-sm">
                            <span class="glyphicon glyphicon-calendar"></span> <?=_e('Calendar')?>
                        </a>
                    <? endif ?>
                    <?if (core::config('advertisement.map')==1):?>
                        <a href="<?=Route::url('map')?>?category=<?=Model_Category::current()->loaded()?Model_Category::current()->seoname:NULL?>&location=<?=Model_Location::current()->loaded()?Model_Location::current()->seoname:NULL?>" class="btn btn-default pull-right">
                            <span class="glyphicon glyphicon-globe"></span>
                        </a>
                    <?endif?>
                    <?if(core::config('general.auto_locate')):?>
                        <button
                            class="btn btn-default width-auto pull-right <?=core::request('userpos') == 1 ? 'active' : NULL?>"
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
                </div>
            </div>
            <div class="clearfix"></div><br>

            <div id="products" class="list-group listing_ads grid-container">
                <li class="grid-sizer"></li>
                <?$i=1;
                foreach($ads as $ad ):?>
                    <div class="item <?=(core::cookie('list/grid')==1)?'list-group-item':'grid-group-item'?>">
                        <a class="more-link" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"></a>
                        <div class="thumbnail <?=($ad->featured >= Date::unix2mysql(time()))?'featured-item':''?> <?if(Theme::get('dark_listing')!='0'):?>dark_listing<?endif?>">
                            <?if($ad->featured >= Date::unix2mysql(time())):?>
                                <div class="triangle-top-left">
                                    <p class="featured-text"><?=_e('Featured')?></p>
                                </div>
                            <?endif?>
                            <div class="pull-right favorite" id="fav-<?=$ad->id_ad?>">
                                <?if (Auth::instance()->logged_in()):?>
                                    <?$fav = Model_Favorite::is_favorite($user,$ad);?>
                                    <a data-id="fav-<?=$ad->id_ad?>" class="add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                    	<i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i>
            						</a>
                                <?else:?>
                                    <a data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                        <i class="glyphicon glyphicon-heart-empty"></i>
                                    </a>
                                <?endif?>
                            </div>
                            <?if(Theme::get('listing_display')!='title-in-ad'):?>
                                <div class="picture pull-left">
                                    <?if(Theme::get('listing_display')=='title-above-ad'):?>
                                        <h3>
                                            <a class="small-txt" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                                                <?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?>
                                            </a>
                                        </h3>
                                    <?endif?>
                                    <?if($ad->get_first_image()!== NULL):?>
                                        <figure class="image_holder holderjs">
                                            <?=HTML::picture($ad->get_first_image('image'), ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '305', 'h' => '305'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '240', 'h' => '240'], '320px' => ['w' => '215', 'h' => '215']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                        </figure>
                                    <?else:?>
                                        <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                            <figure class="image_holder">
                                                <?=HTML::picture($icon_src, ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '305', 'h' => '305'], '768px' => ['w' => '230', 'h' => '230'], '480px' => ['w' => '240', 'h' => '240'], '320px' => ['w' => '215', 'h' => '215']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                            </figure>
                                        <?else:?>
                                            <figure class="image_holder holderjs" data-background-src="?holder.js/275x275?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=14&amp;auto=yes" alt="<?=HTML::chars($ad->title)?>">
                                            </figure>
                                        <?endif?>
                                    <?endif?>
                                </div>

                                <div class="brake-grid"></div>
                                <div class="caption pull-left">
                                    <h3 id="title" <?=(Theme::get('listing_display')=='title-below-ad')?'hidden':''?>>
                                        <a class="big-txt <?=(core::cookie('list/grid')==0)?'hide':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                                        <?=Text::limit_chars(Text::removebbcode($ad->title), 45, NULL, TRUE)?>
                                        </a>
                                    </h3>
                                    <?if(Theme::get('listing_display')=='title-below-ad'):?>
                                        <h3>
                                            <a class="big-txt <?=(core::cookie('list/grid')==0)?'hide':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                                            <?=Text::limit_chars(Text::removebbcode($ad->title), 45, NULL, TRUE)?>
                                            </a>
                                            <a class="small-txt <?=(core::cookie('list/grid')==1)?'hide':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                                            <?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?>
                                            </a>
                                        </h3>
                                    <?endif?>
                                    <?if (Core::config('advertisement.reviews')==1 AND $ad->rate>0):?>
                                        <div class="description <?=(Theme::get('dark_listing')!=0)?'dark_listing_reviews':''?>">
                                            <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                                <span class="glyphicon glyphicon-star"></span>
                                            <?endfor?>
                                        </div>
                                    <?endif?>
                                    <div class="details <?=(core::cookie('list/grid')==0)?'hide':''?>">
                                        <?= _e('Posted by');?> <?=$ad->user->name?> <?if ($ad->id_location != 1):?><?= _e('from');?> <?=$ad->location->translate_name() ?><?endif?> <?if ($ad->published!=0){?><?= _e('on');?> <?= Date::format($ad->published, core::config('general.date_format'))?><? }?>
                                    </div>
                                    <?if(core::config('advertisement.description')!=FALSE AND $ad->description):?>
                                        <p class="description"><?=Text::limit_chars(Text::removebbcode($ad->description), 150, NULL, TRUE)?></p>
                                    <?else:?>
                                        <p class="description">&nbsp;</p>
                                    <?endif?>
                                    <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                        <?if($value=='checkbox_1'):?>
                                            <p class="description"><b><?=$name?></b>: <i class="fa fa-check"></i></p>
                                        <?elseif($value=='checkbox_0'):?>
                                            <p class="description"><b><?=$name?></b>: <i class="fa fa-times"></i></p>
                                        <?else:?>
                                            <?if(is_string($name)):?>
                                                <p class="description"><b><?=$name?></b>: <?=$value?></p>
                                            <?else:?>
                                                <p class="description"><?=$value?></p>
                                            <?endif?>
                                        <?endif?>
                                    <?endforeach?>
                                    <div class="extra_info">
                                        <?if ($ad->price!=0){?>
                                        <div class="price pull-left price-curry">
                                            <?=i18n::money_format( $ad->price, $ad->currency())?>
                                        </div>
                                        <?}?>
                                          <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                                        <div class="price pull-left">
                                            <?=_e('Free');?>
                                        </div>
                                        <?}?>
                                        <div class="location pull-left">
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
                            <?else:?><!-- title-in-ad -->
                                <?if($ad->get_first_image()!== NULL):?>
                                    <div class="picture pull-left">
                                        <figure class="image_holder">
                                            <?=HTML::picture($ad->get_first_image('image'), ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '215', 'h' => '215'], '768px' => ['w' => '220', 'h' => '220'], '480px' => ['w' => '220', 'h' => '220'], '320px' => ['w' => '200', 'h' => '200']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                            <figcaption>
                                                <h2><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                            </figcaption>
                                        </figure>
                                    </div>
                                <?else:?>
                                    <div class="picture pull-left">
                                        <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                            <figure class="image_holder holderjs">
                                                <?=HTML::picture($icon_src, ['w' => 275, 'h' => 275], ['1200px' => ['w' => '275', 'h' => '275'],'992px' => ['w' => '215', 'h' => '215'], '768px' => ['w' => '220', 'h' => '220'], '480px' => ['w' => '220', 'h' => '220'], '320px' => ['w' => '200', 'h' => '200']], array('alt' => Text::limit_chars(Text::removebbcode($ad->title))))?>
                                                <figcaption>
                                                    <h2><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                                </figcaption>
                                            </figure>
                                        <?else:?>
                                            <figure class="image_holder holderjs" data-background-src="?holder.js/275x275?text=<?=HTML::entities($ad->category->translate_name())?>&amp;size=14&amp;auto=yes" alt="<?=HTML::chars($ad->title)?>">
                                                <figcaption>
                                                    <h2><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></h2>
                                                </figcaption>
                                            </figure>
                                        <?endif?>
                                    </div>
                                <?endif?>

                                <div class="brake-grid"></div>
                                <div class="caption pull-left">
                                    <?if (Core::config('advertisement.reviews')==1 AND $ad->rate>0):?>
                                        <div class="description">
                                            <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                                <span class="glyphicon glyphicon-star"></span>
                                            <?endfor?>
                                        </div>
                                    <?endif?>
                                    <?if(core::config('advertisement.description')!=FALSE AND $ad->description):?>
                                        <p class="description"><?=Text::limit_chars(Text::removebbcode($ad->description), 150, NULL, TRUE)?></p>
                                    <?else:?>
                                        <p class="description">&nbsp;</p>
                                    <?endif?>
                                    <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                        <?if($value=='checkbox_1'):?>
                                            <p class="description"><b><?=$name?></b>: <i class="fa fa-check"></i></p>
                                        <?elseif($value=='checkbox_0'):?>
                                            <p class="description"><b><?=$name?></b>: <i class="fa fa-times"></i></p>
                                        <?else:?>
                                            <p class="description"><b><?=$name?></b>: <?=$value?></p>
                                        <?endif?>
                                    <?endforeach?>
                                    <div class="extra_info">
                                        <?if ($ad->price!=0){?>
                                        <div class="price pull-left price-curry">
                                            <?=i18n::money_format( $ad->price, $ad->currency())?>
                                        </div>
                                        <?}?>
                                          <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                                        <div class="price pull-left">
                                            <?=_e('Free');?>
                                        </div>
                                        <?}?>
                                        <div class="location pull-left">
                                            <?if(Theme::get('listing_extra_info')=='views'):?>
                                                <i class="fa fa-eye"></i><?=$ad->count_ad_hit()?>
                                            <?elseif(Theme::get('listing_extra_info')=='location'):?>
                                                <?if (core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()):?>
                                                    <?if(Theme::get('boxed_layout')==1):?>
                                                        <i class="fa fa-map-marker hidden-xs hidden-sm"></i>
                                                    <?endif?>
                                                    <?=$ad->location->translate_name() ?>
                                                <?endif?>
                                            <?elseif(Theme::get('listing_extra_info')=='user'):?>
                                                <a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><i class="fa fa-user"></i><?=$ad->user->name?></a>
                                            <?endif?>
                                        </div>
                                    </div>
                                </div>
                            <?endif?>


                            <?if ($user !== NULL AND ($user->is_admin() OR $user->is_moderator())):?>
                                <br />
                                <div class="toolbar btn-primary"><i class="glyphicon glyphicon-cog"></i>
                                    <div id="user-toolbar-options<?=$ad->id_ad?>" class="hide user-toolbar-options">
                                        <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><i class="glyphicon glyphicon-edit"></i> <?=_e("Edit");?></a> |
                                        <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'deactivate','id'=>$ad->id_ad))?>"
                                            onclick="return confirm('<?=__('Deactivate?')?>');"><i class="glyphicon glyphicon-off"></i><?=_e("Deactivate");?>
                                        </a> |
                                        <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'spam','id'=>$ad->id_ad))?>"
                                            onclick="return confirm('<?=__('Spam?')?>');"><i class="glyphicon glyphicon-fire"></i><?=_e("Spam");?>
                                        </a> |
                                        <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'delete','id'=>$ad->id_ad))?>"
                                            onclick="return confirm('<?=__('Delete?')?>');"><i class="glyphicon glyphicon-remove"></i><?=_e("Delete");?>
                                        </a>

                                    </div>
                                </div>
                            <?elseif($user !== NULL && $user->id_user == $ad->id_user):?>

                            <br/>
                            <div class="toolbar btn-primary"><i class="glyphicon glyphicon-cog"></i>
                                <div id="user-toolbar-options<?=$ad->id_ad?>" class="hide user-toolbar-options">
                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><i class="glyphicon glyphicon-edit"></i><?=_e("Edit");?></a> |
                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'deactivate','id'=>$ad->id_ad))?>"
                                        onclick="return confirm('<?=__('Deactivate?')?>');"><i class="glyphicon glyphicon-off"></i><?=_e("Deactivate");?>
                                    </a>
                                </div>
                            </div>
                            <?endif?>
                        </div>
                    </div>
                    <?if($i===$position):?>
                        <div class="item <?=(core::cookie('list/grid')==1)?'list-group-item':'grid-group-item'?> col-lg-4 col-md-4 col-sm-4 col-xs-10">
                            <div class="thumbnail">
                                <?=Theme::get('listing_ad')?>
                            </div>
                        </div>
                    <?endif?>
                <?$i++?>
                <?endforeach?>

            </div>
            <?=$pagination?>
            <?elseif (core::count($ads) == 0):?>
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
                                    <button id="setMyLocation" class="btn btn-default" type="button" style="padding: 6px 12px;"><?=_e('Ok')?></button>
                                </span>
                            </div>
                            <br>
                            <div id="mapCanvas"></div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal"><?=_e('Close')?></button>
                            <?if (core::request('userpos') == 1) :?>
                                <a class="btn btn-danger" href="?<?=http_build_query(['userpos' => NULL] + Request::current()->query())?>"><?=_e('Remove')?></a>
                            <?endif?>
                        </div>
                    </div>
                </div>
            </div>
        <?endif?>
        <?if (core::config('advertisement.map')==1):?>
            <?=View::factory('pages/ad/listing_map', compact('ads'))?>
        <?endif?>
    </section>
</div>
