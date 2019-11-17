<?php defined('SYSPATH') or die('No direct script access.');?>

<?if (Theme::landing_single_ad() == FALSE):?>
<nav role="navigation" class="navbar navbar-default <?=(Theme::get('fixed_toolbar')==1)?'navbar-fixed-top':''?>">
    <div class="container">
        <div class="navbar-header">
            <button type="button" data-target="#navbarCollapse" data-toggle="collapse" class="navbar-toggle">
                <span class="sr-only"><?=_e('Toggle navigation')?></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="<?=Route::url('default')?>">
                <?if (Theme::get('logo_url')!=''):?>
                    <img class="img-responsive" src="<?=Theme::get('logo_url')?>" title="<?=HTML::chars(core::config('general.site_name'))?>" alt="<?=HTML::chars(core::config('general.site_name'))?>" >
                <?else:?>
                    <?=core::config('general.site_name')?>
                <?endif?>
            </a>
        </div>
        <div id="navbarCollapse" class="collapse navbar-collapse">
            <ul class="nav navbar-nav navbar-right">
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
                <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                    <li class="hidden-xs hidden-sm"><a href="<?=Route::url('post_new')?>" class="btn btn-res-primary navbar-btn"><i class="fa fa-pencil"></i> <?=_e('Publish new ')?></a></li>
                <?endif?>
                <?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                    <li class="hidden-xs hidden-md hidden-lg"><a href="<?=Route::url('post_new')?>" class="btn btn-res-primary navbar-btn"><i class="fa fa-pencil"></i></a></li>
                <?endif?>
                <?=View::factory('widget_login')?>
                <div class="hidden-sm hidden-md hidden-lg">
                	<?if ((Core::config('advertisement.only_admin_post')!=1) OR (Core::config('advertisement.only_admin_post')==1 AND Auth::instance()->logged_in() AND (Auth::instance()->get_user()->is_admin() OR Auth::instance()->get_user()->is_moderator()))):?>
                    	<li class="hidden-sm hidden-md hidden-lg"><a href="<?=Route::url('post_new')?>" class="btn btn-res-primary navbar-btn"><i class="fa fa-pencil"></i> <?=_e('Publish new ')?></a></li>
                	<?endif?>
            </div>
            </ul>
        </div>
    </div>
</nav>

<nav class="navbar">
    <div class="container">
        <ul class="nav navbar-nav nav-cat">
            <p class="navbar-text nav-cat-cont"><?=_e('Categories')?></p>
            <?
                $cats = Model_Category::get_category_count();

                $cat_id = NULL;
                $cat_parent = NULL;

                if (Model_Category::current()->loaded())
                {
                    $cat_id = Model_Category::current()->id_category;
                    $cat_parent =  Model_Category::current()->id_category_parent;
                }

                $loc_seoname = NULL;

                if (Model_Location::current()->loaded())
                    $loc_seoname = Model_Location::current()->seoname;

            ?>
            <?foreach($cats as $c ):?>
                <?if($c['id_category_parent'] == 1 && $c['has_siblings'] == FALSE):?>
                    <li  class="<?=($c['id_category'] == $cat_id)?'active':''?>">
                        <a  title="<?=HTML::chars($c['seoname'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>">
                            <?=$c['translate_name']?> </a>
                    </li>
                <?elseif($c['id_category_parent'] == 1 && $c['id_category'] != 1):?>
                    <li class="dropdown <?=($c['id_category'] == $cat_parent OR $c['id_category'] == $cat_id)?'active':''?>">
                        <a href="#" data-toggle="dropdown" class="dropdown-toggle" title="<?=HTML::chars($c['seoname'])?>" >
                            <?=$c['translate_name']?> <b class="caret"></b></a>
                        <ul class="dropdown-menu">
                            <?$i=1;foreach($cats as $chi):?>
                                <?if($chi['id_category_parent'] == $c['id_category']):?>
                                    <li>
                                        <a class="<?=($chi['id_category'] == $cat_id)?'active':''?>" title="<?=HTML::chars($chi['translate_name'])?>" href="<?=Route::url('list', array('category'=>$chi['seoname'],'location'=>$loc_seoname))?>">
                                            <?if (Theme::get('category_badge')!=1) : ?>
                                                <span class="label label-default label-as-badge pull-right"><?=number_format($chi['count'])?></span>
                                            <?endif?>
                                            <span class="cat-text <?=Theme::get('category_badge') != 1 ? 'badged-name' : NULL?>"><?=$chi['translate_name']?></span>
                                        </a>
                                    </li>
                                <?$i++;endif?>
                            <?endforeach?>
                            <li class="divider"></li>
                            <li>
                                <a class="<?=($c['id_category'] == $cat_id)?'active':''?>" title="<?=HTML::chars($c['seoname'])?>" href="<?=Route::url('list', array('category'=>$c['seoname'],'location'=>$loc_seoname))?>">
                                    <?if (Theme::get('category_badge')!=1) : ?>
                                        <span class="label label-success label-as-badge pull-right"><?=number_format($c['count'])?></span>
                                    <?endif?>
                                    <?=$c['translate_name']?>
                                </a>
                            </li>
                        </ul>
                    </li>
                <?endif?>
            <?endforeach?>
        </ul>
        <?=FORM::open(Route::url('search'), array('class'=>'navbar-form navbar-right', 'method'=>'GET', 'action'=>''))?>
            <div class="input-group">
                <input name="search" type="text" class="form-control" placeholder="<?=__('Search')?>">
                <span class="input-group-btn">
                    <button type="submit" class="btn btn-default"><span class=" glyphicon glyphicon-search"></span></button>
                </span>
            </div>
        <?=FORM::close()?>
    </div>
</nav>
<?endif?>

<?if (!Auth::instance()->logged_in()):?>
	<div id="login-modal" class="modal fade">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                  <a class="close" data-dismiss="modal" >&times;</a>
                  <h4 class="modal-title"><?=_e('Login')?></h4>
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
                  <h4 class="modal-title"><?=_e('Forgot password')?></h4>
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
                  <h4 class="modal-title"><?=_e('Register')?></h4>
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