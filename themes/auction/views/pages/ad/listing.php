<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header">
    <?if ($category!==NULL):?>
       <h1><?=$category->translate_name() ?></h1>
    <?elseif ($location!==NULL):?>
       <h1><?=$location->translate_name() ?></h1>
    <?elseif(strtolower(Request::current()->action()) != 'advanced_search'):?>
       <h1><?=_e('Listings')?></h1>
    <?endif?>
</div>
<?$slider_ads = ($featured != NULL)? $featured: $ads?>

<!-- count ads, remove those that are not valid for auction -->
<?
$ads_counter = 0;
if (core::count($slider_ads)>0)
{
    foreach ($ads as $ad){
        if(get_remaining_time($ad) > 0){
            $ads_counter++;
        }
    }
}
?>

<?if (core::count($slider_ads)>0 AND Theme::get('listing_slider')!=0 AND strtolower(Request::current()->action()) != 'advanced_search'):?>
    <section class="featured-posts">
        <div class="row">
            <div id="slider-fixed-products-listing" class="carousel slide hidden-xs">
                <div id="latest-ads" class="carousel-inner">
                    <div class="active item">
                        <?$i=0; foreach ($ads as $ad):?>
                            <?if(get_remaining_time($ad) > 0):?>
                            <?
                                // Get highest bid
                                $message = new Model_Message();

                                $message->where('id_ad','=',$ad->id_ad)
                                            ->and_where('id_user_to','=',$ad->id_user)
                                            ->order_by('price', 'DESC')
                                            ->limit(1)
                                            ->find();

                                $best_bidder = '';

                                if($message->price != '' AND $message->price != NULL){
                                    $ad->price = $message->price;
                                    $best_bidder = new Model_User($message->id_user_from);
                                }

                                $messages = new Model_Message();

                                $bids = $messages->where('id_ad', '=', $ad->id_ad)
                                                ->and_where('price','>',0)
                                                ->and_where('price','!=','');

                                $num_of_bids = $bids->count_all();

                                // Calculate and $time_left
                                $time_left = get_remaining_time($ad);

                                $remaining_time = $time_left;

                                $days = intval($time_left / 86400);
                                $time_left = $time_left % 86400;

                                $remaining_time_content = '';

                                // We show hours and minutes only if the remaining time is less than a day

                                if ($days > 0) {
                                    $remaining_time_content .= '<span>'.$days.'</span>d ';

                                    $hours = intval($time_left / 3600);
                                    $time_left = $time_left % 3600;

                                    $remaining_time_content .= '<span>'.$hours.'</span>h ';

                                } else {
                                    $hours = intval($time_left / 3600);
                                    $time_left = $time_left % 3600;

                                    if ($hours > 1){
                                        $remaining_time_content .= '<span>'.$hours.'</span>h ';
                                    }

                                    $minutes = $time_left / 60;

                                    if ($minutes > 1){
                                        if($remaining_time < 3600){
                                            $remaining_time_content .= '<span class="time-danger">'.intval($minutes).'mins</span> ';
                                        } else {
                                            $remaining_time_content .= '<span>'.intval($minutes).'</span>mins ';
                                        }
                                    // elseif less than a minute left to bid
                                    } elseif ($remaining_time < 61 AND $remaining_time > 0){
                                        $remaining_time_content .= '<span>'.intval($minutes).'</span>min ';
                                    } elseif ($remaining_time < 1){
                                        $remaining_time_content .= '<span>0</span> mins ';
                                    }
                                }

                                $remaining_time_content .= 'left';
                            ?>

                            <?if ($i%6==0 AND $i!=0):?></div><div class="item"><?endif?>
                            <div class="col-sm-2">
                                <div class="thumbnail latest_ads">
                                    <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" class="min-h">
                                        <?if($ad->get_first_image()!== NULL):?>
                                            <?=HTML::picture($ad->get_first_image('image'), ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'], '992px' => ['w' => '300', 'h' => '300'], '768px' => ['w' => '300', 'h' => '300'], '480px' => ['w' => '200', 'h' => '200'], '320px' => ['w' => '200', 'h' => '200']], ['alt' => HTML::chars($ad->title), 'class' => 'img-responsive'])?>
                                        <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                            <?=HTML::picture($icon_src, ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'], '992px' => ['w' => '300', 'h' => '300'], '768px' => ['w' => '300', 'h' => '300'], '480px' => ['w' => '200', 'h' => '200'], '320px' => ['w' => '200', 'h' => '200']], ['alt' => HTML::chars($ad->title), 'class' => 'img-responsive'])?>
                                        <?else:?>
                                            <img data-src="holder.js/300x300?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 18, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive">
                                        <?endif?>
                                    </a>
                                    <div class="caption text-center">


                                        <p class="col-xs-12">
                                            <?if (Core::config('advertisement.reviews')==1 AND $ad->rate!=NULL):?>
                                                <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                                    <span class="glyphicon glyphicon-star"></span>
                                                <?endfor?>
                                                <?for ($jj=$j; $jj < 5; $jj++):?>
                                                    <span class="glyphicon glyphicon-star-empty"></span>
                                                <?endfor?>
                                            <?endif?>
                                        </p>
                                        <p><span class="price-curry text-danger"><strong><?=i18n::money_format( $ad->price, $ad->currency())?></strong></span></p>
                                        <p class="time_left"><b><i class="fa fa-clock-o"></i> <?=$remaining_time_content?></b></p>
                                        <p class="text-muted"><?=$num_of_bids?> <?=_e('Bids')?></p>
                                        <?if(Theme::get('highest_bidder_listing')!=1 AND $best_bidder!=''):?>
                                            <p><i><?=Text::limit_chars($best_bidder->name, 15, NULL, TRUE)?></i></p>
                                        <?endif?>
                                    </div>
                                    <div class="buttons">
                                        <a class="btn btn-success bid-btn" title="<?=__('View Ad')?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><strong><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i></strong></a>
                                        <div class="favorite" id="fav-<?=$ad->id_ad?>">
                                            <?if (Auth::instance()->logged_in()):?>
                                                <?$user = (Auth::instance()->get_user() == NULL) ? NULL : Auth::instance()->get_user();?>
                                                <?$fav = Model_Favorite::is_favorite($user,$ad);?>
                                                <a data-id="fav-<?=$ad->id_ad?>" class="btn btn-favorite add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                                    <i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i>
                                                </a>
                                            <?else:?>
                                                <a class="btn btn-favorite add-favorite" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                                    <i class="glyphicon glyphicon-heart-empty"></i>
                                                </a>
                                            <?endif?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?$i++;?>
                            <?endif?>
                        <?endforeach?>
                    </div>
                </div>

                <?if($ads_counter > 6):?>
	                <a class="left carousel-control" href="#slider-fixed-products-listing" data-slide="prev">
	                    <span class="glyphicon glyphicon-chevron-left"></span>
	                </a>
	                <a class="right carousel-control" href="#slider-fixed-products-listing" data-slide="next">
	                    <span class="glyphicon glyphicon-chevron-right"></span>
	                </a>
                <?endif?>
            </div>

            <!-- Listing slider mobile -->
            <?if(Theme::get('listing_slider_mobile')!=1):?>
                <div id="slider-fixed-products-listing-mobile" class="carousel slide hidden-lg hidden-md hidden-sm">
                    <div id="latest-ads" class="carousel-inner">
                        <div class="active item">
                            <?$i=0; foreach ($ads as $ad):?>
                                <?if(get_remaining_time($ad) > 0):?>
                                <?
                                    // Get highest bid
                                    $message = new Model_Message();

                                    $message->where('id_ad','=',$ad->id_ad)
                                                ->and_where('id_user_to','=',$ad->id_user)
                                                ->order_by('price', 'DESC')
                                                ->limit(1)
                                                ->find();

                                    $best_bidder = '';

                                    if($message->price != '' AND $message->price != NULL){
                                        $ad->price = $message->price;
                                        $best_bidder = new Model_User($message->id_user_from);
                                    }

                                    $messages = new Model_Message();

                                    $bids = $messages->where('id_ad', '=', $ad->id_ad)
                                                    ->and_where('price','>',0)
                                                    ->and_where('price','!=','');

                                    $num_of_bids = $bids->count_all();

                                    // Calculate and $time_left
                                    $time_left = get_remaining_time($ad);

                                    $remaining_time = $time_left;

                                    $days = intval($time_left / 86400);
                                    $time_left = $time_left % 86400;

                                    $remaining_time_content = '';

                                    // We show hours and minutes only if the remaining time is less than a day

                                    if ($days > 0) {
                                        $remaining_time_content .= '<span>'.$days.'</span>d ';

                                        $hours = intval($time_left / 3600);
                                        $time_left = $time_left % 3600;

                                        $remaining_time_content .= '<span>'.$hours.'</span>h ';

                                    } else {
                                        $hours = intval($time_left / 3600);
                                        $time_left = $time_left % 3600;

                                        if ($hours > 1){
                                            $remaining_time_content .= '<span>'.$hours.'</span>h ';
                                        }

                                        $minutes = $time_left / 60;

                                        if ($minutes > 1){
                                            if($remaining_time < 3600){
                                                $remaining_time_content .= '<span class="time-danger">'.intval($minutes).'mins</span> ';
                                            } else {
                                                $remaining_time_content .= '<span>'.intval($minutes).'</span>mins ';
                                            }
                                        // elseif less than a minute left to bid
                                        } elseif ($remaining_time < 61 AND $remaining_time > 0){
                                            $remaining_time_content .= '<span>'.intval($minutes).'</span>min ';
                                        } elseif ($remaining_time < 1){
                                            $remaining_time_content .= '<span>0</span> mins ';
                                        }
                                    }
                                    $remaining_time_content .= 'left';
                                ?>

                                <?if ($i%2==0 AND $i!=0):?></div><div class="item"><?endif?>
                                <div class="col-xs-6">
                                    <div class="thumbnail latest_ads">
                                        <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" class="min-h">
                                            <?if($ad->get_first_image()!== NULL):?>
                                                <?=HTML::picture($ad->get_first_image('image'), ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'], '992px' => ['w' => '300', 'h' => '300'], '768px' => ['w' => '300', 'h' => '300'], '480px' => ['w' => '200', 'h' => '200'], '320px' => ['w' => '200', 'h' => '200']], ['alt' => HTML::chars($ad->title), 'class' => 'img-responsive'])?>
                                            <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                                <?=HTML::picture($icon_src, ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'], '992px' => ['w' => '300', 'h' => '300'], '768px' => ['w' => '300', 'h' => '300'], '480px' => ['w' => '200', 'h' => '200'], '320px' => ['w' => '200', 'h' => '200']], ['alt' => HTML::chars($ad->title), 'class' => 'img-responsive'])?>
                                            <?else:?>
                                                <img data-src="holder.js/300x300?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 18, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive">
                                            <?endif?>
                                        </a>
                                        <div class="caption text-center">
                                            <h5 class="h4">
                                                <a title="<?=$ad->title?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                                    <strong><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></strong>
                                                </a>
                                            </h5>
                                            <p class="col-xs-12">
                                                <?if (Core::config('advertisement.reviews')==1 AND $ad->rate!=NULL):?>
                                                    <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                                        <span class="glyphicon glyphicon-star"></span>
                                                    <?endfor?>
                                                    <?for ($jj=$j; $jj < 5; $jj++):?>
                                                        <span class="glyphicon glyphicon-star-empty"></span>
                                                    <?endfor?>
                                                <?endif?>
                                            </p>
                                            <p><span class="price-curry text-danger"><strong><?=i18n::money_format( $ad->price, $ad->currency())?></strong></span></p>
                                            <p class="time_left"><b><i class="fa fa-clock-o"></i> <?=$remaining_time_content?></b></p>
                                            <p class="text-muted"><?=$num_of_bids?> <?=_e('Bids')?></p>
                                            <?if(Theme::get('highest_bidder_listing')!=1 AND $best_bidder!=''):?>
                                                <p><i><?=Text::limit_chars($best_bidder->name, 15, NULL, TRUE)?></i></p>
                                            <?endif?>

                                        </div>
                                        <div class="buttons">
                                            <a class="btn btn-success bid-btn" title="<?=__('View Ad')?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><strong><i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i></strong></a>
                                            <div class="favorite" id="fav-<?=$ad->id_ad?>">
                                                <?if (Auth::instance()->logged_in()):?>
                                                    <?$user = (Auth::instance()->get_user() == NULL) ? NULL : Auth::instance()->get_user();?>
                                                    <?$fav = Model_Favorite::is_favorite($user,$ad);?>
                                                    <a data-id="fav-<?=$ad->id_ad?>" class="btn btn-favorite add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                                        <i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i>
                                                    </a>
                                                <?else:?>
                                                    <a class="btn btn-favorite add-favorite" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                                        <i class="glyphicon glyphicon-heart-empty"></i>
                                                    </a>
                                                <?endif?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?$i++;?>
                                <?endif?>
                            <?endforeach?>
                        </div>
                    </div>
                    <?if($ads_counter > 2):?>
	                    <a class="left carousel-control" href="#slider-fixed-products-listing-mobile" data-slide="prev">
	                        <span class="glyphicon glyphicon-chevron-left"></span>
	                    </a>
	                    <a class="right carousel-control" href="#slider-fixed-products-listing-mobile" data-slide="next">
	                        <span class="glyphicon glyphicon-chevron-right"></span>
	                    </a>
                    <?endif?>
                </div>
            <?endif?>
        </div>
    </section>
<?endif?>

<div class="blog-description" id="recomentadion">
    <?if (Controller::$image!==NULL AND Theme::get('hide_description_icon')!=1):?>
        <img src="<?=Controller::$image?>" class="img-responsive" alt="<?=($category!==NULL) ? HTML::chars($category->translate_name()) : (($location!==NULL AND $category===NULL) ? HTML::chars($location->translate_name()) : NULL)?>">
    <?endif?>
    <?if ($category!==NULL):?>
        <p>
            <?=$category->translate_description()?>
        </p>
    <?elseif ($location!==NULL):?>
        <p>
            <?=$location->translate_description() ?>
        </p>
    <?endif?>
    <? if (Core::config('advertisement.only_admin_post') != 1
        AND (core::config('advertisement.parent_category') == 1
            OR (core::config('advertisement.parent_category') != 1
                AND $category !== NULL
                AND ! $category->is_parent()))):?>

        <a class="btn btn-primary" title="<?=__('New Advertisement')?>"
            href="<?=Route::url('post_new')?>?category=<?=($category!==NULL)?$category->seoname:''?>&location=<?=($location!==NULL)?$location->seoname:''?>">
            <i class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<?=_e('Publish new advertisement')?>
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
            <a href="#" id="map" data-toggle="modal" data-target="#listingMap" class="btn btn-default btn-sm">
                <span class="glyphicon glyphicon-globe"></span> <?=_e('Map')?>
            </a>
        <?endif?>
        <a href="#" id="list" class="btn btn-default btn-sm <?=(get_listgrid_state()==1)?'active':''?>">
            <span class="glyphicon glyphicon-th-list"></span> <?=_e('List')?>
        </a>
        <a href="#" id="grid" class="btn btn-default btn-sm <?=(get_listgrid_state()==0)?'active':''?>">
            <span class="glyphicon glyphicon-th"></span> <?=_e('Grid')?>
        </a>
        <div class="btn-group">
            <button class="btn btn-default btn-sm dropdown-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                <?=_e('Show').' '.HTML::chars(core::request('items_per_page')).' '._e('items per page')?> <span class="caret"></span>
            </button>
            <ul class="dropdown-menu dropdown-menu-left" role="menu" id="show-list">
                <li><a href="?<?=http_build_query(['items_per_page' => '5'] + Request::current()->query())?>"> 5 <?=_e('per page')?></a></li>
                <li><a href="?<?=http_build_query(['items_per_page' => '10'] + Request::current()->query())?>"> 10 <?=_e('per page')?></a></li>
                <li><a href="?<?=http_build_query(['items_per_page' => '20'] + Request::current()->query())?>"> 20 <?=_e('per page')?></a></li>
                <li><a href="?<?=http_build_query(['items_per_page' => '50'] + Request::current()->query())?>"> 50 <?=_e('per page')?></a></li>
                <li><a href="?<?=http_build_query(['items_per_page' => '100'] + Request::current()->query())?>">100 <?=_e('per page')?></a></li>
            </ul>
        </div>
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
    <div class="clearfix"></div>
    <br>

    <div id="products" class="list-group">
        <?$i=0;
        foreach($ads as $ad ):?>
            <?if(get_remaining_time($ad) > 0):?>
            <?
                // Get highest bid
                $message = new Model_Message();

                $message->where('id_ad','=',$ad->id_ad)
                            ->and_where('id_user_to','=',$ad->id_user)
                            ->order_by('price', 'DESC')
                            ->limit(1)
                            ->find();

                $best_bidder = '';

                if($message->price != '' AND $message->price != NULL){
                    $ad->price = $message->price;
                    $best_bidder = new Model_User($message->id_user_from);
                }

                $messages = new Model_Message();

                $bids = $messages->where('id_ad', '=', $ad->id_ad)
                                ->and_where('price','>',0)
                                ->and_where('price','!=','');

                $num_of_bids = $bids->count_all();

                // Calculate and $time_left
                $time_left = get_remaining_time($ad);

                $remaining_time = $time_left;

                $days = intval($time_left / 86400);
                $time_left = $time_left % 86400;

                $remaining_time_content = '';

                // We show hours and minutes only if the remaining time is less than a day

                if ($days > 0) {
                    if ($days > 1){
                        $remaining_time_content .= '<span>'.$days.'</span> days ';
                    } elseif ($days > 0){
                        $remaining_time_content .= '<span>'.$days.'</span> day ';
                    }

                    $hours = intval($time_left / 3600);
                    $time_left = $time_left % 3600;

                    $remaining_time_content .= '<span>'.$hours.'</span>h ';

                } else {
                    $hours = intval($time_left / 3600);
                    $time_left = $time_left % 3600;

                    if ($hours > 1){
                        $remaining_time_content .= '<span>'.$hours.'</span>h ';
                    }

                    $minutes = $time_left / 60;

                    if ($minutes > 1){
                        $remaining_time_content .= '<span>'.intval($minutes).'</span>min ';
                    // elseif less than a minute left to bid
                    } elseif ($remaining_time < 61 AND $remaining_time > 0){
                        $remaining_time_content .= '<span> < '.intval($minutes).'</span>min ';
                    } elseif ($remaining_time < 1){
                        $remaining_time_content .= '<span>0</span>mins ';
                    }
                }

            ?>
            <?if($i%6==0 OR $i==0):?><div class="row"><?endif?>
            <div class="item <?=(get_listgrid_state()==1)?'list-group-item col-sm-12 col-xs-12':'grid-group-item col-sm-2 col-xs-6'?>">
                <div class="thumbnail <?=(get_listgrid_state()==1)?'text-left':'text-center'?> <?=($ad->featured >= Date::unix2mysql(time()))?'featured_container':''?>">
                    <div class="picture <?=(get_listgrid_state()==1)?'col-sm-2 col-xs-5':''?>">
                        <a class="<?=($ad->featured >= Date::unix2mysql(time()))?'featured':''?>" title="<?=HTML::chars($ad->title)?>" alt="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <figure>
                                <?if($ad->featured >= Date::unix2mysql(time())):?>
                                    <div class="corner-ribbon top-left sticky red shadow"><?=_e('Featured')?></div>
                                <?endif?>
                                <?if($ad->get_first_image() !== NULL):?>
                                    <img src="<?=Core::imagefly($ad->get_first_image('image'),200,200)?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive pull-right">
                                <?elseif(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                    <img src="<?=Core::imagefly($icon_src,200,200)?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive pull-right">
                                <?else:?>
                                    <img data-src="holder.js/200x200?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 12, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive pull-right">
                                <?endif?>

                                <?if($ad->price > 0):?>
                                    <figcaption><b><?=i18n::money_format( $ad->price, $ad->currency())?></b></figcaption>
                                <?endif?>
                            </figure>
                        </a>
                    </div>

                    <div class="caption <?=(get_listgrid_state()==1)?'col-sm-8 col-xs-7':''?>">
                        <h2 class="h3">
                            <a class="ad-title list <?=(get_listgrid_state()==0)?'hidden':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                                    <?=Text::limit_chars(Text::removebbcode($ad->title), 60, NULL, TRUE)?>
                            </a>
                            <a class="ad-title grid <?=(get_listgrid_state()==1)?'hidden':''?>" title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" >
                                    <?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?>
                            </a>
                        </h2>
                        <p>
                            <?if (Core::config('advertisement.reviews')==1 AND $ad->rate!=NULL):?>
                                <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                    <span class="glyphicon glyphicon-star"></span>
                                <?endfor?>
                                <?for ($jj=$j; $jj < 5; $jj++):?>
                                    <span class="glyphicon glyphicon-star-empty"></span>
                                <?endfor?>
                                <small class="text-muted">(<?=$ad->rate?>)</small>
                            <?endif?>
                        </p>
                        <p>
                            <?if($ad->id_category != 1 AND $ad->category->loaded()):?>
                                <a class="cat-loc-badge <?=(get_listgrid_state()==0)?'hidden':''?> hidden-xs" href="<?= Route::url('list',array('category'=>$ad->category->seoname))?>" title="<?=__('Category:').' '.HTML::chars($ad->category->translate_name())?>">
                                    <span class="badge"><i class="fa fa-tag" aria-hidden="true"></i> <?=$ad->category->translate_name() ?></span>
                                </a>
                            <?endif?>
                            <?if (core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()):?>
                                <a class="cat-loc-badge <?=(get_listgrid_state()==0)?'hidden':''?> hidden-xs" href="<?= Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=__('Location:').' '.HTML::chars($ad->location->translate_name())?>">
                                    <span class="badge"><i class="fa fa-map-marker" aria-hidden="true"></i> <?=$ad->location->translate_name() ?></span>
                                </a>
                            <?endif?>
                        </p>
                        <p class="price <?=(get_listgrid_state()==0)?'hidden':''?>">
                            <b><span class="price-curry text-danger"><?=i18n::money_format( $ad->price, $ad->currency())?></span></b>
                        </p>
                        <?if($ad->price > 0 AND isset($ad->cf_auction_days) AND $ad->cf_auction_days!=''):?>
                            <p><b><i class="fa fa-clock-o fa-lg"></i> <?=$remaining_time_content?> <?=_e('left')?></b></p>
                            <p class="text-muted"><?=$num_of_bids?> <?=_e('Bids')?></p>
                            <?if(Theme::get('highest_bidder_listing')!=1 AND $best_bidder!=''):?>
                            	<p class="bidder list <?=(get_listgrid_state()==0)?'hidden':''?>"><i><?=Text::limit_chars(($best_bidder!=''?$best_bidder->name:''), 40, NULL, TRUE)?></i></p>
                            	<p class="bidder grid <?=(get_listgrid_state()==1)?'hidden':''?>"><i><?=Text::limit_chars(($best_bidder!=''?$best_bidder->name:''), 15, NULL, TRUE)?></i></p>
                            <?endif?>

                        <?endif?>

                        <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                            <?if($value=='checkbox_1'):?>
                                <p><b><?=$name?></b>: <i class="fa fa-check"></i></p>
                            <?elseif($value=='checkbox_0'):?>
                                <p><b><?=$name?></b>: <i class="fa fa-times"></i></p>
                            <?elseif(is_string($name)):?>
                                <p><b><?=$name?></b>: <?=$value?></p>
                            <?else:?>
                                <p><?=$value?></p>
                            <?endif?>
                        <?endforeach?>

                        <?if(core::config('advertisement.description')!=FALSE):?>
                        	<p class="description list <?=(get_listgrid_state()==0)?'hidden':''?> hidden-xs"><?=Text::limit_chars(Text::removebbcode($ad->description), 300, NULL, TRUE)?></p>
                        <?endif?>

                    </div>

                    <!-- List View buttons -->
                    <div class="buttons-list col-sm-2 <?=(get_listgrid_state()==1)?'':'hidden'?> hidden-xs">
                        <div class="favorite" id="fav-<?=$ad->id_ad?>">
                            <?if (Auth::instance()->logged_in()):?>
                                <?$user = (Auth::instance()->get_user() == NULL) ? NULL : Auth::instance()->get_user();?>
                                <?$fav = Model_Favorite::is_favorite($user,$ad);?>
                                <a data-id="fav-<?=$ad->id_ad?>" class="btn btn-favorite add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                    <strong><i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i></strong>
                                </a>
                            <?else:?>
                                <a class="btn btn-favorite" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                    <i class="glyphicon glyphicon-heart-empty"></i>
                                </a>
                            <?endif?>
                        </div>
                        <?if ($user !== NULL AND ($user->is_admin() OR $user->is_moderator())):?>
                            <div title="<?=__('Manage your ad')?>" class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
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
                            <div title="<?=__('Manage your ad')?>" class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
                                <div id="user-toolbar-options<?=$ad->id_ad?>" class="hide user-toolbar-options">
                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><i class="glyphicon glyphicon-edit"></i><?=_e("Edit");?></a> |
                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'deactivate','id'=>$ad->id_ad))?>"
                                        onclick="return confirm('<?=__('Deactivate?')?>');"><i class="glyphicon glyphicon-off"></i><?=_e("Deactivate");?>
                                    </a>
                                </div>
                            </div>
                        <?endif?>
                    </div>

                	<!-- Grid View -->
                    <div class="buttons center-block <?=(get_listgrid_state()==0)?'':'hidden'?>">
                        <a class="btn btn-success bid-btn" title="<?=__('View Ad')?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                        	<strong>
                        		<i class="glyphicon glyphicon-eye-open" aria-hidden="true"></i>
                            </strong>
                    	</a>
                        <div class="favorite" id="fav-<?=$ad->id_ad?>">
                            <?if (Auth::instance()->logged_in()):?>
                                <?$user = (Auth::instance()->get_user() == NULL) ? NULL : Auth::instance()->get_user();?>
                                <?$fav = Model_Favorite::is_favorite($user,$ad);?>
                                <a data-id="fav-<?=$ad->id_ad?>" class="btn btn-favorite add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                    <strong><i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i></strong>
                                </a>
                            <?else:?>
                                <a class="btn btn-favorite add-favorite" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                    <i class="glyphicon glyphicon-heart-empty"></i>
                                </a>
                            <?endif?>
                        </div>
                        <?if ($user !== NULL AND ($user->is_admin() OR $user->is_moderator())):?>
                            <div title="<?=__('Manage your ad')?>" class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
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
                            <div title="<?=__('Manage your ad')?>" class="toolbar btn btn-primary btn-xs"><i class="glyphicon glyphicon-cog"></i>
                                <div id="user-toolbar-options<?=$ad->id_ad?>" class="hide user-toolbar-options">
                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><i class="glyphicon glyphicon-edit"></i><?=_e("Edit");?></a> |
                                    <a class="btn btn-primary btn-xs" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'deactivate','id'=>$ad->id_ad))?>"
                                        onclick="return confirm('<?=__('Deactivate?')?>');"><i class="glyphicon glyphicon-off"></i><?=_e("Deactivate");?>
                                    </a>
                                </div>
                            </div>
                        <?endif?>
                    </div>

    				<div class="clearfix"></div>

                </div>
            </div>
            <?if($i===$position):?>
                <div class="item <?=(get_listgrid_state()==1)?'list-group-item':'grid-group-item'?> col-lg-3 col-md-3 col-sm-3 col-xs-12">
                    <div class="thumbnail">
                        <?=Theme::get('listing_ad')?>
                    </div>
                </div>
            <?endif?>
            <?$i++;?>
            <?if($i%6==0 AND $i!=0):?></div><?endif?>
            <?endif?>
        <?endforeach?>
        </div>
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
