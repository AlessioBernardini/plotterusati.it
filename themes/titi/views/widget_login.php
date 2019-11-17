<?php defined('SYSPATH') or die('No direct script access.');?>
<?if (Auth::instance()->logged_in()):?>
    <ul class="nav navbar-nav navbar-right">
        <?=View::factory('widget_notification')?>
        <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                <i class="glyphicon glyphicon-user"></i> <span class="caret"></span>
            </a>
            <ul class="dropdown-menu dropdown-menu-right">
                <li>
                    <a href="<?=Route::url('oc-panel',array('controller'=>'home','action'=>'index'))?>">
                        <i class="glyphicon glyphicon-cog"></i> <?=__('Panel')?>
                    </a>
                </li>
                <li>
                    <a href="<?=Route::url('oc-panel',array('controller'=>'myads','action'=>'index'))?>">
                        <i class="glyphicon glyphicon-edit"></i> <?=__('My Advertisements')?>
                    </a>
                </li>
                <li>
                    <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'favorites'))?>">
                        <i class="glyphicon glyphicon-heart"></i> <?=__('My Favorites')?>
                    </a>
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
                        <a href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'index'))?>">
                            <i class="fa fa-inbox"></i> <?=__('Messages')?>
                        </a>
                    </li>
                <?endif?>
                <li>
                    <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'subscriptions'))?>">
                        <i class="glyphicon glyphicon-envelope"></i> <?=__('Subscriptions')?>
                    </a>
                </li>
                <li>
                    <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'edit'))?>">
                        <i class="glyphicon glyphicon-lock"></i> <?=__('Edit profile')?>
                    </a>
                </li>
                <li>
                    <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'public'))?>">
                        <i class="glyphicon glyphicon-eye-open"></i> <?=__('Public profile')?>
                    </a>
                </li>
                <li class="divider"></li>
                <li>
                    <a href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'logout'))?>">
                        <i class="glyphicon glyphicon-off"></i> <?=__('Logout')?>
                    </a>
                </li>
                <li>
                    <a href="<?=Route::url('default')?>">
                        <i class="glyphicon glyphicon-home"></i> <?=__('Visit Site')?>
                    </a>
                </li>
                <? if (Auth::instance()->get_user()->is_admin() or Auth::instance()->get_user()->is_moderator() or Auth::instance()->get_user()->is_translator()) : ?>
                    <li class="divider"></li>
                    <li class="dropdown-header"><?= _e('Live translator') ?></li>
                    <? if (Core::request('edit_translation') == '1') : ?>
                        <li>
                            <a href="?edit_translation=0">
                                <i class="fa fa-globe"></i> <?= __('Disable') ?>
                            </a>
                        </li>
                    <? else : ?>
                        <li>
                            <a href="?edit_translation=1">
                                <i class="fa fa-globe"></i> <?= __('Enable') ?>
                            </a>
                        </li>
                    <? endif ?>
                <? endif ?>
            </ul>
        </li>
    </ul>
<?else:?>
    <ul class="nav navbar-nav navbar-right">
        <li>
            <a data-toggle="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'register'))?>#register-modal">
                <?=__('Register')?>
            </a>
        </li>
        <li>
            <a data-toggle="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
                <?=__('Login')?>
            </a>
        </li>
    </ul>
<?endif?>