<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<div class="row">
    <nav role="navigation" class="navbar navbar-default">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only"><?=_e('Toggle navigation')?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-btn pull-right hidden-sm hidden-md hidden-lg">
                <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                    <a href="<?=Route::url('post_new')?>" class="btn btn-success">
                        <?=_e('Publish new')?>
                    </a>
                <?endif?>
            </div>
            <div class="clearfix"></div>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav">
                <?if (class_exists('Menu') AND core::count( $menus = Menu::get() )>0 ):?>
                    <?foreach ($menus as $menu => $data):?>
                        <li class="<?=(Request::current()->uri()==$data['url'])?'active':''?>">
                            <a href="<?=$data['url']?>" target="<?=$data['target']?>">
                                <?if($data['icon']!=''):?><i class="<?=$data['icon']?>"></i> <?endif?>
                                <?=$data['title']?>
                            </a>
                        </li>
                    <?endforeach?>
                <?else:?>
                    <li class="<?=(Request::current()->controller()=='home')?'active':''?>">
                        <a href="<?=Route::url('default')?>"><i class="glyphicon glyphicon-home "></i> <?=_e('Home')?></a>
                    </li>
                    <?=Theme::nav_link(_e('Listing'),'ad', 'glyphicon glyphicon-list' ,'listing', 'list')?>
                    <?if (core::config('general.blog')==1):?>
                        <?=Theme::nav_link(_e('Blog'),'blog','','index','blog')?>
                    <?endif?>
                    <?if (core::config('general.faq')==1):?>
                        <?=Theme::nav_link(_e('FAQ'),'faq','','index','faq')?>
                    <?endif?>
                    <?if (core::config('general.forums')==1):?>
                        <?=Theme::nav_link(_e('Forums'),'forum','glyphicon glyphicon-tag','index','forum-home')?>
                    <?endif?>
                    <?if (core::config('advertisement.map')==1):?>
                        <?=Theme::nav_link('','map', 'glyphicon glyphicon-globe ', 'index', 'map')?>
                    <?endif?>
                    <?=Theme::nav_link(_e('Contact'),'contact', 'glyphicon glyphicon-envelope ', 'index', 'contact')?>
                    <?=Theme::nav_link('','rss', 'glyphicon glyphicon-signal ', 'index', 'rss')?>
                <?endif?>
                <?=View::factory('widget_login')?>
            </ul>
            <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                <a href="<?=Route::url('post_new')?>" class="btn btn-warning post-ad-btn hidden-xs"><i  class="glyphicon glyphicon-pencil"></i>&nbsp;&nbsp;<?=_e('Publish new ')?></a>
            <?endif?>
        </div>
    </nav>
</div>
<div class="row" id="logo">
    <div class="col-sm-8">
        <? if(Theme::get('logo_url')!=''):?>
            <img class="img-responsive" src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" >
        <? else:?>
            <h1><?=core::config('general.site_name')?></h1>
        <? endif?>
        <? if(Theme::get('website_slogan')!=''):?>
            <div id="slogan"><?=Theme::get('website_slogan')?></div>
        <? endif?>
    </div>
    <?if(Theme::get('home_query')==1 AND (strtolower(Request::current()->controller())=='home' AND Request::current()->action()=='index')):?>
    <?else:?>
    <div class="col-sm-4">
        <?if(Core::config('general.algolia_search') == 1):?>
            <?=View::factory('pages/algolia/autocomplete')?>
        <?else:?>
            <?=FORM::open(Route::url('search'), array('class'=>'', 'method'=>'GET', 'action'=>''))?>
                <div class="input-group" id="head-search">
                    <input name="search" type="text" class="search-query form-control" placeholder="<?=__('Search')?>" />
                    <span class="input-group-btn">
                        <button type="submit" class="btn btn-default"><span class=" glyphicon glyphicon-search"></span></button>
                    </span>
                </div>
            <?=FORM::close()?>
        <?endif?>
    </div>
    <?endif?>
</div>
<?if(Theme::get('home_query')==1 AND (strtolower(Request::current()->controller())=='home' AND Request::current()->action()=='index')):?>
    <div class="center">
        <?=FORM::open(Route::url('search'), array('class'=>'center col-sm-12', 'method'=>'GET', 'action'=>''))?>
            <h3><?=Theme::get('home_query_slogan')?></h3>
            <div class="input-group col-md-6 col-md-offset-3" id="head-search">
                <input name="search" type="text" class="search-query form-control h45px" placeholder="<?=__('Search')?>" />
                    <span class="input-group-btn">" />
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default h45px"><span class=" glyphicon glyphicon-search"></span></button>
                </span>
            </div>
            <br>
            <button type="submit" class="btn btn-primary btn-lg"><?=_e('Search')?></button>
        <?=FORM::close()?>
    </div>
<?endif?>

<div class="clearfix"></div><br>
<? if(Theme::get('header_banner')!=''):?>
    <div class="header-banner"><?=Theme::get('header_banner')?></div>
<? endif?>

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
