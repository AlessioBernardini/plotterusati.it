<?php defined('SYSPATH') or die('No direct script access.');?>

	<?=Form::errors()?>
	<?if(core::config('general.contact_page') != ''):?>
		<?$content = Model_Content::get_by_title(core::config('general.contact_page'))?>
		<div class="page-header">
			<h1><?=$content->title?></h1>
		</div>
		<?=$content->description?>
		<br>
	<?else:?>
		<div class="page-header">
			<h1><?=__('Contact Us')?></h1>
		</div>
	<?endif?>
	<?= FORM::open(Route::url('contact'), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>
	<fieldset>
        <?if (!Auth::instance()->get_user()):?>
		<div class="control-group">
			<?= FORM::label('name', __('Name'), array('class'=>'control-label', 'for'=>'name'))?>
			<div class="controls ">
				<?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => 'input-xlarge', 'id' => 'name', 'required'))?>
			</div>
		</div>
		<div class="control-group">
			
			<?= FORM::label('email', __('Email'), array('class'=>'control-label', 'for'=>'email'))?>
			<div class="controls ">
				<?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => 'input-xlarge', 'id' => 'email', 'type'=>'email','required'))?>
			</div>
		</div>
        <?endif?>
		<div class="control-group">
			
			<?= FORM::label('subject', __('Subject'), array('class'=>'control-label', 'for'=>'subject'))?>
			<div class="controls ">
				<?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => 'input-xlarge', 'id' => 'subject'))?>
			</div>
		</div>
		<div class="control-group">
			<?= FORM::label('message', __('Message'), array('class'=>'control-label', 'for'=>'message'))?>
			<div class="controls">
				<?= FORM::textarea('message', Core::request('message'), array('class'=>'input-xlarge', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>7, 'required'))?>	
				</div>
		</div>
		
		<?if (core::config('advertisement.captcha') != FALSE):?>
		<div class="control-group">
			<div class="controls">
				<?if (Core::config('general.recaptcha_active')):?>
					<?=Captcha::recaptcha_display()?>
					<div id="recaptcha1"></div>
				<?else:?>
					<?=__('Captcha')?>*:<br />
					<?=captcha::image_tag('contact')?><br />
					<?= FORM::input('captcha', "", array('class' => 'input-xlarge', 'id' => 'captcha', 'required'))?>
				<?endif?>
			</div>
		</div>
		<?endif?>
		<div class="control-group">
			<div class="controls">
				<?= FORM::button('submit', 'Contact Us', array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('contact')))?>
			</div>
			<br class="clear">
		</div>
	</fieldset>
	<?= FORM::close()?>
