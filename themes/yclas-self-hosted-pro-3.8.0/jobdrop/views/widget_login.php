<?php defined('SYSPATH') or die('No direct script access.');?>
<?if (Auth::instance()->logged_in()):?>
    <div class="btn-group">
        <?if(core::count(Auth::instance()->get_user()->contacts()) > 0):?>
            <div class="btn-group" role="group">
                <a class="btn dropdown-toggle btn-success" data-toggle="dropdown"
                    href="#" id="contact-notification" data-url="<?=Route::url('oc-panel', array('controller'=>'profile', 'action'=>'notifications'))?>"> <i class="fa fa-bell"></i> <span class="badge"><?=core::count(Auth::instance()->get_user()->contacts())?></span>
                </a>
                <ul id="contact-notification-dd" class="dropdown-menu">
                    <li class="dropdown-header"><?=_e('Please check your email')?></li>
                    <li class="divider"></li>
                    <li class="dropdown-header"><?=_e('You have been contacted for these ads')?></li>
                    <?foreach (Auth::instance()->get_user()->contacts() as $ad ):?>
                        <li class="dropdown-header"><strong><?=$ad["title"]?></strong></li>
                    <?endforeach?>
                </ul>
            </div>
        <?endif?>
        <a class="btn"
            href="<?=Route::url('oc-panel',array('controller'=>'home','action'=>'index'))?>">
            <i class="glyphicon glyphicon-user "></i>
        </a>
        <a class="btn dropdown-toggle" data-toggle="dropdown"
            href="#"> <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li>
                <a href="<?=Route::url('oc-panel',array('controller'=>'home','action'=>'index'))?>">
                    <i class="glyphicon glyphicon-cog"></i> <?=_e('Panel')?>
                </a>
            </li>

            <li>
                <a href="<?=Route::url('oc-panel',array('controller'=>'myads','action'=>'index'))?>">
                    <i class="glyphicon glyphicon-edit"></i> <?=_e('My Advertisements')?>
                </a>
            </li>

            <li>
                <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'favorites'))?>">
                    <i class="glyphicon glyphicon-heart"></i> <?=_e('My Favorites')?>
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
                        <i class="fa fa-inbox"></i> <?=_e('Messages')?>
                    </a>
                </li>
            <?endif?>

            <li>
                <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'subscriptions'))?>">
                    <i class="glyphicon glyphicon-envelope"></i> <?=_e('Subscriptions')?>
                </a>
            </li>

            <li>
                <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'edit'))?>">
                    <i class="glyphicon glyphicon-lock"></i> <?=_e('Edit profile')?>
                </a>
            </li>

            <li>
                <a href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'public'))?>">
                    <i class="glyphicon glyphicon-eye-open"></i> <?=_e('Public profile')?>
                </a>
            </li>

            <li class="divider"></li>

            <li>
                <a href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'logout'))?>">
                    <i class="glyphicon glyphicon-off"></i> <?=_e('Logout')?>
                </a>
            </li>

            <li>
                <a href="<?=Route::url('default')?>">
                    <i class="glyphicon glyphicon-home"></i> <?=_e('Visit Site')?>
                </a>
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
        </ul>
    </div>
<?else:?>
    <a class="btn" data-toggle="modal" href="<?=Route::url('oc-panel',array('directory'=>'user','controller'=>'auth','action'=>'login'))?>#login-modal">
        <i class="glyphicon glyphicon-user"></i> <?=_e('Login')?>
    </a>
<?endif?>