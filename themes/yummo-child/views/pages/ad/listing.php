<?php defined('SYSPATH') or die('No direct script access.');?>

<?php
$annunci = new Model_Ad();
$annunci->where('status', '=', Model_Ad::STATUS_PUBLISHED);
$annunci = $annunci->find_all();
?>

<?if ($category!==NULL):?>
    <h1><?=$category->translate_name()?></h1>
<?elseif ($location!==NULL):?>
    <h1><?=$location->translate_name()?></h1>
<?else:?>
	<?php 
	if(strpos($_SERVER['REQUEST_URI'], 'ricerca') == false){
	    ?><h1><?=_e('Listings')?> <span class="count_ads">(<?=core::count($annunci)?>)</span></h1><?php  
	}
	?>
<?endif?>
<? /* if (Core::config('advertisement.only_admin_post') != 1
        AND (core::config('advertisement.parent_category') == 1
            OR (core::config('advertisement.parent_category') != 1
                AND $category !== NULL
                AND ! $category->is_parent()))):?>
   <a title="<?=__('New Advertisement')?>" class="btn btn-primary btn-publish pull-right" href="<?=Route::url('post_new')?>?category=<?=($category!==NULL)?$category->seoname:''?>&amp;location=<?=($location!==NULL)?$location->seoname:''?>"><i class="fa fa-pencil"></i> <?=_e('Publish new advertisement')?></a>
<?endif */?>

<p id="listing_description" class="pull-left col-xs-12">
    <?if ($category!==NULL):?>
        <?=$category->translate_description() ?>
    <?elseif ($location!==NULL):?>
        <?=$location->translate_description() ?>
    <?endif?>
</p>

<div class="clearfix"></div>

<?$slider_ads = ($featured != NULL)? $featured: $ads?>

