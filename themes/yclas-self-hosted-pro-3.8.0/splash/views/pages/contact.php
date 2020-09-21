<?php defined('SYSPATH') or die('No direct script access.');?>

<section id="page-header">
		<div class="container no-gutter">	
			<div class="row">		
				<div class="col-sm-8">
					<?if(core::config('general.contact_page') != ''):?>
						<?$content = Model_Content::get_by_title(core::config('general.contact_page'))?>
						<h1 class="h1"><?=$content->title?></h1>
					<?else:?>
						<h1 class="h1"><?=_e('Contact')?></h1>
					<?endif?>
				</div>
				<?if (Theme::get('breadcrumb')==1):?>
					<div class="col-sm-4 breadcrumbs">
						<?=Breadcrumbs::render('breadcrumbs')?>
					</div>
				<?endif?>
			</div>
		</div>
		<div class="overlay"></div>
	</section>

<?=Alert::show()?>

	<section id="main">
		<div class="container no-gutter">
			<div class="row">
				<div class="col-xs-12 col-sm-8 <?=(Theme::get('sidebar_position')=='hidden')?'col-md-12':'col-md-9'?> <?=(Theme::get('sidebar_position')=='left')?'col-md-push-3':NULL?>">
					<div class="contact no-gutter">
						<div class="col-xs-12">
							<?=Form::errors()?>
							<?if(core::config('general.contact_page') != ''):?>
								<?=$content->description?>
							<?endif?>
							<?= FORM::open(Route::url('contact'), array('class'=>'form-horizontal standard-frm contact-frm', 'enctype'=>'multipart/form-data'))?>
						        <?if (!Auth::instance()->logged_in()):?>								
								<?= FORM::label('name', _e('Name'), array('class'=>'', 'for'=>'name'))?>
								<?= FORM::input('name', Core::request('name'), array('placeholder' => __('Name'), 'class' => 'form-control input', 'id' => 'name', 'required'))?>						
								<?= FORM::label('email', _e('Email'), array('class'=>'', 'for'=>'email'))?>	
								<?= FORM::input('email', Core::request('email'), array('placeholder' => __('Email'), 'class' => 'form-control input', 'id' => 'email', 'type'=>'email','required'))?>
						        <?endif?>
									<?= FORM::label('subject', _e('Subject'), array('class'=>'', 'for'=>'subject'))?>
									<?= FORM::input('subject', Core::request('subject'), array('placeholder' => __('Subject'), 'class' => 'form-control input', 'id' => 'subject'))?>
									<?= FORM::label('message', _e('Message'), array('class'=>'', 'for'=>'message'))?>
									<?= FORM::textarea('message', Core::request('message'), array('class'=>'form-control input', 'placeholder' => __('Message'), 'name'=>'message', 'id'=>'message', 'rows'=>7, 'required'))?>	
								<?if (core::config('advertisement.captcha') != FALSE):?>
										<?if (Core::config('general.recaptcha_active')):?>
                                            <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                        <?else:?>
											<label><?=_e('Captcha')?>*:</label>
											<?= captcha::image_tag('contact');?><br />
											<?= FORM::input('captcha', "", array('class' => 'form-control input', 'id' => 'captcha', 'required'))?>
										<?endif?>
								<?endif?>
								<?= FORM::button(NULL, _e('Contact Us'), array('type'=>'submit', 'class'=>'primary-btn color-primary btn', 'action'=>Route::url('contact')))?>
							<?= FORM::close()?>
						</div>
					</div>
				</div>
				<aside><?=View::fragment('sidebar_front','sidebar')?></aside>
			</div>
		</div>
	</div>
</section>	