<!-- If (theme::get ktl ktl) Latest Closed bids option enabled -->
    <?if (get_sold_ads() != NULL AND Theme::get('closed_auctions') == 1):?>
		<? $ads = get_sold_ads(); ?>
        <section class="closed-auctions">
            <hr class="hidden-lg hidden-md hidden-sm">
            <h2>
                <?=_e('Closed Auctions')?>
            </h2>
            <div class="row">
            	<!-- sold ads desktop, laptop, tablet -->
                <div id="slider-fixed-closed-products" class="carousel slide hidden-xs">
                    <div id="latest-ads" class="carousel-inner">
                        <div class="active item">
                            <?$i=0; foreach ($ads as $ad):?>

                            <?
                            $message = new Model_Message();

                            $message->where('id_ad','=',$ad->id_ad)
                                        ->and_where('id_user_to','=',$ad->id_user)
                                        ->order_by('price', 'DESC')
                                        ->limit(1)
                                        ->find();

                            if($message->price != '' AND $message->price != NULL){
                                $ad->price = $message->price;
                                $best_bidder = new Model_User($message->id_user_from);
                            } else {
                                $order = new Model_Order();
                                $order->where('id_ad','=',$ad->id_ad)
                                        ->and_where('status','=',1)
                                        ->and_where('id_product','=',Model_Order::PRODUCT_AD_SELL)
                                        ->and_where('amount','>',0)
                                        ->and_where('amount','!=','')
                                        ->limit(1)
                                        ->find();

                                $ad->price = $order->amount;
                                $best_bidder = '';
                            }


                            ?>

                            <?if ($i%6==0 AND $i!=0):?></div><div class="item"><?endif?>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                <div class="thumbnail latest_ads ribbon-content">
                                    <div class="ribbon red"><span><?=_e('Sold')?></span></div>
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
                                        <p class="col-xs-12 text-right">
                                            <?if (Core::config('advertisement.reviews')==1 AND $ad->rate!=NULL):?>
                                                <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                                    <span class="glyphicon glyphicon-star"></span>
                                                <?endfor?>
                                                <?for ($jj=$j; $jj < 5; $jj++):?>
                                                    <span class="glyphicon glyphicon-star-empty"></span>
                                                <?endfor?>
                                            <?endif?>
                                        </p>
                                        <h5 class="h4">
                                            <a title="<?=$ad->title?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                                <strong><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></strong>
                                            </a>
                                        </h5>
                                        <p>
                                            <strong>
                                                <span class="price-curry text-danger"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                                            </strong>
                                        </p>
                                        <?if(Theme::get('highest_bidder_homepage')!=1 AND $best_bidder!=''):?>
	                                        <p>
	                                            <i><?=($best_bidder!=''?$best_bidder->name:'')?></i> <!-- theme Option -->
	                                        </p>
	                                    <?endif?>
                                    </div>
                                </div>
                            </div>
                            <?$i++;?>
                            <?endforeach?>
                        </div>
                    </div>

                    <?if(core::count($ads) > 6):?>
                        <a class="left carousel-control" href="#slider-fixed-closed-products" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#slider-fixed-closed-products" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    <?endif?>
                </div>

                <!-- Sold ads mobile -->
                <div id="slider-fixed-closed-products-mobile" class="carousel slide hidden-lg hidden-md hidden-sm">
                    <div id="latest-ads" class="carousel-inner">
                        <div class="active item">
                            <?$i=0; foreach ($ads as $ad):?>

                            <?
                            $message = new Model_Message();

                            $message->where('id_ad','=',$ad->id_ad)
                                        ->and_where('id_user_to','=',$ad->id_user)
                                        ->order_by('price', 'DESC')
                                        ->limit(1)
                                        ->find();

                            if($message->price != '' AND $message->price != NULL){
                                $ad->price = $message->price;
                                $best_bidder = new Model_User($message->id_user_from);
                            } else {
                                $order = new Model_Order();
                                $order->where('id_ad','=',$ad->id_ad)
                                        ->and_where('status','=',1)
                                        ->and_where('id_product','=',Model_Order::PRODUCT_AD_SELL)
                                        ->and_where('amount','>',0)
                                        ->and_where('amount','!=','')
                                        ->limit(1)
                                        ->find();

                                $ad->price = $order->amount;
                                $best_bidder = '';
                            }

                            ?>

                            <?if ($i%2==0 AND $i!=0):?></div><div class="item"><?endif?>
                            <div class="col-lg-2 col-md-2 col-sm-2 col-xs-6">
                                <div class="thumbnail latest_ads ribbon-content">
                                    <div class="ribbon red"><span><?=_e('Sold')?></span></div>
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
                                        <p class="col-xs-12 text-right">
                                            <?if (Core::config('advertisement.reviews')==1 AND $ad->rate!=NULL):?>
                                                <?for ($j=0; $j < round($ad->rate,1); $j++):?>
                                                    <span class="glyphicon glyphicon-star"></span>
                                                <?endfor?>
                                                <?for ($jj=$j; $jj < 5; $jj++):?>
                                                    <span class="glyphicon glyphicon-star-empty"></span>
                                                <?endfor?>
                                            <?endif?>
                                        </p>
                                        <h5 class="h4">
                                            <a title="<?=$ad->title?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                                <strong><?=Text::limit_chars(Text::removebbcode($ad->title), 30, NULL, TRUE)?></strong>
                                            </a>
                                        </h5>
                                        <p>
                                            <strong>
                                                <span class="price-curry text-danger"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                                            </strong>
                                        </p>
                                        <p>
                                            <i><?=($best_bidder!=''?$best_bidder->name:'')?></i> <!-- theme Option -->
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <?$i++;?>
                            <?endforeach?>
                        </div>
                    </div>

                    <?if(core::count($ads) > 2):?>
                        <a class="left carousel-control" href="#slider-fixed-closed-products-mobile" data-slide="prev">
                            <span class="glyphicon glyphicon-chevron-left"></span>
                        </a>
                        <a class="right carousel-control" href="#slider-fixed-closed-products-mobile" data-slide="next">
                            <span class="glyphicon glyphicon-chevron-right"></span>
                        </a>
                    <?endif?>
                </div>
            </div>
        </section>
    <?endif?>
<!-- EndIf Latest Closed bids option enabled -->