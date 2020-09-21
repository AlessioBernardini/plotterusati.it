<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
    <h3><?=_e('User Profile')?></h3>
</div>

<div id="user_profile_info" class="row">
    <div class="col-sm-3 col-sm-offset-0 col-xs-8 col-xs-offset-2">
        <?$images = $user->get_profile_images(); if ($images):?>
            <div id="gallery">
                <?$i = 0; foreach ($images as $key => $image):?>
                    <a href="<?=$image?>" class="thumbnail gallery-item <?=$i > 0 ? 'hidden' : NULL?>" data-gallery>
                        <img class="img-rounded img-responsive" src="<?=Core::imagefly($image,200,200)?>" alt="<?=$user->name?>">
                    </a>
                <?$i++; endforeach?>
            </div>
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
    </div>
    <div class="col-xs-12 col-sm-9">
        <h3><?=$user->name?> <?=$user->is_verified_user();?></h3>
        <?if (Core::config('advertisement.reviews')==1):?>
            <? if ($user->rate !== NULL) : ?>
                <a href="<?= Route::url('user-reviews', ['seoname' => $user->seoname]) ?>">
                    <? for ($i=0; $i < round($user->rate,1); $i++) : ?>
                        <span class="glyphicon glyphicon-star"></span>
                    <? endfor ?>
                    <? for ($jj=$i; $jj < 5; $jj++): ?>
                        <span class="glyphicon glyphicon-star-empty"></span>
                    <? endfor ?>
                </a>
            <? endif ?>
        <?endif?>
        <div class="text-description">
            <?=Text::bb2html($user->description,TRUE)?>
        </div>
    </div>
</div>

<div class="page-header">
    <article>
        <ul class="list-unstyled">
            <li><strong><?=_e('Member since')?>:</strong> <?= Date::format($user->created, core::config('general.date_format')) ?></li>
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
        </ul>
        <?if (Theme::get('premium')==1):?>
            <?if(isset($user->cf_whatsapp) AND strlen($user->cf_whatsapp) > 6):?>
                <a href="https://api.whatsapp.com/send?phone=<?=$user->cf_whatsapp?>" title="Chat with <?=$user->name?>" alt="Whatsapp"><i class="fa fa-2x fa-whatsapp"></i></a>
            <?endif?>
            <?if(isset($user->cf_skype) AND strlen($user->cf_skype) > 6):?>
                <a href="skype:<?=$user->cf_skype?>?chat" title="Chat with <?=$user->name?>" alt="Skype"><i class="fa fa-2x fa-skype"></i></a>
            <?endif?>
            <?if(isset($user->cf_telegram) AND strlen($user->cf_telegram) > 6):?>
                <a href="tg://resolve?domain=<?=$user->cf_telegram?>" id="telegram" title="Chat with <?=$user->name?>" alt="Telegram"><i class="fa fa-2x fa-telegram"></i></a>
            <?endif?>
        <?endif?>
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
                                        <?= FORM::label('name', _e('Name'), array('class'=>'col-md-2 control-label', 'for'=>'name'))?>
                                        <div class="col-md-4 ">
                                            <?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => 'form-control', 'id' => 'name', 'required'))?>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <?= FORM::label('email', _e('Email'), array('class'=>'col-md-2 control-label', 'for'=>'email'))?>
                                        <div class="col-md-4 ">
                                            <?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => 'form-control', 'id' => 'email', 'type'=>'email','required'))?>
                                        </div>
                                    </div>
                                <?endif?>
                                <?if(core::config('general.messaging') != TRUE):?>
                                    <div class="form-group">
                                        <?= FORM::label('subject', _e('Subject'), array('class'=>'col-md-2 control-label', 'for'=>'subject'))?>
                                        <div class="col-md-4 ">
                                            <?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => 'form-control', 'id' => 'subject'))?>
                                        </div>
                                    </div>
                                <?endif?>
                                <div class="form-group">
                                    <?= FORM::label('message', _e('Message'), array('class'=>'col-md-2 control-label', 'for'=>'message'))?>
                                    <div class="col-md-6">
                                        <?= FORM::textarea('message', HTML::chars(Core::post('subject')), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>2, 'required'))?>
                                        </div>
                                </div>
                                <?if (core::config('advertisement.captcha') != FALSE):?>
                                    <div class="form-group">
                                        <?= FORM::label('captcha', _e('Captcha'), array('class'=>'col-md-2 control-label', 'for'=>'captcha'))?>
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
                                    <?= FORM::button(NULL, _e('Send Message'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'userprofile_contact' , 'id'=>$user->id_user))))?>
                                </div>
                            </fieldset>
                        <?= FORM::close()?>
                    </div>
                </div>
            </div>
        </div>

        <?if (core::config('advertisement.gm_api_key')):?>
            <?if(Core::config('advertisement.map') AND $user->address !== NULL AND $user->latitude !== NULL AND $user->longitude !== NULL):?>
                <h3><?=_e('Map')?></h3>
                <p>
                    <img class="img-responsive" src="//maps.googleapis.com/maps/api/staticmap?language=<?=i18n::get_gmaps_language(i18n::$locale)?>&amp;zoom=<?=Core::config('advertisement.map_zoom')?>&amp;scale=false&amp;size=600x300&amp;maptype=roadmap&amp;format=png&amp;visual_refresh=true&amp;markers=size:large%7Ccolor:red%7Clabel:·%7C<?=$user->latitude?>,<?=$user->longitude?>&amp;key=<?=core::config('advertisement.gm_api_key')?>" alt="<?=HTML::chars($user->name)?> <?=_e('Map')?>" style="width:100%;">
                </p>
                <p>
                    <a class="btn btn-default btn-sm" href="<?=Route::url('map')?>?id_user=<?=$user->id_user?>" target="<?=THEME::$is_mobile ? '_blank' : NULL?>">
                        <span class="glyphicon glyphicon-globe"></span> <?=_e('Map View')?>
                    </a>
                </p>
            <?elseif (Auth::instance()->logged_in() AND Auth::instance()->get_user()->is_admin() AND !Core::config('advertisement.map')) :?>
                <p>
                    <div class="alert alert-danger" role="alert">
                        <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'edit'))?>" class="alert-link">
                            <?=__('Please enable "Google Maps in Ad and Profile page" to show user location on the map.')?>
                        </a>
                    </div>
                </p>
            <?elseif(Auth::instance()->logged_in() AND Auth::instance()->get_user()->id_user == $user->id_user):?>
                <p>
                    <div class="alert alert-danger" role="alert">
                        <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'edit'))?>" class="alert-link">
                            <?=__('Click here to enter your address.')?>
                        </a>
                    </div>
                </p>
            <?endif?>
        <?elseif (Core::config('advertisement.map') AND Auth::instance()->logged_in() AND Auth::instance()->get_user()->is_admin()) :?>
            <div class="alert alert-danger" role="alert">
                <a href="<?=Route::url('oc-panel',array('controller'=>'settings', 'action'=>'form'))?>" class="alert-link">
                    <?=__('Please set your Google API key on advertisement configuration.')?>
                </a>
            </div>
        <?endif?>

        <div class="clearfix">&nbsp;</div>
	</article>
