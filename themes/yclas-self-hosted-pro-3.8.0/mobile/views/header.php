<?php defined('SYSPATH') or die('No direct script access.');?>

<!-- Header -->
<div class="ui_base ui-header ui-header-fixed slidedown ui-bar-colorama ui-bar-a ui-panel-fixed-toolbar" data-role="header" data-theme="<?=Theme::get('theme_color_main');?>" data-add-back-btn="true" data-position="fixed" role="banner">
    <h4 class="ui-title" role="heading" aria-level="1"><a target="_self" id="logo_name" href="<?=Route::url('default')?>" class="ui-link"><?=core::config('general.site_name')?></a></h4>
    <a target="_self" href="#nav-panel" data-icon="bars" class="ui_btn_menu ui-link ui-btn-left ui-btn ui-icon-bars ui-btn-icon-notext ui-btn-inline ui-shadow ui-corner-all" data-inline="true" data-iconpos="notext" data-role="button" role="button"><?=__('Menu')?></a>
</div>
<!-- NAV PANEL -->
<div data-role="panel" data-position-fixed="true" id="nav-panel">
    <ul data-role="listview" data-transition="slide" class="nav-search panel_list_box" >
        <li data-role="divider" data-theme="<?=Theme::get('theme_list_elements');?>" class="ui_base divider"></li>
        <li><a target="_self" href="<?=Route::url('default')?>"><?=__('Home')?></a></li>
        <li><a target="_self" href="<?=Route::url('list', array('category'=>URL::title(__('all'))))?>"><?=__('Listing')?></a></li>
        <li><a target="_self" href="<?=Route::url('contact')?>"><?=__('Contact us')?></a></li>
        <?if (core::config('general.blog')==1):?>
            <li><a target="_self" href="<?=Route::url('blog')?>"><?=__('Blog')?></a></li>
        <?endif?>
        <?if (core::config('general.faq')==1):?>
            <li><a target="_self" href="<?=Route::url('faq')?>"><?=__('FAQ')?></a></li>
        <?endif?>
        <?if (core::config('general.forums')==1):?>
            <li><a target="_self" href="<?=Route::url('forum-home')?>"><?=__('Forums')?></a></li>
        <?endif?>
        <li><a target="_self" href="<?=Route::url('search')?>"><?=__('Advanced search')?></a></li>
        <li><a target="_blank" href="<?=Route::url('default')?>?theme=<?=Core::config('appearance.theme')?>"><?=__('Desktop Version')?></a></li>
        <?if(Auth::instance()->logged_in()):?>
            <li data-role="divider" data-theme="<?=Theme::get('theme_list_elements');?>" class="<?=(Theme::get('theme_list_elements')=='a')?'color-gray':''?> ui_base divider"><strong><?=sprintf(__('Welcome %s'), Auth::instance()->get_user()->name)?></strong></li>
            <?if (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator() OR Auth::instance()->get_user()->is_translator()) :?>
                <li><a target="_blank" href="<?=Route::url('oc-panel',array('controller'=>'home','action'=>'index'))?>" data-inline="true" ><?=__('Panel')?></a></li>
            <?endif?>
            <li><a target="_self" href="<?=Route::url('oc-panel',array('controller'=>'myads','action'=>'index'))?>"><?=__('My Advertisements')?></a></li>
            <li><a target="_self" href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'favorites'))?>"><?=__('My Favorites')?></a></li>
            <li><a target="_self" href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'orders'))?>"><?=__('My Payments')?></a></li>
            <?if (core::config('general.messaging') == TRUE):?>
                <li><a target="_self" href="<?=Route::url('oc-panel',array('controller'=>'messages','action'=>'index'))?>"><?=__('Messages')?></a></li>
            <?endif?>
            <li><a target="_self" href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'subscriptions'))?>"><?=__('Subscriptions')?></a></li>
            <li><a target="_self" href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'edit'))?>"><?=__('Edit profile')?></a></li>
            <li><a target="_self" href="<?=Route::url('oc-panel',array('controller'=>'profile','action'=>'public'))?>"></i> <?=__('Public profile')?></a></li>
            <li><a target="_self" href="<?=Route::url('oc-panel',array('controller'=>'auth','action'=>'logout'))?>"><?=__('Logout')?></a></li>
    </ul>
    <?if(Core::config('general.pusher_notifications')):?> 
	    <div id="pusher-subscribe" class="hidden" data-user="<?=Auth::instance()->get_user()->email?>" data-key="<?=Core::config('general.pusher_notifications_key')?>" data-cluster="<?=Core::config('general.pusher_notifications_cluster')?>"></div>
	<?endif?>
        <?else:?>
    </ul>
        <div class="panel_login_box">
            <?=View::factory('pages/auth/login-form')?>
        </div>
        <?endif?>

</div>
        <!-- end header-->