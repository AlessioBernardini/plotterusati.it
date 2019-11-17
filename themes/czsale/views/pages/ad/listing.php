<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header blog-description">
    <?if (Controller::$image!==NULL AND Theme::get('hide_description_icon')!=1):?>
        <p><img class="mw100p" src="<?=Controller::$image?>" class="img-responsive" alt="<?=($category!==NULL) ? HTML::chars($category->translate_name()) : (($location!==NULL AND $category===NULL) ? HTML::chars($location->translate_name()) : NULL)?>"></p>
    <?endif?>
    <?if ($category!==NULL):?>
        <h1><?=$category->translate_name() ?></h1>
        <p><?=$category->translate_description() ?></p>
    <?elseif ($location!==NULL):?>
        <h1><?=$location->translate_name() ?></h1>
        <p><?=$location->translate_description()?></p>
    <?else:?>
        <h1><?=_e('Listings')?></h1>
    <?endif?>
    <? if (Core::config('advertisement.only_admin_post') != 1
        AND (core::config('advertisement.parent_category') == 1
            OR (core::config('advertisement.parent_category') != 1
                AND $category !== NULL
                AND ! $category->is_parent()))):?>
        <a title="<?=__('New Advertisement')?>"
            href="<?=Route::url('post_new')?>?category=<?=($category!==NULL)?$category->seoname:''?>&location=<?=($location!==NULL)?$location->seoname:''?>" class="btn btn-primary"><i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<?=_e('Publish new advertisement')?>
        </a>
    <?endif?>
</div>
<?$slider_ads = ($featured != NULL)? $featured: $ads?>
<?if (core::count($slider_ads)>0 AND Theme::get('listing_slider')!=0 AND strtolower(Request::current()->action()) != 'advanced_search'):?>
    <section class="featured-posts">
        <div class="well well-sm" style="padding: 0; background-color: #FCF8E3;">
            <div class="row top-classifieds">
                <div id="slider-fixed-products" class="carousel slide">
                    <div class="carousel-inner">
                        <div class="active item">
                            <?$i=0; foreach ($slider_ads as $ad):?>
                            <?if ($i%6==0 AND $i!=0):?></div><div class="item"><?endif?>
                                <div class="col-md-2 top-classified">
                                    <div class="thumbnail latest_ads">
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                            <?if($ad->get_first_image()!== NULL):?>
                                                <?=HTML::picture($ad->get_first_image('image'), ['w' => 156, 'h' => 156], ['1200px' => ['w' => '117', 'h' => '117'],'992px' => ['w' => '92', 'h' => '92'], '768px' => ['w' => '156', 'h' => '156'], '480px' => ['w' => '156', 'h' => '156'], '320px' => ['w' => '156', 'h' => '156']], array('class' => 'center-block', 'alt' => HTML::chars($ad->title)))?>
                                            <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                                <?=HTML::picture($icon_src, ['w' => 156, 'h' => 156], ['1200px' => ['w' => '117', 'h' => '117'],'992px' => ['w' => '92', 'h' => '92'], '768px' => ['w' => '156', 'h' => '156'], '480px' => ['w' => '156', 'h' => '156'], '320px' => ['w' => '156', 'h' => '156']], array('class' => 'center-block', 'alt' => HTML::chars($ad->title)))?>
                                            <?else:?>
                                                <img data-src="holder.js/156x156?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                            <?endif?>
                                        </a>
                                        <div class="caption">
                                            <p><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a><p>
                                            <?if(core::config('advertisement.price') AND $ad->price!=0):?>
                                                <p><strong><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span></strong></p>
                                            <?elseif(core::config('advertisement.price') AND $ad->price==0 AND core::config('advertisement.free')==1):?>
                                                <p><strong><?=_e('Free');?></strong></p>
                                            <?else:?>
                                                <p>&nbsp;</p>
                                            <?endif?>
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
            </div>
        </div>
    </section>
<?endif?>

