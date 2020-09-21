<?php defined('SYSPATH') or die('No direct script access.');?>
<div class="page-header text-center">
	<h1 class="h1"><?=$topic->title?></h1> 
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
				    <div class="col-md-3 span2">
				        <div class="thumbnail highlight">
				            <img src="<?=$topic->user->get_profile_image()?>" width="120" height="120" alt="<?=HTML::chars($topic->user->name)?>">
				            <div class="caption">
				                <p>
				                    <?=$topic->user->name?> <?=$topic->user->is_verified_user()?><br>
				                    <?=Date::fuzzy_span(Date::mysql2unix($topic->created))?><br>
				                    <?=$topic->created?>
				                </p>
				            </div>
				        </div> 
				    </div>
				    <div class="col-md-9 span6">
				        <?if(Auth::instance()->logged_in()):?>
				            <?if(Auth::instance()->get_user()->is_admin()):?>
				                <a class="label label-warning pull-right" href="<?=Route::url('oc-panel', array('controller'=> 'topic', 'action'=>'update','id'=>$topic->id_post)) ?>">
				                    <i class="glyphicon icon-white icon-edit glyphicon-edit"></i>
				                </a>
				            <?endif?>
				        <?endif?>
				        <p><?=Text::bb2html($topic->description,TRUE)?></p>
				        <?if (Auth::instance()->logged_in()):?>
				            <a  class="btn btn-primary" href="#reply_form"><?=_e('Reply')?></a>
				        <?else:?>
				            <a class="btn btn-primary" data-toggle="modal" data-dismiss="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
				                <?=_e('Reply')?>
				            </a>
				        <?endif?>
				    </div>
				<div class="clearfix"></div>
				<div class="page-header"></div>
				
				<?foreach ($replies as $reply):?>
				
				    <div class="col-md-3 span2">
				        <div class="thumbnail highlight">
				            <img src="<?=$reply->user->get_profile_image()?>" width="120" height="120" alt="<?=HTML::chars($reply->user->name)?>">
				            <div class="caption">
				                <p>
				                    <?=$reply->user->name?> <?=$reply->user->is_verified_user()?><br>
				                    <?=Date::fuzzy_span(Date::mysql2unix($reply->created))?><br>
				                    <?=$reply->created?>
				                </p>
				            </div>
				        </div>
				    </div>
				    <div class="col-md-9 span6">
				    <?if(Auth::instance()->logged_in()):?>
				        <?if(Auth::instance()->get_user()->is_admin()):?>
				            <a class="label label-warning pull-right" href="<?=Route::url('oc-panel', array('controller'=> 'topic', 'action'=>'update','id'=>$reply->id_post)) ?>">
				                <i class="glyphicon icon-white icon-edit glyphicon-edit"></i>
				            </a>
				        <?endif?>
				    <?endif?>
				        <p><?=Text::bb2html($reply->description,TRUE)?></p>
				        <a  class="btn btn-xs btn-primary" href="#reply_form"><?=_e('Reply')?></a>
				    </div>
				
				<div class="clearfix"></div>
				<div class="page-header"></div>
				<?endforeach?>
				<?=$pagination?>
				
				
				<?if($topic->status==Model_POST::STATUS_ACTIVE AND Auth::instance()->logged_in()):?>
				<form class="well form-horizontal" id="reply_form" method="post" action="<?=Route::url('forum-topic',array('seotitle'=>$topic->seotitle,'forum'=>$forum->seoname))?>"> 
				<h3><?=_e('Reply')?></h3>
				  <?php if ($errors): ?>
				    <p class="message"><?=_e('Some errors were encountered, please check the details you entered.')?></p>
				    <ul class="errors">
				        <?php foreach ($errors as $message): ?>
				            <li><?php echo $message ?></li>
				        <?php endforeach ?>
				    </ul>
				    <?php endif?>       
				
				    <div class="form-group control-group">
				        <div class="col-md-12">
				            <textarea name="description" rows="10" class="form-control input-xxlarge" required><?=core::post('description',__('Reply here'))?></textarea>
				        </div>
				    </div>
				
				    <?if (core::config('advertisement.captcha') != FALSE):?>
				    <div class="form-group">
				            <div class="col-md-4">
				                <?if (Core::config('general.recaptcha_active')):?>
                                    <?=View::factory('recaptcha', ['id' => 'recaptcha1'])?>
                                <?else:?>
				                    <?=_e('Captcha')?>*:<br />
				                    <?=captcha::image_tag('new-reply-topic')?><br />
				                    <?= FORM::input('captcha', "", array('class' => 'form-control', 'id' => 'captcha', 'required'))?>
				                <?endif?>
				            </div>
				    </div>
				    <?endif?>
				
				    <button type="submit" class="btn btn-primary"><?=_e('Reply')?></button>
				</form>  
				<?else:?>
				<a class="btn btn-success pull-right" data-toggle="modal" data-dismiss="modal" 
				        href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
				        <?=_e('Login to reply')?>
				</a>
				<?endif?>  
			</div>
		</div>
	</div>
</section>

