<?php defined('SYSPATH') or die('No direct script access.');?>

<div class="page-header">
	<h1><?= __('User Profile')?></h1>
</div>

<div class="row">
	<div class="span3">
	    <?$images = $user->get_profile_images(); if ($images):?>
            <?$i = 0; foreach ($images as $key => $image):?>
				<a href="#user-img<?=$i?>" data-rel="popup" data-position-to="window" data-transition="fade">
						<img class="popphoto image_box" src="<?=Core::imagefly($image,150,150)?>" alt="<?=__('Profile Picture')?>">
				</a>
				<div data-role="popup" id="user-img<?=$i?>" data-overlay-theme="a" data-corners="false">
				    	<img class="popphoto" src="<?=$image?>" style="max-height:512px;" alt="">
				</div>
			<?$i++; endforeach?>
		
	    <?endif?>

	</div>
</div>

<div class="header_devider"></div>
<?if (Theme::get('premium')==1):?>
    <?if(isset($user->cf_whatsapp) AND strlen($user->cf_whatsapp) > 6):?>
        <a href="https://api.whatsapp.com/send?phone=<?=$user->cf_whatsapp?>" title="Chat with <?=$user->name?>" alt="Whatsapp"><i class="fa fa-2x fa-whatsapp" style="color:#43d854"></i></a>
    <?endif?>
    <?if(isset($user->cf_skype) AND $user->cf_skype!=''):?>
        <a href="skype:<?=$user->cf_skype?>?chat" title="Chat with <?=$user->name?>" alt="Skype"><i class="fa fa-2x fa-skype" style="color:#00aff0"></i></a>
    <?endif?>
    <?if(isset($user->cf_telegram) AND $user->cf_telegram!=''):?>
        <a href="tg://resolve?domain=<?=$user->cf_telegram?>" id="telegram" title="Chat with <?=$user->name?>" alt="Telegram"><i class="fa fa-2x fa-telegram" style="color:#0088cc"></i></a>
    <?endif?>
