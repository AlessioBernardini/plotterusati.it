<?php defined('SYSPATH') or die('No direct script access.');?>
<header class="navbar navbar-default navbar-main <?=(strtolower(Request::current()->controller())!=='faq' AND Theme::get('fixed_toolbar')==1)?'navbar-fixed-top site-header':''?>">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-menu-panel">
                <span class="sr-only"><?=__('Toggle navigation')?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand logo <?=(Theme::get('logo_url')!=''?'logo_img':'')?>" href="<?=Route::url('default')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>">
                <?if (Theme::get('logo_url')!=''):?>
                    <img href="<?=Route::url('default')?>" src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" >
                <?else:?>
                    <h1><?=core::config('general.site_name')?></h1>
                <?endif?>
            </a>
        </div>
        <div class="collapse navbar-collapse" id="mobile-menu-panel">
            <?=FORM::open(Route::url('search'), array('class'=>'navbar-form navbar-left', 'method'=>'GET', 'action'=>''))?>
                <div class="form-group">
                    <i class="fa fa-search"></i> <input type="text" id="title" name="title" class="form-control" value="<?=HTML::chars(core::get('title'))?>" placeholder="<?=__('Search')?>">
                </div>
            </form>
            <?if (class_exists('Menu') AND core::count( $menus = Menu::get() )>0 ):?>
                <ul class="nav navbar-nav navbar-left hidden-md hidden-lg">
                    <?foreach ($menus as $menu => $data):?>
                        <li class="<?=(Request::current()->uri()==$data['url'])?'active':''?>" >
                            <a href="<?=$data['url']?>" target="<?=$data['target']?>">
                                <?if ($data['icon']!=''):?>
                                    <i class="<?=$data['icon']?>"></i>
                                <?endif?>
                                <span class="text-uppercase"><?=$data['title']?></span>
                            </a>
                        </li>
                    <?endforeach?>
                </ul>
            <?else:?>
                <?
                $cats = Model_Category::get_category_count();

                $cat_id = NULL;
                if (Model_Category::current()->loaded())
                    $cat_id = Model_Category::current()->id_category;

                $loc_seoname = NULL;
                if (Model_Location::current()->loaded())
                    $loc_seoname = Model_Location::current()->seoname;
                ?>
                <ul class="nav navbar-nav navbar-left hidden-md hidden-lg">
                    <?foreach($cats as $c ):?>
                        <li class="<?=($c['id_category'] == $cat_id)?'active':''?>">
                            <a title="<?=HTML::chars($c['seoname'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>">
                                <span class="text-uppercase"><?=$c['translate_name']?></span>
                                <?if (Theme::get('category_badge')!=1 AND FALSE) : ?>
                                    <div class="badge <?=(Theme::get('rtl'))? 'pull-left':'pull-right'?>"> <?=number_format($c['count'])?></div>
                                <?endif?>
                            </a>
                        </li>
                    <?endforeach?>
                </ul>
            <?endif?>
            <?=View::factory('widget_login')?>
            <?if (Core::config('advertisement.only_admin_post')!=1):?>
                <a class="btn btn-default navbar-btn navbar-right" href="<?=Route::url('post_new')?>">
                    <?=__('Publish new ')?>
                </a>
            <?endif?>
        </div><!--/.nav-collapse -->
    </div>
