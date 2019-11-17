<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="container">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <?=Breadcrumbs::render('breadcrumbs')?>
            <div class="panel panel-default">
                <div class="panel-heading">
                    <img src="<?=$ad->user->get_profile_image()?>" class="profile img-thumbnail">
                    <a href="<?=Route::url('profile', array('seoname'=>$ad->user->seoname))?>">
                        <?if (isset($ad->user->cf_verified) AND $ad->user->cf_verified) :?>
                            <span class="text-verified"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                        <?endif?>
                        <?=$ad->user->name?>
                    </a>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-8">
                            <?if ($ad->status != Model_Ad::STATUS_PUBLISHED && $permission === FALSE && ($ad->id_user != $user)):?>

                                <div class="page-header">
                                    <h1><?=_e('This advertisement doesn´t exist, or is not yet published!')?></h1>
                                </div>

                            <?else:?>
                                <?=Form::errors()?>

                                <? if($ad->get_first_image()!== NULL): ?>
                                    <img class="img-responsive" src="<?=$ad->get_first_image('image')?>" alt="<?=HTML::chars($ad->title)?>">
                                    <br>
                                <? endif?>
                                <?$images = $ad->get_images()?>
                                <?if($images):?>
                                    <div class="row">
                                        <div class="col-md-9">
                                            <div class="row">
                                                <?foreach ($images as $path => $value):?>
                                                    <?if( isset($value['thumb']) AND isset($value['image']) ):?>
                                                        <div class="col-xs-4 col-sm-4 col-md-3">
                                                            <a href="<?= $value['image']?>" rel="gallery-1" class="thumbnail swipebox">
                                                                <img src="<?= $value['thumb']?>"  class="img-rounded" alt="">
                                                            </a>
                                                        </div>
                                                    <?endif?>
                                                <?endforeach?>
                                            </div>
                                        </div>
                                    </div>
                                <?endif?>
                                <div class="hidden-md hidden-lg">
                                    <h4 class="h5"><?=_e('Description')?></h4>
                                    <p><?= Text::bb2html($ad->description,TRUE)?></p>
                                </div>
                                <table class="table">
                                    <tr class="hidden-xs hidden-sm">
                                        <td class="text-muted"><?=_e('Description')?></td>
                                        <td><p><?= Text::bb2html($ad->description,TRUE)?></p></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><?=_e('Publish date')?></td>
                                        <td><?= Date::format($ad->published, core::config('general.date_format'))?></td>
                                    </tr>
                                    <tr>
                                        <td class="text-muted"><?=_e('Location')?></td>
                                        <td>
                                            <a href="<?=Route::url('list',array('location'=>$ad->location->seoname))?>" title="<?=HTML::chars($ad->location->translate_name())?>">
                                                <?=$ad->location->translate_name() ?>
                                            </a>
                                        </td>
                                    </tr>
                                    <?if (core::config('advertisement.address')
                                        AND $ad->address != ''
                                        AND $ad->address != 0):?>
                                        <tr>
                                            <td class="text-muted"><?=_e('Address')?></td>
                                            <td><?=$ad->address?></td>
                                        </tr>
                                    <?endif?>
                                    <?if(core::config('advertisement.count_visits')==1):?>
                                        <tr>
                                            <td class="text-muted"><?=_e('Visits')?></td>
                                            <td><?=$hits?> <?=_e('Hits')?></td>
                                        </tr>
                                    <?endif?>
                                    <?foreach ($cf_list as $name => $value):?>
                                        <?if($value=='checkbox_1'):?>
                                            <tr>
                                                <td class="text-muted"><?=$name?></td>
                                                <td><i class="fa fa-check"></i></td>
                                            </tr>
                                        <?elseif($value=='checkbox_0'):?>
                                            <tr>
                                                <td class="text-muted"><?=$name?></td>
                                                <td><i class="fa fa-times"></i></td>
                                            </tr>
                                        <?elseif(strtolower($name)=='modelo'):?>
                                            <tr>
                                                <td class="text-muted"><?=$name?></td>
                                                <td>
                                                    <a href="<?=Route::url('search')?>?cf_modelo=<?=$value?>&location=<?=$ad->location->seoname?>">
                                                        <?=$value?>
                                                    </a>
                                                </td>
                                            </tr>
                                        <?else:?>
                                            <tr>
                                                <td class="text-muted"><?=$name?></td>
                                                <td><?=$value?></td>
                                            </tr>
                                        <?endif?>
                                    <?endforeach?>
                                    <?if (Valid::url($ad->website) AND core::config('advertisement.website')==1):?>
                                        <tr>
                                            <td class="text-muted"><?=_e('Website')?></td>
                                            <td><a href="<?=$ad->website?>" rel="nofollow" target="_blank"><?=$ad->website?></a></td>
                                        </tr>
                                    <?endif?>
                                </table>

                                <br>

                                <?if(core::config('advertisement.sharing')==1):?>
                                    <hr>
                                    <?=View::factory('share')?>
                                <?endif?>
                                <?=$ad->qr()?>
                                <?if (core::config('advertisement.map')==1 AND $ad->latitude AND $ad->longitude):?>
                                    <hr>
                                    <?=$ad->map()?>
                                <?endif?>
                                <?=$ad->comments()?>

                                <!-- modal-gallery is the modal dialog used for the image gallery -->
                                <div class="modal fade" id="modal-gallery">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                                            </div>
                                            <div class="modal-body"><div class="modal-image"></div></div>
                                            <div class="modal-footer">
                                                <a class="btn btn-info modal-prev"><i class="glyphicon glyphicon-arrow-left glyphicon"></i> <?=__('Previous')?></a>
                                                <a class="btn btn-primary modal-next"><?=__('Next')?> <i class="glyphicon glyphicon-arrow-right glyphicon"></i></a>
                                                <a class="btn btn-success modal-play modal-slideshow" data-slideshow="5000"><i class="glyphicon glyphicon-play glyphicon"></i> <?=__('Slideshow')?></a>
                                                <a class="btn modal-download" target="_blank"><i class="glyphicon glyphicon-download"></i> <?=__('Download')?></a>
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
                            </div>
                            <div class="col-md-4">
                                <div class="single-contact-container">
                                    <div class="info">
                                        <h1>
                                            <?if (isset($ad->cf_verified) AND $ad->cf_verified) :?>
                                                <span class="text-verified"><i class="fa fa-check-circle-o" aria-hidden="true"></i></span>
                                            <?endif?>
                                            <?=$ad->title?>
                                        </h1>
                                        <?if ($ad->price>0):?>
                                            <p class="price-curry price"><?=i18n::money_format($ad->price, $ad->currency())?></p>
                                        <?endif?>
                                        <?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
                                            <p class="label label-danger"><?=_e('Free');?></p>
                                        <?endif?>
                                    </div>
                                    <?if ($ad->can_contact()):?>
                                        <?if ($ad->user->id_user != 15):?>
                                        <?if ((core::config('advertisement.login_to_contact') == TRUE OR core::config('general.messaging') == TRUE) AND !Auth::instance()->logged_in()) :?>
                                            <a class="btn btn-success btn-block" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                                <span class="text-uppercase"><?=_e('Send Message')?></span>
                                            </a>
                                        <?else :?>
                                            <button class="btn btn-success btn-block" type="button" data-toggle="modal" data-target="#contact-modal"><span class="text-uppercase"><?=_e('Send Message')?></span></button>
                                        <?endif?>
                                        <?endif?>

                                        <?if (core::config('advertisement.phone')==1 AND strlen($ad->phone)>1):?>
                                            <a class="btn btn-warning btn-block" href="tel:<?=$ad->phone?>">
                                                <span class="text-uppercase"><?=_e('Phone').': '.$ad->phone?></span>
                                            </a>
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

                                                        <?= FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'user_contact', 'id'=>$ad->id_ad)), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>
                                                            <fieldset>
                                                                <?if (!Auth::instance()->get_user()):?>
                                                                    <div class="form-group">
                                                                        <?= FORM::label('name', __('Name'), array('class'=>'col-sm-2 control-label', 'for'=>'name'))?>
                                                                        <div class="col-md-4 ">
                                                                            <?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class'=>'form-control', 'id' => 'name', 'required'))?>
                                                                        </div>
                                                                    </div>
                                                                    <div class="form-group">
                                                                        <?= FORM::label('email', __('Email'), array('class'=>'col-sm-2 control-label', 'for'=>'email'))?>
                                                                        <div class="col-md-4 ">
                                                                            <?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class'=>'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                                                                        </div>
                                                                    </div>
                                                                <?endif?>
                                                                <?if(core::config('general.messaging') != TRUE):?>
                                                                    <div class="form-group">
                                                                        <?= FORM::label('subject', __('Subject'), array('class'=>'col-sm-2 control-label', 'for'=>'subject'))?>
                                                                        <div class="col-md-4 ">
                                                                            <?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class'=>'form-control', 'id' => 'subject'))?>
                                                                        </div>
                                                                    </div>
                                                                <?endif?>
                                                                <div class="form-group">
                                                                    <?= FORM::label('message', __('Message'), array('class'=>'col-sm-2 control-label', 'for'=>'message'))?>
                                                                    <div class="col-md-6">
                                                                        <?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>2, 'required'))?>
                                                                    </div>
                                                                </div>
                                                                <?if(core::config('general.messaging')):?>
                                                                    <div class="form-group">
                                                                        <?= FORM::label('price', __('Price'), array('class'=>'col-sm-2 control-label', 'for'=>'price'))?>
                                                                        <div class="col-md-6">
                                                                            <?= FORM::input('price', Core::post('price'), array('placeholder' => html_entity_decode(i18n::money_format(1)), 'class' => 'form-control', 'id' => 'price', 'type'=>'text'))?>
                                                                        </div>
                                                                    </div>
                                                                <?endif?>
                                                                <!-- file to be sent-->
                                                                <?if(core::config('advertisement.upload_file') AND core::config('general.messaging') != TRUE):?>
                                                                    <div class="form-group">
                                                                        <?= FORM::label('file', __('File'), array('class'=>'col-sm-2 control-label', 'for'=>'file'))?>
                                                                        <div class="col-md-6">
                                                                            <?= FORM::file('file', array('placeholder' => __('File'), 'class'=>'form-control', 'id' => 'file'))?>
                                                                        </div>
                                                                    </div>
                                                                <?endif?>
                                                                <?if (core::config('advertisement.captcha') != FALSE):?>
                                                                    <div class="form-group">
                                                                        <?=FORM::label('captcha', __('Captcha'), array('class'=>'col-sm-2 control-label', 'for'=>'captcha'))?>
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
                                                                    <?= FORM::button(NULL, __('Contact Us'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'user_contact' , 'id'=>$ad->id_ad))))?>
                                                                </div>
                                                            </fieldset>
                                                        <?= FORM::close()?>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    <?endif?>
                                </div>
                                <div class="single-user-actions-container">
                                    <div class="info">
                                        <div class="favorite" id="fav-<?=$ad->id_ad?>">
                                            <?if (Auth::instance()->logged_in()):?>
                                                <?$fav = Model_Favorite::is_favorite(Auth::instance()->get_user(),$ad);?>
                                                <a data-id="fav-<?=$ad->id_ad?>" class="add-favorite btn btn-secondary btn-block <?=($fav)?'remove-favorite':''?>" title="<?=__('Add to Favorites')?>" href="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'favorites','id'=>$ad->id_ad))?>">
                                                    <i class="glyphicon glyphicon-heart<?=($fav)?'':'-empty'?>"></i> <?=_e('Add to Favorites')?>
                                                </a>
                                            <?else:?>
                                                <a class="btn btn-secondary btn-block" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                                                    <i class="glyphicon glyphicon-heart-empty"></i> <?=_e('Add to Favorites')?>
                                                </a>
                                            <?endif?>
                                        </div>
                                        <a class="btn btn-secondary btn-block mt-10" href="<?=Route::url('contact')?>?subject=<?=__('Report Ad')?> - <?=$ad->id_ad?> - <?=$ad->title?>&message=<?=__('Report Ad')?> - <?=$ad->id_ad?> - <?=$ad->title?> - <?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                            <span class="glyphicon glyphicon-exclamation-sign" aria-hidden="true"></span> <?=_e('Report this ad')?>
                                        </a>
                                        <?if (Core::config('advertisement.reviews')==1):?>
                                            <a class="btn btn-secondary btn-block mt-10" href="<?=Route::url('ad-review', array('seotitle'=>$ad->seotitle))?>">
                                                <span class="glyphicon glyphicon-star" aria-hidden="true"></span> <?=_e('Leave a review')?>
                                            </a>
                                        <?endif?>
                                        <!-- PAYPAL buttons to featured and to top -->
                                        <?if ((Auth::instance()->logged_in() AND Auth::instance()->get_user()->id_role == 10 ) OR
                                            (Auth::instance()->logged_in() AND $ad->user->id_user == Auth::instance()->get_user()->id_user)):?>
                                            <?if((core::config('payment.pay_to_go_on_top') > 0
                                                    && core::config('payment.to_top') != FALSE )
                                                    OR (core::config('payment.pay_to_go_on_feature') > 0
                                                    && core::config('payment.to_featured') != FALSE)):?>
                                                    <?if(core::config('payment.pay_to_go_on_top') > 0 && core::config('payment.to_top') != FALSE):?>
                                                        <a class="btn btn-secondary btn-block mt-10" type="button" href="<?=Route::url('default', array('action'=>'to_top','controller'=>'ad','id'=>$ad->id_ad))?>"><?=__('Go Top!')?></a>
                                                    <?endif?>
                                                    <?if(core::config('payment.to_featured') != FALSE AND $ad->featured < Date::unix2mysql()):?>
                                                        <a class="btn btn-secondary btn-block mt-10" type="button" href="<?=Route::url('default', array('action'=>'to_featured','controller'=>'ad','id'=>$ad->id_ad))?>"><?=__('Go Featured!')?></a>
                                                    <?endif?>
                                            <?endif?>
                                        <?endif?>
                                        <!-- end paypal button -->
                                        <?if((core::config('payment.paypal_seller')==1 OR Core::config('payment.stripe_connect')==1 OR Core::config('payment.escrow_pay')==1) AND $ad->price != NULL AND $ad->price > 0):?>
                                            <?if(core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1)):?>
                                                    <a class="btn btn-secondary btn-block mt-10" href="<?=Route::url('default', array('action'=>'buy','controller'=>'ad','id'=>$ad->id_ad))?>"><?=__('Buy Now')?></a>
                                            <?endif?>
                                        <?endif?>
                                    </div>
                                </div>
                                <?if (Core::config('advertisement.reviews')==1 AND $ad->rate!==NULL):?>
                                    <div class="single-user-status-container">
                                        <p><?=_e('Seller Rating')?></p>
                                        <hr>
                                        <p>
                                            <?for ($i=0; $i < round($ad->rate,1); $i++):?>
                                                <span class="glyphicon glyphicon-star"></span>
                                            <?endfor?>
                                        </p>
                                    </div>
                                <?endif?>

                                <?=$ad->btc()?>

                                <?if (core::count(Widgets::render('single')) > 0) :?>
                                    <div class="single-user-actions-container">
                                        <?foreach ( Widgets::render('single') as $widget):?>
                                            <div class="panel panel-default <?=get_class($widget->widget)?>">
                                                <?=$widget?>
                                            </div>
                                        <?endforeach?>
                                    </div>
                                <?endif?>
                            </div>
                        </div>
                    <?endif?>
                </div>
            </div>
            <div class="nav-center">
                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation" class="active"><a href="#similar" aria-controls="similar" role="tab" data-toggle="tab"><?=_e('Other ads from')?> <?=$ad->user->name?></a></li>
                    <li role="presentation"><a href="#related" aria-controls="related" role="tab" data-toggle="tab"><?=_e('Related Ads')?></a></li>
                </ul>
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="similar">
                        <?
                            $profile_ads = new Model_Ad();
                            $profile_ads->where('id_user', '=', $ad->user->id_user)
                                ->where('status', '=', Model_Ad::STATUS_PUBLISHED)
                                ->order_by('created','desc');
                            $profile_ads = $profile_ads->limit(core::config('advertisement.related'))->find_all();
                        ?>
                        <?if(core::count($profile_ads)):?>
                            <br>
                            <div class="row">
                                <?foreach($profile_ads as $ad):?>
                                    <div class="col-md-3">
                                        <div class="box-card box-item-card">
                                            <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                                                <div class="box-card-header">
                                                    <img src="<?=$ad->user->get_profile_image()?>" class="profile img-circle"> <?=($ad->user->id_user == 15 AND isset($ad->cf_milname))?$ad->cf_milname:$ad->user->name?>
                                                </div>
                                                <div class="box-card-images">
                                                    <?if($ad->get_first_image()!== NULL):?>
                                                        <img width="1067" height="1067" src="<?=$ad->get_first_image()?>" alt="<?=HTML::chars($ad->title)?>">
                                                    <?else:?>
                                                        <img width="1067" height="1067" data-src="holder.js/179x179?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 12, 'auto' => 'yes')))?>" alt="<?=HTML::chars($ad->title)?>">
                                                    <?endif?>
                                                </div>
                                                <div class="box-card-footer">
                                                    <div class="box-card-footer-title">
                                                        <div class="box-card-footer-title-wrapper">
                                                            <div class="headline"><h4><?=$ad->title?></h4></div>
                                                            <div class="excerpt">
                                                                <p>
                                                                    <?if ($ad->price!=0):?>
                                                                        <span class="price"><?=i18n::money_format( $ad->price, $ad->currency())?></span>
                                                                    <?endif?>
                                                                    <?=Text::truncate_html(Text::removebbcode($ad->description, TRUE), 255, NULL)?>
                                                                </p>
                                                                <?if(core::config('advertisement.location') AND $ad->id_location != 1 AND $ad->location->loaded()):?>
                                                                    <p><?=_e('Location')?>: <?=$ad->location->translate_name() ?></p>
                                                                <?endif?>
                                                                <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                                                    <?if($value=='checkbox_1'):?>
                                                                        <p><?=$name?>: <i class="fa fa-check"></i></p>
                                                                    <?elseif($value=='checkbox_0'):?>
                                                                        <p><?=$name?>: <i class="fa fa-times"></i></p>
                                                                    <?else:?>
                                                                        <?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                                                                            <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
                                                                                <p><?=$name?>: <?=$value?></p>
                                                                            <?endif?>
                                                                        <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                                                                            <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                                                                                <p><?=$name?>: <?=$value?></p>
                                                                            <?endif?>
                                                                        <?else:?>
                                                                            <?if(is_string($name)):?>
                                                                                <p><?=$name?>: <?=$value?></p>
                                                                            <?else:?>
                                                                                <p><?=$value?></p>
                                                                            <?endif?>
                                                                        <?endif?>
                                                                    <?endif?>
                                                                <?endforeach?>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                <?endforeach?>
                            </div>
                        <?endif?>
                    </div>
                    <div role="tabpanel" class="tab-pane" id="related">
                        <?=$ad->related()?>
                    </div>
                </div>
                <br>
            </div>
        </div>
    </div>
</div>
