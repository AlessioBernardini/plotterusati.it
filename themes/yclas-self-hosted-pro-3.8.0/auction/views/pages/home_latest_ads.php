<!-- count ads, remove those that are not valid for auction -->
<?
$ads_counter = 0;
foreach ($ads as $ad){
    if(get_remaining_time($ad) > 0){
        $ads_counter++;
    }
}
?>

<?if(core::config('advertisement.ads_in_home') != 3):?>
    <?if ($ads_counter>0):?>
        <section id="home-latest-ads" class="featured-posts">
            <h2>
                <?if(core::config('advertisement.ads_in_home') == 0):?>
                    <?=_e('Latest Auctions')?>
                <?elseif(core::config('advertisement.ads_in_home') == 1 OR core::config('advertisement.ads_in_home') == 4):?>
                    <?=_e('Featured Auctions')?>
                <?elseif(core::config('advertisement.ads_in_home') == 2):?>
                    <?=_e('Popular Ads last month')?>
                <?endif?>
                <?if ($user_location) :?>
                    <small><?=$user_location->translate_name() ?></small>
                <?endif?>
            </h2>
            <div class="row">


                <!-- Latest Ads slider desktop, laptop, tablet -->
                <div id="slider-fixed-products" class="carousel slide hidden-xs">
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
                                    <div class="col-lg-2 col-md-2 col-sm-2">
                                        <div class="thumbnail latest_ads">
                                            <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>" class="min-h">
                                                <?if($ad->get_first_image()!== NULL):?>
                                                    <?=HTML::picture($ad->get_first_image('image'), ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'], '992px' => ['w' => '300', 'h' => '300'], '768px' => ['w' => '300', 'h' => '300'], '480px' => ['w' => '200', 'h' => '200'], '320px' => ['w' => '200', 'h' => '200']], ['alt' => HTML::chars($ad->title), 'class' => 'img-responsive'])?>
                                                <?elseif( ($icon_src = $ad->category->get_icon()) !== FALSE):?>
                                                    <?=HTML::picture($icon_src, ['w' => 300, 'h' => 300], ['1200px' => ['w' => '300', 'h' => '300'], '992px' => ['w' => '300', 'h' => '300'], '768px' => ['w' => '300', 'h' => '300'], '480px' => ['w' => '200', 'h' => '200'], '320px' => ['w' => '200', 'h' => '200']], ['alt' => HTML::chars($ad->title), 'class' => 'img-responsive'])?>
                                                <?else:?>
                                                    <img data-src="holder.js/300x300?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive">
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
                                                <?if(Theme::get('highest_bidder_homepage')!=1 AND $best_bidder!=''):?>
                                                    <p><i><?=Text::limit_chars($best_bidder->name, 15, NULL, TRUE)?></i> <!-- theme Option --></p>
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
                        <a class="left carousel-control" href="#slider-fixed-products" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#slider-fixed-products" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    <?endif?>
                </div>

                <!-- Latest Ads slider mobile -->
                <div id="slider-fixed-products-mobile" class="carousel slide hidden-lg hidden-md hidden-sm">
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
                                                    <img data-src="holder.js/300x300?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>" class="img-responsive">
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
                                                <?if(Theme::get('highest_bidder_homepage')!=1 AND $best_bidder!=''):?>
                                                    <p><i><?=Text::limit_chars($best_bidder->name, 15, NULL, TRUE)?></i> <!-- theme Option --></p>
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
                        <div class="row">
                            <a class="left carousel-control" href="#slider-fixed-products-mobile" data-slide="prev">
                                <span class="glyphicon glyphicon-chevron-left"></span>
                            </a>
                            <a class="right carousel-control" href="#slider-fixed-products-mobile" data-slide="next">
                                <span class="glyphicon glyphicon-chevron-right"></span>
                            </a>
                        </div>
                    <?endif?>
                </div>
            </div>
        </section>
    <?endif?>
<?endif?>