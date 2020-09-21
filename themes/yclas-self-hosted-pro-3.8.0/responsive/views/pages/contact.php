<?php defined('SYSPATH') or die('No direct script access.');?>
<?if(core::config('general.contact_page') != ''):?>
	<?$content = Model_Content::get_by_title(core::config('general.contact_page'))?>
	<div class="page-header">
		<h1><?=$content->title?></h1>
	</div>
	<?=$content->description?>
	<br>
<?else:?>
	<div class="page-header">
		<h1><?=_e('Contact Us')?></h1>
	</div>
<?endif?>
<div class="well">
	<?=Form::errors()?>
	<?= FORM::open(Route::url('contact'), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>
        <?if (!Auth::instance()->get_user()):?>
		<div class="form-group">
			<?= FORM::label('name', _e('Name'), array('class'=>'col-sm-2 control-label', 'for'=>'name'))?>
			<div class="col-sm-10 ">
				<?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => 'form-control', 'id' => 'name', 'required'))?>
			</div>
		</div>
		<div class="form-group">
			<?= FORM::label('email', _e('Email'), array('class'=>'col-sm-2 control-label', 'for'=>'email'))?>
			<div class="col-sm-10 ">
				<?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => 'form-control', 'id' => 'email', 'type'=>'email','required'))?>
			</div>
		</div>
        <?endif?>
		<div class="form-group">
			<?= FORM::label('subject', _e('Subject'), array('class'=>'col-sm-2 control-label', 'for'=>'subject'))?>
			<div class="col-sm-10 ">
				<?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => 'form-control', 'id' => 'subject'))?>
			</div>
		</div>
		<div class="form-group">
			<?= FORM::label('message', _e('Message'), array('class'=>'col-sm-2 control-label', 'for'=>'message'))?>
			<div class="col-sm-10">
				<?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>7, 'required'))?>	
				</div>
		</div>
		<?if (core::config('advertisement.captcha') != FALSE):?>
		<div class="form-group">
			<?= FORM::label('message', _e('Captcha'), array('class'=>'col-sm-2 control-label', 'for'=>'captcha'))?>
			<div class="col-sm-10">
				<?if (Core::config('general.recaptcha_active')):?>
                    <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                <?else:?>
					<?=captcha::image_tag('contact')?><br />
					<?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required'))?>
				<?endif?>
			</div>
		</div>
		<?endif?>
		<div class="form-group">
			<div class="col-sm-offset-2 col-sm-10">
				<?= FORM::button(NULL, _e('Contact Us'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('contact')))?>
			</div>
			<br class="clear">
		</div>
	<?= FORM::close()?>

</div><!--end span10-->