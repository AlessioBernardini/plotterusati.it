<?php defined('SYSPATH') or die('No direct script access.');?>
<?if ($ad->status != Model_Ad::STATUS_PUBLISHED && $permission === FALSE && ($ad->id_user != $user)):?>
    <div class="page-header">
        <h1><?= _e('This advertisement doesn´t exist, or is not yet published!')?></h1>
    </div>
<?else:?>
    <?=Form::errors()?>

    <!-- PAYPAL buttons to featured and to top -->
    <?if ((Auth::instance()->logged_in() AND Auth::instance()->get_user()->id_role == 10 ) OR
        (Auth::instance()->logged_in() AND $ad->user->id_user == Auth::instance()->get_user()->id_user)):?>
        <?if((core::config('payment.pay_to_go_on_top') > 0
            AND core::config('payment.to_top') != FALSE )
            OR (core::config('payment.pay_to_go_on_feature') > 0
            AND core::config('payment.to_featured') != FALSE)):?>
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

    <h1>
        <?= $ad->title?>
        <span class="favorite" id="fav-<?=$ad->id_ad?>">
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
        </span>
    </h1>
    <?if (Core::config('advertisement.reviews')==1):?>
        <p>
            <a class="label label-success" href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>" >
                <?if ($ad->rate !== NULL):?>
                    <?for ($i=0; $i < round($ad->rate,1); $i++):?>
                        <span class="glyphicon glyphicon-star"></span>
                    <?endfor?>
                <?else:?>
                    <?=_e('Leave a review')?>
                <?endif?>
            </a>
        </p>
    <?endif?>

    <div class="row item-page">
        <div class="col-md-8">
            <?$images = $ad->get_images()?>

            <?if($images):?>
                <div class="row">
                    <div class="col-md-12" id="slider">
                        <div class="row">
                            <div class="col-md-12" id="carousel-bounding-box">
                                <div id="detailCarousel" class="carousel slide">
                                    <div class="carousel-inner">
                                        <?$i=0;foreach ($images as $path => $value):?>
                                            <?if( isset($value['thumb']) AND isset($value['image']) ):?>
                                                <div class="<?=($i==0)?'active':''?> item" data-slide-number="<?=$i?>">
                                                    <a href="<?=$value['image']?>" class="gallery-item" data-gallery>
                                                        <?=HTML::picture($value['image'], ['h' => 350], ['1200px' => ['h' => '350'],'992px' => ['h' => '300'], '768px' => ['h' => '310'], '480px' => ['h' => '300'], '320px' => ['h' => '190']], array('class' => 'img-responsive center-block', 'alt' => HTML::chars($ad->title)))?>
                                                    </a>
                                                </div>
                                            <?endif?>
                                        <?$i++;endforeach?>
                                    </div>
                                    <a class="carousel-control left" href="#detailCarousel" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                                    <a class="carousel-control right" href="#detailCarousel" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                                </div>
                            </div>
                            <div class="col-md-12 hidden-sm hidden-xs" id="slider-thumbs">
                                <ul class="list-inline">
                                    <?$i=0;foreach ($images as $path => $value):?>
                                        <?if( isset($value['thumb']) AND isset($value['image']) ):?>
                                            <li>
                                                <a id="carousel-selector-<?=$i?>" class="selected">
                                                    <img src="<?=Core::imagefly($value['image'],80,60)?>" alt="<?=HTML::chars($ad->title)?>">
                                                </a>
                                            </li>
                                        <?endif?>
                                    <?$i++;endforeach?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            <?else:?>
                <img data-src="holder.js/100px400?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14)))?>" class="img-responsive" alt="<?=HTML::chars($ad->title)?>">
            <?endif?>
        </div>

        <div class="col-md-4">
            <?if((core::config('payment.paypal_seller')==1 OR Core::config('payment.stripe_connect')==1 OR Core::config('payment.escrow_pay')==1) AND $ad->price != NULL AND $ad->price > 0):?>
                <?if(core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1)):?>
                    <?if($ad->status != Model_Ad::STATUS_SOLD):?>
                        <a class="btn btn-block btn-primary" href="<?=Route::url('default', array('action'=>'buy','controller'=>'ad','id'=>$ad->id_ad))?>"><?=_e('Buy Now')?></a>
                    <?else:?>
                        <a class="btn btn-block btn-primary disabled">
                            &nbsp;&nbsp;<?=_e('Sold')?>
                        </a>
                    <?endif?>
                    <hr>
                <?endif?>
            <?elseif (isset($ad->cf_file_download) AND !empty($ad->cf_file_download) AND  ( core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1))):?>
                <div class="" role="group">
                    <a class="btn btn-block btn-primary" type="button" href="<?=$ad->cf_file_download?>">
                        <i class="fa fa-download" aria-hidden="true"></i>
                        &nbsp;&nbsp;<?=_e('Download')?>
                    </a>
                </div>
            <?endif?>
            <table class="table table-condensed table-hover">
                <thead>
                    <th colspan="2"><?=_e('Details')?>:</th>
                </thead>
                <tbody style="font-size: 12px;">
                    <?if ($ad->price>0):?>
                        <tr>
                            <td><?=_e('Price')?></td>
                            <td><span class="price-curry"><?=i18n::money_format( $ad->price, $ad->currency())?></span></td>
                        </tr>
                    <?endif?>
                    <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                        <tr>
                            <td><?=_e('Price')?></td>
                            <td><?=_e('Free');?></td>
                        </tr>
                    <?endif?>
                    <tr>
                        <td><?=_e('Published')?></td>
                        <td><?= Date::format($ad->published, core::config('general.date_format'))?></td>
                    </tr>
                    <!-- custom fields display -->
                    <?foreach ($cf_list as $name => $value):?>
                        <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                            <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                <tr>
                                    <td><?=$name?></td>
                                    <td>
                                        <?=$value?>
                                    </td>
                                </tr>
                            <?endif?>
                        <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                            <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                <tr>
                                    <td><?=$name?></td>
                                    <td>
                                        <?if($value=='checkbox_1'):?>
                                            <i class="fa fa-check"></i>
                                        <?elseif($value=='checkbox_0'):?>
                                            <i class="fa fa-times"></i>
                                        <?else:?>
                                                <?=$value?>
                                        <?endif?>
                                    </td>
                                </tr>
                            <?endif?>
                        <?else:?>
                            <?if(is_string($name)):?>
                                <tr>
                                    <td><?=$name?></td>
                                    <td>
                                        <?if($value=='checkbox_1'):?>
                                            <i class="fa fa-check"></i>
                                        <?elseif($value=='checkbox_0'):?>
                                            <i class="fa fa-times"></i>
                                        <?else:?>
                                            <?=$value?>
                                        <?endif?>
                                    </td>
                                </tr>
                            <?else:?>
                                <tr>
                                    <td>
                                        <?=$value?>
                                    </td>
                                    <td></td>
                                </tr>
                            <?endif?>
                        <?endif?>
                    <?endforeach?>
                </tbody>
            </table>

            <div class="row">
                <div class="col-md-12">
                    <span style="padding-left: 5px;"><strong><?=_e('Publisher')?></strong></span>
                    <div class="well">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4><a href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><?=$ad->user->name?> <?=$ad->user->is_verified_user();?></a></h4>
                                <? if ($ad->id_location != 1 AND $ad->location->loaded()) : ?>
                                    <small><?=_e('Location')?>: <cite title="<?=HTML::chars($ad->location->translate_name())?>"><?=$ad->location->translate_name() ?></cite></small>
                                <?endif?>

                                <?if (core::config('advertisement.address') AND $ad->address != NULL):?>
                                    <br />
                                    <span class="glyphicon glyphicon-map-marker"></span>
                                    <?=$ad->address?>
                                <?endif?>

                                <?if (Valid::url($ad->website)):?>
                                    <br />
                                    <span class="glyphicon glyphicon-cloud"></span>
                                    <a href="<?=$ad->website?>" rel="nofollow" target="_blank"><?=$ad->website?></a>
                                <?endif?>

                                <?if (core::config('advertisement.phone')==1 AND strlen($ad->phone)>1):?>
                                    <br />
                                    <span class="glyphicon glyphicon-phone"></span>
                                    <a href="tel:<?=$ad->phone?>"><?=$ad->phone?></a>
                                <?endif?>

                                <?if(core::config('advertisement.count_visits')==1):?>
                                    <br />
                                    <span class="glyphicon glyphicon-eye-open"></span> <?=$hits?><br />
                                <?endif?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix"></div>
        <div class="col-md-12">
            <?if(core::config('advertisement.description')!=FALSE):?>
                <h4><?=_e('Description')?></h4>
                <div class="text-description"><?= Text::bb2html($ad->description,TRUE)?></div>
                <hr>
            <?endif?>
            <?=$ad->btc()?>
        </div>

        <div class="col-md-12">
            <?if ($ad->can_contact()):?>
                <?if ((core::config('advertisement.login_to_contact') == TRUE OR core::config('general.messaging') == TRUE) AND !Auth::instance()->logged_in()) :?>
                    <a class="btn btn-success" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                        <?=_e('Send Message')?>
                    </a>
                <?else:?>
                    <h4><?=_e('Send Message')?></h4>
                    <div class="panel panel-default">
                        <div class="panel-body">
                            <?= FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'user_contact', 'id'=>$ad->id_ad)), array('class'=>'', 'enctype'=>'multipart/form-data'))?>
                                <fieldset>
                                    <?if (!Auth::instance()->get_user()):?>
                                        <div class="form-group">
                                            <?= FORM::label('name', _e('Name'), array('class'=>'', 'for'=>'name'))?>
                                            <?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class'=>'form-control', 'id' => 'name', 'required'))?>
                                        </div>
                                        <div class="form-group">
                                            <?= FORM::label('email', _e('Email'), array('class'=>'', 'for'=>'email'))?>
                                            <?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class'=>'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                                        </div>
                                    <?endif?>
                                    <?if(core::config('general.messaging') != TRUE):?>
                                        <div class="form-group">
                                            <?= FORM::label('subject', _e('Subject'), array('class'=>'', 'for'=>'subject'))?>
                                            <?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class'=>'form-control', 'id' => 'subject'))?>
                                        </div>
                                    <?endif?>
                                    <div class="form-group">
                                        <?= FORM::label('message', _e('Message'), array('class'=>'', 'for'=>'message'))?>
                                        <?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>2, 'required'))?>
                                    </div>
                                    <?if(core::config('general.messaging') AND
                                        core::config('advertisement.price') AND
                                        core::config('advertisement.contact_price')):?>
                                        <div class="form-group">
                                            <?= FORM::label('price', _e('Price'), array('class'=>'', 'for'=>'price'))?>
                                            <?= FORM::input('price', "", array('placeholder' => html_entity_decode(i18n::money_format(1, $ad->currency())), 'class'=>'form-control', 'id' => 'price'))?>
                                        </div>
                                    <?endif?>
                                    <!-- file to be sent-->
                                    <?if(core::config('advertisement.upload_file') AND core::config('general.messaging') != TRUE):?>
                                        <div class="form-group">
                                            <?= FORM::label('file', _e('File'), array('class'=>'', 'for'=>'file'))?>
                                            <?= FORM::file('file', array('placeholder' => __('File'), 'class'=>'form-control', 'id' => 'file'))?>
                                        </div>
                                    <?endif?>
                                    <?if (core::config('advertisement.captcha') != FALSE):?>
                                        <div class="form-group">
                                            <?if (Core::config('general.recaptcha_active')):?>
                                                <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                            <?else:?>
                                                <?= FORM::label('captcha', _e('Captcha'), array('class'=>'', 'for'=>'captcha'))?><br>
                                                <?=captcha::image_tag('contact')?><br />
                                                <?= FORM::input('captcha', "", array('class'=>'form-control', 'id' => 'captcha', 'required'))?>
                                            <?endif?>
                                        </div>
                                    <?endif?>
                                    <div class="clearfix"></div><br>
                                    <?= FORM::button(NULL, _e('Send Message'), array('type'=>'submit', 'class'=>'btn btn-info', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'user_contact' , 'id'=>$ad->id_ad))))?>
                                </fieldset>
                            <?= FORM::close()?>
                        </div>
                    </div>
                <?endif?>
            <?endif?>
        </div>
    </div>

    <div class="clearfix"></div>

    <?if ($ad->map() !== FALSE):?>
        <?=$ad->map()?>
        <hr>
    <?endif?>

    <?if(core::config('advertisement.sharing')==1):?>
        <h4><?=_e('Share')?></h4>
        <?=View::factory('share')?>
        <hr>
    <?endif?>

    <?if ($ad->qr()) :?>
        <h4><?=_e('QR code')?></h4>
        <?=$ad->qr()?>
        <hr>
    <?endif?>

    <?=$ad->comments()?>
    <?=$ad->related()?>
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

<?endif?>
