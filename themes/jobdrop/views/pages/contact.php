<?php defined('SYSPATH') or die('No direct script access.');?>
<?if(core::config('general.contact_page') != ''):?>
	<?$content = Model_Content::get_by_title(core::config('general.contact_page'))?>
	<div class="page-header text-center">
		<h1><?=$content->title?></h1>
	</div>
<?else:?>
	<div class="page-header text-center">
		<h1><?=_e('Contact')?></h1>
	</div>
<?endif?>
<?if (Theme::get('header_ad_possible')!=''):?>
	<div class="container">
		<div class="row">
			<div class="col-xs-12 header-ad-room">
				<?=(Theme::get('header_ad_possible')!='')?Theme::get('header_ad_possible'):''?>
			</div>
		</div>
	</div>
<?endif?> 
<section id="main">
	<div class="container no-gutter">
		<?=Alert::show()?>  
		<div class="row">
			<div class="col-xs-12">
			     <?=(Theme::get('breadcrumb')==1)?Breadcrumbs::render('breadcrumbs'):''?>
			</div>
		    <?foreach ( Widgets::render('header') as $widget):?>
		        <div class="col-lg-4 col-md-4 col-sm-12 col-xs-12">
		            <?=$widget?>
		        </div>
		    <?endforeach?>
		</div>	
		<div class="row">
			<div class="<?=(Theme::get('sidebar_position')!='none')?'sidebar-active-container col-lg-9 col-md-9 col-sm-12 col-xs-12':'col-xs-12 col-lg-12'?> <?=(Theme::get('sidebar_position')=='left')?'pull-right':'pull-left'?>">
				<div class="contact no-gutter">
					<div class="row">
						<div class="col-xs-12">
							<?=Form::errors()?>
							<?if(core::config('general.contact_page') != ''):?>
								<?$content = Model_Content::get_by_title(core::config('general.contact_page'))?>
								<div class="text-description"><?=$content->description?></div>
								<br>
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
								<?= FORM::button(NULL, _e('Contact Us'), array('type'=>'submit', 'class'=>'btn btn-primary', 'action'=>Route::url('contact')))?>
							<?= FORM::close()?>
						</div>
					</div>
				</div>
			</div>
			<?if(Theme::get('sidebar_position')!='none'):?>
				<aside><?=View::fragment('sidebar_front','sidebar')?></aside>
			<?endif?>
		</div>
	</div>
</section>	