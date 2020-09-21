<?php defined('SYSPATH') or die('No direct script access.');?>
<? if (Auth::instance()->logged_in()):?>
	<?=View::factory('widget_notification')?>
	<li><button class="btn btn-res-secondary navbar-btn dropdown-toggle" type="button" id="dropdownLogin" data-toggle="dropdown" aria-expanded="true"><i class="fa fa-user "></i></button>
	<ul class="dropdown-menu" role="menu" aria-labelledby="dropdownLogin">
		<li>
			<a href="<?=Route::url('oc-panel',array('controller'=>'home','action'=>'index'))?>"><i class="glyphicon glyphicon-cog"></i> <?=_e('Panel')?></a>
		</li>
		<li>
			<a href="<?=Route::url('oc-panel',array('controller'=>'myads','action'=>'index'))?>"><i class="glyphicon glyphicon-edit"></i> <?=_e('My Advertisements')?></a>
		</li>
		<li>
			<a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'favorites'))?>"><i class="glyphicon glyphicon-heart"></i> <?=_e('My Favorites')?></a>
		</li>
        <?if(core::config('payment.paypal_seller') == TRUE OR Core::config('payment.stripe_connect')==TRUE OR Core::config('payment.escrow_pay')==TRUE):?>
            <li><a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'sales'))?>"><i
                   class="glyphicon glyphicon-usd"></i> <?=_e('My Sales')?></a></li>
            <?endif?>
		<? if (Model_Order::by_user(Auth::instance()->get_user())->count_all() > 0) : ?>
			<li>
				<a href="<?= Route::url('oc-panel', array('controller' => 'profile', 'action' => 'orders')) ?>">
					<i class="glyphicon glyphicon-shopping-cart"></i> <?= _e('My Payments') ?>
				</a>
			</li>
		<? endif ?>
		<?if (core::config('general.messaging') == TRUE):?>
			<li>
				<a href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'index'))?>"><i class="fa fa-inbox"></i> <?=_e('Messages')?></a>
			</li>
		<?endif?>
		<li>
			<a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'subscriptions'))?>"><i class="glyphicon glyphicon-envelope"></i> <?=_e('Subscriptions')?></a>
		</li>
		<li>
			<a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'edit'))?>"><i class="glyphicon glyphicon-lock"></i> <?=_e('Edit profile')?></a>
		</li>
		<li>
			<a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'public'))?>"><i class="glyphicon glyphicon-eye-open"></i> <?=_e('Public profile')?></a>
		</li>
		<li class="divider"></li>
			<li>
				<a href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'logout'))?>"><i class="glyphicon glyphicon-off"></i> <?=_e('Logout')?></a>
			</li>
		<li>
			<a href="<?=Route::url('default')?>"><i class="glyphicon glyphicon-home"></i> <?=_e('Visit Site')?></a>
		</li>
		<?if (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator() OR Auth::instance()->get_user()->is_translator()):?>
            <li class="divider"></li>
            <li class="dropdown-header"><?=_e('Live translator')?></li>
            <?if (Core::request('edit_translation') == '1'):?>
                <li>
                    <a href="?edit_translation=0">
                        <i class="fa fa-globe"></i> <?=__('Disable')?>
                    </a>
                </li>
            <?else:?>
                <li>
                    <a href="?edit_translation=1">
                        <i class="fa fa-globe"></i> <?=__('Enable')?>
                    </a>
                </li>
            <?endif?>
        <?endif?>
	</ul></li>
<? else:?>
	<li class="dropdown">
		<a href="#" class="dropdown-toggle" data-toggle="dropdown"><?=_e('Login')?> <b class="caret"></b></a>
		<ul class="dropdown-menu dropdown-login">
			<li>
				<div class="row">
					<div class="col-md-12">
						<form class="form" id="login-nav" enctype="multipart/form-data" method="post" action="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>">
							<div class="form-group">
								<label class="sr-only" for="lemail"><?=_e('Email')?></label>
								<input type="email" class="form-control" placeholder="<?=__('Email')?>" name="email" id="lemail" required>
							</div>
							<div class="form-group">
								<label class="sr-only" for="password"><?=_e('Password')?></label>
								<input type="password" class="form-control" placeholder="<?=__('Password')?>" name="password" id="password" required>
								<p class="help-block">
									<small><a href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'forgot'))?>">
										<?=_e('Forgot password?')?>
									</a></small>
								</p>
							</div>
							<div class="checkbox">
								<label>
									<input type="checkbox" name="remember" checked="checked"> <?=_e('Remember me')?>
								</label>
							</div>
							<div class="form-group">
								<a class="btn btn-default btn-block" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'register'))?>">
									<?=_e('Register')?>
								</a>
							</div>
							<div class="form-group">
								<button type="submit" class="btn btn-success btn-block"><?=_e('Login')?></button>
							</div>
							<?=Form::redirect()?>
							<?=Form::CSRF('login')?>
						</form>
					</div>
				</div>
			</li>
			<li>
			  <?=View::factory('pages/auth/social')?>
			</li>
		</ul>
	</li>
<? endif?>
