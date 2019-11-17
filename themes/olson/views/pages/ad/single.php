<?php defined('SYSPATH') or die('No direct script access.');?>

<?if ($ad->status != Model_Ad::STATUS_PUBLISHED && $permission === FALSE && ($ad->id_user != $user)):?>
    <div class="page-title">
       <h1><?= _e('This advertisement doesn´t exist, or is not yet published!')?></h1>
    </div>
<?else:?>
    <?=Form::errors()?>

    <div class="page-title">
        <div class="pull-right favorite" id="fav-<?=$ad->id_ad?>">
            <?if (Auth::instance()->logged_in()):?>
                <?$fav = Model_Favorite::is_favorite(Auth::instance()->get_user(),$ad);?>
                <a data-id="fav-<?=$ad->id_ad?>" class="add-favorite <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                    <i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i>
                </a>
            <?else:?>
                <a data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                    <i class="glyphicon glyphicon-heart-empty"></i>
                </a>
            <?endif?>
        </div>
        <h1><?=$ad->title?></h1>
        <?if (Core::config('advertisement.reviews')==1):?>
            <li>
                <?if ($ad->rate!==NULL):?>
                    <a href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>">
                        <?for ($i=0; $i < round($ad->rate,1); $i++):?>
                            <span class="glyphicon glyphicon-star"></span>
                        <?endfor?>
                    </a>
                <?else:?>
                    <a class="btn btn-sm btn-success" href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>">
                        <strong><?=_e('Leave a review')?></strong>
                    </a>
                <?endif?>
            </li>
        <?endif?>
        <hr>
    </div>

    <!-- PAYPAL buttons to featured and to top -->
    <?if ((Auth::instance()->logged_in() AND Auth::instance()->get_user()->id_role == 10 ) OR
        (Auth::instance()->logged_in() AND $ad->user->id_user == Auth::instance()->get_user()->id_user)):?>
        <?if((core::config('payment.pay_to_go_on_top') > 0
            && core::config('payment.to_top') != FALSE )
            OR (core::config('payment.pay_to_go_on_feature') > 0
            && core::config('payment.to_featured') != FALSE)):?>
            <?if (core::config('payment.pay_to_go_on_top') > 0 && core::config('payment.to_top') != FALSE):?>
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="<?=__('Close')?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p>
                        <strong><?=_e('Your Advertisement can go on top again! For only ').i18n::format_currency(core::config('payment.pay_to_go_on_top'),core::config('payment.paypal_currency'));?></strong>
                    </p>
                    <p>
                        <a class="btn btn-sm btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_top','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Top!')?></a>
                    </p>
                </div>
            <?endif?>
            <?if (core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql()):?>
                <div class="alert alert-info" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="<?=__('Close')?>">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <p>
                        <strong><?=_e('Your Advertisement can go to featured! For only ').i18n::format_currency(Model_Order::get_featured_price(),core::config('payment.paypal_currency'));?></strong>
                    </p>
                    <p>
                        <a class="btn btn-sm btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Featured!')?></a>
                    </p>
                </div>
            <?endif?>
        <?endif?>
    <?endif?>
    <!-- end paypal button -->

    <div class="single-item">
        <div class="row">
            <?if ($images = $ad->get_images()):?>
                <div class="col-md-5 col-xs-6">
                    <?if ($ad->get_first_image()!== NULL) : ?>
                        <a href="<?=$ad->get_first_image('image')?>" class="thumbnail" data-gallery>
                            <?=HTML::picture($ad->get_first_image('image'), array('w' => 288), array('1200px' => array('w' => '288'), '992px' => array('w' => '263'), '768px' => array('w' => '335'), '480px' => array('w' => '337'), '320px' => array('w' => '200')), array('alt' => HTML::chars($ad->title), 'class' => 'img-responsive center-block'))?>
                        </a>
                    <?endif?>
                    <div class="row">
                        <?foreach (array_slice($images,1) as $path => $value):?>
                            <?if( isset($value['thumb']) AND isset($value['image']) ):?>
                                <div class="col-sm-6 col-md-4">
                                    <a href="<?=$value['image']?>" class="thumbnail" data-gallery>
                                        <?=HTML::picture($value['thumb'], array('w' => 61, 'h' => 61), array('1200px' => array('w' => '70', 'h' => '70'), '992px' => array('w' => '61', 'h' => '61'), '768px' => array('w' => '140', 'h' => '140'), '480px' => array('w' => '70', 'h' => '70'), '320px' => array('w' => '61', 'h' => '61')), array('alt' => HTML::chars($ad->title), 'class' => 'center-block single-image img-responsive'))?>
                                    </a>
                                </div>
                            <?endif?>
                        <?endforeach?>
                    </div>
                </div>
            <?endif?>
            <div class="<?=$ad->get_images() ? 'col-md-7 col-xs-6': 'col-md-12 col-xs-12'?>">
                <h4><?=$ad->title?></h4>
                <?if ($ad->price>0):?>
                    <h5><strong><?=_e('Price')?> : <span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span></strong></h5>
                <?endif?>
                <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                    <h5><strong><?=_e('Price')?> : <?=_e('Free');?></strong></h5>
                <?endif?>
                <p>
                    <strong><?=_e('Posted by')?> :</strong>
                    <a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><i class="icon-user"></i> <?=$ad->user->name?> <?=$ad->user->is_verified_user();?></a>
                </p>
                <p>
                    <strong><?=_e('Posted on')?> :</strong>
                    <?= Date::format($ad->published, core::config('general.date_format'))?>
                </p>

                <?if (core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()):?>
                    <p>
                        <strong><?=_e('Location')?> :</strong>
                        <?=$ad->location->translate_name() ?>
                    </p>
                <?endif?>
                <?if (core::config('advertisement.address') AND $ad->address != NULL):?>
                    <p>
                        <strong><?=_e('Address')?> :</strong>
                        <?=$ad->address?>
                    </p>
                <?endif?>
                <?if(core::config('advertisement.count_visits')==1):?>
                    <p>
                        <strong><?=_e('Hits')?> :</strong>
                        <?=$hits?>
                    </p>
                <?endif?>
                <?if (Valid::url($ad->website)):?>
                    <p>
                        <strong><?=_e('Website')?> :</strong>
                        <a href="<?=$ad->website?>" rel="nofollow" target="_blank"><?=$ad->website?></a>
                    </p>
                <?endif?>
                <?if ($ad->can_contact() AND core::config('advertisement.phone')==1 AND strlen($ad->phone)>1):?>
                    <p>
                        <strong><?=_e('Phone')?> :</strong>
                        <a href="tel:<?=$ad->phone?>"><?=$ad->phone?></a>
                    </p>
                <?endif?>
                <br>
                <ul class="list-inline">
                    <?if ($ad->can_contact()):?>
                        <li>
                            <?if ((core::config('advertisement.login_to_contact') == TRUE OR core::config('general.messaging') == TRUE) AND !Auth::instance()->logged_in()) :?>
                                <a class="btn btn-sm btn-success" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                    <i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;<strong><?=_e('Send Message')?></strong>
                                </a>
                            <?else :?>
                                <button class="btn btn-sm btn-success" type="button" data-toggle="modal" data-target="#contact-modal">
                                    <i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;<strong><?=_e('Send Message')?></strong>
                                </button>
                            <?endif?>
                        </li>
                    <?endif?>
                    <?if((core::config('payment.paypal_seller')==1 OR Core::config('payment.stripe_connect')==1 OR Core::config('payment.escrow_pay')==1) AND $ad->price != NULL AND $ad->price > 0):?>
                        <?if(core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1)):?>
                            <li>
                                <?if($ad->status != Model_Ad::STATUS_SOLD):?>
                                    <a class="btn btn-sm btn-primary" href="<?=Route::url('default', array('action'=>'buy','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Buy Now')?></a>
                                <?else:?>
                                    <a class="btn btn-sm btn-primary disabled"><?=_e('Sold')?></a>
                                <?endif?>
                            </li>
                        <?endif?>
                    <?elseif (isset($ad->cf_file_download) AND !empty($ad->cf_file_download) AND  ( core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1))):?>
                        <div class="btn-group" role="group">
                            <a class="btn btn-sm btn-primary" type="button" href="<?=$ad->cf_file_download?>">
                                <i class="fa fa-download" aria-hidden="true"></i>
                                &nbsp;&nbsp;<?=_e('Download')?>
                            </a>
                        </div>
                    <?endif?>
                </ul>
                <?if(core::config('advertisement.sharing')==1):?>
                    <p><?=View::factory('share')?></p>
                <?endif?>
            </div>
        </div>
    </div>

    <br>

    <ul class="nav nav-tabs" id="myTab">
        <li class="active"><a data-toggle="tab" href="#tab1" aria-expanded="true"><?=_e('Description')?></a></li>
        <?if (core::count($cf_list) > 0) :?>
            <li class=""><a data-toggle="tab" href="#tab2" aria-expanded="false"><?=_e('Details')?></a></li>
        <?endif?>
        <?if (core::config('advertisement.map')==1 AND $ad->latitude AND $ad->longitude):?>
            <li class=""><a data-toggle="tab" href="#tab3" aria-expanded="false"><?=_e('Map')?></a></li>
        <?endif?>
        <?if (core::config('advertisement.qr_code')==1) :?>
            <li class=""><a data-toggle="tab" href="#tab4" aria-expanded="false"><?=_e('QR code')?></a></li>
        <?endif?>
    </ul>
    <div class="tab-content" id="myTabContent">
        <!-- Description -->
        <div id="tab1" class="tab-pane fade active in">
            <h5><strong><?=$ad->title?></strong></h5>
            <?if(core::config('advertisement.description')!=FALSE):?>
                <p><?=Text::bb2html($ad->description,TRUE)?></p>
            <?endif?>
            <?=$ad->btc()?>
        </div>
        <?if (core::count($cf_list) > 0) :?>
            <!-- Custom Fields -->
            <div id="tab2" class="tab-pane fade">
                <table class="table table-striped">
                    <tbody>
                        <?foreach ($cf_list as $name => $value):?>
                            <?if($value=='checkbox_1'):?>
                                <tr><td><strong><?=$name?></strong></td>
                                <td><i class="fa fa-check"></i></td></tr>
                            <?elseif($value=='checkbox_0'):?>
                                <tr><td><strong><?=$name?></strong></td>
                                <td><i class="fa fa-times"></i></td></tr>
                            <?else:?>
                                <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                    <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                        <tr><td><strong><?=$name?></strong></td>
                                        <td><?=$value?></td></tr>
                                    <?endif?>
                                <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                    <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                        <tr><td><strong><?=$name?></strong></td>
                                        <td><?=$value?></td></tr>
                                    <?endif?>
                                <?else:?>
                                    <?if(is_string($name)):?>
                                        <tr><td><strong><?=$name?></strong></td>
                                        <td><?=$value?></td></tr>
                                    <?else:?>
                                        <tr><td><?=$value?></td>
                                        <td></td></tr>
                                    <?endif?>
                                <?endif?>
                            <?endif?>
                        <?endforeach?>
                    </tbody>
                </table>
            </div>
        <?endif?>
        <?if ($ad->map() !== FALSE):?>
            <div id="tab3" class="tab-pane fade">
                <?=$ad->map()?>
            </div>
        <?endif?>
        <?if (core::config('advertisement.qr_code')==1) :?>
            <div id="tab4" class="tab-pane fade">
                <br>
                <?=$ad->qr()?>
            </div>
        <?endif?>
    </div>

    <?=$ad->comments()?>
    <?=$ad->related()?>
    <?if(core::config('advertisement.report')==1):?>
        <?=$ad->flagad()?>
    <?endif?>
    <?=$ad->structured_data()?>

    <?if ($ad->can_contact()):?>
        <div class="modal fade" id="contact-modal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title"><?=_e('Contact')?></h4>
                    </div>
                    <div class="modal-body">
                        <?=Form::errors()?>

                        <?= FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'user_contact', 'id'=>$ad->id_ad)), array('class'=>'form-horizontal ', 'enctype'=>'multipart/form-data'))?>
                        <fieldset>
                            <?if (!Auth::instance()->get_user()):?>
                                <div class="form-group">
                                    <?= FORM::label('name', _e('Name'), array('class'=>'col-sm-2 control-label', 'for'=>'name'))?>
                                    <div class="col-md-5">
                                        <?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class'=>'form-control', 'id' => 'name', 'required'))?>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <?= FORM::label('email', _e('Email'), array('class'=>'col-sm-2 control-label', 'for'=>'email'))?>
                                    <div class="col-md-5">
                                        <?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class'=>'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                                    </div>
                                </div>
                            <?endif?>
                            <?if(core::config('general.messaging') != TRUE):?>
                                <div class="form-group">
                                    <?= FORM::label('subject', _e('Subject'), array('class'=>'col-sm-2 control-label', 'for'=>'subject'))?>
                                    <div class="col-md-5">
                                        <?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class'=>'form-control', 'id' => 'subject'))?>
                                    </div>
                                </div>
                            <?endif?>
                            <div class="form-group">
                                <?= FORM::label('message', _e('Message'), array('class'=>'col-sm-2 control-label', 'for'=>'message'))?>
                                <div class="col-md-5">
                                    <?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>2, 'required'))?>
                                </div>
                            </div>
                            <?if(core::config('general.messaging') AND
                                core::config('advertisement.price') AND
                                core::config('advertisement.contact_price')):?>
                                <div class="form-group">
                                    <?= FORM::label('price', _e('Price'), array('class'=>'col-sm-2 control-label', 'for'=>'price'))?>
                                    <div class="col-md-5">
                                        <?= FORM::input('price', Core::post('price'), array('placeholder' => html_entity_decode(i18n::money_format(1, $ad->currency())), 'class' => 'form-control', 'id' => 'price', 'type'=>'text'))?>
                                    </div>
                                </div>
                            <?endif?>
                            <!-- file to be sent-->
                            <?if(core::config('advertisement.upload_file') AND core::config('general.messaging') != TRUE):?>
                                <div class="form-group">
                                    <?= FORM::label('file', _e('File'), array('class'=>'col-sm-2 control-label', 'for'=>'file'))?>
                                    <div class="col-md-5">
                                        <?= FORM::file('file', array('placeholder' => __('File'), 'class'=>'form-control', 'id' => 'file'))?>
                                    </div>
                                </div>
                            <?endif?>
                            <?if (core::config('advertisement.captcha') != FALSE):?>
                            <div class="form-group">
                                <?=FORM::label('captcha', _e('Captcha'), array('class'=>'col-sm-2 control-label', 'for'=>'captcha'))?>
                                <div class="col-md-5">
                                    <?if (Core::config('general.recaptcha_active')):?>
                                        <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                    <?else:?>
                                        <?=captcha::image_tag('contact')?><br />
                                        <?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required'))?>
                                    <?endif?>
                                </div>
                            </div>
                            <?endif?>

                            <div class="modal-footer">
                                <?= FORM::button(NULL, _e('Send Message'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'user_contact' , 'id'=>$ad->id_ad))))?>
                            </div>
                        </fieldset>
                        <?= FORM::close()?>
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div><!-- /.modal -->
    <?endif?>
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
