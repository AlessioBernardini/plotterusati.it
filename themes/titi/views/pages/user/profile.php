<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h3><?=_e('User Profile')?></h3>
</div>

<div class="row">
    <div class="col-xs-3">
        <a class="thumbnail">
            <picture>
                <?=HTML::picture($user->get_profile_image(), array('w' => 142, 'h' => 142), array('1200px' => array('w' => '179', 'h' => '179'), '992px' => array('w' => '142', 'h' => '142'), '768px' => array('w' => '205', 'h' => '205'), '480px' => array('w' => '152', 'h' => '152'), '320px' => array('w' => '80', 'h' => '80')), array('class' => 'img-thumbnail img-responsive', 'alt' => __('Profile Picture')))?>
            </picture>
        </a>
    </div>
    <div class="col-xs-9">
        <h3><?=$user->name?> <?=$user->is_verified_user()?></h3>
        <ul class="list-unstyled">
            <?if (Core::config('advertisement.reviews')==1):?>
                <? if ($user->rate !== NULL) : ?>
                    <li>
                         <a href="<?= Route::url('user-reviews', ['seoname' => $user->seoname]) ?>">
                            <? for ($i=0; $i < round($user->rate,1); $i++) : ?>
                                <span class="glyphicon glyphicon-star"></span>
                            <? endfor ?>
                        </a>
                    </li>
                <? endif ?>
            <?endif?>
            <li><strong><?=_e('Created')?>:</strong> <?= Date::format($user->created, core::config('general.date_format')) ?></li>
            <?if ($user->last_login!=NULL):?>
            <li><strong><?=_e('Last Login')?>:</strong> <?= Date::format($user->last_login, core::config('general.date_format'))?></li>
            <?endif?>
            <?if (Theme::get('premium')==1):?>
                <?foreach ($user->custom_columns(TRUE) as $name => $value):?>
                	<?if($value!=''):?>
                        <?if($name!='whatsapp' AND $name!='skype' AND $name!='telegram'):?>
        	            	<li>
        	                    <strong><?=$name?>:</strong>
        	                    <?if($value=='checkbox_1'):?>
        	                        <i class="fa fa-check"></i>
        	                    <?elseif($value=='checkbox_0'):?>
        	                        <i class="fa fa-times"></i>
        	                    <?else:?>
        	                        <?=$value?>
        	                    <?endif?>
        	            	</li>
                        <?endif?>
    	            <?endif?>
                <?endforeach?>
            <?endif?>
            <?if (Theme::get('premium')==1):?>
                <?if(isset($user->cf_whatsapp) AND strlen($user->cf_whatsapp) > 6):?>
                    <li><a href="https://api.whatsapp.com/send?phone=<?=$user->cf_whatsapp?>" title="Chat with <?=$user->name?>" alt="Whatsapp"><i class="fa fa-2x fa-whatsapp" style="color:#43d854"></i></a></li>
                <?endif?>
                <?if(isset($user->cf_skype) AND $user->cf_skype!=''):?>
                    <li><a href="skype:<?=$user->cf_skype?>?chat" title="Chat with <?=$user->name?>" alt="Skype"><i class="fa fa-2x fa-skype" style="color:#00aff0"></i></a></li>
                <?endif?>
                <?if(isset($user->cf_telegram) AND $user->cf_telegram!=''):?>
                    <li><a href="tg://resolve?domain=<?=$user->cf_telegram?>" id="telegram" title="Chat with <?=$user->name?>" alt="Telegram"><i class="fa fa-2x fa-telegram" style="color:#0088cc"></i></a></li>
                <?endif?>
            <?endif?>
        </ul>
        <div class="clearfix">&nbsp;</div>
        <!-- Popup contact form -->
        <?if (core::config('general.messaging') == TRUE AND !Auth::instance()->logged_in()) :?>
            <a class="btn btn-success" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                <i class="glyphicon glyphicon-envelope"></i>
                <?=_e('Send Message')?>
            </a>
        <?else :?>
            <button class="btn btn-success" type="button" data-toggle="modal" data-target="#contact-modal"><i class="glyphicon glyphicon-envelope"></i> <?=_e('Send Message')?></button>
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

                        <?= FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'userprofile_contact', 'id'=>$user->id_user)), array('class'=>'form-horizontal well', 'enctype'=>'multipart/form-data'))?>
                            <fieldset>
                                <?if (!Auth::instance()->get_user()):?>
                                    <div class="form-group">
                                        <?= FORM::label('name', __('Name'), array('class'=>'col-md-2 control-label', 'for'=>'name'))?>
                                        <div class="col-md-4 ">
                                            <?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => 'form-control', 'id' => 'name', 'required'))?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?= FORM::label('email', __('Email'), array('class'=>'col-md-2 control-label', 'for'=>'email'))?>
                                        <div class="col-md-4 ">
                                            <?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => 'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                                        </div>
                                    </div>
                                <?endif?>
                                <?if(core::config('general.messaging') != TRUE):?>
                                    <div class="form-group">
                                        <?= FORM::label('subject', __('Subject'), array('class'=>'col-md-2 control-label', 'for'=>'subject'))?>
                                        <div class="col-md-4 ">
                                            <?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => 'form-control', 'id' => 'subject'))?>
                                        </div>
                                    </div>
                                <?endif?>
                                <div class="form-group">
                                    <?= FORM::label('message', __('Message'), array('class'=>'col-md-2 control-label', 'for'=>'message'))?>
                                    <div class="col-md-6">
                                        <?= FORM::textarea('message', Core::post('subject'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>2, 'required'))?>
                                        </div>
                                </div>
                                <?if (core::config('advertisement.captcha') != FALSE):?>
                                    <div class="form-group">
                                        <?= FORM::label('captcha', __('Captcha'), array('class'=>'col-md-2 control-label', 'for'=>'captcha'))?>
                                        <div class="col-md-4">
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
                                    <?= FORM::button(NULL, __('Send Message'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'userprofile_contact' , 'id'=>$user->id_user))))?>
                                </div>
                            </fieldset>
                        <?= FORM::close()?>
                    </div>
                </div>
            </div>
        </div>
        <div class="clearfix">&nbsp;</div>
        <?if (Theme::get('premium')==1):?>
            <p>
                <?if(isset($user->cf_skype) AND $user->cf_skype!=''):?>
                    <a href="skype:<?=$user->cf_skype?>?chat" title="Skype" alt="Skype"><i class="fa fa-2x fa-skype" style="color:#00aff0"></i></a>
                <?endif?>
                <?if(isset($user->cf_telegram) AND $user->cf_telegram!=''):?>
                    <a href="tg://resolve?domain=<?=$user->cf_telegram?>" id="telegram" title="Telegram" alt="Telegram"><i class="glyphicon fa-2x glyphicon-send" style="color:#0088cc"></i></a>
                <?endif?>
            </p>
        <?endif?>
        <div class="text-description">
            <?=$user->description?>
        </div>
    </div>
