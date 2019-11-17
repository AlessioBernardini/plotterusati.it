<?php defined('SYSPATH') or die('No direct script access.');?>

<?if(core::config('general.contact_page') != ''):?>
	<?$content = Model_Content::get_by_title(core::config('general.contact_page'))?>
	<div class="page-header">
		<h1><?=$content->title?></h1>
	</div>
	<div class="text-description"><?=$content->description?></div>
	<br>
<?else:?>
	<div class="page-header">
		<h1><?=_e('Contact Us')?></h1>
	</div>
<?endif?>
<div class="well row contact-form col-xs-12">
	<?=Form::errors()?>
	<?= FORM::open(Route::url('contact'), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>
	<div class="col-md-6 col-md-offset-3">
		<fieldset>
			<?if (!Auth::instance()->logged_in()):?>
			<div class="form-group">
				<div class="col-md-12">
					<?= FORM::label('name', _e('Name'), array('class'=>'control-label', 'for'=>'name'))?>
					<?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => 'form-control', 'id' => 'name', 'required'))?>
				</div>
			</div>
			<div class="form-group">
				<?= FORM::label('email', _e('Email'), array('class'=>'control-label', 'for'=>'email'))?>
				<div class="col-md-12">
					<?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => 'form-control', 'id' => 'email', 'type'=>'email','required'))?>
				</div>
			</div>
			<?endif?>

			<div class="form-group">
				<div class="col-md-12">
					<?= FORM::label('subject', _e('Subject'), array('class'=>'control-label', 'for'=>'subject'))?>
					<?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => 'form-control', 'id' => 'subject'))?>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<?= FORM::label('message', _e('Message'), array('class'=>'control-label', 'for'=>'message'))?>
					<?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>7, 'required'))?>	
				</div>
			</div>

			<?if (core::config('advertisement.captcha') != FALSE):?>
				<div class="form-group">
					<div class="col-md-6 col-sm-offset-3">
						<?if (Core::config('general.recaptcha_active')):?>
                            <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
						<?else:?>
							<?=_e('Captcha')?>*:<br />
							<?=captcha::image_tag('contact')?><br />
							<?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required'))?>
						<?endif?>
					</div>
				</div>
			<?endif?>
			<div class="form-group">
				<div class="col-sm-offset-3 col-md-6 text-center">
					<?= FORM::button(NULL, _e('Contact Us'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('contact')))?>
				</div>
			</div>
		</fieldset>
	</div>
	<?= FORM::close()?>
</div>