<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<header>
    <nav class="navbar navbar-default">
        <div class="container no-gutter"> 
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="row">
                <div class="col-xs-12 col-sm-3">
                    <div class="navbar-header no-gutter">
                        <div class="col-xs-9 col-sm-12">
                            <a href="<?=Route::url('default')?>" id="logo">
                                <?if (Theme::get('logo_url')!=''):?>
                                    <img src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>">
                                <?else:?>
                                    <h1 class="h1"><?=core::config('general.site_name')?></h1>
                                <?endif?>
                            </a>
                        </div>
                        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only"><?=_e('Toggle navigation')?></span>
                            <i class="fa fa-bars"></i>
                        </button>
                        <ul class="nav navbar-nav pull-right hidden-sm hidden-md hidden-lg">
                            <?=View::factory('widget_login')?>
                            <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                                <li><a href="<?=Route::url('post_new')?>" class="primary-btn color-primary header-btn"><?=_e('Publish new')?> <i class="fa fa-plus"></i></a></li>  
                            <?endif?>
                        </ul>
                        <?
                            $cats = Model_Category::get_category_count();
                            $loc_seoname = NULL;
                            
                            if (Model_Location::current()->loaded())
                                $loc_seoname = Model_Location::current()->seoname;
                        ?>
                    </div>
                </div>		
                <!-- Collect the nav links, forms, and other content for toggling -->
                <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                    <ul class="nav navbar-nav">
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
                            <?=Theme::nav_link(_e('Listing'),'ad', '' ,'listing', 'list')?>
                            <?if (core::config('general.blog')==1):?>
                                <?=Theme::nav_link(_e('Blog'),'blog','','index','blog')?>
                            <?endif?>
                            <?if (core::config('general.faq')==1):?>
                                <?=Theme::nav_link(_e('FAQ'),'faq','','index','faq')?>
                            <?endif?>
                            <?if (core::config('general.forums')==1):?>
                                <?=Theme::nav_link(_e('Forums'),'forum','','index','forum-home')?>
                            <?endif?>
                            <?=Theme::nav_link(_e('Search'),'ad', '', 'advanced_search', 'search')?>
                            <?if (core::config('advertisement.map')==1):?>
                                <?=Theme::nav_link('','map', 'glyphicon glyphicon-globe ', 'index', 'map')?>
                            <?endif?>
                            <?=Theme::nav_link(_e('Contact'),'contact', '', 'index', 'contact')?>
                        <?endif?>
                    </ul>
                    <ul class="nav navbar-nav navbar-right hidden-xs">
                        <?=View::factory('widget_login')?>
                        <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                            <li><a href="<?=Route::url('post_new')?>" class="primary-btn color-primary header-btn"><?=_e('Publish new')?> <i class="fa fa-plus"></i></a></li>  
                        <?endif?>
                    </ul>
                </div>
            </div>
        </div>
    </nav>		
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