</header>
<div class="navbar navbar-default navbar-submain hidden-xs hidden-sm">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#mobile-submenu-panel" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
        </div>
        <div class="collapse navbar-collapse" id="mobile-submenu-panel">
            <?if (class_exists('Menu') AND core::count( $menus = Menu::get() )>0 ):?>
                <ul class="nav navbar-nav navbar-left">
                    <?foreach ($menus as $menu => $data):?>
                        <li class="<?=(Request::current()->uri()==$data['url'])?'active':''?>" >
                            <a href="<?=$data['url']?>" target="<?=$data['target']?>">
                                <?if ($data['icon']!=''):?>
                                    <i class="<?=$data['icon']?>"></i>
                                <?endif?>
                                <span class="text-uppercase"><?=$data['title']?></span>
                            </a>
                        </li>
                    <?endforeach?>
                </ul>
            <?else:?>
                <?
                    $cats = Model_Category::get_category_count();

                    $cat_id = NULL;
                    $cat_parent = NULL;

                    if (Model_Category::current()->loaded())
                    {
                        $cat_id = Model_Category::current()->id_category;
                        $cat_parent = Model_Category::current()->id_category_parent;
                    }

                    $loc_seoname = NULL;

                    if (Model_Location::current()->loaded())
                        $loc_seoname = Model_Location::current()->seoname;
                ?>
                <ul class="nav navbar-nav navbar-left">
                    <?$i = 1; foreach($cats as $c ):?>
                        <? if ($c['id_category_parent'] == 1 AND $c['has_siblings'] == FALSE): ?>
                            <?if($i < 6): ?>
                                <li class="<?=($c['id_category'] == $cat_id)?'active':''?>">
                                    <a title="<?=HTML::chars($c['seoname'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>">
                                        <span class="text-uppercase"><?=$c['translate_name']?></span>
                                        <?if (Theme::get('category_badge')!=1 AND FALSE) : ?>
                                            <div class="badge <?=(Theme::get('rtl'))? 'pull-left':'pull-right'?>"> <?=number_format($c['count'])?></div>
                                        <?endif?>
                                    </a>
                                </li>
                            <?endif?>
                            <? $i++ ?>
                        <?elseif($c['id_category_parent'] == 1 AND $c['id_category'] != 1):?>
                            <?if($i < 6): ?>
                                <li class="dropdown <?=($c['id_category'] == $cat_parent OR $c['id_category'] == $cat_id)?'active':''?>">
                                    <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="<?=HTML::chars($c['seoname'])?>" >
                                        <span class="text-uppercase"><?=$c['translate_name']?></span> <b class="caret"></b>
                                        <?if (Theme::get('category_badge')!=1 AND FALSE) : ?>
                                            <div class="badge <?=(Theme::get('rtl'))? 'pull-left':'pull-right'?>"> <?=number_format($c['count'])?></div>
                                        <?endif?>
                                    </a>
                                    <ul class="dropdown-menu">
                                        <?foreach($cats as $chi):?>
                                            <?if($chi['id_category_parent'] == $c['id_category']):?>
                                                <li>
                                                    <a class="<?=($chi['id_category'] == $cat_id)?'active':''?>" title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'],'location'=>$loc_seoname))?>">
                                                        <span class="text-uppercase"><?=$chi['translate_name']?></span>
                                                        <?if (Theme::get('category_badge')!=1) : ?>
                                                            <div class="badge <?=(Theme::get('rtl'))? 'pull-left':'pull-right'?>"><?=number_format($chi['count'])?></div>
                                                        <?endif?>
                                                    </a>
                                                </li>
                                            <?endif?>
                                        <?endforeach?>
                                        <li class="divider"></li>
                                        <li>
                                            <a class="<?=($c['id_category'] == $cat_id)?'active':''?>" title="<?=HTML::chars($c['seoname'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>">
                                                <span class="text-uppercase"><?=$c['translate_name']?></span>
                                                <?if (Theme::get('category_badge')!=1) : ?>
                                                    <span class="badge badge-success <?=(Theme::get('rtl'))? 'pull-left':'pull-right'?>"><?=number_format($c['count'])?></span>
                                                <?endif?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
                            <? endif ?>
                            <? $i++ ?>
                        <? endif ?>
                    <?endforeach?>
                    <?if(core::count($cats) >= 6): ?>
                        <li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= _e('More') ?> <span class="caret"></span></a>
                            <ul class="dropdown-menu">
                    <?endif?>
                    <?$i = 1; foreach($cats as $c ):?>
                        <? if ($c['id_category_parent'] == 1): ?>
                            <?if($i >= 6): ?>
                                <li class="<?=($c['id_category'] == $cat_id)?'active':''?>">
                                    <a title="<?=HTML::chars($c['seoname'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>">
                                        <span class="text-uppercase"><?=$c['translate_name']?></span>
                                        <?if (Theme::get('category_badge')!=1 AND FALSE) : ?>
                                            <div class="badge <?=(Theme::get('rtl'))? 'pull-left':'pull-right'?>"> <?=number_format($c['count'])?></div>
                                        <?endif?>
                                    </a>
                                </li>
                            <?endif?>
                            <?$i++?>
                        <?endif?>
                    <?endforeach?>
                    <?if(core::count($cats) >= 6): ?>
                            </ul>
                        </li>
                    <?endif?>
                </ul>
            <?endif?>
            <ul class="nav navbar-nav navbar-right">
                <? if(Theme::get('facebook_link')!='') :?>
                    <li><a href="<?=Theme::get('facebook_link')?>"><i class="fa fa-facebook"></i></a></li>
                <?endif?>
                <? if(Theme::get('twitter_link')!='') :?>
                    <li><a href="<?=Theme::get('twitter_link')?>"><i class="fa fa-twitter"></i></a></li>
                <?endif?>
                <? if(Theme::get('instagram_link')!='') :?>
                    <li><a href="<?=Theme::get('instagram_link')?>"><i class="fa fa-instagram"></i></a></li>
                <?endif?>
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</div>
<?if(Request::current()->controller()=='Home'): ?>
    <div class="header-banner">
        <div class="header-banner-image">
            <img src="<?=Theme::get('homepage_img')?>">
        </div>
        <div class="container">
            <div class="header-banner-content">
                <h1><?=Theme::get('homepage_text_1')?></h1>
                <h2><?=Theme::get('homepage_text_2')?></h2>
                <br>
                <ul class="list-inline">
                    <li><a class="btn btn-primary btn-lg" data-toggle="modal" href="<?=Route::url('post_new')?>">
                        <span class="text-uppercase"><?=Theme::get('homepage_cta_1')?></span>
                    </a></li>
                    <li><a class="btn btn-success btn-lg" data-toggle="modal" href="<?=Route::url('list')?>">
                        <span class="text-uppercase"><?=Theme::get('homepage_cta_2')?></span>
                    </a></li>
                </ul>
            </div>
        </div>
    </div>
<?endif?>
<?if (!Auth::instance()->logged_in()):?>
    <div id="login-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <a class="close" data-dismiss="modal" >&times;</a>
                    <h3><?=__('Login')?></h3>
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
                    <h3><?=__('Forgot password')?></h3>
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
                    <h3><?=__('Register')?></h3>
                </div>
                <div class="modal-body">
                    <?=View::factory('pages/auth/register-form')?>
                </div>
            </div>
        </div>
    </div>
<?elseif(Core::config('general.pusher_notifications')):?>
    <div id="pusher-subscribe" class="hidden" data-user="<?=Auth::instance()->get_user()->email?>" data-key="<?=Core::config('general.pusher_notifications_key')?>" data-cluster="<?=Core::config('general.pusher_notifications_cluster')?>"></div>
<?endif?>