<?endif?>
<h3 class="c-bl"><?=$user->name?> <?=$user->is_verified_user();?></h3>
<div class="descr_content">
	<p class="c-wh"><b><?=__('Description')?>: </b><?= $user->description?></p>
	<p class="c-wh"><b><?=__('Email')?>: </b><?= $user->email?></p>
	<p class="c-wh"><b><?=__('Created')?>: </b><?=Date::format($user->created, core::config('general.date_format')) ?></p>
    <?if ($user->last_login!=NULL):?>
	<p class="c-wh"><b><?=__('Last Login')?>: </b><?=Date::format($user->last_login, core::config('general.date_format'))?></p>
    <?endif?>
    <?foreach ($user->custom_columns(TRUE) as $name => $value):?>
        <?if($value!=''):?>
    		<?if($name!='whatsapp' AND $name!='skype' AND $name!='telegram'):?>
	            <p class="c-wh">
	                <b><?=$name?>:</b>
	                <?if($value=='checkbox_1'):?>
	                    <i class="fa fa-check"></i>
	                <?elseif($value=='checkbox_0'):?>
	                    <i class="fa fa-times"></i>
	                <?else:?>
	                    <?=$value?>
	                <?endif?>
	            </p>
        	<?endif?>
        <?endif?>
	<?endforeach?>

    <?if (core::config('advertisement.gm_api_key')):?>
        <?if(Core::config('advertisement.map') AND $user->address !== NULL AND $user->latitude !== NULL AND $user->longitude !== NULL):?>
            <h4><?=_e('Map')?></h4>
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
</div>
<!-- popup button send message -->
		<a data-role="button" href="#popupContact" data-rel="popup" data-position-to="window"  data-inline="true" data-icon="check" data-transition="pop"><?=__('Send Message')?></a>
		<div data-role="popup" id="popupMenu">
		    <div data-role="popup" id="popupContact" class="ui-corner-all">
		    	<a data-role="button" href="#" data-rel="back"  data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>
		     
		            <div style="padding:10px 20px;">
		              <h3 class="header_text"><?=__('Send Message')?></h3>
		              <?=Form::errors()?>
			
			<?= FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'userprofile_contact', 'id'=>$user->id_user)), array('class'=>'', 'enctype'=>'multipart/form-data', 'method'=>'post'))?>
			<fieldset>
				<div class="control-group">
					<?= FORM::label('name', __('Name'), array('class'=>'control-label header_text', 'for'=>'name'))?>
					<div class="controls ">
						<?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => '', 'id' => 'name', 'required'))?>
					</div>
				</div>
				<div class="control-group">
					
					<?= FORM::label('email', __('Email'), array('class'=>'control-label header_text', 'for'=>'email'))?>
					<div class="controls ">
						<?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => '', 'id' => 'email', 'type'=>'email','required'))?>
					</div>
				</div>
				<div class="control-group">
					
					<?= FORM::label('subject', __('Subject'), array('class'=>'control-label header_text', 'for'=>'subject'))?>
					<div class="controls ">
						<?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => '', 'id' => 'subject'))?>
					</div>
				</div>
				<div class="control-group">
					<?= FORM::label('message', __('Message'), array('class'=>'control-label header_text', 'for'=>'message'))?>
					<div class="controls">
						<?= FORM::textarea('message', Core::request('message'), array('class'=>'', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>2, 'required'))?>	
						</div>
				</div>
				
				<?if (core::config('advertisement.captcha') != FALSE):?>
				<div class="control-group ">
					<div class="controls ">
						<?if (Core::config('general.recaptcha_active')):?>
						    <?=Captcha::recaptcha_display()?>
						    <div id="recaptcha1"></div>
						<?else:?>
						    <div class="header_text"><?=__('Captcha')?>*:</div><br />
						    <?=captcha::image_tag('contact')?><br />
						    <?= FORM::input('captcha', "", array('class' => '', 'id' => 'captcha', 'required'))?>
						<?endif?>
					</div>
				</div>
				<?endif?>
					
					<div class="modal-footer">	
					<?= FORM::button('submit',__('Send Message'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'userprofile_contact' , 'id'=>$user->id_user))))?>
				</div>
			</fieldset>
			<?= FORM::close()?>
		            </div>
		       
		    </div>
		</div>
<h3 class="c-bl"><?=$user->name." ".__('advertisements')?></h3>
<ul data-role="listview" data-inset="true" data-filter="true" data-split-icon="edit" data-split-theme="d">
	<?if($profile_ads!==NULL):?>
		<?foreach($profile_ads as $ads):?>
		<?if($ads->featured >= Date::unix2mysql(time())):?>
	    	<li data-icon="star" data-theme="<?=Theme::get('theme_featured_elements');?>" class="ui_child_list_cat ui_featured"><a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ads->category,'seotitle'=>$ads->seotitle))?>">
	    <?else:?>
			<li data-theme="<?=Theme::get('theme_list_elements');?>" class="ui_child_list_cat"><a href="<?=Route::url('ad', array('controller'=>'ad','category'=>$ads->category,'seotitle'=>$ads->seotitle))?>">
		<?endif?>
			<h2><?=$ads->title?></h2>
			<p><strong>Description: </strong><?=Text::removebbcode($ads->description)?></p>
		<?if($ads->published != NULL):?>
			<p><b><?=__('Publish Date');?>:</b> <?= Date::format($ads->published, core::config('general.date_format'))?></p>
		<?else:?>
			<p><b><?=__('Publish Date');?>:</b> <?=__('Not yet published')?></p>
		<?endif?>
		</a>
		<?$visitor = Auth::instance()->get_user()?>
		<?if ($visitor !== FALSE && $visitor->id_role == 10):?>
			 <a data-theme="<?=Theme::get('theme_headers');?>" class="ui_child_list_cat side_edit_btn" target="_blank" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ads->id_ad))?>">Edit</a>
		<?endif?>
		
		</li>
		<?endforeach?>
        <?=$pagination?>
	<?endif?>
</ul>

	