<div class="classifieds-table">
    <?if(core::count($ads)):?>
        <div class="btn-group pull-right" id="listgrid" data-default="<?=Theme::get('listgrid')?>">
            <?if(core::config('general.auto_locate')):?>
                <button
                    class="btn btn-sm btn-default <?=core::request('userpos') == 1 ? 'active' : NULL?>"
                    id="myLocationBtn"
                    type="button"
                    data-toggle="modal"
                    data-target="#myLocation"
                    data-marker-title="<?=__('My Location')?>"
                    data-marker-error="<?=__('Cannot determine address at this location.')?>"
                    data-href="?<?=http_build_query(['userpos' => 1] + Request::current()->query())?>">
                    <i class="glyphicon glyphicon-map-marker"></i> <?=sprintf(__('%s from you'), i18n::format_measurement(Core::cookie('mydistance', Core::config('advertisement.auto_locate_distance', 2))))?>
                </button>
            <?endif?>
            <?if (core::config('advertisement.map')==1):?>
                <a href="#" data-toggle="modal" data-target="#listingMap" class="btn btn-default btn-sm">
                    <span class="glyphicon glyphicon-globe"></span> <?=_e('Map')?>
                </a>
            <?endif?>
            <a href="#" id="list" class="btn btn-default btn-sm <?=(core::cookie('list/grid')==1)?'active':''?>">
                <span class="glyphicon glyphicon-th-list"></span> <?=_e('List')?>
            </a>
            <a href="#" id="grid" class="btn btn-default btn-sm <?=(core::cookie('list/grid')==0)?'active':''?>">
                <span class="glyphicon glyphicon-th"></span> <?=_e('Grid')?>
            </a>
            <div class="btn-group">
                <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <?=_e('Show').' '.HTML::chars(core::request('items_per_page')).' '._e('items per page')?> <span class="caret"></span>
                </button>
                <ul class="dropdown-menu" role="menu" id="show-list">
                    <li><a href="?<?=http_build_query(['items_per_page' => '5'] + Request::current()->query())?>">  5 <?=_e('per page')?></a></li>
                    <li><a href="?<?=http_build_query(['items_per_page' => '10'] + Request::current()->query())?>"> 10 <?=_e('per page')?></a></li>
                    <li><a href="?<?=http_build_query(['items_per_page' => '20'] + Request::current()->query())?>"> 20 <?=_e('per page')?></a></li>
                    <li><a href="?<?=http_build_query(['items_per_page' => '50'] + Request::current()->query())?>"> 50 <?=_e('per page')?></a></li>
                    <li><a href="?<?=http_build_query(['items_per_page' => '100'] + Request::current()->query())?>">100 <?=_e('per page')?></a></li>
                </ul>
            </div>
            <button type="button" id="sort" data-sort="<?=HTML::chars(core::request('sort',core::config('advertisement.sort_by')))?>" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
                <span class="glyphicon glyphicon-list-alt"></span><?=_e('Sort')?> <span class="caret"></span>
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
                <li><a href="?<?=http_build_query(['sort' => 'featured'] + Request::current()->query())?>"><?=_e('Featured')?></a></li>
                <li><a href="?<?=http_build_query(['sort' => 'favorited'] + Request::current()->query())?>"><?=_e('Favorited')?></a></li>
                <?if(core::config('general.auto_locate')):?>
                    <li><a href="?<?=http_build_query(['sort' => 'distance'] + Request::current()->query())?>" id="sort-distance"><?=_e('Distance')?></a></li>
                <?endif?>
                <li><a href="?<?=http_build_query(['sort' => 'published-desc'] + Request::current()->query())?>"><?=_e('Newest')?></a></li>
                <li><a href="?<?=http_build_query(['sort' => 'published-asc'] + Request::current()->query())?>"><?=_e('Oldest')?></a></li>
            </ul>
        </div>
        <div class="clearfix"></div><hr>

        <div class="<?=(core::cookie('list/grid')==1)?'table-responsive':''?>">
            <table class="table table-hover <?=(core::cookie('list/grid')==1)?'':'hide'?>">
                <thead>
                      <tr>
                        <th></th>
                        <th></th>
                        <?if(core::config('advertisement.price')):?>
                        <th class="text-center"><?=_e('Price')?></th>
                        <?endif?>
                        <?if(core::config('advertisement.location')):?>
                        <th class="text-center"><?=_e('Location')?></th>
                        <?endif?>
                        <th class="text-center"><?=_e('Published')?></th>
                        <?if (core::request('sort') == 'distance' AND Model_User::get_userlatlng()) :?>
                            <th class="text-center"><?=_e('Distance')?></th>
                        <?endif?>
                      </tr>
                </thead>

                <tbody>
                    <?foreach($ads as $ad ):?>
                        <?if($ad->featured >= Date::unix2mysql(time())):?>
                            <tr class="featured-item">
                        <?else:?>
                            <tr>
                        <?endif?>
                        <td class="col-sm-8 col-md-6">
                        	<?if($ad->featured >= Date::unix2mysql(time())):?>
                                <div class="triangle-top-left">
                                    <p class="featured-text"><?=_e('Featured')?></p>
                                </div>
                            <?endif?>
                            <div class="media">
                                <a class="thumbnail pull-left" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                    <figure>
                                        <?if($ad->get_first_image() !== NULL):?>
                                            <img src="<?=Core::imagefly($ad->get_first_image('image'),200,200)?>" alt="<?=HTML::chars($ad->title)?>" />
                                        <?elseif(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                            <img src="<?=Core::imagefly($icon_src,200,200)?>" class="img-responsive" alt="<?=HTML::chars($ad->title)?>" />
                                        <?elseif(( $icon_src = $ad->location->get_icon() )!==FALSE ):?>
                                            <img src="<?=Core::imagefly($icon_src,200,200)?>" class="img-responsive" alt="<?=HTML::chars($ad->title)?>" />
                                        <?else:?>
                                            <img data-src="holder.js/200x200?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="img-responsive" alt="<?=HTML::chars($ad->title)?>">
                                        <?endif?>
                                    </figure>
                                </a>
                                <?if (Core::config('advertisement.reviews')==1):?>
                                    <?for ($i=0; $i < round($ad->rate,1); $i++):?>
                                        <span class="glyphicon glyphicon-star"></span>
                                    <?endfor?>
                                <?endif?>
                                <div class="media-body">
                                    <h4 class="media-heading"><a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"> <?=$ad->title; ?></a></h4>
                                    <?if(core::config('advertisement.description')!=FALSE):?>
                                        <p><small><?=Text::limit_chars(Text::removebbcode($ad->description), 100, NULL, TRUE);?></small></p>
                                    <?endif?>
                                    <?if (core::count($custom_columns = $ad->custom_columns(TRUE)) > 0) :?>
                                        <ul class="list-inline">
                                            <?foreach ($custom_columns as $name => $value):?>
                                                <?if($value=='checkbox_1'):?>
                                                    <li class="col-xs-12"><small><b><?=$name?></b>: <i class="fa fa-check"></i></small></li>
                                                <?elseif($value=='checkbox_0'):?>
                                                    <li class="col-xs-12"><small><b><?=$name?></b>: <i class="fa fa-times"></i></small></li>
                                                <?elseif(is_string($name)):?>
                                                    <li class="col-xs-12"><small><b><?=$name?></b>: <?=$value?></small></li>
                                                <?else:?>
                                                    <li class="col-xs-12"><small><?=$value?></small></li>
                                                <?endif?>
                                            <?endforeach?>
                                        </ul>
                                    <?endif?>
                                    <?if ($user !== NULL AND ($user->is_admin() OR $user->is_moderator())):?>
                                        <div class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
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
                                        <div class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
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
                        </td>
                        <td class="col-sm-1 col-md-1 text-center" style="vertical-align: middle;">
                            <span class="favorite" id="fav-<?=$ad->id_ad?>">
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
                            </span>
                        </td>
                        <?if(core::config('advertisement.price')):?>
                            <td class="col-sm-1 col-md-1 text-center" style="vertical-align: middle;">
                                <strong>
                                    <?if ($ad->price!=0){?>
                                        <b><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span></b>
                                    <?}?>
                                    <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                                        <b><?=_e('Free');?></b>
                                    <?}?>
                                </strong>
                            </td>
                        <?endif?>
                        <?if(core::config('advertisement.location')):?>
                            <td class="col-sm-1 col-md-1 text-center" style="vertical-align: middle;">
                                <?if($ad->id_location != 1):?>
                                    <a href="<?=Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=HTML::chars($ad->location->translate_name())?>">
                                        <?=$ad->location->translate_name() ?>
                                    </a>
                                <?endif?>
                            </td>
                        <?endif?>
                        <td class="col-sm-1 col-md-1 text-center" style="vertical-align: middle;">
                            <?if ($ad->published!=0):?>
                                <?= Date::format($ad->published, core::config('general.date_format'))?>
                            <?endif?>
                        </td>
                        <?if (core::request('sort') == 'distance' AND Model_User::get_userlatlng()) :?>
                            <td class="col-sm-1 col-md-1 text-center" style="vertical-align: middle;">
                                <?=i18n::format_measurement($ad->distance)?>
                            </td>
                        <?endif?>
                        </tr>
                    <?endforeach?>
                </tbody>
            </table>

            <!-- Grid View -->
            <div class="grid-view <?=(core::cookie('list/grid')==0)?'':'hide'?>">
                <?$j=0;?>
                <?foreach($ads as $ad ):?>
                    <?if($j%4==0 OR $j==0):?>
                        <div class="row grid-row">
                    <?endif?>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-12 grid-item">
                            <div class="thumbnail <?=($ad->featured >= Date::unix2mysql(time()))?'featured-item':''?>">
                                <?if($ad->featured >= Date::unix2mysql(time())):?>
                                    <div class="triangle-top-left">
                                        <p class="featured-text"><?=_e('Featured')?></p>
                                    </div>
                                <?endif?>
                                <a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                    <figure>
                                        <?if($ad->get_first_image() !== NULL):?>
                                            <?=HTML::picture($ad->get_first_image('image'), ['w' => 200, 'h' => 200], ['1200px' => ['w' => '200', 'h' => '200'],'992px' => ['w' => '200', 'h' => '200'], '768px' => ['w' => '200', 'h' => '200'], '480px' => ['w' => '200', 'h' => '200'], '320px' => ['w' => '200', 'h' => '200']], array('class' => 'img-responsive center-block', 'alt' => HTML::chars($ad->title)))?>
                                        <?elseif(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                            <?=HTML::picture($icon_src, ['w' => 200, 'h' => 200], ['1200px' => ['w' => '200', 'h' => '200'],'992px' => ['w' => '200', 'h' => '200'], '768px' => ['w' => '200', 'h' => '200'], '480px' => ['w' => '200', 'h' => '200'], '320px' => ['w' => '200', 'h' => '200']], array('class' => 'img-responsive center-block', 'alt' => HTML::chars($ad->title)))?>
                                        <?elseif(( $icon_src = $ad->location->get_icon() )!==FALSE ):?>
                                            <?=HTML::picture($icon_src, ['w' => 179, 'h' => 150], ['1200px' => ['w' => '179', 'h' => '150'],'992px' => ['w' => '141', 'h' => '150'], '768px' => ['w' => '147', 'h' => '150'], '480px' => ['w' => '147', 'h' => '150'], '320px' => ['w' => '156', 'h' => '150']], array('class' => 'img-responsive center-block', 'alt' => HTML::chars($ad->title)))?>
                                        <?else:?>
                                            <img data-src="holder.js/200x200?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="img-responsive center-block" alt="<?=HTML::chars($ad->title)?>">
                                        <?endif?>
                                    </figure>
                                </a>
                                <h3 class="media-heading text-center grid-item-heading"><a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"> <?=$ad->title; ?></a></h3>
                                <?if (Core::config('advertisement.reviews')==1):?>
                                    <?for ($i=0; $i < round($ad->rate,1); $i++):?>
                                        <span class="glyphicon glyphicon-star"></span>
                                    <?endfor?>
                                <?endif?>
                                <?if(core::config('advertisement.location')):?>
                                    <div class="col-sm-12 col-md-12" style="vertical-align: middle;">
                                        <?if($ad->id_location != 1):?>
                                            <a href="<?=Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=HTML::chars($ad->location->translate_name())?>">
                                                <div class="pull-right label label-default"><?=$ad->location->translate_name() ?></div>
                                            </a>
                                        <?endif?>
                                    </div>
                                <?endif?>
                                <div class="col-sm-12 col-md-12">
                                    <?if(core::config('advertisement.description')!=FALSE):?>
                                        <p><small><?=Text::limit_chars(Text::removebbcode($ad->description), 100, NULL, TRUE);?></small></p>
                                    <?endif?>
                                    <?if (core::count($custom_columns = $ad->custom_columns(TRUE)) > 0) :?>
                                        <ul class="list-inline">
                                            <?foreach ($custom_columns as $name => $value):?>
                                                <?if($value=='checkbox_1'):?>
                                                    <li class="col-xs-12"><small><b><?=$name?></b>: <i class="fa fa-check"></i></small></li>
                                                <?elseif($value=='checkbox_0'):?>
                                                    <li class="col-xs-12"><small><b><?=$name?></b>: <i class="fa fa-times"></i></small></li>
                                                <?else:?>
                                                    <li class="col-xs-12"><small><b><?=$name?></b>: <?=$value?></small></li>
                                                <?endif?>
                                            <?endforeach?>
                                        </ul>
                                    <?endif?>

                                </div>

                                <?if(core::config('advertisement.price')):?>
                                    <div class="col-sm-12 col-md-12" style="vertical-align: middle;">
                                        <strong>
                                            <?if ($ad->price!=0){?>
                                                <b><?=_e('Price')?>: <span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span></b>
                                            <?}?>
                                            <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                                                <b><?=_e('Free');?></b>
                                            <?}?>
                                        </strong>
                                    </div>
                                <?endif?>
                                <div class="col-sm-12 col-md-12" style="vertical-align: middle;">
                                    <?if ($ad->published!=0):?>
                                        <b><?=_e('Publish Date')?>:</b> <?= Date::format($ad->published, core::config('general.date_format'))?>
                                    <?endif?>
                                </div>
                                <?if (core::request('sort') == 'distance' AND Model_User::get_userlatlng()) :?>
                                    <div class="col-sm-12 col-md-12" style="vertical-align: middle;">
                                        <?=i18n::format_measurement($ad->distance)?>
                                    </div>
                                <?endif?>
                                <div>
                                    <?if ($user !== NULL AND ($user->is_admin() OR $user->is_moderator())):?>
                                        <div class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
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
                                        <div class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
                                            <div id="user-toolbar-options<?=$ad->id_ad?>" class="hide user-toolbar-options">
                                                <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><i class="glyphicon glyphicon-edit"></i><?=_e("Edit");?></a> |
                                                <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'deactivate','id'=>$ad->id_ad))?>"
                                                    onclick="return confirm('<?=__('Deactivate?')?>');"><i class="glyphicon glyphicon-off"></i><?=_e("Deactivate");?>
                                                </a>
                                            </div>
                                        </div>
                                    <?endif?>
                                    <div class="pull-right" style="vertical-align: middle;">
                                        <span class="favorite" id="fav-<?=$ad->id_ad?>">
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
                                        </span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?$j++;?>
                    <?if($j%4==0):?>
                        </div>
                    <?endif?>
                <?endforeach?>
                <?if($j%4!=0):?>
                    </div>
                <?endif?>
            </div>
        </div>
        <div class="text-center">
            <?=$pagination?>
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
                            <div class="input-group-btn">
                                <button type="button" class="btn btn-distance btn-default dropdown-toggle" data-toggle="dropdown">
                                    <span class="label-icon"><?=i18n::format_measurement(Core::cookie('mydistance', Core::config('advertisement.auto_locate_distance', 2)))?></span>
                                    <span class="caret"></span>
                                </button>
                                <ul class="dropdown-menu pull-left" role="menu">
                                    <li>
                                        <a href="#" data-value="2"><?=i18n::format_measurement(2)?></a>
                                    </li>
                                    <li>
                                        <a href="#" data-value="5"><?=i18n::format_measurement(5)?></a>
                                    </li>
                                    <li>
                                        <a href="#" data-value="10"><?=i18n::format_measurement(10)?></a>
                                    </li>
                                    <li>
                                        <a href="#" data-value="20"><?=i18n::format_measurement(20)?></a>
                                    </li>
                                    <li>
                                        <a href="#" data-value="50"><?=i18n::format_measurement(50)?></a>
                                    </li>
                                    <li>
                                        <a href="#" data-value="250"><?=i18n::format_measurement(250)?></a>
                                    </li>
                                    <li>
                                        <a href="#" data-value="500"><?=i18n::format_measurement(500)?></a>
                                    </li>
                                </ul>
                            </div>
                            <input type="hidden" name="distance" id="myDistance" value="<?=Core::cookie('mydistance', Core::config('advertisement.auto_locate_distance', 2))?>" disabled>
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
                        <button type="button" class="btn btn-default" data-dismiss="modal"><?=_e('Close')?></button>
                        <?if (core::request('userpos') == 1) :?>
                            <a class="btn btn-danger" href="?<?=http_build_query(['userpos' => NULL] + Request::current()->query())?>"><?=__('Remove')?></a>
                        <?endif?>
                    </div>
                </div>
            </div>
        </div>
    <?endif?>
    <?if (core::config('advertisement.map')==1):?>
        <?=View::factory('pages/ad/listing_map', compact('ads'))?>
    <?endif?>
</div>
