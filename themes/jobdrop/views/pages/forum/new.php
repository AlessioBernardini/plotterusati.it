<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header text-center">
	<h1 class="h1"><?=_e("New forum topic")?></h1> 
</div>
<section id="main">			
	<div class="container">
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
		    <div class="col-xs-12">
		        <?if (!Auth::instance()->logged_in()):?>
			        <a class="btn btn-success pull-right" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
			    <?else:?>
			        <a class="btn btn-success pull-right" href="<?=Route::url('forum-new')?>">
			    <?endif?>
			        <?=_e('New Topic')?></a>		    
			    <?=View::factory('pages/forum/search-form')?>
		    </div>	
		</div>
		<div class="row">
			<div class="col-sm-12">			
				<div class="well">
					<?php if ($errors): ?>
				    <div class="alert alert-warning">
					    <?=_e('Some errors were encountered, please check the details you entered.')?>
					    <ul class="errors">
						    <?php foreach ($errors as $message): ?>
						        <li><?php echo $message ?></li>
						    <?php endforeach ?>
					    </ul>
				    </div>
				    <?php endif ?>       
					<?=FORM::open(Route::url('forum-new'), array('class'=>'form-horizontal', 'enctype'=>'multipart/form-data'))?>
					<fieldset>
				
				        <div class="form-group control-group">
				            <?= FORM::label('id_forum', _e('Forum'), array('class'=>'col-md-2 control-label', 'for'=>'id_forum' ))?>
				            <div class="col-md-6 controls">
				                <select name="id_forum" id="id_forum" class="form-control input-xlarge" REQUIRED>
				                    <option><?=__('Select a forum')?></option>
				                    <?foreach ($forums as $f):?>
				                        <option value="<?=$f['id_forum']?>" <?=(core::request('id_forum')==$f['id_forum'])?'selected':''?>>
				                            <?=$f['name']?></option>
				                    <?endforeach?>
				                </select>
				            </div>
				        </div>
				
						<div class="form-group control-group">
							<?= FORM::label('title', _e('Title'), array('class'=>'col-md-2 control-label', 'for'=>'title'))?>
							<div class="col-md-6 controls">
								<?= FORM::input('title', core::post('title'), array('placeholder' => __('Title'), 'class' => 'form-control input-xlarge', 'id' => 'title', 'required'))?>
							</div>
						</div>
						<div class="form-group control-group">
							<?= FORM::label('description', _e('Description'), array('class'=>'col-md-2 control-label', 'for'=>'description'))?>
							<div class="col-md-6 controls">
								<?= FORM::textarea('description', core::post('description'), array('placeholder' => __('Description'), 'class' => 'form-control input-xxlarge', 'name'=>'description', 'id'=>'description', 'required'))?>	
							</div>
						</div>
						
						<?if (core::config('advertisement.captcha') != FALSE):?>
						<div class="form-group control-group">
							<div class="col-md-6 col-md-offset-2 controls">
								<?if (Core::config('general.recaptcha_active')):?>
                                    <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                <?else:?>
								    <?=_e('Captcha')?>*:<br />
								    <?=captcha::image_tag('new-forum')?><br />
								    <?= FORM::input('captcha', "", array('class' => 'form-control input-xlarge', 'id' => 'captcha', 'required'))?>
								<?endif?>
							</div>
						</div>
						<?endif?>
						<div class="clearfix"></div><br>
						<div class="form-group control-group">
							<div class="col-md-6 col-md-offset-2 controls">
								<?= FORM::button(NULL, _e('Publish new topic'), array('type'=>'submit', 'class'=>'btn btn-success', 'action'=>Route::url('forum-new')))?>
							</div>
						</div>
					</fieldset>
					<?= FORM::close()?>
				
				</div>
			</div>
		</div>
	</div>
</section>