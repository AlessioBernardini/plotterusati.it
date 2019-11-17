<?php defined('SYSPATH') or die('No direct script access.');?>
<? if ($ad->status != Model_Ad::STATUS_PUBLISHED && $permission === FALSE && ($ad->id_user != $user)):?>
    <div class="page-header">
        <h1><?=_e('This advertisement doesn´t exist, or is not yet published!')?></h1>
    </div>
<? else:?>
    <?=Form::errors()?>
    <div class="page-header">
        <? if ($ad->price!=0) : ?>
            <p class="pull-right title-price price-curry"><?=i18n::money_format($ad->price, $ad->currency())?></p>
        <? endif; ?>
        <? if ($ad->price==0 AND core::config('advertisement.free')==1) : ?>
            <p class="pull-right title-price"><?=_e('Free');?></p>
        <? endif; ?>
        <h1><?= $ad->title;?></h1>
        <?if (Core::config('advertisement.reviews')==1):?>
            <p class="pull-right favorite" id="fav-<?=$ad->id_ad?>">
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
            </p>
            <p>
                <a class="label label-success" href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>" >
                    <?if ($ad->rate!==NULL):?>
                        <?for ($i=0; $i < round($ad->rate,1); $i++):?>
                            <span class="glyphicon glyphicon-star"></span>
                        <?endfor?>
                    <?else:?>
                        <?=_e('Leave a review')?>
                    <?endif?>
                </a>
            </p>
        <?endif?>
        <? if ($ad->id_location != 1 AND $ad->location->loaded()) : ?>
            <?=_e('Location')?>:
            <a href="<?= Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=HTML::chars($ad->location->translate_name())?>">
                <?= $ad->location->translate_name() ?>
            </a>
        <? endif?>
    </div>
    <!-- PAYPAL buttons to featured and to top -->
    <? if ((Auth::instance()->logged_in() AND Auth::instance()->get_user()->id_role == 10 ) OR
        (Auth::instance()->logged_in() AND $ad->user->id_user == Auth::instance()->get_user()->id_user)):?>
        <? if((core::config('payment.pay_to_go_on_top') > 0
            && core::config('payment.to_top') != FALSE )
            OR (core::config('payment.pay_to_go_on_feature') > 0
            && core::config('payment.to_featured') != FALSE)):?>
            <div id="recomentadion" class="well recomentadion clearfix">
                <? if(core::config('payment.pay_to_go_on_top') > 0 && core::config('payment.to_top') != FALSE):?>
                    <p class="text-info"><?=_e('Your Advertisement can go on top again! For only ').i18n::format_currency(core::config('payment.pay_to_go_on_top'),core::config('payment.paypal_currency'));?></p>
                    <a class="btn btn-xs btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_top','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Top!')?></a>
                <? endif?>
                <? if(core::config('payment.pay_to_go_on_feature') > 0 && core::config('payment.to_featured') != FALSE):?>
                    <p class="text-info"><?=_e('Your Advertisement can go to featured! For only ').i18n::format_currency(Model_Order::get_featured_price(),core::config('payment.paypal_currency'));?></p>
                    <a class="btn btn-xs btn-primary" type="button" href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Go Featured!')?></a>
                <? endif?>
            </div>
        <? endif?>
    <? endif?>
    <!-- end paypal button -->
    <? $images = $ad->get_images()?>
    <? if($images):?>
        <div class="row">
            <div class="col-sm-7">
                <? if($ad->get_first_image()!== NULL): ?>
                	<a href="<?= $ad->get_first_image('image')?>" class="thumbnail gallery-item" data-gallery>
                    	<?=HTML::picture($ad->get_first_image('image'), array('w' => 529), array('1200px' => array('w' => '529'), '992px' => array('w' => '529'), '768px' => array('w' => '406'), '480px' => array('w' => '460'), '320px' => array('w' => '257')), array('alt' => HTML::chars($ad->title), 'class' => 'img-responsive center-block'))?>
                    </a>
                <? endif?>
            </div>
            <div class="col-sm-5">
                <div id="gallery" class="row">
                    <? $i=0;foreach (array_slice($images,1) as $path => $value):?>
                        <? if( isset($value['thumb']) AND isset($value['image']) ):?>
                            <div class="col-xs-6" style="margin-bottom: 10px;">
                                <a href="<?= $value['image']?>" class="thumbnail gallery-item" data-gallery>
                                    <?=HTML::picture($value['image'], array('w' => 250, 'h' => 250), array('1200px' => array('w' => '250', 'h' => '250'), '992px' => array('w' => '160', 'h' => '160'), '768px' => array('w' => '115', 'h' => '115'), '480px' => array('w' => '200', 'h' => '200'), '320px' => array('w' => '200', 'h' => '200')), array('alt' => HTML::chars($ad->title), 'class' => 'img-responsive center-block'))?>
                                </a>
                            </div>
                        <? endif?>
                    <? $i++;endforeach?>
                </div>
            </div>
        </div>
    <? endif?>
    <div class="row">
        <div class="col-sm-12">
            <h2 class="listings-title"><span><?=_e('Details')?></span></h2>
            <table class="table table-condensed">
                <tbody>
                    <tr>
                        <td><strong><?=_e('Publisher')?></strong></td>
                        <td><a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><?=$ad->user->name?> <?=$ad->user->is_verified_user();?></a></td>
                    </tr>
                    <tr>
                        <td><strong><?=_e('Published')?></strong></td>
                        <td><?= Date::format($ad->published, core::config('general.date_format'))?></td>
                    </tr>
                    <? if (core::config('advertisement.phone')==1 AND strlen($ad->phone)>1): ?>
                        <tr>
                            <td><strong><span class="glyphicon glyphicon-phone"></span></strong></td>
                            <td><a href="tel:<?=$ad->phone?>"><?=$ad->phone?></a></td>
                        </tr>
                    <? endif; ?>
                    <?if (Valid::url($ad->website)):?>
                        <tr>
                            <td><strong><span class="glyphicon glyphicon-cloud"></span></strong></td>
                            <td><a href="<?=$ad->website?>" rel="nofollow" target="_blank"><?=$ad->website?></a></td>
                        </tr>
                    <?endif?>
                    <?if (core::config('advertisement.address') AND $ad->address != NULL):?>
                        <tr>
                            <td><strong><span class="glyphicon glyphicon-map-marker"></span></strong></td>
                            <td><?=$ad->address?></td>
                        </tr>
                    <?endif?>
                    <?if(core::config('advertisement.count_visits')==1):?>
                        <tr>
                            <td><strong><span class="glyphicon glyphicon-eye-open"></span></strong></td>
                            <td><?=$hits?></td>
                        </tr>
                    <?endif?>
                    <?foreach ($cf_list as $name => $value):?>
                        <?if($value=='checkbox_1'):?>
                            <tr>
                                <td><strong><?=$name?></strong></td>
                                <td><i class="fa fa-check"></i></td>
                            </tr>
                        <?elseif($value=='checkbox_0'):?>
                            <tr>
                                <td><strong><?=$name?></strong></td>
                                <td><i class="fa fa-times"></i></td>
                            </tr>
                        <?else:?>
                            <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                    <tr>
                                        <td><strong><?=$name?></strong></td>
                                        <td><?=$value?></td>
                                    </tr>
                                <?endif?>
                            <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                    <tr>
                                        <td><strong><?=$name?></strong></td>
                                        <td><?=$value?></td>
                                    </tr>
                                <?endif?>
                            <?else:?>
                                <?if(is_string($name)):?>
                                    <tr>
                                        <td><strong><?=$name?></strong></td>
                                        <td><?=$value?></td>
                                    </tr>
                                <?else:?>
                                    <tr>
                                        <td><?=$value?></td>
                                        <td></td>
                                    </tr>
                                <?endif?>
                            <?endif?>
                        <?endif?>
                    <?endforeach?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="row">
        <div class="col-md-12">
            <h2 class="listings-title"><span><?=_e('Description')?></span></h2>
            <?if(core::config('advertisement.description')!=FALSE):?>
                <p><?= Text::bb2html($ad->description,TRUE)?></p>
            <?endif?>
            <?=$ad->btc()?>
        </div>
    </div>
    <div class="btn-group btn-group-justified" role="group">
        <?if((core::config('payment.paypal_seller')==1 OR Core::config('payment.stripe_connect')==1 OR Core::config('payment.escrow_pay')==1) AND $ad->price != NULL AND $ad->price > 0):?>
            <?if(core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1)):?>
                <div class="btn-group" role="group">
                    <?if($ad->status != Model_Ad::STATUS_SOLD):?>
                        <a class="btn btn-primary" href="<?=Route::url('default', array('action'=>'buy','controller'=>'ad','id'=>$ad->id_ad))?>">
                            <i class="fa fa-money" aria-hidden="true"></i>
                            &nbsp;&nbsp;<?=_e('Buy Now')?>
                        </a>
                    <?else:?>
                        <a class="btn btn-primary disabled">
                            <i class="fa fa-money" aria-hidden="true"></i>
                            &nbsp;&nbsp;<?=_e('Sold')?>
                        </a>
                    <?endif?>
                </div>
            <?endif?>
        <?elseif (isset($ad->cf_file_download) AND !empty($ad->cf_file_download) AND  ( core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1))):?>
            <div class="btn-group" role="group">
                <a class="btn btn-primary" type="button" href="<?=$ad->cf_file_download?>">
                    <i class="fa fa-download" aria-hidden="true"></i>
                    &nbsp;&nbsp;<?=_e('Download')?>
                </a>
            </div>
        <?endif?>
        <?if ($ad->can_contact()):?>
            <div class="btn-group" role="group">
                <?if ((core::config('advertisement.login_to_contact') == TRUE OR core::config('general.messaging') == TRUE) AND !Auth::instance()->logged_in()) :?>
                    <a class="btn btn-success" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                        <i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;<?=_e('Send Message')?>
                    </a>
                <?else :?>
                    <button class="btn btn-success" type="button" data-toggle="modal" data-target="#contact-modal"><i class="glyphicon glyphicon-envelope"></i>&nbsp;&nbsp;<?=_e('Send Message')?></button>
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
                    <a class="btn btn-warning" href="tel:<?=$ad->phone?>">
                        <span class="glyphicon glyphicon-earphone"></span>&nbsp;&nbsp;
                        <?=_e('Phone').': '.$ad->phone?>
                    </a>
                </div>
            <?endif?>
        <?endif?>
    </div>
    <hr>
    <?if(core::config('advertisement.sharing')==1):?>
        <?=View::factory('share')?>
        <hr>
    <?endif?>
    <?=$ad->qr()?>
    <?=$ad->map()?>
    <?=$ad->related()?>
    <br>
    <?=$ad->comments()?>
    <br>
    <?if(core::config('advertisement.report')==1):?>
        <?=$ad->flagad()?>
    <?endif?>
    <?=$ad->structured_data()?>



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
    <div id="blueimp-gallery" class="blueimp-gallery blueimp-gallery-controls">
        <div class="slides"></div>
        <h3 class="title"></h3>
        <a class="prev">‹</a>
        <a class="next">›</a>
        <a class="close">×</a>
        <a class="play-pause"></a>
        <ol class="indicator"></ol>
    </div>
<? endif?>
