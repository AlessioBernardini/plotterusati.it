<?php defined('SYSPATH') or die('No direct script access.');?>

	<?if ($ad->status != Model_Ad::STATUS_PUBLISHED && $permission === FALSE && ($ad->id_user != $user)):?>

	<div class="page-header">
		<h1><?= __('This advertisement doesn´t exist, or is not yet published!')?></h1>
	</div>

	<?else:?>

	<div class="page-header">
		<h1><?=$ad->title;?></h1>
	</div>
	<?=Form::errors()?>
	<?$images = $ad->get_images()?>
	<?if($images):?>
		<?foreach ($images as $path => $value):?>
			<?if(isset($value['thumb'])):?>
			<a href="#<?=$path?>" data-rel="popup" data-position-to="window" data-transition="fade">
				<?=HTML::picture($value['image'], array('w' => 135, 'h' => 135), array('1200px' => array('w' => '382', 'h' => '382'), '992px' => array('w' => '350', 'h' => '350'), '768px' => array('w' => '288', 'h' => '288'), '480px' => array('w' => '221', 'h' => '221'), '320px' => array('w' => '135', 'h' => '135')), array('alt' => '', 'class' => 'img-responsive popphoto image_box'))?>
			</a>
		    <div data-role="popup" id="<?=$path?>" data-overlay-theme="a" data-corners="false">
		    	<img class="popphoto" src="<?=$value['image']?>" style="max-height:512px;" alt="">
			</div>
			<?endif?>
		<?endforeach?>
	<?endif?>
	<div class="descr_content">
		<?if ($ad->price>0):?>
    		<p class="c-wh"><?=__('Price')?> : <strong><?=i18n::money_format($ad->price, $ad->currency())?></strong></p>
    	<?endif?>
		<?if ($ad->price==0 AND core::config('advertisement.free')==1):?>
    		<p class="c-wh"><?=__('Price')?> : <strong><?=__('Free');?></strong></p>
    	<?endif?>
    	<p class="c-wh"><?=__('Published')?>: <strong> <?=Date::format($ad->published, core::config('general.date_format'))?></strong></p>
    	<p class="c-wh"><?=__('Publisher')?>: <a class="c-wh" class="label" href="<?=Route::url('profile',  array('seoname'=>$ad->user->seoname))?>"><?=$ad->user->name?> <?=$ad->user->is_verified_user();?></a></p>
        <?if(core::config('advertisement.count_visits')==1):?>
    	<p class="c-wh"><?=__('Hits')?>: <strong><?=$hits?></strong></p>
        <?endif?>
	    <?if (Valid::url($ad->website)):?>
	    <p class="c-wh overflow-hidden"><?=__('Website')?>: <a class="c-wh" href="<?=$ad->website?>" rel="nofollow" target="_blank"><?=$ad->website?></a> </p>
	    <?endif?>
	    <!-- custom fields display -->
	    <?foreach ($cf_list as $name => $value):?>
	    	    <?if($value=='checkbox_1'):?>
	    	        <p><b><?=$name?></b>: √</p>
	    	    <?elseif($value=='checkbox_0'):?>
	    	        <p><b><?=$name?></b>: &times;</p>
	    	    <?else:?>
	    	    	<?if(isset($ad->cf_vatnumber) AND isset($ad->cf_vatcountry)):?>
                        <?if($value != $ad->cf_vatnumber AND $value != $ad->cf_vatcountry):?>
	    	        		<p class="c-wh"><strong><?=$name?></strong>: <?=$value?></p>
	    	        	<?endif?>
                    <?elseif(isset($ad->cf_file_download))://hide file download on sale link?>
                        <?if($value != '<a'.HTML::attributes(['class' => 'btn btn-success', 'href' => $ad->cf_file_download]).'>'.__('Download').'</a>'):?>
                            <p><b><?=$name?></b>: <?=$value?></p>
                        <?endif?>
	    	        <?else:?>
	    	        	<p class="c-wh"><strong><?=$name?></strong>: <?=$value?></p>
	    	        <?endif?>
	    	    <?endif?>
	    <?endforeach?>

	    <!-- ./end custom fields -->
	    <?if(core::config('advertisement.description')!=FALSE):?>
	    	<p class="c-wh"><?= Text::bb2html($ad->description,TRUE)?></p>
	   	<?endif?>
	    <?if(Auth::instance()->logged_in() AND $ad->id_user === $user):?>
	    <a data-role="button" data-inline="true"  target="_blank" data-transition="slide" data-icon="edit" class="pag_right ui_base_btn ui_btn_small" href="<?=Route::url('oc-panel', array('controller'=>'myads','action'=>'update','id'=>$ad->id_ad))?>"><?=__('Edit')?></a>
	    <?endif?>
	</div>

	<hr />

	<?=$ad->btc()?>

	<?if((core::config('payment.paypal_seller')==1 OR Core::config('payment.stripe_connect')==1) AND $ad->price != NULL AND $ad->price > 0):?>
      	<?if(core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1)):?>
      		<?if($ad->status != Model_Ad::STATUS_SOLD):?>
		    	<a class="ui_base_btn ui_btn_small ui-link ui-btn ui-btn-inline ui-shadow ui-corner-all" href="<?=Route::url('default', array('action'=>'buy','controller'=>'ad','id'=>$ad->id_ad))?>"><?=__('Buy Now')?></a>
		    <?else:?>
		    	<a class="ui_base_btn ui_btn_small ui-link ui-btn ui-btn-inline ui-shadow ui-corner-all ui-button-disabled ui-state-disabled"><?=__('Sold')?></a>
		    <?endif?>
		<?endif?>
    <?elseif (isset($ad->cf_file_download) AND !empty($ad->cf_file_download) AND  ( core::config('payment.stock')==0 OR ($ad->stock > 0 AND core::config('payment.stock')==1))):?>
	    <div class="btn-group" role="group">
	        <a class="ui_base_btn ui_btn_small ui-link ui-btn ui-btn-inline ui-shadow ui-corner-all" type="button" href="<?=$ad->cf_file_download?>">
	            <i class="fa fa-download" aria-hidden="true"></i>
	            &nbsp;&nbsp;<?=_e('Download')?>
	        </a>
	    </div>
	<?endif?>

	<?if ($ad->can_contact()):?>
	    <!-- popup button send message -->
		<?if (core::config('advertisement.login_to_contact') == TRUE AND !Auth::instance()->logged_in()) :?>
		    <a class="ui_base_btn ui_btn_small" data-role="button" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>" data-inline="true" data-icon="check"><?=__('Send Message')?></a>
		<?else:?>
            <a class="ui_base_btn ui_btn_small" data-role="button" href="#popupContact" data-rel="popup" data-position-to="window"  data-inline="true" data-icon="check" data-transition="pop"><?=__('Send Message')?></a>
		<?endif?>
		<?if($ad->phone):?>
		    <a class="ui_base_btn ui_btn_small" href="<?='tel:'.str_replace(array(' ', '-','/','_'), '', $ad->phone);?>" data-inline="true" data-icon="phone" data-role="button" rel="external"><?=str_replace(array(' ', '-','/','_'), '', $ad->phone);?></a>
	    <?endif?>
		<div data-role="popup" id="popupMenu">
		    <div data-role="popup" id="popupContact" class="ui-corner-all">
		    	<a data-role="button" href="#" data-rel="back"  data-icon="delete" data-iconpos="notext" class="ui-btn-right">Close</a>

		            <div style="padding:10px 20px;">
		              <h3 class="header_text"><?=__('Send Message')?></h3>
		              <?=Form::errors()?>

			<?= FORM::open(Route::url('default', array('controller'=>'contact', 'action'=>'user_contact', 'id'=>$ad->id_ad)), array('class'=>'', 'enctype'=>'multipart/form-data'))?>
			<fieldset>
                <?if (!Auth::instance()->get_user()):?>
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
                <?endif?>
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
					<?= FORM::button('submit', __('Send Message'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('default', array('controller'=>'contact', 'action'=>'user_contact' , 'id'=>$ad->id_ad))))?>
				</div>
			</fieldset>
			<?= FORM::close()?>
		            </div>

		    </div>
		</div>
		<?endif?>

         <div class="clearfix"></div><br>
        <?=$ad->qr()?>
        <?=$ad->map()?>
        <?=$ad->related()?>
        <?if(core::config('advertisement.report')==1):?>
	        <?=$ad->flagad()?>
	    <?endif?>
        <?=$ad->structured_data()?>

	<?endif?>

<div class="disqus_content">
<?=$ad->comments()?>
</div>