<?if (core::count($slider_ads)>0 AND Theme::get('listing_slider')!=0 AND strtolower(Request::current()->action()) != 'advanced_search'):?>
<section class="featured-posts">
      <div id="slider-fixed-products" class="carousel slide">
        <div class="carousel-inner">
            <div class="active item">
                <ul class="thumbnails">
                <?$i=0;
                foreach ($slider_ads as $ad):?>
                <?if ($i%3==0 AND $i!=0):?></ul></div><div class="item"><ul class="thumbnails"><?endif?>
                <li class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
                    <div class="latest_ads">
                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <?if($ad->get_first_image()!== NULL):?>
                                <?=HTML::picture($ad->get_first_image('image'), ['w' => 360, 'h' => 275], ['1200px' => ['w' => '360', 'h' => '275'], '992px' => ['w' => '455', 'h' => '350'], '768px' => ['w' => '750', 'h' => '400'], '480px' => ['w' => '710', 'h' => '475'], '320px' => ['w' => '420', 'h' => '280']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                            <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                <?=HTML::picture($icon_src, ['w' => 360, 'h' => 275], ['1200px' => ['w' => '360', 'h' => '275'], '992px' => ['w' => '455', 'h' => '350'], '768px' => ['w' => '750', 'h' => '400'], '480px' => ['w' => '710', 'h' => '475'], '320px' => ['w' => '420', 'h' => '280']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                            <?else:?>
                                <img data-src="holder.js/360x275?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="center-block img-responsive" alt="<?=HTML::chars($ad->title)?>">
                            <?endif?>
                        </a>
                        <div class="caption">
                            <h5><a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></a></h5>
                            <p><?=Text::limit_chars(Text::removebbcode($ad->description), 100, NULL, TRUE)?></p>
                        </div>
                        <div class="extra_info">
                            <?if ($ad->price!=0){?>
                            <div class="price pull-left">
                                <i class="fa fa-money"></i><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
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
            $position = rand(1,floor(core::count($ads)/3))*3;
    ?>
        <div class="filter row">
            <div class="btn-group col-xs-12 col-sm-7 pull-right" id="listgrid" data-default="<?=Theme::get('listgrid')?>">
                <div class="btn-group pull-right">
                    <a href="#" data-sort="<?=HTML::chars(core::request('sort',core::config('advertisement.sort_by')))?>" class="btn btn-default width-auto dropdown-toggle" data-toggle="dropdown">
                        <?=_e('Sort')?> <span class="caret"></span>
                    </a>
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
                <div class="btn-group pull-right">
                    <a href="#" class="btn btn-default width-auto dropdown-toggle" id="show" data-toggle="dropdown" aria-expanded="false">
                        <?=_e('Show').' '.HTML::chars(core::request('items_per_page')).' '._e('items per page')?> <span class="caret"></span>
                    </a>
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
                <?if (core::config('advertisement.map')==1):?>
                    <!--<a href="#" data-toggle="modal" data-target="#listingMap" class="btn btn-default pull-right">-->
                    <a href="https://plotterusati.online/mappa.html" target="_blank" class="btn btn-default pull-right">
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
                        <i class="glyphicon glyphicon-map-marker"></i> <?=sprintf(__('%s from you'), i18n::format_measurement(Core::cookie('mydistance', Core::config('advertisement.auto_locate_distance', 2))))?>
                    </button>
                <?endif?>
            </div>
        </div>
        <div class="clearfix"></div><br>

        <div id="products" class="list-group listing_ads">
            <?$i=1;
            foreach($ads as $ad ):?>
                <?if ($i%3==1 OR $i==1):?><div class="row"><?endif?>
                <div class="item <?=(core::cookie('list/grid')==1)?'list-group-item':'grid-group-item'?> col-md-4 col-sm-12 col-xs-12">
                    <div class="thumbnail <?=($ad->featured >= Date::unix2mysql(time()))?'featured-item':''?>">
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

                        <div class="picture pull-left">
                            <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                <?if($ad->get_first_image()!== NULL):?>
                                    <?=HTML::picture($ad->get_first_image('image'), ['w' => 368, 'h' => 280], ['1200px' => ['w' => '368', 'h' => '280'], '992px' => ['w' => '468', 'h' => '350'], '768px' => ['w' => '360', 'h' => '240'], '480px' => ['w' => '765', 'h' => '510'], '320px' => ['w' => '480', 'h' => '300']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                                <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                    <?=HTML::picture($icon_src, ['w' => 368, 'h' => 280], ['1200px' => ['w' => '368', 'h' => '280'], '992px' => ['w' => '468', 'h' => '350'], '768px' => ['w' => '360', 'h' => '240'], '480px' => ['w' => '765', 'h' => '510'], '320px' => ['w' => '480', 'h' => '300']], ['class' => 'center-block img-responsive', 'alt' => HTML::chars($ad->title)])?>
                                <?else:?>
                                    <img data-src="holder.js/368x280?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="center-block img-responsive" alt="<?=HTML::chars($ad->title)?>">
                                <?endif?>
                            </a>

                            <?if (Core::config('advertisement.reviews')==1):?>
                                <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                    <span class="glyphicon glyphicon-star"></span>
                                <?endfor?>
                            <?endif?>
                        </div>
                        <a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                        <div class="extra_info">
                            <?if ($ad->price!=0){?>
                                <div class="price pull-left">
                                    <i class="fa fa-money"></i><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
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
                            <?php /* <a class="more-link pull-right hvr-icon-forward" href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=_e('more')?></a> */?>
                        	<div class="date pull-right"><?if ($ad->published!=0){?> <?= Date::format($ad->published, core::config('general.date_format'))?><? }?></div>
                        </div></a>
                        <div class="brake-grid"></div>
                        <div class="caption pull-left">
                            <h3>
                                <a class="big-txt <?=(core::cookie('list/grid')==0)?'hide':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                                    <?=Text::limit_chars(Text::removebbcode($ad->title), 20, NULL, TRUE)?>
                                </a>
                                <a class="small-txt <?=(core::cookie('list/grid')==1)?'hide':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                                    <?=Text::limit_chars(Text::removebbcode($ad->title), 20, NULL, TRUE)?>
                                </a>
                                <div class="details">
                                    <?= _e('Posted by');?> <?=$ad->user->name?> <?if ($ad->id_location != 1):?><?= _e('from');?> <?=$ad->location->translate_name() ?><?endif?> <?if ($ad->published!=0){?><?= _e('on');?> <?= Date::format($ad->published, core::config('general.date_format'))?><? }?>
                                </div>
                            </h3>
                            <?if(core::config('advertisement.description')!=FALSE AND $ad->description):?>
                            	<a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                <p class="description"><?=Text::limit_chars(Text::removebbcode($ad->description), 100, NULL, TRUE)?></p>
                                </a>              
                            <?else:?>
                                <a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                <p class="description">&nbsp;</p>
                                </a>
                            <?endif?>
                            <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                <?if($value=='checkbox_1'):?>
                                    <p><b><?=$name?></b>: <i class="fa fa-check"></i></p>
                                <?elseif($value=='checkbox_0'):?>
                                    <p><b><?=$name?></b>: <i class="fa fa-times"></i></p>
                                <?else:?>
                                    <?if(is_string($name)):?>
                                    	<a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                        <p><?=$name?>: <b><?=$value?></b></p>
                                        </a>
                                    <?else:?>
                                    	<a class="nolink" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                        <p><b><?=$value?></b></p>
                                        </a>
                                    <?endif?>
                                <?endif?>
                            <?endforeach?>
                            <p class="provenienza">Provenienza: <?if ($ad->id_location != 1):?><b><a href="/all/<?=strtolower($ad->location->translate_name())?>"><?=$ad->location->translate_name()?></a></b><?endif?></p>
                        </div>
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
                    </div>
                    <div class="row">
                        <div class="item <?=(core::cookie('list/grid')==1)?'list-group-item':'grid-group-item'?> col-xs-12">
                            <div class="thumbnail">
                                <?=Theme::get('listing_ad')?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                    <?$i = 0; $position = NULL;?>
                <?endif?>
            <?$i++?>
            <?if ($i%3==1 OR $i==1):?></div><?endif?>
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