</div>
<div class="page-header">
    <h3><?=$user->name.' '._e(' advertisements')?></h3>
</div>
<div>
    <?if($profile_ads!==NULL):?>
        <?foreach($profile_ads as $ad):?>
            <?if($ad->price > 0):?>
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
                <?if($ad->featured >= Date::unix2mysql(time())):?>
                    <article id="user_profile_ads" class="col-sm-3 col-xs-6 featured">
                        <span class="label label-danger pull-right"><?=_e('Featured')?></span>
                <?else:?>
                    <article id="user_profile_ads" class="col-sm-3 col-xs-6">
                <?endif?>
                    <div class="col-xs-12 picture">
                        <a title="<?=HTML::chars($ad->title)?>" href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>">
                            <figure>
                                <?if($ad->get_first_image() !== NULL):?>
                                    <img src="<?=Core::imagefly($ad->get_first_image('image'),160,160)?>" class="img-responsive center-block" alt="<?=HTML::chars($ad->title)?>" />
                                <?elseif(( $icon_src = $ad->category->get_icon() )!==FALSE ):?>
                                    <img src="<?=Core::imagefly($icon_src,160,160)?>" class="img-responsive center-block" alt="<?=HTML::chars($ad->title)?>" />
                                <?elseif(( $icon_src = $ad->location->get_icon() )!==FALSE ):?>
                                    <img src="<?=Core::imagefly($icon_src,160,160)?>" class="img-responsive center-block" alt="<?=HTML::chars($ad->title)?>" />
                                <?else:?>
                                    <img data-src="holder.js/160x160?<?=str_replace('+', ' ', http_build_query(array('text' => $ad->category->translate_name(), 'size' => 14, 'auto' => 'yes')))?>" class="img-responsive center-block" alt="<?=HTML::chars($ad->title)?>">
                                <?endif?>
                            </figure>
                        </a>
                    </div>
                    <div class="col-xs-12 text-center caption">
                        <h4><a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ad->category->seoname,'seotitle'=>$ad->seotitle))?>"><?=$ad->title?></a></h4>
                        <?if (Core::config('advertisement.reviews')==1 AND $ad->rate!==NULL):?>
                            <?for ($i=0; $i < round($user->rate,1); $i++):?>
                                <span class="glyphicon glyphicon-star"></span>
                            <?endfor?>
                            <?for ($jj=$i; $jj < 5; $jj++):?>
                                <span class="glyphicon glyphicon-star-empty"></span>
                            <?endfor?>
                        <?endif?>
                        <p><span class="price-curry text-danger"><strong><?=i18n::money_format( $ad->price, $ad->currency())?></strong></span></p>
                        <?if($remaining_time > 0):?>
                            <p class="time_left"><b><i class="fa fa-clock-o"></i> <?=$remaining_time_content?></b></p>
                        <?else:?>
                            <p><b><?=_e('Closed')?></b></p>
                        <?endif?>

                    </div>
                        <?$visitor = Auth::instance()->get_user()?>

                        <?if ($visitor != FALSE && $visitor->id_role == 10):?>
                            <br>
                            <a href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><?=_e("Edit");?></a> |
                            <a href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'deactivate','id'=>$ad->id_ad))?>"
                                onclick="return confirm('<?=__('Deactivate?')?>');"><?=_e("Deactivate");?>
                            </a> |
                            <a href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'spam','id'=>$ad->id_ad))?>"
                                onclick="return confirm('<?=__('Spam?')?>');"><?=_e("Spam");?>
                            </a> |
                            <a href="<?=Route::url('oc-panel', array('controller'=>'ad','action'=>'delete','id'=>$ad->id_ad))?>"
                                onclick="return confirm('<?=__('Delete?')?>');"><?=_e("Delete");?>
                            </a>
                        <?elseif($visitor != FALSE && $visitor->id_user == $ad->id_user):?>
                            <br>
                            <a href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><?=_e("Edit");?></a>
                        <?endif?>
                    <div class="clearfix"></div>
                </article>
            <?endif?>
        <?endforeach?>
        <div class="col-xs-12 text-center"><?=$pagination?></div>
    <?endif?>

</div>
