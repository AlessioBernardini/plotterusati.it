<?php defined('SYSPATH') or die('No direct script access.');?>

<?if ($ad->status != Model_Ad::STATUS_PUBLISHED && $permission === FALSE && ($ad->id_user != $user)):?>
    <div class="page-header">
        <h1><?= _e('This advertisement doesn´t exist, or is not yet published!')?></h1>
    </div>
<?else:?>
    <?=Form::errors()?>
    <section id="page-header">
        <div class="container no-gutter">
            <div class="row">
                <div class="col-sm-8">
                    <h1 class="h1"><?= $ad->title;?></h1>
                </div>
                <?if (Theme::get('breadcrumb')==1 AND Theme::landing_single_ad() == FALSE):?>
                    <div class="col-sm-4 breadcrumbs">
                        <?=Breadcrumbs::render('breadcrumbs')?>
                    </div>
                <?endif?>
            </div>
        </div>
        <div class="overlay"></div>
    </section>

    <?=Alert::show()?>

    <section id="main">
        <div class="container no-gutter">
            <div class="row">
                <article class="col-xs-12 col-sm-8 <?=(Theme::get('sidebar_position')=='hidden')?'col-md-12':'col-md-9'?> <?=(Theme::get('sidebar_position')=='left')?'col-md-push-3':NULL?>">
                    <!-- PAYPAL buttons to featured and to top -->
                    <?if ((Auth::instance()->logged_in() AND Auth::instance()->get_user()->id_role == 10 ) OR
                        (Auth::instance()->logged_in() AND $ad->user->id_user == Auth::instance()->get_user()->id_user)):?>
                        <?if((core::config('payment.pay_to_go_on_top') > 0
                                && core::config('payment.to_top') != FALSE )
                                OR (core::config('payment.pay_to_go_on_feature') > 0
                                && core::config('payment.to_featured') != FALSE)):?>
                                <?if(core::config('payment.pay_to_go_on_top') > 0 && core::config('payment.to_top') != FALSE):?>
                                    <div id="recomentadion" class="well recomentadion clearfix">
                                        <p class="text-info"><?=_e('Your Advertisement can go on top again! For only ').i18n::format_currency(core::config('payment.pay_to_go_on_top'),core::config('payment.paypal_currency'));?></p>
                                        <a class="btn btn-xs btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_top','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Top!')?></a>
                                    </div>
                                <?endif?>
                                <?if(core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql()):?>
                                    <div id="recomentadion" class="well recomentadion clearfix">
                                        <p class="text-info"><?=_e('Your Advertisement can go to featured! For only ').i18n::format_currency(Model_Order::get_featured_price(),core::config('payment.paypal_currency'));?></p>
                                        <a class="btn btn-xs btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Featured!')?></a>
                                    </div>
                                <?endif?>
                        <?endif?>
                    <?endif?>
                    <!-- end paypal button -->
                    <div class="contact no-gutter">
                        <div class="col-xs-12 col-sm-7 col-md-8 col-left">
                            <!-- main slider carousel -->
                            <?$images = $ad->get_images()?>
                            <?if($images):?>
                                <div id="slider">
                                    <div id="carousel-bounding-box">
                                        <div id="myCarousel" class="carousel slide">
                                            <!-- main slider carousel items -->
                                            <div class="carousel-inner">
                                                <?$j=0; foreach ($images as $path => $value):?>
                                                    <?if( isset($value['thumb']) AND isset($value['image']) ):?>
                                                        <div class="item <?=($j==0)?'active':NULL?>" data-slide-number="<?=$j?>">
                                                            <a href="<?=$value['image']?>" data-gallery>
                                                                <?=HTML::picture($value['image'], array('w' => 550), array('1200px' => array('w' => '550'), '992px' => array('w' => '450'), '768px' => array('w' => '259'), '480px' => array('w' => '724'), '320px' => array('w' => '290')), array('alt' => '', 'class' => 'center-block img-responsive'))?>
                                                            </a>
                                                        </div>
                                                    <?endif?>
                                                <?$j++; endforeach?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- thumb navigation carousel -->
                                <div id="slider-thumbs">
                                      <!-- thumb navigation carousel items -->
                                      <ul class="list-inline">
                                          <?$j=0; foreach ($images as $path => $value):?>
                                              <?if( isset($value['thumb']) AND isset($value['image']) ):?>
                                                <li>
                                                    <a id="carousel-selector-<?=$j?>" class="<?=($j==0)?'selected':NULL?>">
                                                        <?=HTML::picture($value['thumb'], array('w' => 200, 'h' => 200), array('1200px' => array('w' => '100', 'h' => '100'), '992px' => array('w' => '80', 'h' => '80'), '768px' => array('w' => '42', 'h' => '42'), '480px' => array('w' => '200', 'h' => '200'), '320px' => array('w' => '80', 'h' => '80')), array('alt' => '', 'class' => 'center-block img-responsive'))?>
                                                    </a>
                                                </li>
                                              <?endif?>
                                          <?$j++; endforeach?>
                                      </ul>
                                </div>
                            <?endif?>
                                <div>
                                    <div>
                                        <?if(core::config('advertisement.description')!=FALSE):?>
                                            <p><?= Text::bb2html($ad->description,TRUE)?></p>
                                        <?endif?>
                                        <?if (Valid::url($ad->website)):?>
                                        <br>
                                        <p><a href="<?=$ad->website?>" rel="nofollow" target="_blank"><?=$ad->website?></a></p>
                                        <?endif?>
                                        <?if (core::config('advertisement.address') AND $ad->address != NULL):?>
                                            <br>
                                            <p><?=$ad->address?></p>
                                        <?endif?>
                                    </div>
                                </div>

                                <hr>

                                <div class="btn-group btn-group-justified" role="group">
                                    <?if((core::config('payment.paypal_seller')==1 OR Core::config('payment.stripe_connect')==1 OR Core::config('payment.escrow_pay')==1) AND $ad->price != NULL AND $ad->price > 0):?>
                                        <?if(core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1)):?>
                                            <div class="btn-group" role="group">
                                                <?if($ad->status != Model_Ad::STATUS_SOLD):?>
                                                    <a class="primary-btn color-secondary btn" href="<?=Route::url('default', array('action'=>'buy','controller'=>'ad','id'=>$ad->id_ad))?>">
                                                        <i class="fa fa-money" aria-hidden="true"></i>
                                                        &nbsp;&nbsp;<?=_e('Buy Now')?>
                                                    </a>
                                                <?else:?>
                                                    <a class="primary-btn color-secondary btn disabled">
                                                        <i class="fa fa-money" aria-hidden="true"></i>
                                                        &nbsp;&nbsp;<?=_e('Sold')?>
                                                    </a>
                                                <?endif?>
                                            </div>
                                        <?endif?>
                                    <?elseif (isset($ad->cf_file_download) AND !empty($ad->cf_file_download) AND  ( core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1))):?>
                                        <div class="btn-group" role="group">
                                            <a class="primary-btn color-secondary btn" type="button" href="<?=$ad->cf_file_download?>">
                                                <i class="fa fa-download" aria-hidden="true"></i>
                                                &nbsp;&nbsp;<?=_e('Download')?>
                                            </a>
                                        </div>
                                    <?endif?>
                                    <?if ($ad->can_contact()):?>
                                        <div class="btn-group" role="group">
                                            <?if ((core::config('advertisement.login_to_contact') == TRUE OR core::config('general.messaging') == TRUE) AND !Auth::instance()->logged_in()) :?>
                                                <a class="primary-btn color-primary btn" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                                    <i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;<?=_e('Send Message')?>
                                                </a>
                                            <?else :?>
                                                <button class="primary-btn color-primary btn" type="button" data-toggle="modal" data-target="#contact-modal"><i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;<?=_e('Send Message')?></button>
                                            <?endif?>

                                            <div id="contact-modal" class="modal fade">
                                                <div class="modal-dialog">
                                                    <div class="modal-content">
                                                        <div class="modal-header">
                                                             <a class="close" data-dismiss="modal" aria-hidden="true">&times;</a>
                                                            <h3><?=_e('Contact')?></h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <?=Form::errors()?>

                                                            <?= FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'user_contact', 'id'=>$ad->id_ad)), array('class'=>'form-horizontal well', 'enctype'=>'multipart/form-data'))?>
                                                                <fieldset>
                                                                    <?if (!Auth::instance()->get_user()):?>
                                                                        <div class="form-group">
                                                                            <?= FORM::label('name', _e('Name'), array('class'=>'col-sm-2 control-label', 'for'=>'name'))?>
                                                                            <div class="col-md-4 ">
                                                                                <?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class'=>'form-control', 'id' => 'name', 'required'))?>
                                                                            </div>
                                                                        </div>
                                                                        <div class="form-group">
                                                                            <?= FORM::label('email', _e('Email'), array('class'=>'col-sm-2 control-label', 'for'=>'email'))?>
                                                                            <div class="col-md-4 ">
                                                                                <?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class'=>'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                                                                            </div>
                                                                        </div>
                                                                    <?endif?>
                                                                    <?if(core::config('general.messaging') != TRUE):?>
                                                                        <div class="form-group">
                                                                            <?= FORM::label('subject', _e('Subject'), array('class'=>'col-sm-2 control-label', 'for'=>'subject'))?>
                                                                            <div class="col-md-4 ">
                                                                                <?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class'=>'form-control', 'id' => 'subject'))?>
                                                                            </div>
                                                                        </div>
                                                                    <?endif?>
                                                                    <div class="form-group">
                                                                        <?= FORM::label('message', _e('Message'), array('class'=>'col-sm-2 control-label', 'for'=>'message'))?>
                                                                        <div class="col-md-6">
                                                                            <?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>2, 'required'))?>
                                                                        </div>
                                                                    </div>
                                                                    <?if(core::config('general.messaging') AND
                                                                        core::config('advertisement.price') AND
                                                                        core::config('advertisement.contact_price')):?>
                                                                        <div class="form-group">
                                                                            <?= FORM::label('price', _e('Price'), array('class'=>'col-sm-2 control-label', 'for'=>'price'))?>
                                                                            <div class="col-md-6">
                                                                                <?= FORM::input('price', Core::post('price'), array('placeholder' => html_entity_decode(i18n::money_format(1, $ad->currency())), 'class' => 'form-control', 'id' => 'price', 'type'=>'text'))?>
                                                                            </div>
                                                                        </div>
                                                                    <?endif?>
                                                                    <!-- file to be sent-->
                                                                    <?if(core::config('advertisement.upload_file') AND core::config('general.messaging') != TRUE):?>
                                                                        <div class="form-group">
                                                                            <?= FORM::label('file', _e('File'), array('class'=>'col-sm-2 control-label', 'for'=>'file'))?>
                                                                            <div class="col-md-6">
                                                                                <?= FORM::file('file', array('placeholder' => __('File'), 'class'=>'form-control', 'id' => 'file'))?>
                                                                            </div>
                                                                        </div>
                                                                    <?endif?>
                                                                    <?if (core::config('advertisement.captcha') != FALSE):?>
                                                                        <div class="form-group">
                                                                            <?=FORM::label('captcha', _e('Captcha'), array('class'=>'col-sm-2 control-label', 'for'=>'captcha'))?>
                                                                            <div class="col-md-4">
                                                                                <?if (Core::config('general.recaptcha_active')):?>
                                                                                    <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                                                                <?else:?>
                                                                                    <?=captcha::image_tag('contact')?><br />
                                                                                    <?= FORM::input('captcha', "", array('class'=>'form-control', 'id' => 'captcha', 'required'))?>
                                                                                <?endif?>
                                                                            </div>
                                                                        </div>
                                                                    <?endif?>
                                                                    <div class="modal-footer">
                                                                        <?= FORM::button(NULL, _e('Contact Us'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'user_contact' , 'id'=>$ad->id_ad))))?>
                                                                    </div>
                                                                </fieldset>
                                                            <?= FORM::close()?>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <?if (core::config('advertisement.phone')==1 AND strlen($ad->phone)>1):?>
                                            <div class="btn-group" role="group">
                                                <a class="primary-btn color-primary btn" href="tel:<?=$ad->phone?>">
                                                    <span class="glyphicon glyphicon-earphone"></span>&nbsp;&nbsp;
                                                    <?=_e('Phone').': '.$ad->phone?>
                                                </a>
                                            </div>
                                        <?endif?>
                                    <?endif?>
                                </div>
                  </div>
                        <div class="col-xs-12 col-sm-5 col-md-4">
                            <ul class="detaillist">
                                <?if ($ad->price>0):?>
                                <li class="price"><span class="primary-btn pricebtn price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span></li>
                                <?endif?>
                                <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                                <li class="price"><span class="primary-btn pricebtn"><?=_e('Free');?></span></li>
                                <?endif?>
                                <?if(core::config('advertisement.count_visits')==1):?>
                                <li><i class="fa fa-eye"></i><i><?=$hits?> <?=_e('Hits')?></i></li>
                                <?endif?>
                                <li><i class="fa fa-clock-o"></i><i><?=_e('Since')?> <?= Date::format($ad->published, core::config('general.date_format'))?></i></li>
                                <li><i class="fa fa-star"></i><i><?=_e('Posted by')?> <a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><?=$ad->user->name?> <?=$ad->user->is_verified_user()?></a></i></li>
                                <?if (core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()):?>
                                    <li><i class="fa fa-map-marker"></i> <i><?=$ad->location->translate_name() ?></i></li>
                                <?endif?>
                                <?if (Core::config('advertisement.reviews')==1):?>
                                    <li>
                                        <i>
                                            <?if ($ad->rate!==NULL):?>
                                                <a href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>" >
                                                    <?for ($i=0; $i < round($ad->rate,1); $i++):?>
                                                        <span class="glyphicon glyphicon-star"></span>
                                                    <?endfor?>
                                                </a>
                                            <?else:?>
                                                <a class="label label-success" href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>" >
                                                    <?=_e('Leave a review')?>
                                                </a>
                                            <?endif?>
                                        </i>
                                    </li>
                                <?endif?>
                                <?=$ad->btc()?>
                            </ul>
                            <?if(core::count($cf_list) > 0):?>
                                <h3><?=_e('Details')?></h3>
                                <ul class="detaillist">
                                    <?foreach ($cf_list as $name => $value):?>
                                        <?if($value=='checkbox_1'):?>
                                            <li><?=$name?> <i class="fa fa-check"></i></li>
                                        <?elseif($value=='checkbox_0'):?>
                                            <li><?=$name?> <i class="fa fa-times"></i></li>
                                        <?else:?>
                                            <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                                <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                                    <li><?=$name?>: <?=$value?></li>
                                                <?endif?>
                                            <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                                <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                                    <li><?=$name?>: <?=$value?></li>
                                                <?endif?>
                                            <?else:?>
                                                <?if(is_string($name)):?>
                                                    <li><?=$name?>: <?=$value?></li>
                                                <?else:?>
                                                    <li><?=$value?></li>
                                                <?endif?>
                                            <?endif?>
                                        <?endif?>
                                    <?endforeach?>
                                </ul>
                            <?endif?>
                            <?if ($ad->map() !== FALSE):?>
                                <h3><?=_e('Map')?></h3>
                                <form class="standard-frm findus-frm">
                                    <?=$ad->map()?>
                                </form>
                            <?endif?>
                        </div>
                        <div class="col-xs-12 share">
                            <?if(core::config('advertisement.sharing')==1):?>
                                <?=View::factory('share')?>
                                <div class="clearfix"></div><br>
                            <?endif?>

                            <?=$ad->qr()?>
                            <?=$ad->related()?>
                            <?=$ad->comments()?>
                            <?if(core::config('advertisement.report')==1):?>
                                <?=$ad->flagad()?>
                            <?endif?>
                            <?=$ad->structured_data()?>
                        </div>
                    </div>
                </article>
                <aside><?=View::fragment('sidebar_front','sidebar')?></aside>
            </div>
        </div>
    </section>
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
<?endif?>
