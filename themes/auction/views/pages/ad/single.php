<?php defined('SYSPATH') or die('No direct script access.');?>

<?if ($ad->status != Model_Ad::STATUS_PUBLISHED && $permission === FALSE && ($ad->id_user != $user)):?>

    <div class="page-header">
        <h1><?= _e('This advertisement doesn´t exist, or is not yet published!')?></h1>
    </div>

<?else:?>
    <?=Form::errors()?>

    <?
        deactivate_auction($ad);
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

        // Calculate bid increment
        $bid_increment = get_bid_increment($ad->price);

        $messages = new Model_Message();

        $bids = $messages->where('id_ad', '=', $ad->id_ad)
                        ->and_where('price','>',0)
                        ->and_where('price','!=','')
                        ->find();

        $num_of_bids = $bids->count_all();

        // Calculate and $time_left
        $time_left = get_remaining_time($ad);

        $remaining_time = $time_left;

        $days = intval($time_left / 86400);
        $time_left = $time_left % 86400;

    ?>

    <!-- PAYPAL buttons to featured and to top -->
    <?if ((Auth::instance()->logged_in() AND Auth::instance()->get_user()->id_role == 10 ) OR
        (Auth::instance()->logged_in() AND $ad->user->id_user == Auth::instance()->get_user()->id_user)):?>
        <?if((core::config('payment.pay_to_go_on_top') > 0 AND core::config('payment.to_top') != FALSE )
        OR (core::config('payment.pay_to_go_on_feature') > 0 AND core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql())):?>
            <div class="well recomentadion text-center alert-dismissable" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <?if(core::config('payment.pay_to_go_on_top') > 0 AND core::config('payment.to_top') != FALSE):?>
                    <p class="text-info"><?=_e('Your Advertisement can go on top again! For only ').i18n::format_currency(core::config('payment.pay_to_go_on_top'),core::config('payment.paypal_currency'));?></p>
                    <a class="btn btn-xs btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_top','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go to Top!')?></a>

                <?endif?>
                <?if(core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql()):?>
                    <p class="text-info"><?=_e('Your Advertisement can go to featured! For only ').i18n::format_currency(Model_Order::get_featured_price(),core::config('payment.paypal_currency'));?></p>
                    <a class="btn btn-xs btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Featured!')?></a>
                <?endif?>
            </div>
        <?endif?>
    <?endif?>
    <!-- end paypal button -->

    <div id="single-details" class="row">
        <h2 class="ad-title hidden-lg hidden-md hidden-sm"><?=$ad->title;?></h2>
        <p class="single_reviews hidden-lg hidden-md hidden-sm">
            <?if (Core::config('advertisement.reviews')==1 AND $ad->rate!=NULL):?>
                <!-- show rate -->
                <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                    <span class="glyphicon glyphicon-star"></span>
                <?endfor?>
                <?for ($jj=$j; $jj < 5; $jj++):?>
                    <span class="glyphicon glyphicon-star-empty"></span>
                <?endfor?>
                <small class="text-muted">(<?=$ad->rate?>)</small>
            <?elseif(Core::config('advertisement.reviews')==1 AND ($ad->rate==NULL)):?>
                <!-- no reviews yet -->
                <?for ($jj=0; $jj < 5; $jj++):?>
                    <span class="glyphicon glyphicon-star-empty"></span>
                <?endfor?>
                <small class="text-muted">(0/0)</small>
                <br class="hidden-lg hidden-md hidden-sm">
                <a href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>">
                    <span><?=_e('Be the first to write a review')?></span>
                </a>
            <?endif?>
        </p>
        <?if(core::config('advertisement.sharing')==1):?>
            <p class="hidden-lg hidden-md hidden-sm"><?=View::factory('share')?></p>
        <?endif?>

        <div id="gallery_container" class="col-sm-5">
            <?$images = $ad->get_images()?>
            <?if($images):?>
                <div id="gallery">
                    <div id="slider">
                        <div id="carousel-bounding-box">
                            <div id="myCarousel-single" class="carousel slide">
                                <!-- main slider carousel items -->
                                <div class="carousel-inner">
                                    <?$j=0; foreach ($images as $path => $value):?>
                                        <?if( isset($value['thumb']) AND isset($value['image']) ):?>
                                            <div class="item <?=($j==0)?'active':NULL?>" data-slide-number="<?=$j?>">
                                                <a title="<?=__('Click to view in full screen mode')?>" class="thumbnail" href="<?=$value['image']?>" data-gallery>
                                                    <?=HTML::picture($value['image'], array('h' => 500), array('1200px' => array('h' => '500'), '992px' => array('w' => '850', 'h' => '850'), '768px' => array('w' => '259', 'h' => '259'), '480px' => array('w' => '724', 'h' => '724'), '320px' => array('w' => '450', 'h' => '450')), array('alt' => '', 'class' => 'center-block img-responsive'))?>
                                                </a>
                                            </div>
                                        <?endif?>
                                    <?$j++; endforeach?>
                                </div>
                            </div>

                            <?if(core::count($images)>1):?>
                                <p class="row hidden-lg hidden-md hidden-sm">
                                    <a class="left carousel-control" href="#myCarousel-single" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#myCarousel-single" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                </p>
                                <div class="clearfix"></div>
                            <?endif?>
                        </div>
                    </div>

                    <?if(core::count($images)>1):?>
                        <div id="carousel-thumbs" class="row hidden-xs">
                            <div id="slider-fixed-products-single" class="carousel slide">
                                <div class="carousel-inner">
                                    <div class="active item">
                                        <?$i=0; foreach ($images as $path => $value):?>
                                        <?if ($i%4==0 AND $i!=0):?></div><div class="item"><?endif?>
                                            <a id="carousel-selector-<?=$i?>" class="<?=($j==0)?'selected':NULL?>">
                                                <img class="img-rounded" src="<?=Core::imagefly($value['image'],100,100)?>">
                                            </a>
                                        <?$i++; endforeach?>
                                    </div>
                                </div>
                                <?if(core::count($images)>4):?>
                                    <a class="left carousel-control" href="#slider-fixed-products-single" data-slide="prev">
                                        <span class="glyphicon glyphicon-chevron-left"></span>
                                    </a>
                                    <a class="right carousel-control" href="#slider-fixed-products-single" data-slide="next">
                                        <span class="glyphicon glyphicon-chevron-right"></span>
                                    </a>
                                <?endif?>
                            </div>
                        </div>
                    <?endif?>
                </div>

            <?else:?>
                <img data-src="holder.js/500x200?<?=str_replace('+', ' ', http_build_query(array('text' => 'No image available', 'size' => 12, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive thumbnail">
            <?endif?>

            <div id="map-single" class="text-center center-block hidden-xs">
                <?=$ad->map()?>
            </div>
        </div>


        <div id="ad_details_container" class="col-sm-7">
            <h2 class="ad-title hidden-xs"><?=$ad->title;?></h2>
            <p class="single_reviews hidden-xs">
                <?if (Core::config('advertisement.reviews')==1 AND $ad->rate != NULL):?>
                    <!-- show rate -->
                    <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                        <span class="glyphicon glyphicon-star"></span>
                    <?endfor?>
                    <?for ($jj=$j; $jj < 5; $jj++):?>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    <?endfor?>
                    <small class="text-muted">(<?=$ad->rate?>)</small>
                <?elseif(Core::config('advertisement.reviews')==1 AND ($ad->rate==NULL)):?>
                    <!-- no reviews yet -->
                    <?for ($jj=0; $jj < 5; $jj++):?>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    <?endfor?>
                    <small class="text-muted">(0/0)</small>
                    <a href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>">
                        <span><?=_e('Be the first to write a review')?></span>
                    </a>
                <?endif?>
            </p>
            <?if(core::config('advertisement.sharing')==1):?>
                <p class="hidden-xs"><?=View::factory('share')?></p>
            <?endif?>

            <div id="ad-details" class="col-sm-12">
                <div class="col-sm-6">
                    <?if(Theme::get('show_starting_price') == 1):?>
                        <?=_e('Starting price')?>: <?=i18n::money_format( $ad->price, $ad->currency())?>
                    <?endif?>
                    <!-- Current price, bids # -->
                    <?if ($ad->price>0):?>
                        <p>
                            <?if($ad->status == Model_Ad::STATUS_SOLD):?>
                                <span class="text-danger lead"><?=_e('Sold for ')?></span> <span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?> </span>
                            <?else:?>
                                <?=_e('Current bid')?>: <span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?> </span>
                            <?endif?>

                            <?if(Theme::get('show_best_bidder')==1):?>
                                <span class="text-muted">(<?=$num_of_bids?> <?=_e('bids')?>)</span>
                            <?elseif(Theme::get('show_best_bidder')==2):?>
                                <span class="text-muted"><?=Text::limit_chars(($best_bidder!='' ? hide_bidder_username($best_bidder->name):''), 10, NULL, TRUE)?></span>
                            <?elseif(Theme::get('show_best_bidder')==3):?>
                                <span class="text-muted"><?=Text::limit_chars(($best_bidder!='' ? $best_bidder->name:''), 10, NULL, TRUE)?></span>
                            <?elseif(Theme::get('show_best_bidder')==4):?>
                                <span class="text-muted">(<?=$num_of_bids?> <?=_e('bids')?>)</span> <span class="text-muted"><?=Text::limit_chars(($best_bidder!='' ? hide_bidder_username($best_bidder->name):''), 10, NULL, TRUE)?></span>
                            <?elseif(Theme::get('show_best_bidder')==5):?>
                                <span class="text-muted">(<?=$num_of_bids?> <?=_e('bids')?>)</span> <span class="text-muted"><?=Text::limit_chars(($best_bidder!='' ? ($best_bidder->name):''), 10, NULL, TRUE)?></span>
                            <?endif?>


                        </p>
                        <?if($ad->status != Model_Ad::STATUS_SOLD AND isset($ad->cf_auction_days)):?>
                            <p>
                                <b><i class="fa fa-clock-o fa-lg"></i></b> <span id="countdown" data-target-date="<?=get_target_date($ad)?>"></span>
                            </p>
                        <?endif?>
                    <?endif?>
                    <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                        <p><span class="price-curry"><?=_e('Free');?></span></p>
                    <?endif?>

                    <!-- Place Bid -->
                    <?=Form::errors()?>

                    <?=FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'user_contact', 'id'=>$ad->id_ad)), array('class'=>'form-horizontal well place-bid-single', 'enctype'=>'multipart/form-data'))?>
                        <fieldset>
                            <div class="form-group">
                                <div class="col-xs-12">
                                    <?=FORM::input('price', HTML::chars(Core::post('price')), array('placeholder' => html_entity_decode(i18n::money_format($ad->price+$bid_increment, $ad->currency())), 'class' => 'form-control', 'id' => 'price', 'type'=>'number', 'min' => $ad->price+$bid_increment))?>
                                </div>
                                <div class="col-xs-12">
                                    <?if(core::config('general.messaging') == TRUE AND Auth::instance()->logged_in()):?>
                                        <?=FORM::button(NULL, '<i class="fa fa-gavel"></i>&nbsp;&nbsp;'._e('Place Bid'), array('type'=>'submit', 'class'=>'btn btn-primary', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'user_contact' , 'id'=>$ad->id_ad))))?>
                                    <?else:?>
                                        <a class="btn btn-primary" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                            <?=_e('Place Bid')?>
                                        </a>
                                    <?endif?>
                                    <span class="text-muted center-block"><?=i18n::money_format($ad->price+$bid_increment, $ad->currency())?> <?=_e('or more')?></span>
                                </div>
                                <div class="col-xs-12">
                                    <?if (core::config('advertisement.captcha') != FALSE):?>
                                        <div class="form-group">
                                            <div id="captcha">
                                                <?=FORM::label('captcha', _e('Captcha'), array('class'=>'col-sm-12', 'for'=>'captcha'))?>
                                                <?if (Core::config('general.recaptcha_active')):?>
                                                    <?=View::factory('recaptcha', ['id' => 'recaptcha2'])?>
                                                <?else:?>
                                                    <?=captcha::image_tag('contact')?><br />
                                                    <?= FORM::input('captcha', "", array('class'=>'form-control', 'id' => 'captcha', 'required'))?>
                                                <?endif?>
                                            </div>
                                        </div>
                                    <?endif?>
                                </div>

                            </div>
                        </fieldset>
                    <?=FORM::close()?>

                    <!-- Contact seller button -->
                    <div class="form-group hidden-xs">
                        <?if ($ad->can_contact()):?>
                            <a class="btn btn-info" href="mailto:<?=$ad->user->email?>" target="_top"><i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;<?=_e('Contact Seller')?></a>
                        <?endif?>

                    <!-- Add to favorites -->
                        <div class="favorite hidden-xs" id="fav-<?=$ad->id_ad?>">
                            <?if (Auth::instance()->logged_in()):?>
                                <?$user = (Auth::instance()->get_user() == NULL) ? NULL : Auth::instance()->get_user();?>
                                <?$fav = Model_Favorite::is_favorite($user,$ad);?>
                                <a data-id="fav-<?=$ad->id_ad?>" class="btn btn-favorite add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                    <strong><i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i></strong> <?=_e('Favorite')?>
                                </a>
                            <?else:?>
                                <a class="btn btn-favorite" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                    <i class="glyphicon glyphicon-heart-empty"></i> <?=_e('Favorite')?>
                                </a>
                            <?endif?>
                        </div>
                    </div>

                    <!-- Leave a review -->
                    <?if (Core::config('advertisement.reviews')==1):?>
                        <a class="btn btn-info hidden-xs" href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>"><i class="fa fa-star"></i> <?=_e('Leave a review')?></a>
                    <?endif?>

                    <!-- Show bids history -->
                    <?if(Theme::get('show_bids_history')!=0):?>
                        <button class="btn btn-info hidden-xs" type="button" data-toggle="modal" data-target="#bidders-modal"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;<?=_e('Bid History')?></button>
                    <?endif?>

                    <!-- Mobile view buttons -->

                    <!-- Contact seller button -->
                    <ul class="list-inline hidden-lg hidden-md hidden-sm">
                        <li class="list-inline-item">
                            <?if ($ad->can_contact()):?>
                                <a class="btn btn-info" href="mailto:<?=$ad->user->email?>" target="_top"><i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;<?=_e('Contact Seller')?></a>
                            <?endif?>
                        </li>
                        <li class="list-inline-item">
                            <!-- Add to favorites -->
                            <div class="favorite" id="fav-<?=$ad->id_ad?>">
                                <?if (Auth::instance()->logged_in()):?>
                                    <?$user = (Auth::instance()->get_user() == NULL) ? NULL : Auth::instance()->get_user();?>
                                    <?$fav = Model_Favorite::is_favorite($user,$ad);?>
                                    <a data-id="fav-<?=$ad->id_ad?>" class="btn btn-favorite add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                        <strong><i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i></strong> <?=_e('Favorite')?>
                                    </a>
                                <?else:?>
                                    <a class="btn btn-favorite" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                        <i class="glyphicon glyphicon-heart-empty"></i> <?=_e('Favorite')?>
                                    </a>
                                <?endif?>
                            </div>
                        </li>

                        <!-- Leave a review -->
                        <?if (Core::config('advertisement.reviews')==1):?>
                            <li class="list-inline-item">
                                <a class="btn btn-info hidden-lg hidden-md hidden-sm" href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>"><i class="fa fa-star"></i> <?=_e('Leave a review')?></a>
                            </li>
                        <?endif?>
                        <!-- Show bids history -->
                        <?if(Theme::get('show_bids_history')!=0):?>
                            <li class="list-inline-item">
                                <button class="btn btn-info hidden-lg hidden-md hidden-sm" type="button" data-toggle="modal" data-target="#bidders-modal"><i class="glyphicon glyphicon-list"></i>&nbsp;&nbsp;<?=_e('Bid History')?></button>
                            </li>
                        <?endif?>
                    </ul>

                </div>

                <div class="well col-sm-6">
                    <?if($ad->id_category != 1 AND $ad->category->loaded()):?>
                        <p class="catloc"><i class="glyphicon glyphicon-tag"></i>&nbsp;&nbsp;<a href="<?= Route::url('list',array('category'=>$ad->category->seoname))?>" title="<?=HTML::chars($ad->category->translate_name())?>"><?=$ad->category->translate_name() ?></a>
                    <?endif?>
                    <?if (core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()):?>
                        <p class="catloc"><i class="glyphicon glyphicon-map-marker"></i>&nbsp;&nbsp;<a href="<?= Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=HTML::chars($ad->location->translate_name())?>"><?=$ad->location->translate_name() ?></a>
                    <?endif?>
                    <p class="publisher">
                        <i class="glyphicon glyphicon-user"></i>&nbsp;&nbsp;
                        <a href="<?=Route::url('profile', array('seoname'=>$ad->user->seoname))?>" title="<?=__('Posted by:')?> <?=$ad->user->name?>">
                            <?=_e('Posted by:')?> <?=$ad->user->name?> <?=$ad->user->is_verified_user();?>
                        </a>
                    </p>
                    <p class="published-date"><i class="fa fa-calendar"></i>&nbsp;&nbsp;<?=_e('Posted on:')?> <?= Date::format($ad->published, core::config('general.date_format'))?></p>
                    <?if(core::config('advertisement.count_visits')==1):?>
                        <p><i class="glyphicon glyphicon-eye-open"></i>&nbsp;&nbsp;<?=$hits?> <?=_e('Hits')?></p>
                    <?endif?>
                    <?if (core::config('advertisement.phone')==1 AND strlen($ad->phone)>1):?>
                    	<?if(Theme::get('click_reveal_phone') == 2):?>
                    		<p>
                    			<a id="single-phone" href="tel:<?=$ad->phone?>">
                                	<span class="fa fa-phone"></span>&nbsp;&nbsp;<?=$ad->phone?>
                            	</a>
                            </p>
                    	<?elseif(Theme::get('click_reveal_phone') == 1):?>
	                        <p>
	                            <a id="single-show-phone">
	                                <span class="fa fa-phone"></span>&nbsp;&nbsp;<?=__('Show Phone Number')?>
	                            </a>
	                            <a id="single-phone" class="hidden" href="tel:<?=$ad->phone?>">
	                                <span class="fa fa-phone"></span>&nbsp;&nbsp;<?=$ad->phone?>
	                            </a>
	                        </p>
                    	<?endif?>
                    <?endif?>
                    <?if (Valid::url($ad->website)):?>
                        <p class="website"><i class="glyphicon glyphicon-globe"></i>&nbsp;&nbsp;<a href="<?=$ad->website?>" rel="nofollow" target="_blank"><?=$ad->website?></a></p>
                    <?endif?>
                    <?if (core::config('advertisement.address') AND $ad->address != NULL):?>
                        <p><i class="fa fa-building" aria-hidden="true"></i>&nbsp;&nbsp;<?=$ad->address?></p>
                    <?endif?>
                </div>
            </div>

            <div id="custom-info" class="col-xs-12">
                <h3><?=_e('Details')?></h3>
                <?foreach ($cf_list as $name => $value):?>
                    <?if($name != 'Auction Days'):?>
                        <?if($value=='checkbox_1'):?>
                            <p><b><?=$name?></b>: <i class="fa fa-check"></i></p>
                        <?elseif($value=='checkbox_0'):?>
                            <p><b><?=$name?></b>: <i class="fa fa-times"></i></p>
                        <?else:?>
                            <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                    <p><b><?=$name?></b>: <?=$value?></p>
                                <?endif?>
                            <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                    <p><b><?=$name?></b>: <?=$value?></p>
                                <?endif?>
                            <?else:?>
                                <?if(is_string($name)):?>
                                    <p><b><?=$name?></b>: <?=$value?></p>
                                <?else:?>
                                    <p><?=$value?></p>
                                <?endif?>
                            <?endif?>
                        <?endif?>
                    <?endif?>
                <?endforeach?>

                <?if(core::config('advertisement.description')!=FALSE):?>
                    <p><?= Text::bb2html($ad->description,TRUE)?></p>
                <?endif?>
            </div>

            <div id="map-single" class="text-center center-block hidden-lg hidden-md hidden-sm">
                <?=$ad->map()?>
            </div>

            <?if(core::config('advertisement.qr_code')==1):?>
                <br>
                <div id="qr-code">
                    <?=$ad->qr()?>
                </div>
            <?endif?>

        </div>
    </div>

    <div class="clearfix"></div><br>
    <?if(core::config('advertisement.report')==1):?>
        <?=$ad->flagad()?>
    <?endif?>
    <?=$ad->comments()?>
    <?=$ad->related()?>
    <?=$ad->structured_data()?>
    <div class="clearfix"></div><br>
    <!-- modal show bidders -->
    <?if(Theme::get('show_bids_history') != 0):?>
        <div id="bidders-modal" class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                        <div class="modal-title"><h1><?=_e('Bid History')?></h1></div>
                    </div>
                    <div class="modal-body">
                        <?if(Theme::get('show_bids_history')==1 OR Theme::get('show_bids_history')==2):?>
                            <?
                                $bid_history   = new Model_Message();
                                $bid_history = $bid_history->order_by('created','desc')
                                                ->where('id_ad','=',$ad->id_ad)
                                                ->limit(1)
                                                // ->offset($pagination->offset)
                                                ->find_all();
                            ?>
                        <?elseif(Theme::get('show_bids_history')==3 OR Theme::get('show_bids_history')==4):?>
                            <?
                                $bid_history   = new Model_Message();
                                $bid_history = $bid_history->order_by('created','desc')
                                                ->where('id_ad','=',$ad->id_ad)
                                                ->limit(3)
                                                // ->offset($pagination->offset)
                                                ->find_all();
                            ?>
                        <?elseif(Theme::get('show_bids_history')==5):?>
                            <?
                                $bid_history   = new Model_Message();
                                $bid_history = $bid_history->order_by('created','desc')
                                                ->where('id_ad','=',$ad->id_ad)
                                                // ->limit(1);
                                                // ->offset($pagination->offset)
                                                ->find_all();
                            ?>
                        <?endif?>

                        <?if(core::count($bid_history)>0):?>
                            <table class="table table-hover table-striped">
                                <tr>
                                    <th>
                                        <?=_e('Date and Time')?>
                                    </th>
                                    <th>
                                        <?=_e('Username')?>
                                    </th>
                                    <th>
                                        <?=_e('Price')?>
                                    </th>
                                </tr>
                                <?foreach ($bid_history as $bid):?>
                                    <tr>
                                        <td><?=Date::format($bid->created, core::config('general.date_format'))?></td>
                                        <?if(Theme::get('show_bids_history')%2 != 0):?> <!-- Theme::get('show_bids_history') == 1,3,5 -->
                                            <td><?=hide_bidder_username($bid->from->name, 0, 1);?></td>
                                        <?else:?>
                                            <td><?=$bid->from->name;?></td>
                                        <?endif?>
                                        <td><?=i18n::money_format($bid->price, $ad->currency())?></td>
                                    </tr>
                                <?endforeach?>
                            </table>
                        <?endif?>
                    </div>
                </div>
            </div>
        </div>
    <?endif?>

    <!-- modal-gallery is the modal dialog used for the image gallery -->
    <div class="modal fade" id="modal-gallery">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body"><div class="modal-image"></div></div>
                <div class="modal-footer">
                    <a class="btn btn-info modal-prev"><i class="glyphicon glyphicon-arrow-left glyphicon"></i> <?=_e('Previous')?></a>
                    <a class="btn btn-primary modal-next"><?=_e('Next')?> <i class="glyphicon glyphicon-arrow-right glyphicon"></i></a>
                    <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="glyphicon glyphicon-play glyphicon"></i> <?=_e('Slideshow')?></a>
                    <a class="btn modal-download" target="_blank"><i class="glyphicon glyphicon-download"></i> <?=_e('Download')?></a>
                </div>
            </div>
        </div>
    </div>

    <!-- modal-gallery is the modal dialog used for the image gallery -->
    <div class="modal fade" id="modal-gallery">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                </div>
                <div class="modal-body"><div class="modal-image"></div></div>
                <div class="modal-footer">
                    <a class="btn btn-info modal-prev"><i class="glyphicon glyphicon-arrow-left glyphicon"></i> <?=_e('Previous')?></a>
                    <a class="btn btn-primary modal-next"><?=_e('Next')?> <i class="glyphicon glyphicon-arrow-right glyphicon"></i></a>
                    <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="glyphicon glyphicon-play glyphicon"></i> <?=_e('Slideshow')?></a>
                    <a class="btn modal-download" target="_blank"><i class="glyphicon glyphicon-download"></i> <?=_e('Download')?></a>
                </div>
            </div>
        </div>
    </div>
    <!-- The modal dialog, which will be used to wrap the lightbox content -->
    <div id="blueimp-gallery" class="blueimp-gallery">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>

        <div class="modal fade">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"></h4>
                    </div>
                    <div class="modal-body next"></div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default pull-left prev">
                            <i class="glyphicon glyphicon-chevron-left"></i>
                        </button>
                        <button type="button" class="btn btn-primary pull-left next">
                            <i class="glyphicon glyphicon-chevron-right"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?endif?>
