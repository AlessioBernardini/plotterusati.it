<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<header class="navbar navbar-fixed-top">
	<div class="container">
	    <div class="col-xs-12 col-sm-3 col-md-3 col-lg-3">
	        <div class="row">
	            <div class="col-lg-12">
	                <a class="brand" href="<?=Route::url('default')?>">
	                    <?if (Theme::get('logo_url')!=''):?>
	                        <img src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" >
	                    <?else:?>
	                        <h1><?=core::config('general.site_name')?></h1>
	                    <?endif?>
	                </a>
	            </div>
	        </div>
	    </div>
	    <div class="navbar-header pull-right">
	        <div class="navbar-btn pull-right">
		        <button type="button" class="navbar-toggle collapsed pull-right hidden-lg" data-toggle="collapse" data-target="#mobile-menu-panel">
		            <span class="sr-only"><?=_e('Toggle navigation')?></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		            <span class="icon-bar"></span>
		        </button>
	            <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
	                <a class="btn hidden-sm hidden-md hidden-lg" href="<?=Route::url('post_new')?>" title="<?=_e('Publish new')?>">
	                    <i class="fa fa-plus-circle"></i>
	                </a>
	            <?endif?>
	            <?=View::factory('widget_login')?>
	        </div>
	    </div>
	    <div class="collapse navbar-collapse" id="mobile-menu-panel">
	    	<div class="navbar-btn pull-right hidden-xs hidden-sm hidden-md">
	             <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
	                <a class="btn" href="<?=Route::url('post_new')?>">
	                    <i class="fa fa-plus-circle"></i> <?=_e('Publish new')?>
	                </a>
	            <?endif?>
	        </div>
	        <ul class="nav navbar-nav pull-right">
	            <?if (class_exists('Menu') AND core::count( $menus = Menu::get() )>0 ):?>
	                <?foreach ($menus as $menu => $data):?>
	                    <li class="<?=(Request::current()->uri()==$data['url'])?'active':''?>" >
	                        <a href="<?=$data['url']?>" target="<?=$data['target']?>">
	                            <?if($data['icon']!=''):?><i class="<?=$data['icon']?>"></i> <?endif?>
	                            <?=$data['title']?>
	                        </a> 
	                    </li>
	                <?endforeach?>
	            <?else:?>
	                <li class="<?=(Request::current()->controller()=='home')?'active':''?>" >
	                    <a href="<?=Route::url('default')?>"><i class="glyphicon glyphicon-home "></i> <?=_e('Home')?></a></li>
	                <?if (core::config('general.blog')==1):?>
	                    <?=Theme::nav_link(_e('Blog'),'blog','glyphicon glyphicon-file','index','blog')?>
	                <?endif?>
	                <?if (core::config('general.faq')==1):?>
	                    <?=Theme::nav_link(_e('FAQ'),'faq','glyphicon glyphicon-question-sign','index','faq')?>
	                <?endif?>
	                <?if (core::config('general.forums')==1):?>
	                    <?=Theme::nav_link(_e('Forums'),'forum','glyphicon glyphicon-tag','index','forum-home')?>
	                <?endif?>
	                <?=Theme::nav_link(_e('Search'),'ad', 'glyphicon glyphicon-search ', 'advanced_search', 'search')?>
	                <?if (core::config('advertisement.map')==1):?>
	                    <?=Theme::nav_link(_e('Map'),'map', 'glyphicon glyphicon-globe ', 'index', 'map')?>
	                <?endif?>
	                <?=Theme::nav_link(_e('Contact'),'contact', 'glyphicon glyphicon-envelope', 'index', 'contact')?>
	            <?endif?>
	        </ul>
	    </div>   
    </div>   
    <!--/.nav-collapse --> 
</header>
<?endif?>

<?if (!Auth::instance()->logged_in()):?>
    <div id="login-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <a class="close" data-dismiss="modal" >&times;</a>
                  <h3 class="modal-title"><?=_e('Login')?></h3>
                </div>                
                <div class="modal-body">
                    <?=View::factory('pages/auth/login-form')?>
                </div>
            </div>
        </div>
    </div>
    
    <div id="forgot-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <a class="close" data-dismiss="modal" >&times;</a>
                  <h3 class="modal-title"><?=_e('Forgot password')?></h3>
                </div>
                
                <div class="modal-body">
                    <?=View::factory('pages/auth/forgot-form')?>
                </div>
            </div>
        </div>
    </div>
    
     <div id="register-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <a class="close" data-dismiss="modal" >&times;</a>
                  <h3 class="modal-title"><?=_e('Register')?></h3>
                </div>
                
                <div class="modal-body">
                    <?=View::factory('pages/auth/register-form', ['recaptcha_placeholder' => 'recaptcha4', 'modal_form' => TRUE])?>
                </div>
            </div>
        </div>
    </div>
<?elseif(Core::config('general.pusher_notifications')):?> 
    <div id="pusher-subscribe" class="hidden" data-user="<?=Auth::instance()->get_user()->email?>" data-key="<?=Core::config('general.pusher_notifications_key')?>" data-cluster="<?=Core::config('general.pusher_notifications_cluster')?>"></div>
<?endif?>