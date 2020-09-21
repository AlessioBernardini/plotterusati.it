<?php defined('SYSPATH') or die('No direct script access.');?>
<div>
    <?if ($category!==NULL):?>
       <h1><?=$category->translate_name() ?></h1>
    <?elseif ($location!==NULL):?>
       <h1><?=$location->translate_name() ?></h1>
    <?else:?>
       <h1><?=_e('Listings')?></h1>
    <?endif?>
</div>
<?$slider_ads = ($featured != NULL)? $featured: $ads?>
<?if (core::count($slider_ads)>0 AND Theme::get('listing_slider')!=0 AND strtolower(Request::current()->action()) != 'advanced_search'):?>
    <section class="featured-posts">
        <div class="row">
            <div id="slider-fixed-products" class="carousel slide">
                <div class="carousel-inner">
                    <div class="active item">
                        <?$i=0; foreach ($slider_ads as $ad):?>
                        <?if ($i%4==0 AND $i!=0):?></div><div class="item"><?endif?>
                        <div class="col-lg-3 col-md-3 col-sm-3 col-xs-6">
                            <div class="thumbnail latest_ads">
                                <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                    <?if($ad->get_first_image()!== NULL):?>
			                            <?=HTML::picture($ad->get_first_image('image'), ['w' => 200, 'h' => 200], ['1200px' => ['w' => '200', 'h' => '200'],'992px' => ['w' => '200', 'h' => '200'], '768px' => ['w' => '200', 'h' => '200']], array('class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)))?>
			                        <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
			                            <?=HTML::picture($icon_src, ['w' => 200, 'h' => 200], ['1200px' => ['w' => '200', 'h' => '200'],'992px' => ['w' => '200', 'h' => '200'], '768px' => ['w' => '200', 'h' => '200']], array('class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)))?>
			                        <?else:?>
			                            <img data-src="holder.js/200x200?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive">
			                        <?endif?>
                                </a>
                                <div class="caption">
                                    <h5><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></h5>
                                    <?if(core::config('advertisement.description')!=FALSE):?>
                                        <p><?=Text::limit_chars(Text::removebbcode($ad->description), 30, NULL, TRUE)?></p>
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
    </section>
<?endif?>
<div class="well blog-description" id="recomentadion">
    <?if (Controller::$image!==NULL AND Theme::get('hide_description_icon')!=1):?>
        <img src="<?=Controller::$image?>" class="img-responsive" alt="<?=($category!==NULL) ? HTML::chars($category->translate_name()) : (($location!==NULL AND $category===NULL) ? HTML::chars($location->translate_name()) : NULL)?>">
    <?endif?>
    <?if ($category!==NULL):?>
        <p>
            <?=$category->translate_description() ?>
        </p>
    <?elseif ($location!==NULL):?>
        <p>
            <?=$location->translate_description()?>
        </p>
    <?endif?>

    <? if (Core::config('advertisement.only_admin_post') != 1
        AND (core::config('advertisement.parent_category') == 1
            OR (core::config('advertisement.parent_category') != 1
                AND $category !== NULL
                AND ! $category->is_parent()))):?>
        <i class="glyphicon glyphicon-pencil"></i>
        <a title="<?=__('New Advertisement')?>"
            href="<?=Route::url('post_new')?>?category=<?=($category!==NULL)?$category->seoname:''?>&location=<?=($location!==NULL)?$location->seoname:''?>">
            <?=_e('Publish new advertisement')?>
        </a>
    <?endif?>
</div><!-- end div.recomentadion-->

<?if(core::count($ads)):
    //random ad
    $position = NULL;
    $i = 0;
    if (strlen(Theme::get('listing_ad'))>0)
        $position = rand(0,core::count($ads));
?>
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
        <?if (Theme::get('minimal_list') == 1) : ?>
            <a href="#" id="minimal" class="btn btn-default btn-sm <?=(core::cookie('list/grid')==2)?'active':''?>">
                <span class="glyphicon glyphicon-align-justify"></span> <?=_e('Minimal')?>
            </a>
        <?endif?>
        <a href="#" id="list" class="btn btn-default btn-sm <?=(core::cookie('list/grid')==1)?'active':''?>">
            <span class="glyphicon glyphicon-th-list"></span> <?=_e('List')?>
        </a>
        <a href="#" id="grid" class="btn btn-default btn-sm <?=(core::cookie('list/grid')==0)?'active':''?>">
            <span class="glyphicon glyphicon-th"></span> <?=_e('Grid')?>
        </a>
        <? if((New Model_Field())->get('eventdate')): ?>
            <a href="<?= Route::url('calendar') ?>" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-calendar"></span> <?=_e('Calendar')?>
            </a>
        <? endif ?>
        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?=_e('Show').' '.HTML::chars(core::request('items_per_page')).' '._e('items per page')?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-right" role="menu" id="show-list">
                <li><a href="?<?=http_build_query(['items_per_page' => '5'] + Request::current()->query())?>">  5 <?=_e('per page')?></a></li>
                <li><a href="?<?=http_build_query(['items_per_page' => '10'] + Request::current()->query())?>"> 10 <?=_e('per page')?></a></li>
                <li><a href="?<?=http_build_query(['items_per_page' => '20'] + Request::current()->query())?>"> 20 <?=_e('per page')?></a></li>
                <li><a href="?<?=http_build_query(['items_per_page' => '50'] + Request::current()->query())?>"> 50 <?=_e('per page')?></a></li>
                <li><a href="?<?=http_build_query(['items_per_page' => '100'] + Request::current()->query())?>">100 <?=_e('per page')?></a></li>
            </ul>
        </div>
        <button type="button" id="sort" data-sort="<?=HTML::chars(core::request('sort',core::config('advertisement.sort_by')))?>" class="btn btn-info btn-sm dropdown-toggle" data-toggle="dropdown">
            <span class="glyphicon glyphicon-list-alt"></span> <?=_e('Sort')?> <span class="caret"></span>
        </button>
        <ul class="dropdown-menu" role="menu" id="sort-list">
            <?if((New Model_Field())->get('eventdate')):?>
                <li><a href="?<?=http_build_query(['sort' => 'event-date'] + Request::current()->query())?>"><?=_e('Event date')?></a></li>
            <?endif?>
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
    <div class="clearfix"></div>
    <br>

    <div id="products" class="list-group">
        <?$i=1;
        foreach($ads as $ad ):?>
            <div class="item <?=(core::cookie('list/grid')==1)?'list-group-item':'grid-group-item'?> col-lg-4 col-md-4 col-sm-4 col-xs-12 <?=($ad->featured >= Date::unix2mysql(time()))?'featured-item':''?>">
                <div class="thumbnail">
                    <?if($ad->featured >= Date::unix2mysql(time())):?>
                        <span class="label label-warning label-as-badge"><?=_e('Featured')?></span>
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
                    <h2>
                        <a class="big-txt <?=(core::cookie('list/grid')==0)?'hide':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                            <?=Text::limit_chars(Text::removebbcode($ad->title), 255, NULL, TRUE)?>
                        </a>
                        <a class="small-txt <?=(core::cookie('list/grid')==1)?'hide':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                            <?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?>
                        </a>
                    </h2>
                    <div class="col-xs-12">
                        <?if (Core::config('advertisement.reviews')==1):?>
                            <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                <span class="glyphicon glyphicon-star"></span>
                            <?endfor?>
                        <?endif?>
                    </div>

                    <?if($ad->id_location != 1):?>
                        <a class="pull-right" href="<?=Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=HTML::chars($ad->location->translate_name())?>">
                            <span class="label label-default"><?=$ad->location->translate_name() ?></span>
                        </a>
                    <?endif?>

                    <div class="picture">
                        <a class="pull-left" title="<?=HTML::chars($ad->title)?>" alt="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <figure>
                                <?if($ad->get_first_image() !== NULL): ?>
                                    <img src="<?=Core::imagefly($ad->get_first_image('image'),200,200)?>" class="center-block img-responsive" alt="<?=HTML::chars($ad->title)?>">
	                            <?else:?>
	                                <?if(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                        <img src="<?=Core::imagefly($icon_src,200,200)?>" class="center-block img-responsive" alt="<?=HTML::chars($ad->title)?>">
	                                <?else:?>
	                                    <img data-src="holder.js/150x150?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="center-block img-responsive" alt="<?=HTML::chars($ad->title)?>">
	                                <?endif?>
	                            <?endif?>
                            </figure>
                        </a>

                    </div>
                    <div class="brake-grid"></div>
                    <ul>
                        <?if (core::request('sort') == 'distance' AND Model_User::get_userlatlng()) :?>
                            <li><b><?=_e('Distance');?>:</b> <?=i18n::format_measurement($ad->distance)?></li>
                        <?endif?>
                        <?if ($ad->published!=0){?>
                            <li><b><?= _e('Publish Date');?>:</b> <?= Date::format($ad->published, core::config('general.date_format'))?></li>
                        <? }?>
                        <?if ($ad->price!=0){?>
                            <li class="price"><?= _e('Price');?>: <b><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span></b></li>
                        <?}?>
                        <?if ($ad->price==0 AND core::config('advertisement.free')==1){?>
                            <li class="price"><?= _e('Price');?>: <b><?=_e('Free');?></b></li>
                        <?}?>
                    </ul>
                    <?if(core::config('advertisement.description')!=FALSE):?>
                        <p class="big-txt <?=(core::cookie('list/grid')==0)?'hide':''?>"><?=Text::limit_chars(Text::removebbcode($ad->description), 255, NULL, TRUE)?></p>
                        <p class="small-txt <?=(core::cookie('list/grid')==1)?'hide':''?>"><?=Text::limit_chars(Text::removebbcode($ad->description), 30, NULL, TRUE)?></p>
                    <?endif?>
                    <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                        <?if($value=='checkbox_1'):?>
                            <p><b><?=$name?></b>: <i class="fa fa-check"></i></p>
                        <?elseif($value=='checkbox_0'):?>
                            <p><b><?=$name?></b>: <i class="fa fa-times"></i></p>
                        <?else:?>
                            <?if(is_string($name)):?>
                                <p><b><?=$name?></b>: <?=$value?></p>
                            <?else:?>
                                <p><?=$value?></p>
                            <?endif?>
                        <?endif?>
                    <?endforeach?>
                    <a title="<?=HTML::chars($ad->seotitle)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><i class="glyphicon glyphicon-share"></i><?=_e('Read more')?></a>
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
                    <div class="clearfix"></div>
                </div>
                <?if (Theme::get('minimal_list') == 1) : ?>
                    <div class="thumbnail minimal <?=($ad->featured >= Date::unix2mysql(time()))?'featured-item':''?> <?=(core::cookie('list/grid')==2) ? NULL : 'hide'?>">
                        <span class="pull-right favorite" id="fav-<?=$ad->id_ad?>">
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
                        <?if($ad->id_location != 1):?>
                            <span class="pull-right">
                                <a href="<?=Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=HTML::chars($ad->location->translate_name())?>">
                                    <span class="label label-default"><?=$ad->location->translate_name() ?></span>
                                </a> &nbsp;
                            </span>
                        <?endif?>
                        <?= Date::format($ad->published, core::config('general.date_format'))?>
                        <a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                            <?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?>
                        </a>
                        <?if ($ad->price!=0) :?>
                            <strong><span class="price-curry"><?=i18n::money_format($ad->price, $ad->currency())?></span></strong>
                        <?endif?>
                    </div>
                <?endif?>
            </div>
            <?if($i===$position):?>
                <div class="item <?=(core::cookie('list/grid')==1)?'list-group-item':'grid-group-item'?> col-lg-4 col-md-4 col-sm-4 col-xs-10">
                    <div class="thumbnail">
                        <?=Theme::get('listing_ad')?>
                    </div>
                </div>
            <?endif?>
            <?if($i%3==0):?><div class="clearfix"></div><?endif?>
            <?$i++?>
        <?endforeach?>
    </div>
    <div class="clearfix"></div>
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