</div>
<?if($profile_ads!==NULL):?>
<h3><?=$user->name.' '._e(' advertisements')?></h3>
<div class="row" data-masonry='{ "itemSelector": ".grid-item" }'>
    <?foreach($profile_ads as $ad):?>
        <div class="col-xs-12 col-sm-4 col-md-3 grid-item">
            <div class="box-card box-item-card">
                <a href="<?=Route::url('ad', array('category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                    <div class="box-card-header">
                        <img src="<?=$ad->user->get_profile_image()?>" class="profile img-thumbnail"> <?=$ad->user->name?>
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
                                            <span class="price"><?=i18n::money_format( $ad->price)?></span>
                                        <?endif?>
                                        <?=Text::truncate_html(Text::removebbcode($ad->description, TRUE), 255, NULL)?>
                                    </p>
                                    <?if($ad->id_location != 1):?>
                                        <p><?=__('Location')?>: <?=$ad->location->translate_name() ?></p>
                                    <?endif?>
                                    <?foreach ($ad->custom_columns(TRUE) as $name => $value):?>
                                        <?if($value=='checkbox_1'):?>
                                            <p><?=$name?>: <i class="fa fa-check"></i></p>
                                        <?elseif($value=='checkbox_0'):?>
                                            <p><?=$name?>: <i class="fa fa-times"></i></p>
                                        <?else:?>
                                            <p><?=$name?>: <?=$value?></p>
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
<?=$pagination?>
<?endif?>
